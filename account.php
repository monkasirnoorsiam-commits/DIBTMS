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
<style>
        .account-info {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .account-info p {
            margin: 10px 0;
            line-height: 1.5;
        }
        .account-info strong {
            display: inline-block;
            width: 150px;
        }
    </style>
</head>
<body>
<?php
        if(!isset($_SESSION["id"])) {
            header("Location: login.php");
        }
        
        $user_id = $_SESSION["id"];
        $sql = "SELECT u.*, p.discount 
                FROM users u 
                LEFT JOIN passengers p ON u.id = p.p_id 
                WHERE u.id = '$user_id'";
        $result = mysqli_query($conn, $sql);
        
        if($row = mysqli_fetch_assoc($result)) {
            echo "<div class='account-info'>";
            echo "<h2>Account Information</h2>";
            echo "<p><strong>Name:</strong> " . $row["name"] . "</p>";
            echo "<p><strong>Email:</strong> " . $row["email"] . "</p>";
            echo "<p><strong>Phone:</strong> " . $row["phone_no"] . "</p>";
            echo "<p><strong>Address:</strong> " . $row["address"] . "</p>";
            echo "<p><strong>Age:</strong> " . $row["age"] . "</p>";
            echo "<p><strong>Number of Rides:</strong> " . $row["no_of_rides"] . "</p>";
            if(isset($row["discount"])) {
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