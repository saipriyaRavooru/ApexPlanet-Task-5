<?php

$conn = new mysqli("localhost", "root", "", "campus_placement");

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

?>