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
        <input type="submit" name="show2" value="Show Bus Services"><br>
        <input type="submit" name="show3" value="Show Bus Timings"><br>
    </form>
</body>
</html>
<?php 
    if(isset($_POST["show2"])){
        header("Location: services.php");
    }
    elseif(isset($_POST["show3"])){
        header("Location: timings.php");
    }
    include("footer.html");
?>