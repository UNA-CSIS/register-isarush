<?php
session_start();

if (isset($_SESSION['user'])) {
    $username = $_SESSION['user'];
} else {
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        Display games here...<br><br>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "softball";

// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM games ORDER BY id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table><tr><th>ID</th><th>Opponent</th><th>Site</th><th>Result</th></tr>";
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["id"] . "</td><td>" . $row["opponent"] . "</td><td>" . $row["site"] . "</td><td>" . $row["result"] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
    </p>
</body>
</html>
</body>
</html>
