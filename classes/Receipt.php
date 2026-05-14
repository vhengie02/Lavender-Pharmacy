<?php
/**
 * Receipt Class - Handle receipt generation and management
 */

class Receipt {
    private $receipt_id;
    private $order_id;
    private $invoice_number;
    private $vat_amount;
    private $vat_exempt_sales;
    private $zero_rated_sales;
    private $cash_tendered;
    private $change_amount;
    private $date_created;
    private $db;
    
    const VAT_RATE = 0.12;
    const VAT_REG_TIN = '000-310-457-107';
    const BUSINESS_NAME = 'LAVENDER PHARMACY';
    
    /**
     * Constructor
     */
    public function __construct($receipt_id = null) {
        $this->db = Database::getInstance()->getConnection();
        
        if ($receipt_id) {
            $this->loadReceipt($receipt_id);
        }
    }
    
    /**
     * Load receipt data
     */
    private function loadReceipt($receipt_id) {
        $query = "SELECT * FROM receipts WHERE receipt_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $receipt_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $receipt = $result->fetch_assoc();
            $this->receipt_id = $receipt['receipt_id'];
            $this->order_id = $receipt['order_id'];
            $this->invoice_number = $receipt['invoice_number'];
            $this->vat_amount = $receipt['vat_amount'];
            $this->vat_exempt_sales = $receipt['vat_exempt_sales'];
            $this->zero_rated_sales = $receipt['zero_rated_sales'];
            $this->cash_tendered = $receipt['cash_tendered'];
            $this->change_amount = $receipt['change_amount'];
            $this->date_created = $receipt['date_created'];
        }
        
        $stmt->close();
    }
    
    /**
     * Generate receipt for order
     */
    public function generateReceipt($order_id, $cash_tendered = null) {
        // Get order details
        $order_query = "SELECT * FROM orders WHERE order_id = ?";
        $order_stmt = $this->db->prepare($order_query);
        $order_stmt->bind_param('i', $order_id);
        $order_stmt->execute();
        $order_result = $order_stmt->get_result();
        
        if ($order_result->num_rows === 0) {
            $order_stmt->close();
            throw new Exception('Order not found');
        }
        
        $order = $order_result->fetch_assoc();
        $order_stmt->close();
        
        // Generate invoice number
        $invoice_number = $this->generateInvoiceNumber();
        
        // Calculate VAT
        $vatable_amount = $order['total_amount'];
        $vat_amount = $vatable_amount * self::VAT_RATE;
        $total_with_vat = $vatable_amount + $vat_amount;
        
        // Calculate change if cash provided
        $change_amount = null;
        if ($cash_tendered !== null && $cash_tendered >= $total_with_vat) {
            $change_amount = $cash_tendered - $total_with_vat;
        }
        
        // Insert receipt
        $insert_query = "INSERT INTO receipts (order_id, invoice_number, vat_amount, vat_exempt_sales, zero_rated_sales, cash_tendered, change_amount) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $this->db->prepare($insert_query);
        
        $vat_exempt = 0;
        $zero_rated = 0;
        
        $insert_stmt->bind_param(
            'isdddd d',
            $order_id,
            $invoice_number,
            $vat_amount,
            $vat_exempt,
            $zero_rated,
            $cash_tendered,
            $change_amount
        );
        
        if (!$insert_stmt->execute()) {
            throw new Exception('Failed to generate receipt');
        }
        
        $this->receipt_id = $this->db->insert_id;
        $this->order_id = $order_id;
        $this->invoice_number = $invoice_number;
        $this->vat_amount = $vat_amount;
        $this->vat_exempt_sales = $vat_exempt;
        $this->zero_rated_sales = $zero_rated;
        $this->cash_tendered = $cash_tendered;
        $this->change_amount = $change_amount;
        
        $insert_stmt->close();
        
        return $this->receipt_id;
    }
    
    /**
     * Generate unique invoice number
     */
    private function generateInvoiceNumber() {
        // Format: YYYYMMDDHHMMSS + random 3 digits
        $prefix = date('YmdHis');
        $suffix = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
        return $prefix . $suffix;
    }
    
    /**
     * Get receipt HTML for printing
     */
    public function getReceiptHTML() {
        // Get order and customer details
        $query = "SELECT o.*, u.name as customer_name, u.contact_number 
                 FROM orders o
                 JOIN users u ON o.user_id = u.user_id
                 WHERE o.order_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $this->order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
        $stmt->close();
        
        // Get order items
        $items_query = "SELECT oi.quantity, oi.price, p.product_name FROM order_items oi
                       JOIN products p ON oi.product_id = p.product_id
                       WHERE oi.order_id = ?";
        $items_stmt = $this->db->prepare($items_query);
        $items_stmt->bind_param('i', $this->order_id);
        $items_stmt->execute();
        $items_result = $items_stmt->get_result();
        $items = $items_result->fetch_all(MYSQLI_ASSOC);
        $items_stmt->close();
        
        // Calculate totals
        $subtotal = 0;
        $items_html = '';
        foreach ($items as $item) {
            $amount = $item['quantity'] * $item['price'];
            $subtotal += $amount;
            $items_html .= sprintf(
                "<tr><td>%s</td><td align='right'>%d</td><td align='right'>₱%.2f</td><td align='right'>₱%.2f</td></tr>",
                htmlspecialchars($item['product_name']),
                $item['quantity'],
                $item['price'],
                $amount
            );
        }
        
        $vat_amount = $subtotal * self::VAT_RATE;
        $total = $subtotal + $vat_amount;
        $change = $this->change_amount ?? 0;
        
        $html = '
        <html>
        <head>
            <title>Receipt - ' . $this->invoice_number . '</title>
            <style>
                body { font-family: Arial, sans-serif; font-size: 12px; }
                .receipt { width: 400px; margin: 20px auto; border: 1px solid #999; padding: 15px; }
                .header { text-align: center; margin-bottom: 10px; border-bottom: 1px solid #999; padding-bottom: 10px; }
                .header h2 { margin: 0; }
                .receipt-number { text-align: center; margin: 10px 0; }
                .details { margin: 10px 0; padding: 10px 0; border-bottom: 1px solid #999; }
                table { width: 100%; margin: 10px 0; }
                td { padding: 5px; }
                .line { border-bottom: 1px solid #999; }
                .total { font-weight: bold; }
                .footer { text-align: center; margin-top: 15px; font-size: 11px; }
            </style>
        </head>
        <body>
            <div class="receipt">
                <div class="header">
                    <h2>' . self::BUSINESS_NAME . '</h2>
                    <p>Pharmacy Management System</p>
                </div>
                
                <div class="receipt-number">
                    <strong>SALES INVOICE NO.</strong><br>
                    ' . $this->invoice_number . '
                </div>
                
                <div class="details">
                    <table>
                        <tr><td>Date:</td><td>' . date('m/d/Y', strtotime($this->date_created)) . '</td></tr>
                        <tr><td>Time:</td><td>' . date('H:i:s', strtotime($this->date_created)) . '</td></tr>
                        <tr><td>Customer:</td><td>' . htmlspecialchars($order['customer_name']) . '</td></tr>
                    </table>
                </div>
                
                <table>
                    <tr class="line">
                        <td><strong>PRODUCT</strong></td>
                        <td align="right"><strong>QTY</strong></td>
                        <td align="right"><strong>PRICE</strong></td>
                        <td align="right"><strong>AMOUNT</strong></td>
                    </tr>
                    ' . $items_html . '
                </table>
                
                <table>
                    <tr><td>Subtotal:</td><td align="right">₱' . number_format($subtotal, 2) . '</td></tr>
                    <tr><td>VAT (12%):</td><td align="right">₱' . number_format($vat_amount, 2) . '</td></tr>
                    <tr class="total"><td>TOTAL DUE:</td><td align="right">₱' . number_format($total, 2) . '</td></tr>
                </table>
                
                <table>
                    <tr><td>Payment Method:</td><td>' . strtoupper($order['payment_method']) . '</td></tr>
                    ' . ($this->cash_tendered ? '<tr><td>Cash Tendered:</td><td align="right">₱' . number_format($this->cash_tendered, 2) . '</td></tr>' : '') . '
                    ' . ($change > 0 ? '<tr class="total"><td>Change Due:</td><td align="right">₱' . number_format($change, 2) . '</td></tr>' : '') . '
                </table>
                
                <div class="footer">
                    <p>Thank you for your purchase!</p>
                    <p>For inquiries, call: 09188887673</p>
                </div>
            </div>
        </body>
        </html>
        ';
        
        return $html;
    }
    
    // Getters
    public function getReceiptId() { return $this->receipt_id; }
    public function getOrderId() { return $this->order_id; }
    public function getInvoiceNumber() { return $this->invoice_number; }
    public function getVatAmount() { return $this->vat_amount; }
    public function getCashTendered() { return $this->cash_tendered; }
    public function getChangeAmount() { return $this->change_amount; }
}
?>
