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
    $sql = "SELECT bus_no, type, total_seats, description, cost FROM bus_service where m_id = '$user_id'";
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
                    <th>Description</th>
                    <th>Ride Cost</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['bus_no']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['type']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['total_seats']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['cost']) . "</td>";
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
            <input type="text" name="description" placeholder="Description">
            <input type="number" name="cost" placeholder="Ride Cost" required>
            <button type="submit" name="add" class="edit-btn">Add</button>
        </form>
        <h2>Change ride fares of a bus service</h2>
        <form method="post" class="add-form">
            <input type="number" name="bus_no" placeholder="Bus Number" required>
            <input type="number" name="cost" placeholder="Ride Cost" required>
            <button type="submit" name="change" class="edit-btn">Change</button>
        </form>
        <h2>Clear seats of a bus service</h2>
        <form method="post" class="add-form">
            <input type="number" name="bus_no" placeholder="Bus Number" required>
            <button type="submit" name="clear" class="edit-btn">Clear</button>
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
            $description = $_POST['description'];
            $cost = mysqli_real_escape_string($conn, $_POST['cost']);
            $m_id = $user_id;
            $sql = "SELECT MAX(bus_no) AS max_bus_no FROM bus_service WHERE m_id = '$m_id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $bus_no = null;
            if($row['max_bus_no'] == null){
                $bus_no = ($m_id%100) * 1000 + 1;
            }
            else {
                $bus_no = 1 + $row['max_bus_no'];
            }
            $counter = 1;
            $sql = "INSERT INTO bus_service (bus_no, m_id, type, total_seats, description, cost) 
                    VALUES ('$bus_no', '$m_id', '$type', '$total_seats', '$description', '$cost')";
            mysqli_query($conn, $sql);
            while ($counter <= $total_seats){
                $sql = "INSERT INTO bus_seats (bus_no, seat_no, vacant) 
                        VALUES ('$bus_no', '$counter', '1')";
                mysqli_query($conn, $sql);
                $counter = $counter + 1;
            }
            echo "<script>alert('Bus service added successfully!'); window.location.href='services.php';</script>";
        }
        else if(isset($_POST['change'])){
            $bus_no = mysqli_real_escape_string($conn, $_POST['bus_no']);
            $cost = mysqli_real_escape_string($conn, $_POST['cost']);
            $sql = "UPDATE bus_service SET cost = '$cost' WHERE bus_no = '$bus_no'";
            if(mysqli_query($conn, $sql)) {
                echo "<script>alert('Ride fares changed successfully!'); window.location.href='services.php';</script>";
            } 
            else {
                echo "<script>alert('Error changing ride fares!');</script>";
            }
        }
        else if(isset($_POST['clear'])){
            $bus_no = mysqli_real_escape_string($conn, $_POST['bus_no']);
            $sql = "SELECT COUNT(seat_no) AS total_seats FROM bus_seats WHERE bus_no = '$bus_no'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $total_seats = $row['total_seats'];
            $sql = "UPDATE bus_service SET total_seats = '$total_seats' WHERE bus_no = '$bus_no'";
            mysqli_query($conn, $sql);
            $sql = "UPDATE bus_seats SET vacant = '1' WHERE bus_no = '$bus_no'";
            if(mysqli_query($conn, $sql)) {
                echo "<script>alert('Seats cleared successfully!'); window.location.href='services.php';</script>";
            } 
            else {
                echo "<script>alert('Error clearing seats!');</script>";
            }
        }
        else if(isset($_POST['delete'])) {
            $bus_no = mysqli_real_escape_string($conn, $_POST['bus_no']);
            $sql = "DELETE FROM bus_seats WHERE bus_no = '$bus_no'";
            mysqli_query($conn, $sql);
            $sql = "DELETE FROM time_slots WHERE bus_no = '$bus_no'";
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