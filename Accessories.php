<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Accessories Category</title>

    <link rel="stylesheet" href="style.css" />
  </head>

  <body>

    <?php

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "e-shop";

        // Create a connection to the database
        $conn = new mysqli($servername, $username, $password, $dbname);

        
        if ($conn -> connect_error)
        {
            die("Problem: " . $conn -> connect_error);
        }

        // SQL query to select data from the PRODUCT table 
        $sql = "SELECT SKU, NAME_PROD, DESC_PROD, PRICE_PROD, CAT_PROD, PHOTO_PROD FROM PRODUCT";
        $result = $conn -> query($sql); // Execute the query

    ?>

<?php
    // Start the session
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
        //If logged in display logout option
        $navbarButton = "<a href='logout.php' id='loginbtn'>Logout</a>";
    } else {
        //If not logged in display login option
        $navbarButton = "<a href='login.php' id='loginbtn'>Login</a>";
    }

    // Handle logout action
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['logout'])) {
        // Update isLoggedIn column in the database
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
            echo $navbarButton; // Display login/logout button
          ?>
          <a href="cart.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
              <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
              </svg>
          </a>
      </div>
  </nav>

  <div class="product-list-container">

    <?php
        // Loop through the query result and display products of category "Accessories"
        while ($row = $result->fetch_assoc())
        {
            if ($row['CAT_PROD'] == "Accessories") 
            {
                echo "<div class=\"product-card\">";
                echo "<img src=\"images/" . $row["PHOTO_PROD"] . "\">";
                echo "<h3 class=\"product-title\">" . $row["NAME_PROD"] . "</h3>";
                echo "<p class=\"product-description\">" . $row["DESC_PROD"] . "</p>";
                echo "<p class=\"product-price\">" . $row["PRICE_PROD"] . "€" . "</p>";
                
                // Add a form to add to the cart AND send SKU to add_to_cart.php
                echo "<form action=\"add_to_cart.php\" method=\"post\">";
                echo "<input type=\"hidden\" name=\"sku\" value=\"" . $row["SKU"] . "\">";
                echo "<button type=\"submit\" class=\"addtocartbutton\">Add to cart</button>";
                echo "</form>";
                echo "</div>";
            }
        }
    ?>

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
