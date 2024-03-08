<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>

    
    <link rel="stylesheet" href="style.css">
</head>
<body>
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
            // Display login option if the user is not logged in
            $navbarButton = "<a href='login.php' id='loginbtn'>Login</a>";
        }

        // Handle logout action
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['logout'])) {
            // Update isLoggedIn column in the database and mark the user as logged out
            $username = $_SESSION['username'];
            $update_sql = "UPDATE customer SET isLoggedIn = 0 WHERE USERNAME = '$username'";
            $conn->query($update_sql);


            session_destroy();

            header("location: login.php"); // Redirect to login page
            exit;
        }

        $conn->close();
    ?>

    <!--NavBar-->
    <nav class="main-nav">
        <div class="main-menu">
            <a id="logo" href="index.php"><img src="images/Logo.png" alt="Logo" style="max-height: 35px" /></a>
            <ul id="main-menu-list">
                <li><a href="shop.php">Shop</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="about.php">About Us</a></li>
            </ul>
        </div>
        <div class="nav-btn">
            <?php 
                echo $navbarButton; 
            ?>
            <a href="cart.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-cart" viewBox="0 0 16 16">
                    <path
                        d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                </svg>
            </a>
        </div>
    </nav>

    <div class="container-log">
        <h1>Login</h1>
        <form class="login" action="login.php" method="POST">
            <p>Username</p>
            <input type="text" name="username" placeholder="Type your Username or e-mail">
            <p>Password</p>
            <input type="password" name="password" placeholder="Type your Password"> 
            <a href="#">Forgot password?</a>
            <input type="submit" name="" value="Login">
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

    // Handle login form from user
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get login username and password from form and assign them to passwords
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query to check if the user exists and credentials match
        $sql = "SELECT * FROM customer WHERE USERNAME = '$username' AND PASS = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            // If the credentials are correct, create a session for the user
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;

            // Update isLoggedIn column in the database
            $update_sql = "UPDATE customer SET isLoggedIn = 1 WHERE USERNAME = '$username'";
            $conn->query($update_sql);

            header("location: shop.php"); // Redirect to the shop page
        } else {
            echo "Invalid username or password";
        }
    }

    // Check if the logout query parameter is present and display a logout message
    if(isset($_GET['logout']) && $_GET['logout'] == 1) 
    {
        // Display an alert message for successful logout
        echo "<script>alert('You have been logged out successfully.');</script>";
    }

    $conn->close();
?>
    
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
    
    
</body>
</html>



