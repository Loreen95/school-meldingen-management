<?php
require 'database/bootstrap.php';
if (!isset($_SESSION["id"])) {
    header('Location: login.php');
} else {
    session_unset();

    session_destroy();

    header('Location: index.php');
}
