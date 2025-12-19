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
    <title>DIBTMS Passenger</title>
</head>
<body>
    This is the passenger's page
</body>
</html>
<?php 
    include("footer.html");
    mysqli_close($conn);
?>