<?php
    include("header.php");
    include("database.php");

    if (empty($_SESSION["id"])) {
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIBTMS Reviews</title>
</head>


<body class="no-footer"> 


<h2 style="display:inline-block;">
    <span style="background:rgb(192,202,51);
                 color:rgb(255,255,255);
                 padding:5px 10px;
                 display:inline-block;
                 ">
        Share your experience and help us improve!
    </span>
</h2>



<form method="post" class="review-form">

    Bus Number:<br>
    <input type="number" name="bus_no" required><br><br>

    Rating (1 to 5):<br>
    <input type="number" name="ratings" min="1" max="5" step="0.1" required><br><br>

    Comment:<br>
    <textarea name="comments" maxlength="100" required></textarea><br><br>

    <input type="submit" name="submit" value="Submit Review">
</form>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $p_id = $_SESSION["id"];
        $bus_no = $_POST["bus_no"];
        $ratings = $_POST["ratings"];
        $comments = $_POST["comments"];

        $sql = "INSERT INTO reviews (p_id, bus_no, comments, ratings)
                VALUES ('$p_id', '$bus_no', '$comments', '$ratings')";

        if (mysqli_query($conn, $sql)) {
            echo "<p>Review submitted successfully!</p>";
        } else {
            echo "<p>Error submitting review.</p>";
        }
    }
?>


<div style="margin-top:auto;">
    <?php 
        include("footer.html");
        mysqli_close($conn);
    ?>
</div>

</body>
</html>
