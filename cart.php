<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "e-shop";

$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Display logout option if the user is logged in
    $navbarButton = "<a href='logout.php' id='loginbtn'>Logout</a>";
} else {
    // Display login option or redirect to login page if user is not logged in
    $navbarButton = "<a href='login.php' id='loginbtn'>Login</a>";
}

// Handle logout action
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['logout'])) {
    // Update isLoggedIn column in the database to mark user as logged out
    $username = $_SESSION['username'];
    $update_sql = "UPDATE customer SET isLoggedIn = 0 WHERE USERNAME = '$username'";
    $conn->query($update_sql);

    // Destroy the session
    session_destroy();

    header("location: login.php"); // Redirect to login page
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<!--NavBar-->
<nav class="main-nav">
    <div class="main-menu">
        <a id="logo" href="index.php"><img src="images/Logo.png" alt="Logo" style="max-height: 35px"/></a>
        <ul id="main-menu-list">
            <li><a href="shop.php">Shop</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="about.php">About Us</a></li>
        </ul>
    </div>
    <div class="nav-btn">
        <?php echo $navbarButton; ?>
        <a href="cart.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
        </a>
    </div>
</nav>

<div class="content">
    <h1 id="cart-title">Your Shopping Cart</h1>
</div>

<div class="product-list-container">
    <?php include 'view_cart.php'; ?>
</div>

<!-- Credit Card form with validation for valid data -->
<div class="container-credit-card">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="creditcardform" class="creditcard">
        <label for="cardName">Card Name Holder:</label>
        <input type="text" id="cardName" name="cardName" pattern="[A-Za-z\s]+" title="Please enter a valid name" required><br><br>

        <label for="cardNumber">Card Number:</label>
        <input type="text" id="cardNumber" name="cardNumber" pattern="[0-9]+" title="Enter a valid credit card number" required><br><br>
        
        <label for="expirationMonth">Expiration Month:</label>
        <input type="text" id="expirationMonth" name="expirationMonth" pattern="[1-9]|1[0-2]" title="Enter a valid expiration month (1-12)" required><br><br>
        
        <label for="expirationYear">Expiration Year:</label>
        <input type="text" id="expirationYear" name="expirationYear"  pattern="(202[4-9])" title="Enter a valid expiration year" required><br><br>
        
        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" pattern="\d{3,4}" title="Enter a valid CVV (three or four digits)" required><br><br>

        <button type="submit" class="savecard" name="savecard" value="savecard">Save Card</button>
    </form>
</div>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "e-shop";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['savecard'])) {
    // Assign the values from the user to php variables
    $cardNumber = $_POST['cardNumber'];
    $expirationMonth = $_POST['expirationMonth'];
    $expirationYear = $_POST['expirationYear'];
    $cvv = $_POST['cvv'];
    
    // Insert the credit card details into the database
    $query = "SELECT USER_ID FROM customer WHERE USERNAME = '" . $_SESSION['username'] . "'";
    $result = $conn -> query($query);

    while ($row = $result->fetch_assoc())
    {
        $userId = $row['USER_ID'];
    }
    
    $sql = "INSERT INTO creditcarddetails (CardNumber, USER_ID, ExpirationMonth, ExpirationYear, CVV)
            VALUES ('$cardNumber', '$userId', '$expirationMonth', '$expirationYear', '$cvv')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Credit card details saved successfully.');</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
    }
}

$conn->close();
?>

<div class="container-checkout">
    <a href="checkout.php" class="checkout" id="checkout">Proceed to Checkout</a>
</div>

<form action="update_cart.php" method="post">
    <button type="submit" class="clearcart" name="action" value="clear">Clear Cart</button>
</form>

<!--Footer-->
<footer>
    <div class="ft-menu">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="shop.php">Shop</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="about.php">About Us</a></li>
        </ul>
    </div>

    <div class="copyright">
        <p>&copy; 2024 All-in-One Bazaar</p>
    </div>
</footer>

<!-- JavaScript -->
<script>
    document.getElementById('checkout').addEventListener('click', function(event) {
        <?php
        // Check if the cart session variable is set and not empty
        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            // Check if the user is logged in
            if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
                // If the user is not logged in, prevent checkout and redirect to login page
                echo "event.preventDefault();";
                echo "alert('You need to be logged in to proceed to checkout.');";
                echo "window.location.href = 'login.php';";
            } 
            else 
            {
                // If the user is logged in, check if they have a saved credit card

                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "e-shop";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Retrieve user ID
                $UserNamequery = "SELECT USER_ID FROM customer WHERE USERNAME = '" . $_SESSION['username'] . "'";
                $UserNameresult = $conn->query($UserNamequery);

                if ($UserNameresult) {
                    $UserNamerow = $UserNameresult->fetch_assoc();
                    $userId = $UserNamerow['USER_ID'];

                    // Query to fetch credit card details for the user
                    $query = "SELECT CardNumber, ExpirationMonth, ExpirationYear, CVV FROM creditcarddetails WHERE USER_ID = $userId";
                    $result = $conn->query($query);

                        $yes = 1;
                        $createCartQuery = "INSERT INTO shoppingcarts (USER_ID, TotalAmount, IsCheckedOut) VALUES ('$userId', '$totalPrice', '$yes')";

                        if ($conn->query($createCartQuery) === TRUE) {
                            // Retrieve the ID of the newly inserted shopping cart
                            $cartID = $conn->insert_id;



                            foreach($_SESSION['cart'] as $sku => $quantity) {
                                // Storing SKU and quantity in local variables
                                $productSKU = $sku;
                                $productQuantity = $quantity;
                            
                                // Insert product details into database
                                $insertSql = "INSERT INTO cartitems (CART_ID, SKU, QUANTITY) VALUES (?, ?, ?)";
                                $insertStmt = $conn->prepare($insertSql);
                                $insertStmt->bind_param("isi", $cartID, $productSKU, $productQuantity); 
                                $insertStmt->execute();
                                $insertStmt->close();
                            }

                        } else {
                            // Error creating the shopping cart
                            echo "Error creating shopping cart: " . $conn->error;
                        }
                } else {
                    // Error executing the validation query
                    echo "Error executing validation query: " . $conn->error;
                }


                    if ($result) {
                        // Fetch the data and assign it to variables
                        if ($result->num_rows > 0) {
                            //If user has a saved credit card
                            $row = $result->fetch_assoc();

                            $cardNumber = $row['CardNumber'];
                            $expirationMonth = $row['ExpirationMonth'];
                            $USER_ID = $row['USER_ID']; // This assignment seems redundant
                            $expirationYear = $row['ExpirationYear'];
                            $cvv = $row['CVV'];

                        } else {
                            //If  User does not have a saved credit card
                            $cardNumber = null;
                            $expirationMonth = null;
                            $expirationYear = null;
                            $cvv = null;
                        }

                        // If the user does not have a credit card saved
                        if ($cardNumber == null || $cardNumber == 0) {
                            // User has not saved a complete set of credit card details, prevent checkout and display message
                            echo "event.preventDefault();";
                            echo "alert('You need to save a card or already have a saved card in order to proceed to the checkout');";
                            echo "window.location.href = 'cart.php';";
                        }
                    } else {
                        echo "Error: " . $conn->error;
                    }

                $conn->close();
            }
        }
        
        ?>
    });
</script>


</body>
</html>
