<?php
    include("database.php");
    include("header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIBTMS Login</title>
</head>
<body style="min-height:100vh; display:flex; flex-direction:column;">
 <form class="login-form" action="<?php htmlspecialchars($_SERVER["PHP_SELF"])?>" method="post">
    <h2 class="login-title">Log into your account</h2>
    <label class="login-label">Email or phone number:</label><br>
    <input class="login-input" type="text" name="input" placeholder="Email" required><br>
    <label class="login-label">Password:</label><br>
    <input class="login-input" type="password" name="password" placeholder="Password" required><br>
    <input class="login-button" type="submit" name="submit" value="Login"><br>
</form>
<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $input = $_POST["input"];
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) { $sql = "SELECT * FROM users where email = '$input'"; }
        else { $sql = "SELECT * FROM users where phone_no = '$input'"; }
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $hash = $row['password'];
        if(mysqli_num_rows($result) > 0){
            if(password_verify($password, $hash)){
                $_SESSION["id"] = $row["id"];
                if(substr($_SESSION["id"], 0, 1) == 1){ header("Location: admin.php"); }
                elseif(substr($_SESSION["id"], 0, 1) == 2){ header("Location: manager.php"); }
                else{ header("Location: passenger.php"); }
            }
            else{ echo "<script>alert(Wrong username or password); window.location.href='login.php';</script>"; }
        }
        else{ echo "<script>alert(Wrong username or password); window.location.href='login.php';</script>"; }
    }
    mysqli_close($conn);
?>
<div style="margin-top:auto;">
        <?php include("footer.html"); ?>
    </div>
</body>
</html>