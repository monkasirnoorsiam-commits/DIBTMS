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
    <title>Your Bus Services</title>
</head>
<body>
<?php 
    $user_id = $_SESSION["id"];
    $sql = "SELECT bus_no, type, total_seats FROM bus_service where m_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
?>
<body>
    <div class='payment-options'>
        <h2>Your Bus Services</h2>
        <table class="payment-table">
            <thead>
                <tr>
                    <th>Bus Number</th>
                    <th>Type</th>
                    <th>Total Seats</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['bus_no']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['type']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['total_seats']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    <div class="button-container">
        <h2>Add a bus service</h2>
        <form method="post" class="add-form">
            <input type="text" name="type" placeholder="Type" required>
            <input type="number" name="total_seats" placeholder="Total Seats" required>
            <button type="submit" name="add" class="edit-btn">Add</button>
        </form>
        <h2>Delete a bus service</h2>
        <form method="post" class="delete-form">
            <input type="number" name="bus_no" placeholder="Bus Number" required>
            <button type="submit" name="delete" class="edit-btn">Delete</button>
            </form>
        </div>
        <?php
        if(isset($_POST['add'])) {
            $type = mysqli_real_escape_string($conn, $_POST['type']);
            $total_seats = mysqli_real_escape_string($conn, $_POST['total_seats']);
            $m_id = $user_id;
            $sql = "SELECT MAX(bus_no) as max_bus_no FROM bus_service where m_id = '$m_id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $bus_no = null;
            if(empty($row)){
                $bus_no = ($user_id%100) * 1000 + 1;
            }
            else {
                $bus_no = 1 + $row["max_bus_no"];
            }
            $counter = 1;
            $sql = "INSERT INTO bus_service (bus_no, m_id, type, total_seats) 
                    VALUES ('$bus_no', '$m_id', '$type', '$total_seats')";
            mysqli_query($conn, $sql);
            while ($counter <= $total_seats){
                $sql = "INSERT INTO bus_seats (bus_no, seat_no, vacant) 
                        VALUES ('$bus_no', '$counter', '1')";
                mysqli_query($conn, $sql);
                $counter = $counter + 1;
            }
            echo "<script>alert('Bus service added successfully!'); window.location.href='services.php';</script>";
        }
        if(isset($_POST['delete'])) {
            $bus_no = mysqli_real_escape_string($conn, $_POST['bus_no']);
            $sql = "DELETE FROM bus_seats WHERE bus_no = '$bus_no'";
            mysqli_query($conn, $sql);
            $sql = "DELETE FROM bus_service WHERE m_id = '$user_id' AND bus_no = '$bus_no'";
            if(mysqli_query($conn, $sql)) {
                echo "<script>alert('Bus service deleted successfully!'); window.location.href='services.php';</script>";
            } 
            else {
                echo "<script>alert('Error deleting bus service!');</script>";
            }
        }
        include("footer.html");
        mysqli_close($conn);
    ?>
</body>