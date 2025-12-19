<?php
    session_start();
    include("database.php");
    include("header2.html");
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
        <input type="submit" name="drop" value="Remove Staff"><br>
    </form>
</body>
</html>
<?php 
    if(isset($_POST["add"])){
        header("Location: add_staff.php");
    }
    elseif(isset($_POST["drop"])){
        header("Location: drop_staff.php");
    }
    include("footer.html");
    mysqli_close($conn);
?>