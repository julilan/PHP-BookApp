<?php

include 'db.php';
require 'checkId.php';

// Array to store errors
$errors = array();
// Error message for empty fields
$error_message = "These fields cannot be empty: ";

function sanitizeInputs($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    $data = filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    // Return the sanitized data
    return $data;
}

if (isset($_GET['update_book'])) {
    $id = $_GET['update_book'];
    $idCheck = checkId($id, $mysqli);

    if ($idCheck === false) {
        // If id is not valid, go back to index.php
        header('location: index.php');
    } else {
        // Get book data
        $sql = "SELECT title, author, genre, description, link, image from books WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $book = $result->fetch_assoc();

        // Populate form fields with book data
        $title = $book['title'];
        $author = $book['author'];
        $genre = $book['genre'];
        $description = $book['description'];
        $link = $book['link'];
        $image = $book['image'];
    }
}
// Handle form submission
elseif (isset($_POST['submit'])) {
    // Get book data from form
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    // Check empty and sanitize description field
    if (empty($_POST['description'])) {
        $errors[] = "description";
        $sql = "SELECT description FROM books WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            echo "ERROR: Query failed.";
        } else {
            $row = $result->fetch_assoc();
            $description = htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8');
        }
    } else {
        $description = sanitizeInputs($_POST['description']);
    }

    // These can be left null
    $link = sanitizeInputs($_POST['link']);
    $image = sanitizeInputs($_POST['image']);

    // If no errors, proceed with update query
    if (empty($errors)) {

        $stmt = $mysqli->prepare("UPDATE books SET description=?, link=?, image=? WHERE id=?");
        $stmt->bind_param("sssi", $description, $link, $image, $id);

        if ($stmt->execute()) {
            header('location: index.php');
        } else {
            echo "ERROR: Could not update book.";
        }
    } else {
        foreach ($errors as $error) {
            $error_message .= "$error ";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpg" href="./assets/favicon.ico" />
    <link rel="stylesheet" href="style.css">
    <title>Edit book</title>
</head>
<h2>Edit book recommendation</h2>

<body>
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="title" value="<?php echo $title; ?>">
        <input type="hidden" name="author" value="<?php echo $author; ?>">
        <input type="hidden" name="genre" value="<?php echo $genre; ?>">
        <p>
            Book: <?= $title ?>
        </p>
        <p>
            Author: <?= $author ?>
        </p>
        <p>
            Genre: <?= $genre ?>
        </p>
        <p>
            <label for="description">Edit book description</label>
            <textarea name="description" id="description" cols="30" rows="6"><?php echo $description; ?></textarea>
        </p>
        <p>
            <label for="link">Add link to Goodreads</label>
            <input type="text" name="link" id="link" value="<?php echo $link; ?>">
        </p>
        <p>
            <label for="image">Add image address:</label>
            <input type="text" name="image" id="image" value="<?php echo $image; ?>">
        </p>
        <input type="submit" name="submit" value="Edit book">
        <p><?php if (!empty($errors)) echo $error_message; ?></p>
    </form>
    <a href="index.php">Back to books</a>
</body>

</html>