<?php
session_start();

// Check if SKU is provided through POST request
if(isset($_POST['sku'])) {
    // Retrieve SKU and quantity from POST data
    $sku = $_POST['sku'];
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1; // Default quantity is 1 if not provided

    // Add the SKU and quantity to the session cart
    $_SESSION['cart'][$sku] = $quantity;
    
    // Redirect back to the previous page
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit(); // Terminate script execution in order to get redirected immediately
}
?>
