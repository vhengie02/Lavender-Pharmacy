<?php
/**
 * Admin Class - Extends User class with admin-specific functionality
 */

class Admin extends User {
    
    /**
     * Manage all user accounts
     */
    public function getAllUsers() {
        $query = "SELECT user_id, name, email, role, status, date_created FROM users ORDER BY date_created DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $users = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $users;
    }
    
    /**
     * Delete user account
     */
    public function deleteUser($user_id) {
        // Cannot delete admin accounts
        $user = self::getUserById($user_id);
        if ($user['role'] === ROLE_ADMIN) {
            throw new Exception('Cannot delete admin accounts');
        }
        
        $query = "DELETE FROM users WHERE user_id = ? AND role != ?";
        $stmt = $this->db->prepare($query);
        $role = ROLE_ADMIN;
        $stmt->bind_param('is', $user_id, $role);
        
        if (!$stmt->execute()) {
            throw new Exception('Failed to delete user');
        }
        
        $stmt->close();
        return true;
    }
    
    /**
     * Update user role
     */
    public function updateUserRole($user_id, $new_role) {
        $valid_roles = [ROLE_ADMIN, ROLE_EDITOR, ROLE_CUSTOMER];
        
        if (!in_array($new_role, $valid_roles)) {
            throw new Exception('Invalid role');
        }
        
        $query = "UPDATE users SET role = ? WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $new_role, $user_id);
        
        if (!$stmt->execute()) {
            throw new Exception('Failed to update user role');
        }
        
        $stmt->close();
        return true;
    }
    
    /**
     * Get dashboard statistics
     */
    public function getDashboardStats() {
        $stats = [];
        
        // Total users
        $result = $this->db->query("SELECT COUNT(*) as count FROM users");
        $stats['total_users'] = $result->fetch_assoc()['count'];
        
        // Total products
        $result = $this->db->query("SELECT COUNT(*) as count FROM products");
        $stats['total_products'] = $result->fetch_assoc()['count'];
        
        // Total orders
        $result = $this->db->query("SELECT COUNT(*) as count FROM orders");
        $stats['total_orders'] = $result->fetch_assoc()['count'];
        
        // Total sales (today)
        $result = $this->db->query("SELECT SUM(total_amount) as total FROM orders WHERE DATE(date_ordered) = CURDATE()");
        $stats['today_sales'] = $result->fetch_assoc()['total'] ?? 0;
        
        // Total sales (this month)
        $result = $this->db->query("SELECT SUM(total_amount) as total FROM orders WHERE MONTH(date_ordered) = MONTH(NOW()) AND YEAR(date_ordered) = YEAR(NOW())");
        $stats['month_sales'] = $result->fetch_assoc()['total'] ?? 0;
        
        // Low stock products
        $result = $this->db->query("SELECT COUNT(*) as count FROM products WHERE stock_quantity < 10");
        $stats['low_stock'] = $result->fetch_assoc()['count'];
        
        return $stats;
    }
    
    /**
     * Log admin action for audit trail
     */
    public function logAction($action, $table_name, $record_id, $old_value = null, $new_value = null) {
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        $query = "INSERT INTO audit_logs (user_id, action_performed, table_name, record_id, old_value, new_value, ip_address, user_agent) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(
            'issisiss',
            $this->user_id,
            $action,
            $table_name,
            $record_id,
            $old_value,
            $new_value,
            $ip_address,
            $user_agent
        );
        
        if (!$stmt->execute()) {
            throw new Exception('Failed to log action');
        }
        
        $stmt->close();
        return true;
    }
}
?>
