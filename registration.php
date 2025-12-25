<?php
    include("header.php");
    include("database.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIBTMS Registration</title>
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
        <h2>Registration form</h2>
        Name:
        <input type="text" name="name" placeholder="Name" required><br>
        Email:
        <input type="text" name="email" placeholder="Email" required><br>
        Phone number:
        <input type="text" name="phone_no" placeholder="Phone number" required><br>
        Password:
        <input type="password" name="password" placeholder="Password" required><br>
        NID:
        <input type="text" name="nid" placeholder="NID" required><br>
        Date of birth:
        <input type="date" name="date_of_birth" placeholder="Date of birth" required><br>
        Address:
        <select name="address" required><br>
            <?php
                $addresses = array("Aftabnagar", "Agargaon", "Airport", "Badda", "Banani", "Bangla Motor", "Bijoy Shoroni", "Cantonment", 
                            "Dhanmondi", "ECB Chottor", "Farmgate", "Gulistan", "Gulshan", "Kamalapur", "Kalshi Flyover", 
                            "Lalbag", "Mohakhali", "Mohammadpur", "Mogbazar", "Motijheel", "Mirpur-1", "Mirpur-10", "Mirpur-12", 
                            "Multiplan", "Puran Dhaka", "Science Lab", "Shahbag", "Shishu Park", "Uttara");
                foreach($addresses as $address){
                    echo "<option value='" . $address . "'>" . $address . "</option>";
                }
            ?>
        </select>
        <input type="submit" name="submit" value="register"><br>
    </form>
</body>
</html>
<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $phone_no = filter_input(INPUT_POST, "phone_no", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $nid = filter_input(INPUT_POST, "nid", FILTER_VALIDATE_INT);
        $date_of_birth = $_POST["date_of_birth"];
        if(isset($_POST["address"])){
            $address = $_POST["address"];
            if(empty($name)){
                echo"Please enter your name";
            }
            elseif(empty($email)){
                echo"Please enter your email";
            }
            elseif(substr($email, 0, 5) == "admin" OR substr($email, 0, 7) == "manager"){
                echo"You cannot use this email";
            }
            elseif(empty($phone_no)){
                echo"Please enter your phone number";
            }
            elseif(substr($phone_no, 0, 9) == "013333333" OR substr($phone_no, 0, 9) == "014444444"){
                echo"You cannot use this phone number";
            }
            elseif(strlen($phone_no) != 11){
                echo"Please use a valid phone number";
            }
            elseif(empty($password)){
                echo"Please enter a password";
            }
            elseif(empty($nid)){
                echo"Please enter your nid";
            }
            elseif(strlen($nid) != 10){
                echo"Please use a valid NID";
            }
            elseif(empty($date_of_birth)){
                echo"Please enter your date of birth";
            }
            else{
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "SELECT id FROM users U1 where reg_date = (SELECT MAX(U2.reg_date) FROM users U2 where U2.id like '3%')";
                $result = mysqli_query($conn, $sql);
                $id = null;
                $row = mysqli_fetch_assoc($result);
                if(empty($row)){
                    $id = 300001;
                }
                else{
                    $id = $row["id"] + 1;
                }
                $no_of_rides = 0;
                $today = new DateTime();
                $dob = new DateTime($date_of_birth);
                $dobFormatted = $dob->format('Y-m-d');
                $age = (int)($dob->diff($today)->y);
                $discount = (5/100);
                $reg_date = $today->format('Y-m-d H:i:s');
                $sql = "INSERT INTO users (id, name, email, phone_no, password, nid, date_of_birth, address, no_of_rides, age, reg_date)
                        VALUES ('$id', '$name', '$email', '$phone_no', '$hash', '$nid', '$dobFormatted', '$address', '$no_of_rides', '$age', '$reg_date')";
                try{
                    mysqli_query($conn, $sql);
                    $sql = "INSERT INTO passengers (p_id, discount) VALUES ('$id', '$discount')";
                    mysqli_query($conn, $sql);
                    echo"You are now registered! Now log in to your account";
                    header("Location: login.php");
                }
                catch(mysqli_sql_exception){
                    echo"That email or phone number is taken";
                }
            }
        }
        else {
            echo"Please make a selection";
        }
    }
    include("footer.html");
    mysqli_close($conn);
?>