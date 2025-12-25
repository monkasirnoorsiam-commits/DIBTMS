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
    <link rel="stylesheet" href="styles/main.css">
    <title>DIBTMS Account Info</title>
</head>
<body>
<?php
    $user_id = $_SESSION["id"];
    if(substr($_SESSION["id"], 0, 1) == 1){
        $sql = "SELECT u.* 
            FROM users u 
            LEFT JOIN admins ad ON u.id = ad.ad_id 
            WHERE u.id = '$user_id'";
    }
    else if(substr($_SESSION["id"], 0, 1) == 2){
        $sql = "SELECT u.*
            FROM users u 
            LEFT JOIN bus_managers m ON u.id = m.m_id 
            WHERE u.id = '$user_id'";
    }
    else {
        $sql = "SELECT u.*, p.discount 
            FROM users u 
            LEFT JOIN passengers p ON u.id = p.p_id 
            WHERE u.id = '$user_id'";
    }
    $result = mysqli_query($conn, $sql);
        
    if($row = mysqli_fetch_assoc($result)) {
        echo "<div class='account-info'>";
        echo "<h2>Account Information</h2>";
        echo "<p><strong>Name:</strong> " . $row["name"] . "</p>";
        echo "<p><strong>Email:</strong> " . $row["email"] . "</p>";
        echo "<p><strong>Phone:</strong> " . $row["phone_no"] . "</p>";
        echo "<p><strong>Address:</strong> " . $row["address"] . "</p>";
        echo "<p><strong>NID:</strong> " . $row["nid"] . "</p>";
        echo "<p><strong>Date of Birth:</strong> " . $row["date_of_birth"] . "</p>";
        echo "<p><strong>Age:</strong> " . $row["age"] . "</p>";
        if(substr($_SESSION["id"], 0, 1) == 3){
            echo "<p><strong>Number of Rides:</strong> " . $row["no_of_rides"] . "</p>";
        }
        if(substr($_SESSION["id"], 0, 1) == 3 && isset($row["discount"])) {
            echo "<p><strong>Discount:</strong> " . ($row["discount"] * 100) . "%</p>";
        }
        echo "<p><strong>Registration Date:</strong> " . $row["reg_date"] . "</p>";
        echo "</div>";
    }
?>
</body>
</html>
<?php 
    include("footer.html");
    mysqli_close($conn);
?>