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
    <title>DIBTMS Booking</title>
</head>
<body>
    <?php
        $start_from = $_SESSION['start_from'];
        $end_at = $_SESSION['end_at'];
        $user_id = $_SESSION["id"];
        $time = null;
        $sql = "SELECT t.time, b.description FROM time_slots t LEFT JOIN bus_service b ON b.bus_no = t.bus_no WHERE t.start_from = '$start_from' AND t.end_at = '$end_at'";
        $result = mysqli_query($conn, $sql);
    ?> 
    <h2>Select available time:</h2><br>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
            Time:
            <select name="time" required onchange="this.form.submit()">
                <?php
                    $time = isset($_POST['time']) ? $_POST['time'] : '';
                    mysqli_data_seek($result, 0);
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['time'] . "'" . ($time == $row['time'] ? " selected" : "") . ">" . $row['time'] . $row['description'] . "</option>";
                    }
                ?>
            </select>
            <button type="submit" name="select2" class="edit-btn">Select</button>
        </form>
            <?php 
            if(isset($_POST['select2'])){
                $time = mysqli_real_escape_string($conn, $_POST['time']);
                $sql = "SELECT p.discount FROM passengers p WHERE p.p_id = '$user_id'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $discount = $row['discount'];
                $sql = "SELECT t.bus_no, b.cost FROM time_slots t LEFT JOIN bus_service b ON b.bus_no = t.bus_no WHERE t.start_from = '$start_from' AND t.end_at = '$end_at' AND t.time = '$time'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $bus_no = $row['bus_no'];
                $cost = $row['cost'];
                $_SESSION['time'] = $time;
                $_SESSION['discount'] = $discount;
                $_SESSION['bus_no'] = $bus_no;
                $_SESSION['cost'] = $cost;
                header("Location: booking3.php");
            }
            include("footer.html");
            mysqli_close($conn);
?>
</body>
</html>