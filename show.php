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
    <title>User List</title>
</head>
<body>
<?php 
    $user_id = $_SESSION["id"];
    $sql = null;
    if(substr($_SESSION["id"], 0, 1) == 1){
        if($_SESSION["type"] == "admin"){
            $sql = "SELECT * FROM users WHERE id LIKE '1%'";
        }
        elseif($_SESSION["type"] == "manager"){
            $sql = "SELECT u.*, m.salary 
            FROM users u
            LEFT JOIN bus_managers m ON u.id = m.m_id WHERE u.id LIKE '2%'";
        }
        elseif($_SESSION["type"] == "passenger"){
            $sql = "SELECT u.*, p.discount 
            FROM users u
            LEFT JOIN passengers p ON u.id = p.p_id WHERE u.id LIKE '3%'";
        }
    }
    elseif(substr($_SESSION["id"], 0, 1) == 2){
        if($_SESSION["type"] == "staff"){
            $sql = "SELECT u.*, s.shift, s.type, s.manager_id as managed_by, s.assigned_duties, s.remarks, s.salary 
            FROM users u
            LEFT JOIN staffs s ON u.id = s.s_id";
        }
    }
    else {}
    if ($sql != null){
        $result = mysqli_query($conn, $sql);
        ?>
    <div class='payment-options'>
        <?php if(substr($_SESSION["id"], 0, 1) == 1){
            if($_SESSION["type"] == "admin"){
            ?> <h2 class="section-title">List Of All Admins</h2> 
        <?php } elseif($_SESSION["type"] == "manager"){
            ?> <h2 class="section-title">List Of All Bus Managers</h2>

        <?php } elseif($_SESSION["type"] == "passenger"){
            ?> <h2 class="section-title">List Of All Registered Passengers</h2> 
        <?php } } elseif(substr($_SESSION["id"], 0, 1) == 2){}
            ?> 
        <table class="payment-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>NID</th>
                    <th>Date Of Birth</th>
                    <th>Address</th>
                    <th>Registration Date</th>
                    <?php if(substr($_SESSION["id"], 0, 1) == 1){
                        if($_SESSION["type"] == "manager"){
                        ?> <th>Salary</th>
                    <?php } elseif($_SESSION["type"] == "passenger"){
                        ?> <th>Discount</th>
                    <?php } } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['phone_no']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nid']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['date_of_birth']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['reg_date']) . "</td>";
                    if(substr($_SESSION["id"], 0, 1) == 1){
                        if($_SESSION["type"] == "manager"){
                            echo "<td>" . htmlspecialchars($row['salary']) . "</td>";
                        }
                        elseif($_SESSION["type"] == "passenger"){
                            echo "<td>" . htmlspecialchars($row['discount']) . "</td>";
                        }
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    <?php if(substr($_SESSION["id"], 0, 1) == 1){
            if($_SESSION["type"] == "manager"){
            ?> <h2 class="section-title">Add a Bus Manager</h2>
<div class="button-container">
    <form method="post" class="add-form bus-form">
        <div class="row">
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="email" placeholder="Email" required>
            <input type="text" name="phone_no" placeholder="Phone Number" required>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <div class="row">
            <input type="text" name="nid" placeholder="NID" required>
            <input type="date" name="dob" placeholder="Date of Birth" required>
            <input type="text" name="address" placeholder="Address" required>
            <input type="number" name="salary" placeholder="Salary" required>
        </div>
        <button type="submit" name="add" class="edit-btn">Add</button>
    </form>
</div>

        <h2 class="section-title">Update Salary of a Bus Manager</h2>
        <form method="post" class="delete-form">
            <input type="number" name="id" placeholder="Manager ID" required>
            <input type="number" name="salary" placeholder="Salary" required>
            <button type="submit" name="update" class="edit-btn">Update</button>
        </form>
        <h2 class="section-title">Delete a Bus Manager</h2>
        <form method="post" class="delete-form">
            <input type="number" name="id" placeholder="Manager ID" required>
            <button type="submit" name="delete" class="edit-btn">Delete</button>
        </form>
        </div>
        <?php
        if(isset($_POST['add'])) {
            $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
            $phone_no = filter_input(INPUT_POST, "phone_no", FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
            $nid = filter_input(INPUT_POST, "nid", FILTER_VALIDATE_INT);
            $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS);
            $date_of_birth = $_POST["dob"];
            $salary = floatval($_POST['salary']);
            $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "SELECT id FROM users U1 where reg_date = (SELECT MAX(U2.reg_date) FROM users U2 where U2.id like '2%')";
                $result = mysqli_query($conn, $sql);
                $id = null;
                $row = mysqli_fetch_assoc($result);
                if(empty($row)){
                    $id = 200001;
                }
                else{
                    $id = $row["id"] + 1;
                }
                $no_of_rides = 0;
                $today = new DateTime();
                $dob = new DateTime($date_of_birth);
                $dobFormatted = $dob->format('Y-m-d');
                $age = (int)($dob->diff($today)->y);
                $reg_date = $today->format('Y-m-d H:i:s');
                $sql = "INSERT INTO users (id, name, email, phone_no, password, nid, date_of_birth, address, age, reg_date)
                        VALUES ('$id', '$name', '$email', '$phone_no', '$hash', '$nid', '$dobFormatted', '$address', '$age', '$reg_date')";
                mysqli_query($conn, $sql);
                $sql = "INSERT INTO bus_managers (m_id, salary) VALUES ('$id', '$salary')";
                if(mysqli_query($conn, $sql)) {
                    echo "<script>alert('Bus manager added successfully!'); window.location.href='show.php';</script>";
                } 
                else {
                    echo "<script>alert('Error adding bus manager!');</script>";
                }
        }
        else if(isset($_POST['update'])){
            $query_id = $_POST['id'];
            $salary = floatval($_POST['salary']);
            $sql = "UPDATE bus_managers SET salary = '$salary' WHERE m_id = '$query_id'";
            if(mysqli_query($conn, $sql)) {
                echo "<script>alert('Salary of a bus manager updated successfully!'); window.location.href='show.php';</script>";
            } 
            else {
                echo "<script>alert('Error updating salary of a bus manager!');</script>";
            }
        }
        else if(isset($_POST['delete'])) {
            $query_id = $_POST['id'];
            $sql = "SELECT bus_no FROM bus_service WHERE m_id = '$query_id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $bus_no = $row['bus_no'];
            $sql = "DELETE FROM bus_seats WHERE bus_no = '$bus_no'";
            mysqli_query($conn, $sql);
            $sql = "DELETE FROM time_slots WHERE bus_no = '$bus_no'";
            mysqli_query($conn, $sql);
            $sql = "DELETE FROM bus_service WHERE m_id = '$user_id' AND bus_no = '$bus_no'";
            mysqli_query($conn, $sql);
            $sql = "DELETE FROM bus_managers WHERE m_id = '$query_id'";
            mysqli_query($conn, $sql);
            $sql = "DELETE FROM users WHERE id = '$query_id'";
            if(mysqli_query($conn, $sql)) {
                echo "<script>alert('Bus manager removed successfully!'); window.location.href='show.php';</script>";
            } 
            else {
                echo "<script>alert('Error removing Bus manager!');</script>";
            }
        }
        }
        else if ($_SESSION["type"] == "passenger"){ ?>
            <div class="button-container">
            <h2 class="section-title">Update discount of a passenger</h2>
            <form method="post" class="delete-form">
                <input type="number" name="id" placeholder="Passenger ID" required>
                <input type="number" name="discount" placeholder="Discount" step=".01" required>
                <button type="submit" name="update1" class="edit-btn">Update</button>
                </form>
            <h2 class="section-title">Update discount of all passengers</h2>
            <form method="post" class="delete-form">
                <input type="number" name="discount" placeholder="Discount" step=".01" required>
                <button type="submit" name="update2" class="edit-btn">Update</button>
                </form>
            <h2 class="section-title">Delete a passenger</h2>
            <form method="post" class="delete-form">
                <input type="number" name="id" placeholder="Passenger ID" required>
                <button type="submit" name="delete" class="edit-btn">Delete</button>
                </form>
            </div>
        <?php 
        if(isset($_POST['update1'])) {
            $query_id = $_POST["id"];
            $discount = $_POST["discount"];
            $sql = "UPDATE passengers SET discount = '$discount' WHERE p_id = '$query_id'";
            if(mysqli_query($conn, $sql)) {
                echo "<script>alert('Updated discount successfully!'); window.location.href='show.php';</script>";
            } 
            else {
                echo "<script>alert('Error updating discount!');</script>";
            }
        }
        if(isset($_POST['update2'])) {
            $discount = $_POST["discount"];
            $sql = "UPDATE passengers SET discount = '$discount'";
            if(mysqli_query($conn, $sql)) {
                echo "<script>alert('Updated discount successfully!'); window.location.href='show.php';</script>";
            } 
            else {
                echo "<script>alert('Error updating discount!');</script>";
            }
        }
        if(isset($_POST['delete'])) {
            $query_id = $_POST["id"];
            $sql = "DELETE U, P, PA, R FROM users U LEFT JOIN passengers P ON U.id = P.p_id LEFT JOIN payment_options PA ON U.id = PA.p_id LEFT JOIN ride_history R ON U.id = R.p_id WHERE U.id = '$query_id'";
            if(mysqli_query($conn, $sql)) {
                echo "<script>alert('Passenger removed successfully!'); window.location.href='show.php';</script>";
            } 
            else {
                echo "<script>alert('Error removing passenger!');</script>";
            }
        }
        } }
        include("footer.html");
        mysqli_close($conn);
    ?>
</body>
<?php  } ?>
