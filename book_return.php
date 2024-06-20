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
    // Retrieve form data
    $employee_id = $_POST['employee_id'];
    $book_id = $_POST['book_id'];
    $return_date = $_POST['return_date'];

    // Update database to set return date
    $sql_update = "UPDATE issued_books SET return_date = ? WHERE employee_id = ? AND bid = ?";
    $stmt_update = $conn->prepare($sql_update);

    if (!$stmt_update) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt_update->bind_param("sss", $return_date, $employee_id, $book_id);

    if ($stmt_update->execute()) {
        // Book returned successfully
        echo "<script>alert('Book returned successfully');</script>";
    } else {
        // Failed to return book
        echo "<script>alert('Failed to return book');</script>";
    }

    $stmt_update->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Book</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="background">
        <div class="form-container">
            <h2>Return Book</h2>
            <!-- Form for returning a book -->
            <form action="book_return.php" method="post">
                <div class="textbox">
                    <label for="employee_id">Employee ID:</label>
                    <input type="text" name="employee_id" required>
                </div>
                <div class="textbox">
                    <label for="book_id">Book ID:</label>
                    <input type="text" name="book_id" required>
                </div>
                <div class="textbox">
                    <label for="return_date">Return Date:</label>
                    <input type="date" name="return_date" required>
                </div>
                <input type="submit" class="btn" value="Return Book">
            </form>
        </div>
    </div>
</body>
</html>
