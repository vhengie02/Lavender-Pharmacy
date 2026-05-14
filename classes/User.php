<?php
/**
 * User Class - Base user class using OOP principles
 * Parent class for Admin, Editor, and Customer roles
 */

class User {
    protected $user_id;
    protected $name;
    protected $email;
    protected $password;
    protected $role;
    protected $contact_number;
    protected $address;
    protected $status;
    protected $date_created;
    protected $db;
    
    /**
     * Constructor
     */
    public function __construct($user_id = null) {
        $this->db = Database::getInstance()->getConnection();
        
        if ($user_id) {
            $this->loadUser($user_id);
        }
    }
    
    /**
     * Load user data from database
     */
    protected function loadUser($user_id) {
        $query = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $this->user_id = $user['user_id'];
            $this->name = $user['name'];
            $this->email = $user['email'];
            $this->password = $user['password'];
            $this->role = $user['role'];
            $this->contact_number = $user['contact_number'];
            $this->address = $user['address'];
            $this->status = $user['status'];
            $this->date_created = $user['date_created'];
        }
        
        $stmt->close();
    }
    
    /**
     * Register new user
     */
    public function register($name, $email, $password, $contact_number = null, $address = null, $role = ROLE_CUSTOMER) {
        // Validate inputs
        if (!$this->validateEmail($email)) {
            throw new Exception('Invalid email format');
        }
        
        if (!$this->validatePassword($password)) {
            throw new Exception('Password must be at least 8 characters with letters and numbers');
        }
        
        // Check if email already exists
        if ($this->emailExists($email)) {
            throw new Exception('Email already registered');
        }
        
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
        // Insert user
        $query = "INSERT INTO users (name, email, password, role, contact_number, address, status) 
                 VALUES (?, ?, ?, ?, ?, ?, 'active')";
        $stmt = $this->db->prepare($query);
        
        if (!$stmt) {
            throw new Exception('Database error: ' . $this->db->error);
        }
        
        $stmt->bind_param(
            'ssssss',
            $name,
            $email,
            $hashed_password,
            $role,
            $contact_number,
            $address
        );
        
        if (!$stmt->execute()) {
            throw new Exception('Registration failed: ' . $stmt->error);
        }
        
        $this->user_id = $this->db->insert_id;
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
        $this->contact_number = $contact_number;
        $this->address = $address;
        
        $stmt->close();
        
        return true;
    }
    
    /**
     * Validate email format
     */
    protected function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    /**
     * Validate password strength
     */
    protected function validatePassword($password) {
        // At least 8 characters, 1 letter, 1 number
        return strlen($password) >= 8 && preg_match('/[a-zA-Z]/', $password) && preg_match('/[0-9]/', $password);
    }
    
    /**
     * Check if email exists
     */
    protected function emailExists($email) {
        $query = "SELECT user_id FROM users WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();
        return $exists;
    }
    
    /**
     * Verify user credentials
     */
    public static function authenticate($email, $password) {
        $db = Database::getInstance()->getConnection();
        
        $query = "SELECT user_id, password, role, status FROM users WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            $stmt->close();
            return false;
        }
        
        $user = $result->fetch_assoc();
        $stmt->close();
        
        // Check if user is active
        if ($user['status'] !== 'active') {
            return false;
        }
        
        // Verify password
        if (!password_verify($password, $user['password'])) {
            return false;
        }
        
        // Update last login
        $update_query = "UPDATE users SET last_login = NOW() WHERE user_id = ?";
        $update_stmt = $db->prepare($update_query);
        $update_stmt->bind_param('i', $user['user_id']);
        $update_stmt->execute();
        $update_stmt->close();
        
        return $user;
    }
    
    /**
     * Get user by ID
     */
    public static function getUserById($user_id) {
        $db = Database::getInstance()->getConnection();
        
        $query = "SELECT * FROM users WHERE user_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        
        return $user;
    }
    
    // Getters
    public function getUserId() { return $this->user_id; }
    public function getName() { return $this->name; }
    public function getEmail() { return $this->email; }
    public function getRole() { return $this->role; }
    public function getContactNumber() { return $this->contact_number; }
    public function getAddress() { return $this->address; }
    public function getStatus() { return $this->status; }
    public function getDateCreated() { return $this->date_created; }
    
    // Setters
    public function setName($name) { $this->name = $name; }
    public function setContactNumber($contact_number) { $this->contact_number = $contact_number; }
    public function setAddress($address) { $this->address = $address; }
}
?>
