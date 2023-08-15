<?php

// Validating the id from GET request
function checkId($id, $mysqli): bool
{
    $sql = "SELECT title from books WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}
