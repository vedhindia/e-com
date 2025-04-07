<?php
session_start();
include_once 'admin/dbconnection.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to log debug information
function debug_log($message, $data = null) {
    error_log(date('Y-m-d H:i:s') . " - " . $message . ($data ? " - Data: " . json_encode($data) : ""));
}

// Generate or get session ID
if (!isset($_SESSION['session_id'])) {
    $_SESSION['session_id'] = session_id();
}
$session_id = $_SESSION['session_id'];
debug_log("Session ID: " . $session_id);

// Function to get cart count
function getCartCount($conn, $session_id) {
    try {
        $sql = "SELECT SUM(quantity) as count FROM cart WHERE session_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            throw new Exception("Error preparing cart count query: " . mysqli_error($conn));
        }
        
        mysqli_stmt_bind_param($stmt, "s", $session_id);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error executing cart count query: " . mysqli_stmt_error($stmt));
        }
        
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        return $row['count'] ?? 0;
    } catch (Exception $e) {
        debug_log("Error in getCartCount: " . $e->getMessage());
        return 0;
    }
}

$response = array('success' => false, 'message' => '', 'cart_count' => 0, 'debug_info' => []);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $unit_id = isset($_POST['unit_id']) && $_POST['unit_id'] !== '' ? (int)$_POST['unit_id'] : null;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        debug_log("Received request", ['product_id' => $product_id, 'unit_id' => $unit_id, 'quantity' => $quantity]);

        if ($product_id <= 0) {
            throw new Exception('Invalid product ID');
        }

        // Check if product exists and get category information
        $check_sql = "SELECT p.id, p.main_category, p.subcategory, p.product_name, 
                     (SELECT COUNT(*) FROM product_units WHERE product_id = p.id) as unit_count 
                     FROM products p 
                     WHERE p.id = ?";
        $stmt = mysqli_prepare($conn, $check_sql);
        if (!$stmt) {
            throw new Exception("Error preparing product check query: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "i", $product_id);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error executing product check query: " . mysqli_stmt_error($stmt));
        }

        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) === 0) {
            throw new Exception("Product not found");
        }

        $product = mysqli_fetch_assoc($result);
        debug_log("Product found", $product);

        // Handle unit validation
        if ($product['unit_count'] > 0) {
            // Product has units, so unit selection is required
            if ($unit_id === null) {
                // If no unit selected, get the default unit
                $default_unit_sql = "SELECT id FROM product_units WHERE product_id = ? ORDER BY id ASC LIMIT 1";
                $stmt = mysqli_prepare($conn, $default_unit_sql);
                if (!$stmt) {
                    throw new Exception("Error preparing default unit query: " . mysqli_error($conn));
                }

                mysqli_stmt_bind_param($stmt, "i", $product_id);
                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception("Error executing default unit query: " . mysqli_stmt_error($stmt));
                }

                $unit_result = mysqli_stmt_get_result($stmt);
                if ($unit_row = mysqli_fetch_assoc($unit_result)) {
                    $unit_id = $unit_row['id'];
                    debug_log("Using default unit", ['unit_id' => $unit_id]);
                } else {
                    throw new Exception("No units available for this product");
                }
            } else {
                // Validate the selected unit
                $unit_check_sql = "SELECT id FROM product_units WHERE id = ? AND product_id = ?";
                $stmt = mysqli_prepare($conn, $unit_check_sql);
                if (!$stmt) {
                    throw new Exception("Error preparing unit check query: " . mysqli_error($conn));
                }

                mysqli_stmt_bind_param($stmt, "ii", $unit_id, $product_id);
                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception("Error executing unit check query: " . mysqli_stmt_error($stmt));
                }

                $unit_result = mysqli_stmt_get_result($stmt);
                if (mysqli_num_rows($unit_result) === 0) {
                    throw new Exception("Invalid unit selected for this product");
                }
            }
        } else {
            // Product has no units, so unit_id should be null
            $unit_id = null;
        }

        // Check if product is already in cart
        $cart_sql = "SELECT id, quantity FROM cart WHERE session_id = ? AND product_id = ? AND (unit_id = ? OR (unit_id IS NULL AND ? IS NULL))";
        $stmt = mysqli_prepare($conn, $cart_sql);
        if (!$stmt) {
            throw new Exception("Error preparing cart check query: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "siii", $session_id, $product_id, $unit_id, $unit_id);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error executing cart check query: " . mysqli_stmt_error($stmt));
        }

        $cart_result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($cart_result) > 0) {
            // Product already exists in cart
            $response['success'] = false;
            $response['message'] = $product['product_name'] . ' is already in your cart. You can update the quantity in the cart page.';
            debug_log("Product already in cart", ['product_id' => $product_id, 'product_name' => $product['product_name']]);
        } else {
            // Add new cart item
            $insert_sql = "INSERT INTO cart (session_id, product_id, main_category, subcategory, unit_id, quantity) 
                          VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insert_sql);
            if (!$stmt) {
                throw new Exception("Error preparing insert query: " . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($stmt, "sissii", $session_id, $product_id, $product['main_category'], 
                                 $product['subcategory'], $unit_id, $quantity);
            
            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Error executing insert query: " . mysqli_stmt_error($stmt));
            }

            debug_log("New cart item added", [
                'session_id' => $session_id,
                'product_id' => $product_id,
                'main_category' => $product['main_category'],
                'subcategory' => $product['subcategory'],
                'unit_id' => $unit_id
            ]);
            
            $response['success'] = true;
            $response['message'] = $product['product_name'] . ' added to cart successfully';
        }

    } catch (Exception $e) {
        debug_log("Error in cart operation: " . $e->getMessage());
        $response['success'] = false;
        $response['message'] = 'Error: ' . $e->getMessage();
        $response['debug_info'] = [
            'error_message' => $e->getMessage(),
            'error_trace' => $e->getTraceAsString()
        ];
    }
} else {
    $response['message'] = 'Invalid request method';
    debug_log("Invalid request method: " . $_SERVER['REQUEST_METHOD']);
}

// Get updated cart count
$response['cart_count'] = getCartCount($conn, $session_id);
debug_log("Final cart count: " . $response['cart_count']);

header('Content-Type: application/json');
echo json_encode($response);
?> 