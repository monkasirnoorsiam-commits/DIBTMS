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
    $date_of_birth = $_POST["date"];
    $today = new DateTime();
    $dob = new DateTime($date_of_birth);
    $age = $dob->diff($today)->y;
    echo$age;
    /*
    Some login info:

    admin1@gmail.com - spongebob
    admin2@yahoo.com - mazda
    admin3@outlook.com - nick

    manager1@gmail.com - patrick
    manager2@gmail.com - tanvir
    manager3@yahoo.com - rasel

    nafis@gmail.com - nafis
    mahin@gmail.com - mahin
    tadrib@gmail.com - tadrib

    */
?>