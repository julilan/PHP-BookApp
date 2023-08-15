<?php

include 'db.php';
require 'checkId.php';

if (isset($_GET['view_book'])) {
    $id = $_GET['view_book'];
    $idCheck = checkId($id, $mysqli);

    if ($idCheck === false) {
        // If id is not valid, go back to index.php
        header('location: index.php');
    } else {
        $result = mysqli_query($mysqli, "SELECT * FROM books WHERE id = $id");
        $book = mysqli_fetch_assoc($result);
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
    <title>View Book</title>
</head>

<body>
    <div class="book">
        <p>Title: <?= $book['title'] ?></p>
        <p>Author: <?= $book['author'] ?></p>
        <p>Genre: <?= $book['genre'] ?></p>
        <p>Description: <?= $book['description'] ?></p>
        <p>Link: <a href="<?= $book['link'] ?>" target="_blank">Goodreads</a></p>
        <img src="<?= $book['image'] ?>" alt="<?= $book['title'] ?>">
    </div>
    <a href="index.php">Back to books</a>
</body>

</html>