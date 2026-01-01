<?php
    session_start();
    include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css"> 

</head>
<header>
    <img src="DIBTMS_logo.png" alt="Dhaka Intercity Bus Transit Management System logo">
    <h2>DIBTMS</h2>
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

