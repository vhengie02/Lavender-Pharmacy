<?php
/**
 * AJAX Cart Handler
 * Handles add, remove, and update cart operations
 */

require_once dirname(__DIR__) . '/includes/init.php';

header('Content-Type: application/json');

try {
    // Ensure user is logged in and is a customer
    if (!isLoggedIn() || !hasRole(ROLE_CUSTOMER)) {
        throw new Exception('Unauthorized');
    }

    $user_id = $_SESSION['user_id'];
    $customer = new Customer($user_id);
    
    $action = $_POST['action'] ?? null;
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : null;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    if (!$action || !$product_id) {
        throw new Exception('Invalid request');
    }

    // Get product info for response
    $product_data = Product::getProductById($product_id);
    
    if (!$product_data) {
        throw new Exception('Product not found');
    }

    $response = [
        'success' => false,
        'message' => '',
        'product_name' => $product_data['product_name'] ?? '',
    ];

    switch ($action) {
        case 'add':
            $customer->addToCart($product_id, $quantity);
            $response['success'] = true;
            $response['message'] = 'Item added to cart';
            break;

        case 'remove':
            // Get cart item by product_id
            $cart_items = $customer->getCart();
            $cart_id = null;
            foreach ($cart_items as $item) {
                if ($item['product_id'] == $product_id) {
                    $cart_id = $item['cart_id'];
                    break;
                }
            }
            
            if ($cart_id) {
                $customer->removeFromCart($cart_id);
                $response['success'] = true;
                $response['message'] = 'Item removed from cart';
            } else {
                throw new Exception('Item not found in cart');
            }
            break;

        case 'update':
            if ($quantity <= 0) {
                // Remove item if quantity is 0 or less
                $cart_items = $customer->getCart();
                $cart_id = null;
                foreach ($cart_items as $item) {
                    if ($item['product_id'] == $product_id) {
                        $cart_id = $item['cart_id'];
                        break;
                    }
                }
                if ($cart_id) {
                    $customer->removeFromCart($cart_id);
                }
            } else {
                // Get cart item and update
                $cart_items = $customer->getCart();
                $cart_id = null;
                $current_item = null;
                foreach ($cart_items as $item) {
                    if ($item['product_id'] == $product_id) {
                        $cart_id = $item['cart_id'];
                        $current_item = $item;
                        break;
                    }
                }
                
                if ($cart_id) {
                    $customer->updateCartQuantity($cart_id, $quantity);
                } else {
                    throw new Exception('Item not found in cart');
                }
            }
            $response['success'] = true;
            $response['message'] = 'Cart updated';
            break;

        default:
            throw new Exception('Invalid action');
    }

    // Get updated cart info
    $cart_items = $customer->getCart();
    $response['cart_count'] = count($cart_items);
    
    // Calculate totals for cart summary
    $subtotal = 0;
    $item_subtotal = 0;
    foreach ($cart_items as $item) {
        $item_total = $item['price'] * $item['quantity'];
        $subtotal += $item_total;
        if ($item['product_id'] == $product_id) {
            $item_subtotal = $item_total;
        }
    }
    
    $response['subtotal'] = $subtotal;
    $response['cart_total'] = $subtotal;
    $response['item_subtotal'] = $item_subtotal;

} catch (Exception $e) {
    http_response_code(400);
    $response = [
        'success' => false,
        'message' => $e->getMessage(),
        'cart_count' => 0,
    ];
}

echo json_encode($response);
exit;
