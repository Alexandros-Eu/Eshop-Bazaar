<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "e-shop";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Checks if the request method is post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // If so get the credit card details
    $cardNumber = $_POST['cardNumber'];
    $expirationMonth = $_POST['expirationMonth'];
    $expirationYear = $_POST['expirationYear'];
    $cvv = $_POST['cvv'];
    
    // Get the user ID from the session and the user that is currently logged in
    $userId = $_SESSION['user_id']; // Assuming you have a user ID stored in the session
    
    // Insert the credit card details into the database
    $sql = "INSERT INTO credit_cards (CardNumber, USER_ID, ExpirationMonth, ExpirationYear, CVV)
            VALUES ('$cardNumber', '$userId', '$expirationMonth', '$expirationYear', '$cvv')";
    
    if ($conn->query($sql) === TRUE) {
        echo "alert('Credit card details saved successfully.')";
    } else {
        echo "alert('Error: " . $sql . "<br>" . $conn->error . "'";
    }
}

$conn->close();
?>
