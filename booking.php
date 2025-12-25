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
        $user_id = $_SESSION["id"];
        $ride_cost = null;
        $ride_date = null;
        $seat_info = null;
        $sql = "SELECT u.address FROM users u WHERE u.id = '$user_id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $curr_address = $row['address'];
        $addresses = array("Aftabnagar", "Agargaon", "Airport", "Badda", "Banani", "Bangla Motor", "Bijoy Shoroni", "Cantonment", 
                           "Dhanmondi", "ECB Chottor", "Farmgate", "Gulistan", "Gulshan", "Kamalapur", "Kalshi Flyover", 
                           "Lalbag", "Mohakhali", "Mohammadpur", "Mogbazar", "Motijheel", "Mirpur-1", "Mirpur-10", "Mirpur-12", 
                           "Multiplan", "Puran Dhaka", "Science Lab", "Shahbag", "Shishu Park", "Uttara");
    ?>
    <h2>Choose a destination</h2>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
            From:
            <select name="start_from" required>
                <?php
                    echo "<option value='" . $curr_address . "'>" . $curr_address . "</option>";
                    foreach($addresses as $address){
                        echo "<option value='" . $address . "'>" . $address . "</option>";
                    }
                ?>
            </select>
            To:
            <select name="end_at" required>
                <?php
                    foreach($addresses as $address){
                        echo "<option value='" . $address . "'>" . $address . "</option>";
                    }
                ?>
            </select>
            <button type="submit" name="select" class="edit-btn">Select</button>
    </form>
    <?php
        if(isset($_POST['select'])) {
            $start_from = mysqli_real_escape_string($conn, $_POST['start_from']);
            $end_at = mysqli_real_escape_string($conn, $_POST['end_at']);
            $sql = "SELECT t.time, b.description FROM time_slots t LEFT JOIN bus_service b ON b.bus_no = t.bus_no WHERE t.start_from = '$start_from' AND t.end_at = '$end_at'";
            $result = mysqli_query($conn, $sql);
            ?> 
            <h2>Select available time:</h2><br>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                Time:
                <select name="time" required>
                    <?php
                        mysqli_data_seek($result, 0);
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['time'] . "'>" . $row['time'] . $row['description'] . "</option>";
                        }
                    ?>
                </select>
                <button type="submit" name="select2" class="edit-btn">Select</button>
            </form>
            <?php if(isset($_POST['select2'])){
                $time = mysqli_real_escape_string($conn, $_POST['time']);
                $sql = "SELECT discount FROM passengers WHERE p_id = '$user_id'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $discount = $row['discount'];
                $sql = "SELECT t.bus_no, b.cost FROM time_slots t LEFT JOIN bus_service b ON b.bus_no = t.bus_no WHERE t.start_from = '$start_from' AND t.end_at = '$end_at' AND t.time = '$time'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $bus_no = $row['bus_no'];
                $cost = $row['cost'];
                ?>
                <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                Select number of seats:
                    <select name="seats" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <button type="submit" name="select3" class="edit-btn">Select</button>
                </form>
                <?php  if(isset($_POST['select3'])){
                    $seats = $_POST['seats'];
                    $sql = "SELECT * FROM bus_seats WHERE bus_no = '$bus_no'";
                    $result = mysqli_query($conn, $sql);
                    if($seats >= 1){ ?>
                        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                            Seat 1:
                            <select name="seat1" required>
                                <?php
                                    mysqli_data_seek($result, 0);
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $row['seat_no'] . "'>" . $row['seat_no'] . "</option>";
                                    }
                                ?>
                            </select>
                            <?php if($seats >= 2){ ?>
                                Seat 2:
                                <select name="seat2" required>
                                    <?php
                                        mysqli_data_seek($result, 0);
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='" . $row['seat_no'] . "'>" . $row['seat_no'] . "</option>";
                                        }
                                    ?>
                                </select>
                                <?php if($seats >= 3){ ?>
                                    Seat 3:
                                    <select name="seat3" required>
                                        <?php
                                            mysqli_data_seek($result, 0);
                                            while($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='" . $row['seat_no'] . "'>" . $row['seat_no'] . "</option>";
                                            }
                                        ?>
                                    </select>
                                    <?php if($seats >= 4){ ?>
                                        Seat 4:
                                        <select name="seat4" required>
                                            <?php
                                                mysqli_data_seek($result, 0);
                                                while($row = mysqli_fetch_assoc($result)) {
                                                    echo "<option value='" . $row['seat_no'] . "'>" . $row['seat_no'] . "</option>";
                                                }
                                            ?>
                                        </select>
                                        <?php if($seats == 5){ ?>
                                            Seat 5:
                                            <select name="seat5" required>
                                                <?php
                                                    mysqli_data_seek($result, 0);
                                                    while($row = mysqli_fetch_assoc($result)) {
                                                        echo "<option value='" . $row['seat_no'] . "'>" . $row['seat_no'] . "</option>";
                                                    }
                                                ?>
                                            </select>
                                            <?php
                                        }
                                    }
                                }
                            } ?>
                        <button type="submit" name="select4" class="edit-btn">Select</button>
                        </form>
                        <?php
                    }
                    if (isset($_POST['select4'])){
                        $ride_cost = $cost * $seats - $cost * $seats * $discount;
                        $seat1 = null; $seat2 = null; $seat3 = null; $seat4 = null; $seat5 = null;
                        if ($seats >= 1){
                            $seat1 = $_POST['seat1'];
                            $sql = "UPDATE bus_seats SET vacant = 0 WHERE bus_no = '$bus_no' AND seat_no = '$seat1'";
                            mysqli_query($conn, $sql);
                            if ($seats >= 2){
                                $seat2 = $_POST['seat2'];
                                $sql = "UPDATE bus_seats SET vacant = 0 WHERE bus_no = '$bus_no' AND seat_no = '$seat2'";
                                mysqli_query($conn, $sql);
                                if ($seats >= 3){
                                    $seat3 = $_POST['seat3'];
                                    $sql = "UPDATE bus_seats SET vacant = 0 WHERE bus_no = '$bus_no' AND seat_no = '$seat3'";
                                    mysqli_query($conn, $sql);
                                    if ($seats >= 4){
                                        $seat4 = $_POST['seat4'];
                                        $sql = "UPDATE bus_seats SET vacant = 0 WHERE bus_no = '$bus_no' AND seat_no = '$seat4'";
                                        mysqli_query($conn, $sql);
                                        if ($seats >= 5){
                                            $seat4 = $_POST['seat5'];
                                            $sql = "UPDATE bus_seats SET vacant = 0 WHERE bus_no = '$bus_no' AND seat_no = '$seat5'";
                                            mysqli_query($conn, $sql);
                                        }
                                    }
                                }
                            }
                        }
                        $current_time = new DateTime();
                        $current_time->format('H:i:s');
                        $timestamp = strtotime($time);
                        $hour = date('H', $timestamp);
                        $minute = date('i', $timestamp);
                        if ($current_time > $time){
                            $tomorrow = new DateTime('tomorrow');
                            $tomorrow->setTime($hour, $minute);
                            $ride_date = $tomorrow->format('Y-m-d H:i:s');
                        }
                        else {
                            $today = new DateTime('today');
                            $today->setTime($hour, $minute);
                            $ride_date = $today->format('Y-m-d H:i:s');
                        }
                        $seat_info = "[ " . "$seat1" . "$seat2" . "$seat3" . "$seat4" . "$seat5" . " ]"; ?>
                        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                            Select Payment Option:
                            <select name="payment_option" required>
                                <?php
                                    $sql = "SELECT banking_service_name, acc_number FROM payment_options WHERE p_id = '$user_id'";
                                    $result = mysqli_query($conn, $sql);
                                    mysqli_data_seek($result, 0);
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $row['banking_service_name'] . "'>" . $row['banking_service_name'] . " - " . $row['acc_number'] . "</option>";
                                    }
                                }
                            ?> </select>
                            <button type="submit" name="select5" class="edit-btn">Select</button>
                        </form>
                        <?php if(isset($_POST['select5'])){
                            $banking_service_name = mysqli_real_escape_string($conn, $_POST['banking_service_name']);
                            $sql = "SELECT amount FROM payment_options WHERE banking_service_name = '$banking_service_name'";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $amount = $row['amount'];
                            if (($amount - $ride_cost) < 0){
                                echo"<script>alert('Insufficient funds!'); window.location.href='booking.php';</script>";
                            }
                            else {
                                $amount = $amount - $ride_cost;
                                $sql = "UPDATE payment_options SET amount = '$amount' WHERE p_id = '$user_id' AND banking_service_name = '$banking_service_name'";
                                mysqli_query($conn, $sql);
                                $sql = "INSERT INTO ride_history (p_id, bus_no, start_from, end_at, time, ride_cost, seat_info, ride_date)
                                        VALUES ('$user_id', '$bus_no', '$start_from', '$end_at', '$time', '$ride_cost', '$seat_info', '$ride_date')";
                                if(mysqli_query($conn, $sql)) {
                                    echo "<script>alert('Ride booked successfully!'); window.location.href='payment_options.php';</script>";
                                } 
                                else {
                                    echo "<script>alert('Error booking ride!');</script>";
                                }
                            }
                        }
                }
            }
        }
    ?>
</body>
</html>
<?php 
    include("footer.html");
    mysqli_close($conn);
?>