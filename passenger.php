<?php
    include("header.php");
    include("database.php");
    if(empty($_SESSION["id"])) {
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIBTMS Passenger</title>
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
        <h2>Actions: </h2>
        <input type="submit" name="book" value="Book a ride"><br>
        <input type="submit" name="payment" value="Set payment options"><br>
        <input type="submit" name="review" value="Give reviews"><br>
        <input type="submit" name="history" value="Your Ride History"><br>
        <input type="submit" name="account" value="Account info"><br>
    </form>
</body>
</html>
<?php
    if(isset($_POST["book"])){
        header("Location: booking.php");
    }
    elseif(isset($_POST["payment"])){
        header("Location: payment_options.php");
    }
    elseif(isset($_POST["review"])){
        header("Location: reviews.php");
    }
    elseif(isset($_POST["account"])){
        header("Location: account.php");
    }
    include("footer.html");
?>