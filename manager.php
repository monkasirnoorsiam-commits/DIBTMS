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
    <title>DIBTMS Manager</title>
</head>
<body>
    <h2>Actions:</h2>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
        <input type="submit" name="add" value="Add Staff"><br>
        <input type="submit" name="show" value="Show Staff"><br>
        <input type="submit" name="drop" value="Remove Staff"><br>
    </form>
</body>
</html>
<?php 
    if(isset($_POST["add"])){
        header("Location: adding.php");
    }
    elseif(isset($_POST["show"])){
        header("Location: show.php");
    }
    elseif(isset($_POST["drop"])){
        header("Location: dropping.php");
    }
    include("footer.html");
    mysqli_close($conn);
?>