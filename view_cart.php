<?php

$totalPrice = 0;

if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Initialize total price
    

    $mysqli = new mysqli("localhost", "root", "", "e-shop");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Get each item of the cart
    foreach($_SESSION['cart'] as $sku => $quantity) {
        // Fetch product based on SKU
        $sql = "SELECT * FROM PRODUCT WHERE SKU = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $sku);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();

        if ($product) {
            // Display product image, name, quantity, and price
            echo '<div class="product-card">';
            echo '<img src="images/' . $product['PHOTO_PROD'] . '" alt="' . $product['NAME_PROD'] . '">';
            echo '<div class="product-details">';
            echo '<h2>' . $product['NAME_PROD'] . '</h2>';
            echo '<p>Description: ' . $product['DESC_PROD'] . '</p>';
            echo '<p>Price: ' . ($product['PRICE_PROD'] * $quantity) . '€</p>';
            echo '<form action="update_cart.php" method="post">';
            echo '<input type="hidden" name="action" value="update">';
            echo '<input type="hidden" name="sku" value="' . $sku . '">';
            echo '<input type="number" name="quantity" value="' . $quantity . '" min="1">';
            echo '<button type="submit">Update</button>';
            echo '</form>';
            echo '<form action="remove_from_cart.php" method="post">';
            echo '<input type="hidden" name="sku" value="' . $sku . '">';
            echo '<button type="submit" class="removebutton" name="remove">Remove</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';  // closing the product-list-container from cart.php
             

            // Calculate subtotal for this product
            $subtotal = $product['PRICE_PROD'] * $quantity;

            // Add subtotal to total price
            $totalPrice += $subtotal;
        }
    }

    // Display total price
    echo '<div class="total-price">';
    echo '<h3>Total Price: ' . globalTotalPrice() . '€</h3>';
    echo '</div>';

    // Close database connection
    $mysqli->close();
} else {
    echo "Your cart is empty.";
}

function globalTotalPrice()
{
    global $totalPrice;
    return $totalPrice;
}
?>
