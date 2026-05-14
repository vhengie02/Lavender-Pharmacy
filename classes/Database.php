<?php
/**
 * Database Class
 * Handles all database connections and queries
 * Implements OOP principles with singleton pattern
 */

class Database {
    private static $instance = null;
    private $connection;
    private $host;
    private $user;
    private $password;
    private $database;
    
    /**
     * Constructor - Initialize database configuration
     */
    private function __construct() {
        $this->host = DB_HOST;
        $this->user = DB_USER;
        $this->password = DB_PASS;
        $this->database = DB_NAME;
        $this->connect();
    }
    
    /**
     * Get singleton instance of Database
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Connect to database
     */
    private function connect() {
        $this->connection = new mysqli(
            $this->host,
            $this->user,
            $this->password,
            $this->database
        );
        
        if ($this->connection->connect_error) {
            die('Database Connection Error: ' . $this->connection->connect_error);
        }
        
        // Set charset to utf8mb4
        $this->connection->set_charset('utf8mb4');
    }
    
    /**
     * Get connection object
     */
    public function getConnection() {
        return $this->connection;
    }
    
    /**
     * Execute SELECT query
     */
    public function select($query, $params = []) {
        $stmt = $this->connection->prepare($query);
        
        if (!$stmt) {
            throw new Exception('Query error: ' . $this->connection->error);
        }
        
        if (!empty($params)) {
            $types = '';
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_float($param)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
            }
            $stmt->bind_param($types, ...$params);
        }
        
        if (!$stmt->execute()) {
            throw new Exception('Query execution error: ' . $stmt->error);
        }
        
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Execute INSERT query
     */
    public function insert($query, $params = []) {
        $stmt = $this->connection->prepare($query);
        
        if (!$stmt) {
            throw new Exception('Query error: ' . $this->connection->error);
        }
        
        if (!empty($params)) {
            $types = '';
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_float($param)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
            }
            $stmt->bind_param($types, ...$params);
        }
        
        if (!$stmt->execute()) {
            throw new Exception('Query execution error: ' . $stmt->error);
        }
        
        return $this->connection->insert_id;
    }
    
    /**
     * Execute UPDATE query
     */
    public function update($query, $params = []) {
        return $this->executeModify($query, $params);
    }
    
    /**
     * Execute DELETE query
     */
    public function delete($query, $params = []) {
        return $this->executeModify($query, $params);
    }
    
    /**
     * Helper function for UPDATE/DELETE queries
     */
    private function executeModify($query, $params = []) {
        $stmt = $this->connection->prepare($query);
        
        if (!$stmt) {
            throw new Exception('Query error: ' . $this->connection->error);
        }
        
        if (!empty($params)) {
            $types = '';
            foreach ($params as $param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_float($param)) {
                    $types .= 'd';
                } else {
                    $types .= 's';
                }
            }
            $stmt->bind_param($types, ...$params);
        }
        
        if (!$stmt->execute()) {
            throw new Exception('Query execution error: ' . $stmt->error);
        }
        
        return $stmt->affected_rows;
    }
    
    /**
     * Prevent cloning of singleton
     */
    private function __clone() {}
    
    /**
     * Prevent unserializing
     */
    private function __wakeup() {}
    
    /**
     * Close connection on destruct
     */
    public function __destruct() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}
?>
