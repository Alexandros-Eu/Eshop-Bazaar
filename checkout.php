<?php
session_start();

// Check if the cart session variable is set and not empty
if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "e-shop";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get user ID
    $UserNamequery = "SELECT USER_ID FROM customer WHERE USERNAME = '" . $_SESSION['username'] . "'";
    $UserNameresult = $conn->query($UserNamequery);

    if ($UserNameresult) {
        $UserNamerow = $UserNameresult->fetch_assoc();
        $userId = $UserNamerow['USER_ID'];

         // Check if the user has a shopping cart
            $cartValidationQuery = "SELECT CART_ID FROM shoppingcarts WHERE USER_ID = $userId";
            $validationResult = $conn->query($cartValidationQuery);

            if ($validationResult) {
                if ($validationResult->num_rows > 0) {
                    // User already has a shopping cart
                    $line = $validationResult->fetch_assoc();
                    $cartID = $line['CART_ID'];
                }
            }

        // Query to fetch credit card details for the user
        $query = "SELECT CardNumber, ExpirationMonth, ExpirationYear, CVV FROM creditcarddetails WHERE USER_ID = $userId";
        $result = $conn->query($query);

        if ($result) {
            // Fetch the data and assign it to variables
            if ($result->num_rows > 0) {
                //If user has a saved credit card
                $row = $result->fetch_assoc();

                $cardNumber = $row['CardNumber'];
                $expirationMonth = $row['ExpirationMonth'];
                $expirationYear = $row['ExpirationYear'];
                $cvv = $row['CVV'];

                $transactionDate = date('Y-m-d');

                $createTransactionsQuery = "INSERT INTO transactions (CART_ID, TransactionDate, CardNumber) VALUES ('$cartID', '$transactionDate', '$cardNumber')";

                if ($conn->query($createTransactionsQuery) === TRUE) {
                    echo "Transaction recorded successfully.";
                    unset($_SESSION['cart']); // If so unset the cart in order to checkout successfully
                    echo "Checkout successful!";
                } else {
                    // Error inserting transaction
                    echo "Error inserting transaction: " . $conn->error;
                }
            } else {
                echo "Your cart is empty. Cannot proceed to checkout.";
            }
        } else {
            echo "Error executing query: " . $conn->error;
        }
    } else {
        echo "Error executing query: " . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    echo "Your cart is empty. Cannot proceed to checkout."; // If the cart is empty print a message informing the user that the cart is empty and he cannot proceed
}
?>
