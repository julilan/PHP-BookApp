<?php include 'db.php';

// Update book

if (isset($_GET['update_book'])) {
    $id = $_GET['update_book'];

    // Get book data
    $sql = "SELECT title, author, genre, description, link, image from books WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();

    // Populate form fields with book data
    $title = htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8');
    $author = htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8');
    $genre = htmlspecialchars($book['genre'], ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($book['description'], ENT_QUOTES, 'UTF-8');
    $link = htmlspecialchars($book['link'], ENT_QUOTES, 'UTF-8');
    $image = htmlspecialchars($book['image'], ENT_QUOTES, 'UTF-8');
} else {
    header('location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit book</title>
</head>
<h2>Edit book details</h2>

<body>
    <form action="update.php" method="POST">
        <p>
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="<?php echo $title; ?>">
        </p>
        <p>
            <label for="author">Author</label>
            <input type="text" name="author" id="author" value="<?php echo $author; ?>">
        </p>
        <p>
            <label for="genre">Genre</label>
            <input type="text" name="genre" id="genre" value="<?php echo $genre; ?>">
        </p>
        <p>
            <label for="description">Description</label>
            <textarea name="description" id="description" cols="30" rows="6"><?php echo $description; ?></textarea>
        </p>
        <p>
            <label for="link">Link to Goodreads</label>
            <input type="text" name="link" id="link" value="<?php echo $link; ?>">
        </p>
        <p>
            <label for="image">Image</label>
            <input type="text" name="image" id="image" value="<?php echo $image; ?>">
        </p>
        <input type="submit" name="submit" value="Edit book">
    </form>
</body>

</html>