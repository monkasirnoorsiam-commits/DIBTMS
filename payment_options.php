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
        <h2>Your Payment Options</h2>
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
        <h2>Add a payment option</h2>
        <form method="post" class="add-form">
            <select name="banking_service" required>
                <option value="Bkash">Bkash</option>
                <option value="Nagad">Nagad</option>
                <option value="Rocket">Rocket</option>
                <option value="Visa">Visa</option>
                <option value="Mastercard">Mastercard</option>
            </select>
            <input type="text" name="acc_number" placeholder="Account Number" required>
            <input type="number" name="amount" placeholder="Initial Amount" required>
            <button type="submit" name="add" class="edit-btn">Add</button>
        </form>
        <h2>Delete a payment option</h2>
        <form method="post" class="delete-form">
            <input type="text" name="banking_service" placeholder="Banking Service Name" required>
            <input type="number" name="acc_number" placeholder="Account Number" required>
            <button type="submit" name="delete" class="edit-btn">Delete</button>
            </form>
        </div>
        <?php
        if(isset($_POST['add'])) {
            $banking_service = mysqli_real_escape_string($conn, $_POST['banking_service']);
            $acc_number = mysqli_real_escape_string($conn, $_POST['acc_number']);
            $amount = floatval($_POST['amount']);
            
            $sql = "INSERT INTO payment_options (p_id, banking_service_name, acc_number, amount) 
                    VALUES ('$user_id', '$banking_service', '$acc_number', '$amount')";
            
            if(mysqli_query($conn, $sql)) {
                echo "<script>alert('Payment option added successfully!'); window.location.href='payment_options.php';</script>";
            } 
            else {
                echo "<script>alert('Error adding payment option!');</script>";
            }
        }
        if(isset($_POST['delete'])) {
            $user_id = $_SESSION["id"];
            $banking_service = mysqli_real_escape_string($conn, $_POST['banking_service']);
            $acc_number = mysqli_real_escape_string($conn, $_POST['acc_number']);
            $sql = "DELETE FROM payment_options WHERE p_id = '$user_id' AND acc_number = '$acc_number' AND banking_service_name = '$banking_service'";
            
            if(mysqli_query($conn, $sql)) {
                echo "<script>alert('Payment option deleted successfully!'); window.location.href='payment_options.php';</script>";
            } 
            else {
                echo "<script>alert('Error deleting payment option!');</script>";
            }
        }
        include("footer.html");
        mysqli_close($conn);
    ?>
</body>