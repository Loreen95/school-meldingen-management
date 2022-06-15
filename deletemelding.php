<?php

require 'includes/header.php';
require 'database/database.php';
require 'includes/navigation.php';

if ($fUser['rol'] != 'medewerker') {
    header('Location: login.php?error=Deze pagina is alleen zichtbaar voor medewerkers.');
} else {
    $id = $conn->real_escape_string($_GET['id']);

    $sql = "DELETE FROM meldingen WHERE id = '" . $id . "'";

    if ($conn->query($sql)) {
        header("location: meldingenlijst.php");
    }
}
