<?php
include("header.php");
include("database.php");

if(empty($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["id"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Feedback Summary</title>
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
<div class="payment-options">
    <h2 class="section-title">Passenger Feedback Summary</h2>
    <table class="payment-table">
        <thead>
            <tr>
                <th>Bus Number</th>
                <th>Average Rating</th>
                <th>Recent Comments</th>
            </tr>
        </thead>
        <tbody>
            <?php
           
            $sql = "
                SELECT 
                    b.bus_no, 
                    COALESCE(AVG(r.ratings), 0) AS avg_rating,
                    (SELECT comments 
                     FROM reviews r2 
                     WHERE r2.bus_no = b.bus_no 
                     ORDER BY r2.p_id DESC 
                     LIMIT 1) AS recent_comment
                FROM bus_service b
                LEFT JOIN reviews r ON b.bus_no = r.bus_no
                WHERE b.m_id = '$user_id'
                GROUP BY b.bus_no
                ORDER BY b.bus_no
            ";

            $result = mysqli_query($conn, $sql);

            while($row = mysqli_fetch_assoc($result)) {
                $avg_rating = $row['avg_rating'] ? number_format($row['avg_rating'], 2) : "No ratings";
                $recent_comment = $row['recent_comment'] ?? "No comments yet";

                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['bus_no']) . "</td>";
                echo "<td>" . $avg_rating . "</td>";
                echo "<td>" . htmlspecialchars($recent_comment) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<?php
include("footer.html");
mysqli_close($conn);
?>
</body>
</html>
