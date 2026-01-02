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


<body style="min-height:100vh; display:flex; flex-direction:column;">

   <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" class="action-form">
    <h2>Hop In & Go! Your Journey Awaits </h2>

    <div class="buttons-container">
        <input type="submit" name="book" value="Book a ride" class="action-btn">
        <input type="submit" name="payment" value="Set payment options" class="action-btn">
        <input type="submit" name="review" value="Give reviews" class="action-btn">
        <input type="submit" name="history" value="Your Ride History" class="action-btn">
        <input type="submit" name="account" value="Account info" class="action-btn">
    </div>
</form>




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
    elseif(isset($_POST["history"])){
    header("Location: history.php");
    
}
    elseif(isset($_POST["account"])){
        header("Location: account.php");
    }
?>

  
    <div style="margin-top:auto;">
        <?php include("footer.html"); ?>
    </div>

</body>
</html>
