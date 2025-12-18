<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="test.php" method="post">
        <label>Date of birth:</label><br>
        <input type="date" name="date"><br>
        <input type="submit" value="enter"><br>
    </form>
</body>
</html>
<?php
    $date_of_birth = $_POST["date"];;
    $today = new DateTime();
    $dob = new DateTime($date_of_birth);
    $age = $dob->diff($today)->y;
    echo$age;
    /*
    nafis
    nafis@gmail.com
    01651614891
    nafis
    1651614844
    
    */
?>