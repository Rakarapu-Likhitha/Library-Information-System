<?php
$servername = "localhost";
$username = "root";
$password = "sreelor254"; // Use the correct password
$dbname = "library";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM librarians WHERE employee_id = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $employee_id, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Successful login
        header("Location: dashboard.php");
        exit();
    } else {
        // Failed login
        echo "<script>alert('Invalid Employee ID or Password');</script>";
    }
    $stmt->close();
}

$conn->close();
?>
