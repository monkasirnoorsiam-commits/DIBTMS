<?php
    include("database.php");
    include("header.html");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIBTMS Login</title>
</head>
<body>
    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
        <h2>Log into your account</h2>
        Email or phone number:<br>
        <input type="text" name="input"><br>
        Password:<br>
        <input type="password" name="password"><br>
        <input type="submit" name="submit" value="login"><br>
    </form>
</body>
</html>
<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $input = $_POST["input"];
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        if(empty($input)){
            echo"Please enter a email or a phone number";
        }
        elseif(empty($password)){
            echo"Please enter a password";
        }
        else{
            $hash = password_hash($password, PASSWORD_DEFAULT);
            if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
                $sql = "SELECT * FROM users where email = '$input'";
            } 
            else {
                $sql = "SELECT * FROM users where phone_no = '$input'";
            }
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0){
                if(password_verify($password, $hash)){
                    if(substr($input, 0, 5) == "admin" OR substr($input, 0, 9) == "013333333"){
                        header("Location: admin.php");
                    }
                    elseif(substr($input, 0, 7) == "manager" OR substr($input, 0, 9) == "014444444"){
                        header("Location: manager.php");
                    }
                    else{
                        header("Location: passenger.php");
                    }
                }
            }
            else{
                echo "Wrong username or password";
            }
        }
    }
    mysqli_close($conn);
?>
<?php 
    include("footer.html");
?>