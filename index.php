<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>
    <main>


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
            // Display logout option if user is logged in
            $navbarButton = "<a href='logout.php' id='loginbtn'>Logout</a>";
        } else {
            // Display login option if the user is logged in
            $navbarButton = "<a href='login.php' id='loginbtn'>Login</a>";
        }

        // Handle logout action
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['logout'])) {
            // Update isLoggedIn column in the database to mark the user as logged out
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
                    echo $navbarButton; // Display login/logout button depending on user state
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

        <!--Carousel-->
        <section id="top-sec">
            <img class="top-sec-pic" src="images/woman.jpg" alt="">
            <div class="top-sec-wrds">

                <h1>Winter Sales</h1>
                <p>See our offers up to 50%</p>
                <button id="top-sec-btn" onclick="window.location.href='shop.php'">Shop Now</button>
            </div>

        </section>

        <!--Products-->
        <section id="mid-sec">

            <h1> Some of Our Products </h1>
            <div class="product-list-container">
                <div class="product-card">
                    <img src="images/boots.jpg" alt="Brown boots" />
                    <h3 class="product-title">Brown Suede Boots</h3>
                    <p class="product-description">Rugged but stylish brown suede boots.</p>
                    <p class="product-price">140.00€</p>
                </div>
                <div class="product-card">
                    <img src="images/blueheels.jpg" alt="Blue Heels" />
                    <h3 class="product-title">Blue Heels</h3>
                    <p class="product-description">Blue heels with flower print.</p>
                    <p class="product-price">90.00€</p>
                </div>
                <div class="product-card">
                    <img src="images/trainerspink.jpg" alt="Pink Trainers" />
                    <h3 class="product-title">Women's Trainers</h3>
                    <p class="product-description">Stylish women's trainers in Pink.</p>
                    <p class="product-price">75.00€</p>
                </div>
            </div>
            <button id="mid-sec-btn" onclick="window.location.href='shop.php'">View More</button>

        </section>

    </main>
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