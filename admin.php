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
    <h2>Actions:</h2>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
        <input type="submit" name="add" value="Add a manager"><br>
        <input type="submit" name="show" value="Show all managers"><br>
        <input type="submit" name="drop" value="Remove a manager"><br>
        <input type="submit" name="show2" value="Show all passengers"><br>
        <input type="submit" name="drop2" value="Remove a passenger"><br>
        <input type="submit" name="verify" value="Verify rides"><br>
    </form>
</body>
</html>
<?php 
    $_SESSION["type"] = null;
    if(isset($_POST["add"])){
        $_SESSION["type"] = "manager";
        header("Location: adding.php");
    }
    elseif(isset($_POST["show"])){
        $_SESSION["type"] = "manager";
        header("Location: show.php");
    }
    elseif(isset($_POST["drop"])){
        $_SESSION["type"] = "manager";
        header("Location: dropping.php");
    }
    elseif(isset($_POST["show2"])){
        $_SESSION["type"] = "passenger";
        header("Location: show.php");
    }
    elseif(isset($_POST["drop2"])){
        $_SESSION["type"] = "passenger";
        header("Location: dropping.php");
    }
    elseif(isset($_POST["verify"])){
        header("Location: verify.php");
    }
    include("footer.html");
    mysqli_close($conn);
?>