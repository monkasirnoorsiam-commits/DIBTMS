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
        $user_id = $_SESSION['id'];
        $bus_no = $_SESSION['bus_no'];
        $time = $_SESSION['time'];
        $seats = $_SESSION['seats'];
        $discount = $_SESSION['discount'];
        $cost = $_SESSION['cost'];
        $ride_cost = null;
        $ride_date = null;
        $seat_info = null;
        $sql = "SELECT * FROM bus_seats WHERE bus_no = '$bus_no'";
                    $result = mysqli_query($conn, $sql); ?>
                    <h2 class="text-design">Choose your preferred seats</h2>
                    <form method="post"> <?php
                    if($seats >= 1){ ?>
                    <div class="time-container">
                            <span class="text-design" style="display: inline-block;">Seat1:</span>
                            <select name="seat1" class="booking-select" required>
                                <?php
                                    mysqli_data_seek($result, 0);
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $row['seat_no'] . "'>" . $row['seat_no'] . "</option>";
                                    }
                                ?>
                            </select>
                            </div>
                            <?php if($seats >= 2){ ?>
                                <div class="time-container">
                                <span class="text-design" style="display: inline-block;">Seat2:</span>
                                <select name="seat2" class="booking-select" required>
                                    <?php
                                        mysqli_data_seek($result, 0);
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='" . $row['seat_no'] . "'>" . $row['seat_no'] . "</option>";
                                        }
                                    ?>
                                </select>
                                </div>
                                <?php if($seats >= 3){ ?>
                                    <div class="time-container">
                                    Seat 3:
                                    <select name="seat3" class="booking-select" required>
                                        <?php
                                            mysqli_data_seek($result, 0);
                                            while($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='" . $row['seat_no'] . "'>" . $row['seat_no'] . "</option>";
                                            }
                                        ?>
                                    </select>
                                    </div>
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
                            }
                    } ?>
                    <div style="text-align: center; margin-top: 15px;">
    <button type="submit" name="select4" class="edit-btn">Select</button>
</div>

                    </form>
                    <?php
                    if (isset($_POST['select4'])){
                        $seat1 = null; $seat2 = null; $seat3 = null; $seat4 = null; $seat5 = null;
                        if ($seats >= 1){
                            $seat1 = $_POST['seat1'];
                            if ($seats >= 2){
                                $seat2 = $_POST['seat2'];
                                if ($seats >= 3){
                                    $seat3 = $_POST['seat3'];
                                    if ($seats >= 4){
                                        $seat4 = $_POST['seat4'];
                                        if ($seats == 5){
                                            $seat5 = $_POST['seat5'];
                                        }
                                    }
                                }
                            }
                        }
                        $_SESSION['seat1'] = $seat1; $_SESSION['seat2'] = $seat2; $_SESSION['seat3'] = $seat3; $_SESSION['seat4'] = $seat4; $_SESSION['seat5'] = $seat5;
                        $seat_info = "[ " . "$seat1, " . "$seat2, " . "$seat3, " . "$seat4, " . "$seat5, " . " ]";
                        $ride_cost = $cost * $seats - $cost * $seats * $discount;
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
                        $_SESSION["ride_cost"] = $ride_cost;
                        $_SESSION["ride_date"] = $ride_date;
                        $_SESSION["seat_info"] = $seat_info;
                        header("Location: booking5.php");
                    }
                    include("footer.html");
                    mysqli_close($conn);
                ?>
</body>
</html>
