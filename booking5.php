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
        $user_id = $_SESSION['id'];
        $bus_no = $_SESSION['bus_no'];
        $time = $_SESSION['time'];
        $seats = $_SESSION['seats'];
        $discount = $_SESSION['discount'];
        $no_of_rides = $_SESSION['no_of_rides'];
        $cost = $_SESSION['cost'];
        $ride_cost = $_SESSION['ride_cost'];
        $ride_date = $_SESSION['ride_date'];
        $seat_info = $_SESSION['seat_info'];
        $total_seats = $_SESSION['total_seats'];
        $seat1 = null; $seat2 = null; $seat3 = null; $seat4 = null; $seat5 = null;
        //echo"a $start_from " . "b $end_at " . "c $user_id " . "d $bus_no " . "e $time " . "f $seats " . "g $discount " . "h $cost " . "i $ride_cost " . "j $ride_date " . "k $seat_info " . "m $total_seats";
    ?>
    <form method="post">
        <div class="time-container">
                        <h2 class="text-design">Your ride fee is <?php echo$ride_cost; ?></h2><br>
                        <h2 class="text-design">Select Payment Option:</h2><br>
                            <select name="payment_option" class="booking-select" required>
                                <?php
                                    $sql = "SELECT banking_service_name, acc_number FROM payment_options WHERE p_id = '$user_id'";
                                    $result = mysqli_query($conn, $sql);
                                    mysqli_data_seek($result, 0);
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value='" . $row['banking_service_name'] . "'>" . $row['banking_service_name'] . " - " . $row['acc_number'] . "</option>";
                                    }
                            ?> </select>
                            <button type="submit" name="select5" class="edit-btn">Select</button>
                         </div>
                        </form>
                        <?php if(isset($_POST['select5'])){
                            $banking_service_name = mysqli_real_escape_string($conn, $_POST['payment_option']);
                            $sql = "SELECT amount, acc_number FROM payment_options WHERE p_id = '$user_id' AND banking_service_name = '$banking_service_name'";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $amount = $row['amount'];
                            $acc_number = $row['acc_number'];
                            if (($amount - $ride_cost) < 0){
                                echo"<script>alert('Insufficient funds!'); window.location.href='booking5.php';</script>";
                            }
                            else {
                                $seat1 = $_SESSION['seat1']; $seat2 = $_SESSION['seat2']; $seat3 = $_SESSION['seat3']; $seat4 = $_SESSION['seat4']; $seat5 = $_SESSION['seat5'];
                                if ($seats >= 1){
                                    $sql = "UPDATE bus_seats SET vacant = 0 WHERE bus_no = '$bus_no' AND seat_no = '$seat1'";
                                    mysqli_query($conn, $sql);
                                    if ($seats >= 2){
                                        $sql = "UPDATE bus_seats SET vacant = 0 WHERE bus_no = '$bus_no' AND seat_no = '$seat2'";
                                        mysqli_query($conn, $sql);
                                        if ($seats >= 3){
                                            $sql = "UPDATE bus_seats SET vacant = 0 WHERE bus_no = '$bus_no' AND seat_no = '$seat3'";
                                            mysqli_query($conn, $sql);
                                            if ($seats >= 4){
                                                $sql = "UPDATE bus_seats SET vacant = 0 WHERE bus_no = '$bus_no' AND seat_no = '$seat4'";
                                                mysqli_query($conn, $sql);
                                                if ($seats >= 5){
                                                    $sql = "UPDATE bus_seats SET vacant = 0 WHERE bus_no = '$bus_no' AND seat_no = '$seat5'";
                                                    mysqli_query($conn, $sql);
                                                }
                                            }
                                        }
                                    }
                                }
                                $total_seats = $total_seats - $seats;
                                $sql = "UPDATE bus_service SET total_seats = '$total_seats' WHERE bus_no = '$bus_no'";
                                mysqli_query($conn, $sql);
                                $amount = $amount - $ride_cost;
                                $sql = "UPDATE bank SET amount = '$amount' WHERE acc_number = '$acc_number' AND banking_service_name = '$banking_service_name'";
                                mysqli_query($conn, $sql);
                                $sql = "UPDATE payment_options SET amount = '$amount' WHERE p_id = '$user_id' AND banking_service_name = '$banking_service_name'";
                                mysqli_query($conn, $sql);
                                $no_of_rides = $no_of_rides + 1;
                                $sql = "UPDATE passengers SET no_of_rides = '$no_of_rides' WHERE p_id = '$user_id'";
                                mysqli_query($conn, $sql);
                                $sql = "INSERT INTO ride_history (p_id, bus_no, start_from, end_at, time, ride_cost, seat_info, ride_date)
                                        VALUES ('$user_id', '$bus_no', '$start_from', '$end_at', '$time', '$ride_cost', '$seat_info', '$ride_date')";
                                if(mysqli_query($conn, $sql)) {
                                    echo "<script>alert('Ride booked successfully!'); window.location.href='passenger.php';</script>";
                                }
                                else {
                                    echo "<script>alert('Error booking ride!'); window.location.href='booking5.php';</script>";
                                }
                                $_SESSION['start_from'] = null; $_SESSION['end_at'] = null; $_SESSION['bus_no'] = null; $_SESSION['time'] = null;
                                $_SESSION['seats'] = null; $_SESSION['discount'] = null; $_SESSION['cost'] = null; $_SESSION['ride_cost'] = null; $_SESSION['total_seats'] = null;
                                $_SESSION['ride_date'] = null; $_SESSION['ride_date'] = null; $_SESSION['seat_info'] = null; $_SESSION['no_of_rides'] = null;
                                $_SESSION['seat1'] = null; $_SESSION['seat2'] = null; $_SESSION['seat3'] = null; $_SESSION['seat4'] = null; $_SESSION['seat5'] = null;
                            }
                        }
                        include("footer.html");
                        mysqli_close($conn);
    ?>
</body>
</html>
