<?php
/**
 * Editor Class - Extends User class with product management functionality
 */

class Editor extends User {
    
    /**
     * Add new product
     */
    public function addProduct($product_data) {
        // Validate required fields
        $required_fields = ['product_name', 'category_id', 'price', 'stock_quantity'];
        foreach ($required_fields as $field) {
            if (!isset($product_data[$field])) {
                throw new Exception("Missing required field: $field");
            }
        }
        
        $query = "INSERT INTO products (
                    product_name, generic_name, brand_name, category_id, 
                    description, dosage_info, price, stock_quantity, 
                    expiration_date, manufacturer, barcode, product_image, prescription_required
                 ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bind_param(
            'sssissdisssi',
            $product_data['product_name'],
            $product_data['generic_name'] ?? null,
            $product_data['brand_name'] ?? null,
            $product_data['category_id'],
            $product_data['description'] ?? null,
            $product_data['dosage_info'] ?? null,
            $product_data['price'],
            $product_data['stock_quantity'],
            $product_data['expiration_date'] ?? null,
            $product_data['manufacturer'] ?? null,
            $product_data['barcode'] ?? null,
            $product_data['product_image'] ?? null,
            $product_data['prescription_required'] ?? false
        );
        
        if (!$stmt->execute()) {
            throw new Exception('Failed to add product: ' . $stmt->error);
        }
        
        $product_id = $this->db->insert_id;
        $stmt->close();
        
        return $product_id;
    }
    
    /**
     * Update product
     */
    public function updateProduct($product_id, $product_data) {
        $updates = [];
        $params = [];
        $types = '';
        
        foreach ($product_data as $key => $value) {
            if ($key !== 'product_id') {
                $updates[] = "$key = ?";
                $params[] = $value;
                $types .= is_int($value) ? 'i' : (is_float($value) ? 'd' : 's');
            }
        }
        
        if (empty($updates)) {
            throw new Exception('No fields to update');
        }
        
        $params[] = $product_id;
        $types .= 'i';
        
        $query = "UPDATE products SET " . implode(', ', $updates) . " WHERE product_id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param($types, ...$params);
        
        if (!$stmt->execute()) {
            throw new Exception('Failed to update product');
        }
        
        $stmt->close();
        return true;
    }
    
    /**
     * Update inventory
     */
    public function updateInventory($product_id, $quantity, $action_type = 'adjusted', $notes = null) {
        // Get current quantity
        $query = "SELECT stock_quantity FROM products WHERE product_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            $stmt->close();
            throw new Exception('Product not found');
        }
        
        $product = $result->fetch_assoc();
        $old_quantity = $product['stock_quantity'];
        $new_quantity = $old_quantity + $quantity;
        
        // Prevent negative stock
        if ($new_quantity < 0) {
            $stmt->close();
            throw new Exception('Insufficient stock');
        }
        
        $stmt->close();
        
        // Update product stock
        $update_query = "UPDATE products SET stock_quantity = ? WHERE product_id = ?";
        $update_stmt = $this->db->prepare($update_query);
        $update_stmt->bind_param('ii', $new_quantity, $product_id);
        
        if (!$update_stmt->execute()) {
            $update_stmt->close();
            throw new Exception('Failed to update inventory');
        }
        
        $update_stmt->close();
        
        // Log inventory change
        $log_query = "INSERT INTO inventory_logs (product_id, quantity_changed, action_type, previous_quantity, new_quantity, notes) 
                     VALUES (?, ?, ?, ?, ?, ?)";
        $log_stmt = $this->db->prepare($log_query);
        $log_stmt->bind_param('iisiis', $product_id, $quantity, $action_type, $old_quantity, $new_quantity, $notes);
        
        if (!$log_stmt->execute()) {
            $log_stmt->close();
            throw new Exception('Failed to log inventory change');
        }
        
        $log_stmt->close();
        return true;
    }
    
    /**
     * Get all products
     */
    public function getAllProducts() {
        $query = "SELECT p.*, c.category_name FROM products p 
                 LEFT JOIN categories c ON p.category_id = c.category_id 
                 ORDER BY p.date_added DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $products;
    }
    
    /**
     * Get low stock products
     */
    public function getLowStockProducts($threshold = 10) {
        $query = "SELECT * FROM products WHERE stock_quantity < ? ORDER BY stock_quantity ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $threshold);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $products;
    }
}
?>
