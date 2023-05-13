<?php include 'db.php';

// Array to store errors
$errors = array();
// Error message for empty fields
$error_message = "Please fill in ";

function sanitizeInputs($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    $data = filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    // Return the sanitized data
    return $data;
}

// Get record from form
if (isset($_POST['submit'])) {

    // Check for empty fields and sanitize inputs
    if (empty($_POST['title'])) {
        $errors[] = "title";
    } else {
        $title = sanitizeInputs($_POST['title']);
    }
    if (empty($_POST['author'])) {
        $errors[] = "author";
    } else {
        $author = sanitizeInputs($_POST['author']);
    }
    if (empty($_POST['genre'])) {
        $errors[] = "genre";
    } else {
        $genre = sanitizeInputs($_POST['genre']);
    }
    if (empty($_POST['description'])) {
        $errors[] = "description";
    } else {
        $description = sanitizeInputs($_POST['description']);
    }

    // If no errors, proceed with insert query
    if (empty($errors)) {
        // Prepare and bind
        $stmt = $mysqli->prepare("INSERT INTO books (title, author, genre, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $author, $genre, $description);

        // Attempt insert
        if ($stmt->execute()) {
            header('location: index.php');
        } else {
            header('location: index.php');
        }
    } else {
        $last_error = array_pop($errors);
        foreach ($errors as $error) {
            $error_message .= "$error, ";
        }
        $error_message .= "$last_error.";
    }
}

// Delete book
if (isset($_GET['del_book'])) {
    $id = $_GET['del_book'];

    // Prepare and bind
    $stmt = $mysqli->prepare("DELETE FROM books WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Attempt delete
    if ($stmt->execute()) {
        header('location: index.php');
        echo "Record deleted successfully.";
    } else {
        header('location: index.php');
        echo "ERROR: Could not execute $stmt->error";
    }
}

// Read data from database
$books = mysqli_query($mysqli, "SELECT id, title, author, genre FROM books");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Book App</title>
</head>

<body>
    <header>
        <h2>Book recommendations app</h2>
    </header>
    <form action="index.php" method="POST">
        <p>
            <label for="title">Title</label>
            <input type="text" name="title" id="title">
        </p>
        <p>
            <label for="author">Author</label>
            <input type="text" name="author" id="author">
        </p>
        <p>
            <label for="genre">Genre</label>
            <input type="text" name="genre" id="genre">
        </p>
        <p>
            <label for="description">Description</label>
            <textarea name="description" id="description" cols="30" rows="6"></textarea>
        </p>
        <input type="submit" name="submit" value="Add book">
        <p><?php if (!empty($errors)) echo $error_message; ?></p>
    </form>

    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Genre</th>
                <th>Actions</th>
            </tr>

        <tbody>
            <?php while ($row = mysqli_fetch_array($books)) { ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['author']; ?></td>
                    <td><?php echo $row['genre']; ?></td>
                    <td>
                        <!-- <a href="#">view</a> -->
                        <a href="update.php?update_book=<?php echo $row['id']; ?>">edit</a>
                        <a href="index.php?del_book=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this book?')">remove</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
        </thead>
    </table>
</body>

</html>