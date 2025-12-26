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
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
                <h2>Select number of seats:</h2>
                    <select name="seats" required onchange="this.form.submit()">
                                            <?php
                                                $selected_seats = isset($_POST['seats']) ? $_POST['seats'] : '1';
                                                for($i = 1; $i <= 5; $i++) {
                                                    echo "<option value='" . $i . "'" . ($selected_seats == $i ? " selected" : "") . ">" . $i . "</option>";
                                                }
                                            ?>
                    </select>
                    <button type="submit" name="select3" class="edit-btn">Select</button>
                </form>
                <?php  if(isset($_POST['select3'])){
                    $seats = $_POST['seats'];
                    $_SESSION['seats'] = $seats;
                    header("Location: booking4.php");
                }
    include("footer.html");
    mysqli_close($conn);
?>
</body>
</html>