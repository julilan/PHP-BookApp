<?php

$host = 'db';
$dbname = 'bookdb';
$user = 'root';
$pass = 'lionPass';

// check the MySQL connection status
$mysqli = new mysqli($host, $user, $pass, $dbname);

// Check connection/
if ($mysqli->connect_error) {
    die("Connection failed:" . $mysqli->connect_error);
}
