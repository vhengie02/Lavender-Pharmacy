<?php
/**
 * Order Class - Handle order operations
 */

class Order {
    private $order_id;
    private $user_id;
    private $total_amount;
    private $payment_method;
    private $order_status;
    private $date_ordered;
    private $db;
    
    /**
     * Constructor
     */
    public function __construct($order_id = null) {
        $this->db = Database::getInstance()->getConnection();
        
        if ($order_id) {
            $this->loadOrder($order_id);
        }
    }
    
    /**
     * Load order data
     */
    private function loadOrder($order_id) {
        $query = "SELECT * FROM orders WHERE order_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $order = $result->fetch_assoc();
            $this->order_id = $order['order_id'];
            $this->user_id = $order['user_id'];
            $this->total_amount = $order['total_amount'];
            $this->payment_method = $order['payment_method'];
            $this->order_status = $order['order_status'];
            $this->date_ordered = $order['date_ordered'];
        }
        
        $stmt->close();
    }
    
    /**
     * Create new order from cart
     */
    public function createOrder($user_id, $payment_method) {
        // Validate payment method
        if (!in_array($payment_method, PAYMENT_METHODS)) {
            throw new Exception('Invalid payment method');
        }
        
        // Start transaction
        $this->db->begin_transaction();
        
        try {
            // Get cart items for user
            $cart_query = "SELECT c.product_id, c.quantity, p.price, p.stock_quantity 
                          FROM carts c
                          JOIN products p ON c.product_id = p.product_id
                          WHERE c.user_id = ?";
            $cart_stmt = $this->db->prepare($cart_query);
            $cart_stmt->bind_param('i', $user_id);
            $cart_stmt->execute();
            $cart_result = $cart_stmt->get_result();
            
            if ($cart_result->num_rows === 0) {
                $cart_stmt->close();
                throw new Exception('Cart is empty');
            }
            
            $cart_items = $cart_result->fetch_all(MYSQLI_ASSOC);
            $cart_stmt->close();
            
            // Calculate total and verify stock
            $total_amount = 0;
            foreach ($cart_items as $item) {
                if ($item['stock_quantity'] < $item['quantity']) {
                    throw new Exception('Insufficient stock for product ID: ' . $item['product_id']);
                }
                $total_amount += ($item['price'] * $item['quantity']);
            }
            
            // Create order
            $order_query = "INSERT INTO orders (user_id, total_amount, payment_method, order_status) 
                           VALUES (?, ?, ?, 'pending')";
            $order_stmt = $this->db->prepare($order_query);
            $order_stmt->bind_param('ids', $user_id, $total_amount, $payment_method);
            
            if (!$order_stmt->execute()) {
                throw new Exception('Failed to create order');
            }
            
            $order_id = $this->db->insert_id;
            $order_stmt->close();
            
            // Add order items and update stock
            foreach ($cart_items as $item) {
                // Insert order item
                $item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                             VALUES (?, ?, ?, ?)";
                $item_stmt = $this->db->prepare($item_query);
                $item_stmt->bind_param('iiii', $order_id, $item['product_id'], $item['quantity'], $item['price']);
                
                if (!$item_stmt->execute()) {
                    throw new Exception('Failed to add order item');
                }
                
                $item_stmt->close();
                
                // Update product stock
                $update_stock = "UPDATE products SET stock_quantity = stock_quantity - ? WHERE product_id = ?";
                $stock_stmt = $this->db->prepare($update_stock);
                $stock_stmt->bind_param('ii', $item['quantity'], $item['product_id']);
                
                if (!$stock_stmt->execute()) {
                    throw new Exception('Failed to update stock');
                }
                
                $stock_stmt->close();
                
                // Log inventory change
                $log_query = "INSERT INTO inventory_logs (product_id, quantity_changed, action_type) 
                            VALUES (?, ?, 'sold')";
                $log_stmt = $this->db->prepare($log_query);
                $qty_change = -$item['quantity'];
                $log_stmt->bind_param('ii', $item['product_id'], $qty_change);
                $log_stmt->execute();
                $log_stmt->close();
            }
            
            // Create payment record
            $payment_query = "INSERT INTO payments (order_id, payment_method, payment_status, amount_paid) 
                            VALUES (?, ?, 'completed', ?)";
            $payment_stmt = $this->db->prepare($payment_query);
            $status = 'completed';
            $payment_stmt->bind_param('iss', $order_id, $status, $total_amount);
            
            if (!$payment_stmt->execute()) {
                throw new Exception('Failed to create payment record');
            }
            
            $payment_stmt->close();
            
            // Clear cart
            $clear_query = "DELETE FROM carts WHERE user_id = ?";
            $clear_stmt = $this->db->prepare($clear_query);
            $clear_stmt->bind_param('i', $user_id);
            $clear_stmt->execute();
            $clear_stmt->close();
            
            // Commit transaction
            $this->db->commit();
            
            $this->order_id = $order_id;
            $this->user_id = $user_id;
            $this->total_amount = $total_amount;
            $this->payment_method = $payment_method;
            $this->order_status = 'pending';
            
            return $order_id;
            
        } catch (Exception $e) {
            $this->db->rollback();
            throw $e;
        }
    }
    
    /**
     * Get order items
     */
    public function getOrderItems() {
        $query = "SELECT oi.*, p.product_name, p.product_image FROM order_items oi
                 JOIN products p ON oi.product_id = p.product_id
                 WHERE oi.order_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $this->order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $items;
    }
    
    /**
     * Update order status
     */
    public function updateStatus($new_status) {
        $valid_statuses = ['pending', 'completed', 'cancelled'];
        
        if (!in_array($new_status, $valid_statuses)) {
            throw new Exception('Invalid order status');
        }
        
        $query = "UPDATE orders SET order_status = ? WHERE order_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $new_status, $this->order_id);
        
        if (!$stmt->execute()) {
            $stmt->close();
            throw new Exception('Failed to update order status');
        }
        
        $this->order_status = $new_status;
        $stmt->close();
        
        return true;
    }
    
    // Getters
    public function getOrderId() { return $this->order_id; }
    public function getUserId() { return $this->user_id; }
    public function getTotalAmount() { return $this->total_amount; }
    public function getPaymentMethod() { return $this->payment_method; }
    public function getOrderStatus() { return $this->order_status; }
    public function getDateOrdered() { return $this->date_ordered; }
}
?>
