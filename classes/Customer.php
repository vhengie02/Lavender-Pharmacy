<?php
/**
 * Customer Class - Extends User class with shopping functionality
 */

class Customer extends User {
    
    /**
     * Add product to cart
     */
    public function addToCart($product_id, $quantity = 1) {
        // Check if product exists and has stock
        $check_query = "SELECT product_id, stock_quantity FROM products WHERE product_id = ?";
        $check_stmt = $this->db->prepare($check_query);
        $check_stmt->bind_param('i', $product_id);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        
        if ($result->num_rows === 0) {
            $check_stmt->close();
            throw new Exception('Product not found');
        }
        
        $product = $result->fetch_assoc();
        $check_stmt->close();
        
        if ($product['stock_quantity'] < $quantity) {
            throw new Exception('Insufficient stock available');
        }
        
        // Check if product already in cart
        $cart_check = "SELECT cart_id, quantity FROM carts WHERE user_id = ? AND product_id = ?";
        $cart_stmt = $this->db->prepare($cart_check);
        $cart_stmt->bind_param('ii', $this->user_id, $product_id);
        $cart_stmt->execute();
        $cart_result = $cart_stmt->get_result();
        
        if ($cart_result->num_rows > 0) {
            // Update quantity
            $cart_row = $cart_result->fetch_assoc();
            $new_quantity = $cart_row['quantity'] + $quantity;
            
            $update_query = "UPDATE carts SET quantity = ? WHERE cart_id = ?";
            $update_stmt = $this->db->prepare($update_query);
            $update_stmt->bind_param('ii', $new_quantity, $cart_row['cart_id']);
            
            if (!$update_stmt->execute()) {
                $update_stmt->close();
                $cart_stmt->close();
                throw new Exception('Failed to update cart');
            }
            
            $update_stmt->close();
        } else {
            // Insert new cart item
            $insert_query = "INSERT INTO carts (user_id, product_id, quantity) VALUES (?, ?, ?)";
            $insert_stmt = $this->db->prepare($insert_query);
            $insert_stmt->bind_param('iii', $this->user_id, $product_id, $quantity);
            
            if (!$insert_stmt->execute()) {
                $insert_stmt->close();
                $cart_stmt->close();
                throw new Exception('Failed to add to cart');
            }
            
            $insert_stmt->close();
        }
        
        $cart_stmt->close();
        return true;
    }
    
    /**
     * Get cart items
     */
    public function getCart() {
        $query = "SELECT c.cart_id, c.product_id, c.quantity, p.product_name, p.price, p.product_image, p.stock_quantity
                 FROM carts c
                 JOIN products p ON c.product_id = p.product_id
                 WHERE c.user_id = ?
                 ORDER BY c.date_added DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $this->user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $cart_items = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $cart_items;
    }
    
    /**
     * Remove item from cart
     */
    public function removeFromCart($cart_id) {
        $query = "DELETE FROM carts WHERE cart_id = ? AND user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $cart_id, $this->user_id);
        
        if (!$stmt->execute()) {
            $stmt->close();
            throw new Exception('Failed to remove item from cart');
        }
        
        $stmt->close();
        return true;
    }
    
    /**
     * Update cart item quantity
     */
    public function updateCartQuantity($cart_id, $quantity) {
        if ($quantity <= 0) {
            throw new Exception('Quantity must be greater than 0');
        }
        
        $query = "UPDATE carts SET quantity = ? WHERE cart_id = ? AND user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iii', $quantity, $cart_id, $this->user_id);
        
        if (!$stmt->execute()) {
            $stmt->close();
            throw new Exception('Failed to update cart');
        }
        
        $stmt->close();
        return true;
    }
    
    /**
     * Clear entire cart
     */
    public function clearCart() {
        $query = "DELETE FROM carts WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $this->user_id);
        
        if (!$stmt->execute()) {
            $stmt->close();
            throw new Exception('Failed to clear cart');
        }
        
        $stmt->close();
        return true;
    }
    
    /**
     * Get order history
     */
    public function getOrderHistory() {
        $query = "SELECT o.order_id, o.total_amount, o.payment_method, o.order_status, o.date_ordered
                 FROM orders o
                 WHERE o.user_id = ?
                 ORDER BY o.date_ordered DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $this->user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $orders;
    }
    
    /**
     * Get order details
     */
    public function getOrderDetails($order_id) {
        $query = "SELECT oi.order_item_id, oi.quantity, oi.price, p.product_name
                 FROM order_items oi
                 JOIN products p ON oi.product_id = p.product_id
                 WHERE oi.order_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $items;
    }
}
?>
