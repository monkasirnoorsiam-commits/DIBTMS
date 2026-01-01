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
        $start_from = null;
        $end_at = null;
        $user_id = $_SESSION["id"];
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
   <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post" class="booking-form">

            From:
            <select name="start_from" class="booking-select" required onchange="this.form.submit()">

                            <?php
                                $start_from = isset($_POST['start_from']) ? $_POST['start_from'] : $curr_address;
                                echo "<option value='" . $curr_address . "'" . ($start_from == $curr_address ? " selected" : "") . ">" . $curr_address . "</option>";
                                foreach($addresses as $address){
                                    echo "<option value='" . $address . "'" . ($start_from == $address ? " selected" : "") . ">" . $address . "</option>";
                                }
                            ?>
                        </select>
            To:
            <select name="end_at" class="booking-select" required>

                            <?php
                                $end_at = isset($_POST['end_at']) ? $_POST['end_at'] : '';
                                foreach($addresses as $address){
                                    echo "<option value='" . $address . "'" . ($end_at == $address ? " selected" : "") . ">" . $address . "</option>";
                                }
                            ?>
                        </select>
           <button type="submit" name="select" class="booking-btn">Select</button>

    </form>
    <?php
        if(isset($_POST['select'])) {
            $start_from = mysqli_real_escape_string($conn, $_POST['start_from']);
            $end_at = mysqli_real_escape_string($conn, $_POST['end_at']);
            $_SESSION['start_from'] = $start_from;
            $_SESSION['end_at'] = $end_at;
            header("Location: booking2.php");
        }
        include("footer.html");
        mysqli_close($conn); 
    ?>
</body>
</html>
