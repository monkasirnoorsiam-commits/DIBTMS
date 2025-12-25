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
        $sql = "SELECT u.address FROM users u where u.id = '$user_id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $curr_address = $row['address'];
        $addresses = array("Aftabnagar", "Agargaon", "Airport", "Badda", "Banani", "Bangla Motor", "Bijoy Shoroni", "Cantonment", 
                           "Dhanmondi", "ECB Chottor", "Farmgate", "Gulistan", "Gulshan", "Kamalapur", "Kalshi Flyover", 
                           "Lalbag", "Mohakhali", "Mohammadpur", "Mogbazar", "Motijheel", "Mirpur-1", "Mirpur-10", "Mirpur-12", 
                           "Multiplan", "Puran Dhaka", "Science Lab", "Shahbag", "Shishu Park", "Uttara");
    ?>
    <h2>Choose a destination</h2>
    From:
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
            <select name="start_from" required>
                <?php
                    echo "<option value='" . $curr_address . "'>" . $curr_address . "</option>";
                    foreach($addresses as $address){
                        echo "<option value='" . $address . "'>" . $address . "</option>";
                    }
                ?>
            </select>
            <br>To:
            <select name="end_at" required>
                <?php
                    foreach($addresses as $address){
                        echo "<option value='" . $address . "'>" . $address . "</option>";
                    }
                ?>
            </select>
            <button type="submit" name="select">Select</button>
    </form>
    <?php
        if(isset($_POST['select'])) {
            $start_from = mysqli_real_escape_string($conn, $_POST['start_from']);
            $end_at = mysqli_real_escape_string($conn, $_POST['end_at']);
            $sql = "SELECT t.* FROM time_slots t LEFT JOIN bus_service b on b.bus_no = t.bus_no where t.start_from = '$start_from' AND t.end_at = '$end_at'";
            include("booking2.php");
        }
    ?>
</body>
</html>
<?php 
    include("footer.html");
    mysqli_close($conn);
?>