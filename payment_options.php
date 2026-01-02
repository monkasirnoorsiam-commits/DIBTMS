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
    <link rel="stylesheet" href="styles/main.css">
    <title>Your Payment Options</title>
</head>
<body>
<?php 
    $user_id = $_SESSION["id"];
    $sql = "SELECT pa.* 
            FROM payment_options pa
            LEFT JOIN passengers p ON p.p_id = pa.p_id 
            WHERE p.p_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
?>
<body>
    <div class='payment-options'>
           <h2 style="background:rgb(192,202,51);
           color:rgb(255,255,255);
           padding:10px 20px;
           display:inline-block;
           ">
    Your payment option
</h2>

    
        <div class="payment-top-row">
        <table class="payment-table">
            <thead>
                <tr>
                    <th>Banking Service</th>
                    <th>Account Number</th>
                    <th>Available Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['banking_service_name']) . "</td>";
                    echo "<td>" . (is_null($row['acc_number']) ? "Not Set" : htmlspecialchars($row['acc_number'])) . "</td>";
                    echo "<td>৳" . number_format($row['amount'], 2) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    <div class="button-container">
       <h2 style="background:rgb(192,202,51);
           color:rgb(255,255,255);
           padding:10px 20px;
           display:inline-block;
           ">
    Update payment option
</h2>


        <form method="post" class="add-form">
            <select name="banking_service" required>
                <option value="Bkash">Bkash</option>
                <option value="Nagad">Nagad</option>
                <option value="Rocket">Rocket</option>
                <option value="Visa">Visa</option>
                <option value="Mastercard">Mastercard</option>
            </select>
            
           <input type="search" class="payment-search" placeholder="Search payment options">

            <button type="submit" name="update" class="edit-btn">Update</button>
        </form>
        </div>
        <?php
        if(isset($_POST['update'])) {
            $banking_service = mysqli_real_escape_string($conn, $_POST['banking_service']);
            $acc_number = mysqli_real_escape_string($conn, $_POST['acc_number']);
            $sql = "SELECT p_id FROM payment_options WHERE acc_number = '$acc_number'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $p_id = $row['p_id'];
            if(($user_id != $p_id) AND !(empty($row))){
                echo "<script>alert('This account is in use by another user'); window.location.href='payment_options.php';</script>";
            }
            else {
                $sql = "SELECT amount FROM bank WHERE banking_service_name = '$banking_service' AND acc_number = '$acc_number'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                if(empty($row)){
                    echo "<script>alert('Bank services do not contain this account'); window.location.href='payment_options.php';</script>";
                }
                else{
                    $amount = $row['amount'];
                    $sql = "UPDATE payment_options SET acc_number = '$acc_number', amount = '$amount' WHERE p_id = '$user_id' AND banking_service_name = '$banking_service'";
                    if(mysqli_query($conn, $sql)) {
                        echo "<script>alert('Payment option updated successfully!'); window.location.href='payment_options.php';</script>";
                    } 
                    else {
                        echo "<script>alert('Error updating payment option!');</script>";
                    }
                }
            }
        }
      //  include("footer.html");
        mysqli_close($conn);
    ?>
</body>
