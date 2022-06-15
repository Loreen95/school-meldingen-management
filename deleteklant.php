<?php

require 'includes/header.php';
require 'database/database.php';
require 'includes/navigation.php';

if ($fUser['rol'] != 'medewerker') {
    header('Location: login.php?error=Om deze pagina te bekijken moet je ingelogd zijn.');
} else {
    $id = $mysqli->real_escape_string($_GET['id']);

    $sql = "DELETE FROM gebruikers WHERE id = '" . $id . "'";

    if ($mysqli->query($sql)) {
        header("location: klantenlijst.php");
    }
}
