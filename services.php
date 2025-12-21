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
</head>
<body>
<?php 
    $user_id = $_SESSION["id"];
    $sql = "SELECT * FROM bus_service bus LEFT JOIN handles h ON bus.bus_no = h.bus_no WHERE h.m_id = '$user_id'";
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
                    <th>Staff Information</th>
                    <th>Destination</th>
                    <th>Availability</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['bus_no']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['type']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['staff_info']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['destination']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['availability']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    <div class="button-container">
        <h2>Add a bus service</h2>
        <form method="post" class="add-form">
            <input type="text" name="type" placeholder="Type" required>
            <input type="text" name="staff_info" placeholder="Staff Details" required>
            <input type="text" name="destination" placeholder="Destination" required>
            <input type="number" name="availability" placeholder="Availability" required>
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
            $staff_info = mysqli_real_escape_string($conn, $_POST['staff_info']);
            $destination = mysqli_real_escape_string($conn, $_POST['destination']);
            $availability = mysqli_real_escape_string($conn, $_POST['availability']);
            $sql = "SELECT * FROM bus_service bus LEFT JOIN handles h ON bus.bus_no = h.bus_no WHERE h.m_id = '$user_id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $bus_no = null;
            if(empty($row)){
                $bus_no = $user_id%100 + 1;
            }
            else {
                $bus_no = $bus_no + 1;
            }
            $counter = 1;
            while ($counter <= $availability){
                $sql = "INSERT INTO bus_seats (bus_no, seat_no, vacant) 
                        VALUES ('$bus_no', '$counter', 'true')";
                mysqli_query($conn, $sql);
                $counter = $counter + 1;
            }
            $sql = "INSERT INTO bus_service (bus_no, type, staff_info, destination, availability) 
                    VALUES ('$bus_no', '$type', '$staff_info', '$destination', '$availability')";
            if(mysqli_query($conn, $sql)) {
                echo "<script>alert('Bus service added successfully!'); window.location.href='services.php';</script>";
            } 
            else {
                echo "<script>alert('Error adding bus service!');</script>";
            }
        }
        if(isset($_POST['delete'])) {
            $bus_no = mysqli_real_escape_string($conn, $_POST['bus_no']);
            $sql = "DELETE FROM bus_service WHERE bus_no = '$bus_no'";
            mysqli_query($conn, $sql);
            $sql = "DELETE FROM bus_seats WHERE bus_no = '$bus_no'";
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