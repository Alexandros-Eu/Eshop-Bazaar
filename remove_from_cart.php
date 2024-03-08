<?php
session_start();

// Checks if the SKU of the item to be removed is set in the POST request 
// and if it exists in the session cart
if(isset($_POST['sku']) && isset($_SESSION['cart'][$_POST['sku']])) 
{
    unset($_SESSION['cart'][$_POST['sku']]); // If so remove the item from the session cart
}

// Redirect back to the cart page
header("Location: cart.php");
exit();
?>
