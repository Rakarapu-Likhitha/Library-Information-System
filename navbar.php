<?php include 'navbar.php'; ?>
<?php
$servername = "localhost";
$username = "root";
$password = "sreelor254";
$dbname = "library";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // Variable to store success or error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bname = $_POST['bname'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $category = $_POST['category'];
    
    // Handle image upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    
    $sql = "INSERT INTO books (bname, author, publisher, category, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $bname, $author, $publisher, $category, $target_file);
    
    if ($stmt->execute()) {
        $message = "New book added successfully";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="background">
        <div class="form-container">
            <h2>Add New Book</h2>
            <?php if ($message): ?>
                <div><?php echo $message; ?></div>
            <?php endif; ?>
            <form action="add_books.php" method="post" enctype="multipart/form-data">
                <!-- <div class="textbox">
                    <input type="text" placeholder="Book ID" name="bid" required>
                </div> -->
                <div class="textbox">
                    <input type="text" placeholder="Book Name" name="bname" required>
                </div>
                <div class="textbox">
                    <input type="text" placeholder="Author" name="author" required>
                </div>
                <div class="textbox">
                    <input type="text" placeholder="Publisher" name="publisher" required>
                </div>
                <div class="textbox">
                    <select name="category" required>
                        <option value="" disabled selected>Select Category</option>
                        <option value="Education">Education</option>
                        <option value="Magazine">Magazine</option>
                        <option value="Politics">Politics</option>
                        <option value="Fiction">Fiction</option>
                        <option value="Non-fiction">Non-fiction</option>
                        <option value="Biography">Biography</option>
                        <option value="History">History</option>
                        <option value="Science">Science</option>
                        <option value="Technology">Technology</option>
                        <option value="Art">Art</option>
                        <option value="Health">Health</option>
                        <option value="Cooking">Cooking</option>
                        <option value="Travel">Travel</option>
                        <option value="Self-Help">Self-Help</option>
                        <option value="Business">Business</option>
                        <option value="Finance">Finance</option>
                        <option value="Sports">Sports</option>
                        <option value="Religion">Religion</option>
                    </select>
                </div>
                <div class="textbox">
                    <input type="file" name="image" accept="image/*" required>
                </div>
                <input type="submit" class="btn" value="Add Book">
            </form>
        </div>
    </div>
</body>
</html>
