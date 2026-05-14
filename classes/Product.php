<?php
/**
 * Product Class - Handle product operations
 */

class Product {
    private $product_id;
    private $product_name;
    private $generic_name;
    private $brand_name;
    private $category_id;
    private $description;
    private $dosage_info;
    private $price;
    private $stock_quantity;
    private $expiration_date;
    private $manufacturer;
    private $barcode;
    private $product_image;
    private $prescription_required;
    private $db;
    
    /**
     * Constructor
     */
    public function __construct($product_id = null) {
        $this->db = Database::getInstance()->getConnection();
        
        if ($product_id) {
            $this->loadProduct($product_id);
        }
    }
    
    /**
     * Load product data
     */
    private function loadProduct($product_id) {
        $query = "SELECT * FROM products WHERE product_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $this->product_id = $product['product_id'];
            $this->product_name = $product['product_name'];
            $this->generic_name = $product['generic_name'];
            $this->brand_name = $product['brand_name'];
            $this->category_id = $product['category_id'];
            $this->description = $product['description'];
            $this->dosage_info = $product['dosage_info'];
            $this->price = $product['price'];
            $this->stock_quantity = $product['stock_quantity'];
            $this->expiration_date = $product['expiration_date'];
            $this->manufacturer = $product['manufacturer'];
            $this->barcode = $product['barcode'];
            $this->product_image = $product['product_image'];
            $this->prescription_required = $product['prescription_required'];
        }
        
        $stmt->close();
    }
    
    /**
     * Get product by ID
     */
    public static function getProductById($product_id) {
        $db = Database::getInstance()->getConnection();
        
        $query = "SELECT * FROM products WHERE product_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();
        
        return $product;
    }
    
    /**
     * Get all products with category
     */
    public static function getAllProducts($limit = null) {
        $db = Database::getInstance()->getConnection();
        
        $query = "SELECT p.*, c.category_name FROM products p 
                 LEFT JOIN categories c ON p.category_id = c.category_id
                 WHERE p.stock_quantity > 0 AND p.expiration_date > NOW()
                 ORDER BY p.date_added DESC";
        
        if ($limit) {
            $query .= " LIMIT ?";
        }
        
        $stmt = $db->prepare($query);
        
        if ($limit) {
            $stmt->bind_param('i', $limit);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $products;
    }
    
    /**
     * Search products by name or category
     */
    public static function searchProducts($search_term) {
        $db = Database::getInstance()->getConnection();
        
        $search_term = "%$search_term%";
        $query = "SELECT p.*, c.category_name FROM products p 
                 LEFT JOIN categories c ON p.category_id = c.category_id
                 WHERE (p.product_name LIKE ? OR p.generic_name LIKE ? OR p.brand_name LIKE ? OR c.category_name LIKE ?)
                 AND p.stock_quantity > 0
                 ORDER BY p.product_name ASC";
        
        $stmt = $db->prepare($query);
        $stmt->bind_param('ssss', $search_term, $search_term, $search_term, $search_term);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $products;
    }
    
    /**
     * Get products by category
     */
    public static function getProductsByCategory($category_id) {
        $db = Database::getInstance()->getConnection();
        
        $query = "SELECT * FROM products WHERE category_id = ? AND stock_quantity > 0 ORDER BY product_name ASC";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $products;
    }
    
    /**
     * Check if product is in stock
     */
    public function isInStock($quantity = 1) {
        return $this->stock_quantity >= $quantity;
    }
    
    /**
     * Check if product is expired
     */
    public function isExpired() {
        if ($this->expiration_date === null) {
            return false;
        }
        return strtotime($this->expiration_date) < time();
    }
    
    // Getters
    public function getProductId() { return $this->product_id; }
    public function getProductName() { return $this->product_name; }
    public function getGenericName() { return $this->generic_name; }
    public function getBrandName() { return $this->brand_name; }
    public function getCategoryId() { return $this->category_id; }
    public function getDescription() { return $this->description; }
    public function getDosageInfo() { return $this->dosage_info; }
    public function getPrice() { return $this->price; }
    public function getStockQuantity() { return $this->stock_quantity; }
    public function getExpirationDate() { return $this->expiration_date; }
    public function getManufacturer() { return $this->manufacturer; }
    public function getBarcode() { return $this->barcode; }
    public function getProductImage() { return $this->product_image; }
    public function isPrescriptionRequired() { return $this->prescription_required; }
}
?>
