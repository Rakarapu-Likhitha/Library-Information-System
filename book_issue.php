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
    $employee_id = $_POST['employee_id'];
    $name = $_POST['name'];
    $department = $_POST['department'];
    $designation = $_POST['designation'];
    $bid = $_POST['bid'];
    $book_name = $_POST['book_name'];
    $author = $_POST['author'];
    $issue_date = $_POST['issue_date'];

    // Insert book issue details into the database
    $sql_issue = "INSERT INTO issued_books (employee_id, name, department, designation, bid, bname, author, issue_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_issue = $conn->prepare($sql_issue);
    
    if (!$stmt_issue) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt_issue->bind_param("ssssssss", $employee_id, $name, $department, $designation, $bid, $book_name, $author, $issue_date);
    
    if ($stmt_issue->execute()) {
        echo "<script>alert('Book issued successfully');</script>";
    } else {
        echo "<script>alert('Failed to issue book');</script>";
    }

    $stmt_issue->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Issue</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="background">
        <div class="form-container">
        <h2>Issue Book</h2>
            <form action="" method="post">
                  <div class="textbox">
                    <label for="employee_id">Employee ID:</label>
                    <input type="text" placeholder="Employee ID" name="employee_id" required>
                </div>
                <div class="textbox">
                    <label for="name">Employee Name:</label>
                    <input type="text" placeholder="Employee Name" name="name" required>
                </div>
                <div class="textbox">
                    <label for="department">Department:</label>
                    <input type="text" placeholder="Department" name="department" required>
                </div>
                <div class="textbox">
                    <label for="designation">Designation:</label>
                    <input type="text" placeholder="Designation" name="designation" required>
                </div> 
                <div class="textbox">
                    <label for="bid">Book ID:</label>
                    <input type="text" placeholder="Book ID" name="bid" required>
                </div>
                <div class="textbox">
                    <label for="bname">Book Name:</label>
                    <input type="text" placeholder="Book Name" name="bname" required>
                </div>
                <div class="textbox">
                    <label for="author">Author:</label>
                    <input type="text" placeholder="Author" name="author" required>
                </div>
                <div class="textbox">
                    <label for="issue_date">Issue Date:</label>
                    <input type="date" name="issue_date" required>
                </div>
                <input type="submit" class="btn" value="Issue Book">
            </form>
        </div>
    </div>
</body>
</html>
