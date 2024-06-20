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

$sql = "SELECT books.bid, books.bname, books.author, books.publisher, books.image, books.category, 
        CASE 
            WHEN issued_books.bid IS NOT NULL THEN 'Issued' 
            ELSE 'Available' 
        END AS status,
        employees.employee_id, employees.name AS employee_name, employees.department, employees.designation
        FROM books
        LEFT JOIN issued_books ON books.bid = issued_books.bid
        LEFT JOIN employees ON issued_books.employee_id = employees.employee_id";
$result = $conn->query($sql);

// Check if query execution was successful
if (!$result) {
    die("Query execution failed: " . $conn->error);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Books</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="background">
        <div class="table-container">
            <h2>List of Books</h2>
            <table>
                <thead>
                    <tr>
                        <th>Book ID</th>
                        <th>Book Name</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Employee Details</th>
                        <th>Action</th> <!-- New column for Delete button -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['bid'] . "</td>";
                            echo "<td>" . $row['bname'] . "</td>";
                            echo "<td>" . $row['author'] . "</td>";
                            echo "<td>" . $row['publisher'] . "</td>";
                            echo "<td><img src='" . $row['image'] . "' alt='Book Image' width='50'></td>";
                            echo "<td>" . $row['category'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            if ($row['status'] == 'Issued') {
                                echo "<td>Employee ID: " . $row['employee_id'] . "<br>Name: " . $row['employee_name'] . "<br>Department: " . $row['department'] . "<br>Designation: " . $row['designation'] . "</td>";
                            } else {
                                echo "<td>N/A</td>";
                            }
                            echo "<td><form action='delete_book.php' method='post'><input type='hidden' name='bid' value='" . $row['bid'] . "'><input type='submit' value='Delete'></form></td>"; // Delete button
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No books found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
