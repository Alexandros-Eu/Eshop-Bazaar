<?php
session_start();

// Check if the action is set in the POST request
if(isset($_POST['action'])) {
    // Switch statement to handle different actions
    switch($_POST['action']) {
        case 'update':  // Update action: Update quantity of an item in the cart
            if(isset($_POST['sku']) && isset($_POST['quantity'])) { // Check if SKU and quantity are set 
                $sku = $_POST['sku'];
                $quantity = $_POST['quantity'];

                // Update quantity in cart if the item exists
                if(isset($_SESSION['cart'][$sku])) {
                    // Ensure the quantity is a positive integer
                    $quantity = max(0, intval($quantity));
                    // Set the new quantity
                    $_SESSION['cart'][$sku] = $quantity;
                }
            }
            break;

        case 'remove':  // Remove an item from the cart
            if(isset($_POST['sku'])) {
                $sku = $_POST['sku'];

                // Remove item from cart if it exists
                if(isset($_SESSION['cart'][$sku])) {
                    unset($_SESSION['cart'][$sku]);
                }
            }
            break;

        case 'clear':   // Clear entire cart
            unset($_SESSION['cart']);
            break;
    }
}

// Redirect back to cart page
header("Location: cart.php");
exit();
?>

