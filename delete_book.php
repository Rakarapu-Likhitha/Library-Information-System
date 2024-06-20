<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Book</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="background">
        <div class="form-container">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bid']) && isset($_POST['confirm'])) {
                $bid = $_POST['bid'];
                
                if ($_POST['confirm'] == 'yes') {
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

                    // Prepare and execute SQL statement to delete the book
                    $sql = "DELETE FROM books WHERE bid = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $bid);
                    
                    if ($stmt->execute()) {
                        // Book deleted successfully
                        echo "<h2>Book Deleted Successfully</h2>";
                        echo "<p>The book with ID: $bid has been successfully deleted.</p>";
                    } else {
                        // Error deleting book
                        echo "<h2>Error Deleting Book</h2>";
                        echo "<p>There was an error while deleting the book with ID: $bid. Please try again later.</p>";
                    }

                    $stmt->close();
                    $conn->close();
                } else {
                    echo "<h2>Deletion Cancelled</h2>";
                    echo "<p>The deletion of the book with ID: $bid has been cancelled.</p>";
                }
            } else {
                echo "<h2>Confirmation Required</h2>";
                echo "<p>Are you sure you want to delete this book?</p>";
                echo "<form action='delete_book.php' method='post'>";
                echo "<input type='hidden' name='bid' value='" . $_POST['bid'] . "'>";
                echo "<input type='hidden' name='confirm' value='yes'>";
                echo "<input type='submit' value='Yes'>";
                echo "</form>";
                echo "<form action='delete_book.php' method='post'>";
                echo "<input type='hidden' name='bid' value='" . $_POST['bid'] . "'>";
                echo "<input type='hidden' name='confirm' value='no'>";
                echo "<input type='submit' value='No'>";
                echo "</form>";
            }
            ?>
        </div>
    </div>
</body>
</html>
