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
            
            $sql = "SELECT bus_no FROM bus_service WHERE m_id = '$user_id'";
            $result = mysqli_query($conn, $sql);

            while($bus = mysqli_fetch_assoc($result)) {
                $bus_no = $bus['bus_no'];


                $rating_sql = "SELECT AVG(ratings) as avg_rating FROM reviews WHERE bus_no = '$bus_no'";
                $rating_result = mysqli_query($conn, $rating_sql);
                $rating_row = mysqli_fetch_assoc($rating_result);
                $avg_rating = number_format($rating_row['avg_rating'], 2);

               
                $comment_sql = "SELECT comments FROM reviews WHERE bus_no = '$bus_no' ORDER BY p_id DESC LIMIT 1";
                $comment_result = mysqli_query($conn, $comment_sql);
                $comment_row = mysqli_fetch_assoc($comment_result);
                $recent_comment = $comment_row['comments'] ?? "No comments yet";

                echo "<tr>";
                echo "<td>" . htmlspecialchars($bus_no) . "</td>";
                echo "<td>" . ($avg_rating ? $avg_rating : "No ratings") . "</td>";
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
