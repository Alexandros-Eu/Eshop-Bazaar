<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-image: url(images/neutralPattern.jpg); background-size: cover;">

    
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
        // Update isLoggedIn column in the database to mark user as logged out
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
            <a id="logo" href="index.php"><img src="images/Logo.png" alt="Logo" style="max-height: 35px"/></a>
            <ul id="main-menu-list">
                <li><a href="shop.php">Shop</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="about.php">About Us</a></li>
            </ul>
        </div>
        <div class="nav-btn">
            <?php 
                echo $navbarButton; // Display login / logout option depending on user state 
            ?>
            <a href="cart.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                </svg>
            </a>
        </div>
    </nav>

    <!--Contact Form-->
    <div class="container-con">
        <form class="cl-contact">
            <p>Full Name</p>
            <input type="text" name="" placeholder="Your name..">

            <p>E-mail</p>
            <input type="text"  name="" placeholder="Your e-mail..">

            <p>Subject</p>
            <textarea id="subject" name="" placeholder="Write something.." style="height:200px; width:50rem"></textarea>

            <input type="submit" id="sendmessagebtn" value="Send message">

        </form>
    </div>

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