<?php
session_start();
error_reporting(E_ALL);

require 'database/database.php';


if ($conn->connect_errno) {
    printf("Connect failed: %s<br />", $conn→connect_error);
    exit();
}

if (isset($_SESSION['id'])) {
    $uID = $conn->real_escape_string($_SESSION['id']);

    $qUser = $conn->query("SELECT * FROM gebruikers where id = '" . $uID . "'");
    $fUser = $qUser->fetch_assoc();
}
