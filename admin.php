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
    <title>DIBTMS Admin</title>
</head>
<body>
    <h2>Your Dashboard, Your Control!</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="action-form">
        <div class="buttons-container">
            <input type="submit" name="show" value="Show all managers" class="action-btn"><br>
            <input type="submit" name="show2" value="Show all passengers" class="action-btn"><br>
            <input type="submit" name="show3" value="Show all admins" class="action-btn"><br>
        </div>
    </form>
</body>
</html>
<?php
    $_SESSION["type"] = null;
    if(isset($_POST["show"])){
        $_SESSION["type"] = "manager";
        header("Location: show.php");
    }
    elseif(isset($_POST["show2"])){
        $_SESSION["type"] = "passenger";
        header("Location: show.php");
    }
    elseif(isset($_POST["show3"])){
        $_SESSION["type"] = "admin";
        header("Location: show.php");
    }
    include("footer.html");
?>
