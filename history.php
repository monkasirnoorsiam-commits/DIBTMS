<?php
include("header.php");
include("database.php");

if(empty($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["id"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Ride History</title>
</head>
<body>

<h2 class="text-design" style="text-align:center;">Your Ride History</h2>

<div class="payment-options">
    <table class="payment-table">
        <tr>
            <th>Bus No</th>
            <th>From</th>
            <th>To</th>
            <th>Time</th>
            <th>Cost</th>
            <th>Seats</th>
            <th>Ride Date</th>
        </tr>
        <?php
        $sql = "SELECT * FROM ride_history WHERE p_id = '$user_id' ORDER BY ride_date DESC, time DESC";
        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)){
            echo "<tr>";
            echo "<td>" . $row['bus_no'] . "</td>";
            echo "<td>" . $row['start_from'] . "</td>";
            echo "<td>" . $row['end_at'] . "</td>";
            echo "<td>" . $row['time'] . "</td>";
            echo "<td>" . $row['ride_cost'] . "</td>";
            echo "<td>" . $row['seat_info'] . "</td>";
            echo "<td>" . $row['ride_date'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>

<?php
include("footer.html");
mysqli_close($conn);
?>

</body>
</html>
