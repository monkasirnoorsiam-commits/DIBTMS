<?php
    session_start();
    include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles/main.css">
</head>
<header>
    <img src="DIBTMS_logo.jpg" alt="Dhaka Intercity Bus Transit Management System logo">
    <h2>Dhaka Intercity Bus Transit Management System</h2>
    <nav>
    <?php
        if(empty($_SESSION["id"])){
            ?>
            <a href="home.php">Home</a>
            <a href="login.php">Login</a>
            <a href="registration.php">Register</a>
            <?php
        }
        else {
            if(substr($_SESSION["id"], 0, 1) == 1){
                ?>
                <a href="admin.php">Home</a>
                <a href="account.php">Account Info</a>
                <a href="logout.php">Log out</a>
                <?php
            }
            elseif(substr($_SESSION["id"], 0, 1) == 2){
                ?>
                <a href="manager.php">Home</a>
                <a href="account.php">Account Info</a>
                <a href="logout.php">Log out</a>
                <?php
            }
            else{
                ?>
                <a href="passenger.php">Home</a>
                <a href="account.php">Account Info</a>
                <a href="logout.php">Log out</a>
                <?php
            }
        }
    ?>
    </nav>
</header>
</html>