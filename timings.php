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
    $sql = "SELECT t.* FROM time_slots t LEFT JOIN bus_service b on b.bus_no = t.bus_no where b.m_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
?>
<body>
    <div class='payment-options'>
        <h2>Your Bus Service Time Slots</h2>
        <table class="payment-table">
            <thead>
                <tr>
                    <th>Bus Number</th>
                    <th>Time</th>
                    <th>From</th>
                    <th>To</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['bus_no']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['time']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['start_from']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['end_at']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    <div class="button-container">
        <h2>Add a Time Slot</h2>
        <form method="post" class="add-form">
            <?php
                $sql = "SELECT bus_no from bus_service where m_id = '$user_id'";
                $result = mysqli_query($conn, $sql); ?>
            <select name="bus_no" required>
                <?php
                    mysqli_data_seek($result, 0);
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['bus_no'] . "'>" . $row['bus_no'] . "</option>";
                    }
                ?>
            </select>
            <input type="time" name="time" placeholder="Start Time" required>
            <input type="text" name="start_from" placeholder="From" required>
            <input type="text" name="end_at" placeholder="To" required>
            <button type="submit" name="add" class="edit-btn">Add</button>
        </form>
        <h2>Delete a Time Slot</h2>
            <form method="post" class="delete-form">
            <?php
                $sql = "SELECT t.* FROM time_slots t LEFT JOIN bus_service b on b.bus_no = t.bus_no where b.m_id = '$user_id'";
                $result = mysqli_query($conn, $sql); ?>
            <select name="bus_no" required>
                <?php
                    mysqli_data_seek($result, 0);
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['bus_no'] . "'>" . $row['bus_no'] . "</option>";
                    }
                ?>
            </select>
            <select name="time" required>
                <?php
                    mysqli_data_seek($result, 0);
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['time'] . "'>" . $row['time'] . "</option>";
                    }
                ?>
            </select>
            <button type="submit" name="delete" class="edit-btn">Delete</button>
            </form>
        </div>
        <?php
        if(isset($_POST['add'])) {
            $bus_no = mysqli_real_escape_string($conn, $_POST['bus_no']);
            $time = mysqli_real_escape_string($conn, $_POST['time']);
            $start_from = mysqli_real_escape_string($conn, $_POST['start_from']);
            $end_at = mysqli_real_escape_string($conn, $_POST['end_at']);
            $sql = "INSERT INTO time_slots (bus_no, time, start_from, end_at) 
                    VALUES ('$bus_no', '$time', '$start_from', '$end_at')";
            if(mysqli_query($conn, $sql)) {
                echo "<script>alert('Time slot added successfully!'); window.location.href='timings.php';</script>";
            } 
            else {
                echo "<script>alert('Error adding time slot!');</script>";
            }
        }
        if(isset($_POST['delete'])) {
            $bus_no = mysqli_real_escape_string($conn, $_POST['bus_no']);
            $time = mysqli_real_escape_string($conn, $_POST['time']);
            $sql = "DELETE FROM time_slots WHERE bus_no = '$bus_no' AND time = '$time'";
            if(mysqli_query($conn, $sql)) {
                echo "<script>alert('Time slot deleted successfully!'); window.location.href='timings.php';</script>";
            } 
            else {
                echo "<script>alert('Error deleting time slot!');</script>";
            }
        }
        include("footer.html");
        mysqli_close($conn);
    ?>
</body>