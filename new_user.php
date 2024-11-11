<?php
// session start here...
session_start();
// get all 3 strings from the form (and scrub w/ validation function)
$uname = $_POST["user"];
$pwd = $_POST["pwd"];
$repeat = $_POST["repeat"];
// make sure that the two password values match!
if ($pwd == $repeat) {
    echo "Good match<br>";
} else {
    echo "Passwords didn't match<br>";
    header("location: index.php");
}
// create the password_hash using the PASSWORD_DEFAULT argument
$hash = password_hash($pwd, PASSWORD_DEFAULT);
// login to the database
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

// select password from users where username = <what the user typed in>
$sql = "SELECT password FROM users WHERE username = '$uname'";
$result = $conn->query($sql);
// make sure that the new user is not already in the database
if (mysqli_num_rows($result) == 0) {
    $sql = "INSERT INTO users (username, password) VALUES ('$uname', '$hash')";
    $result = $conn->query($sql);
    if ($result === TRUE) {
        echo "Created successfully!";
        ?>
        <!DOCTYPE html>
        <html>
            <body>        
                <a href="index.php"><br>Click Here to Login</a>
            </body>
        </html>
        <?php
    }
} else {
    echo "There is already a user under that name";
    header("location: index.php");
}
$conn->close();
?>