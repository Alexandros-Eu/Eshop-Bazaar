<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>

    <link rel="stylesheet" href="style.css">

</head>
<body style="background-image: url(images/neutralPattern.jpg); background-size: cover;">

<?php
    session_start();

    // Establish a database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "e-shop";

    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the user is logged in
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        // Display logout option
        $navbarButton = "<a href='logout.php' id='loginbtn'>Logout</a>";
    } else {
        // Display login option or redirect to login page
        $navbarButton = "<a href='login.php' id='loginbtn'>Login</a>";
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['logout'])) {
        // Update isLoggedIn column in the database
        $username = $_SESSION['username'];
        $update_sql = "UPDATE customer SET isLoggedIn = 0 WHERE USERNAME = '$username'";
        $conn->query($update_sql);

        // Destroy the session
        session_destroy();

        // Redirect to login page after logout 
        header("location: login.php"); 
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
                echo $navbarButton; // // Display login/logout button based on user session
            ?>
            <a href="cart.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                </svg>
            </a>
        </div>
    </nav>

    
        <header>
            <h1 id="about-title">Welcome to All-in-One-Bazaar</h1>
        </header>

        <section class="row">
            <div class="col-about">

                <h2>Our Story</h2>

                <p>As the All-in-One Bazaar, our journey began with a vision to revolutionize the online shopping experience. Founded by a team passionate about merging convenience with quality, our e-shop aimed to offer a diverse array of products under one virtual roof.</p>
                

                <ol>
                <li><span>Inception:</span> All-in-One Bazaar was born, driven by the mission to simplify online shopping for our customers.</li>
                <li><span>Expansion:</span> We expanded our product catalog, incorporating various categories, from electronics to fashion, homeware to gadgets.</li>
                <li><span>Enhanced User Experience:</span> Focused on improving user experience, we revamped our website interface and introduced personalized recommendations.</li>
                <li><span>Global Outreach:</span> Stepping into the global market, we established partnerships with international suppliers, enriching our product range and enabling worldwide shipping.</li>
                <li><span>Community Engagement:</span> Embracing social responsibility, we initiated programs supporting local communities, striving to make a positive impact beyond the realm of commerce.</li>
                <li><span>Innovation and Sustainability:</span> Embracing innovation, we integrated sustainable product lines and implemented eco-friendly packaging options, aligning our growth with environmental consciousness.</li>
                </ol>

            </div>

            <div class="col-about">
                    <h2>Values and Commitments</h2>

                    <p>At All-in-One Bazaar, our core values serve as the compass guiding our decisions and actions:</p>

                    <ol>
                        <li><span>Customer-Centricity:</span>We prioritize our customers above all else, striving to exceed their expectations by offering top-notch service, personalized experiences, and quality products.</li>
                        <li><span>Innovation:</span>We embrace innovation as a means to enhance our offerings continually. We're committed to exploring new technologies, trends, and sustainable practices to improve the shopping journey for our customers.</li>
                        <li><span>Integrity:</span>Honesty and transparency form the bedrock of our operations. We uphold the highest ethical standards in every interaction, fostering trust with our customers, partners, and stakeholders.</li>
                        <li><span>Diversity and Inclusivity:</span> We celebrate diversity in products and people. Our platform is inclusive, welcoming all customers and supporting a diverse range of suppliers and products.</li>
                        <li><span>Sustainability:</span>We are dedicated to sustainable practices, promoting eco-friendly products and packaging while actively seeking ways to reduce our environmental footprint.</li>
                        <li><span>Continuous Improvement:</span> We believe in constant growth and learning. We're committed to evolving our processes, services, and product range to better serve our customers and contribute positively to society.</li>
                    </ol>
            </div>
        </section>

    

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