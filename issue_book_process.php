<?php include 'navbar.php'; ?>
<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "library";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract form data
    $employee_id = $_POST['employee_id'];
    $employee_name = $_POST['employee_name'];
    $department = $_POST['department'];
    $designation = $_POST['designation'];
    $bid = $_POST['bid'];
    // Extract other form fields (book name, author, issue date, etc.)

    // Here you can perform any additional validation or processing of the form data

    // Insert issued book details into the database
    $sql = "INSERT INTO issued_books (employee_id, bid, issue_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $employee_id, $bid, $issue_date); // Adjust parameters as needed
    $issue_date = date("Y-m-d"); // Assuming issue date is today's date
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Book issued successfully
        echo "<script>alert('Book issued successfully');</script>";
        // Redirect or handle success message as needed
    } else {
        // Failed to issue book
        echo "<script>alert('Failed to issue book');</script>";
        // Redirect or handle error message as needed
    }

    $stmt->close();
}

$conn->close();
?>
