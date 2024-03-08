<?php
session_start();

// Check if the cart session variable is set and not empty
if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    
    unset($_SESSION['cart']);   // If so unset the cart in order to checkout successfully
    echo "Checkout successful!";
} else {
    echo "Your cart is empty. Cannot proceed to checkout."; // If the cart is empty print a message informing the user that the cart is empty and he cannot proceed
}
?>
