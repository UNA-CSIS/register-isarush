<?php
session_start();
// start session
include "validate.php";

$uname = test_input($_POST['user']);
$pwd = test_input($_POST['pwd']);

// login to the softball database

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

if (mysqli_num_rows($result) > 0) {
    // if no rows, then username is not valid (but don't tell Mallory) just send her back to the login
    $row = mysqli_fetch_assoc($result);
    $db_hash = $row['password'];
} else {
    $conn->close();
    header("location: index.php");
    exit;
}

$conn->close();
// otherwise, password_verify(password from form, password from db)
$passResult = password_verify($pwd, $db_hash);
echo "verify returned: $passResult<br>";
// if good, put username in session, otherwise send back to login
if ($passResult === true) {
    $_SESSION['user'] = $uname;
    header("location: games.php");
} else {
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
    <body>        
        <a href="index.php">Click Here to Login</a>
    </body>
</html>
