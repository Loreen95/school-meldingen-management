<?php

require 'includes/header.php';
require 'database/database.php';
require 'includes/navigation.php';


if ($fUser['rol'] != 'medewerker') {
    header('Location: login.php?error=Om deze pagina te bekijken moet je ingelogd zijn.');
} else {
    $id = $conn->real_escape_string($_GET['id']);

    $sql = "DELETE FROM categorieen WHERE id = '" . $id . "'";

    if ($conn->query($sql)) {
        header("location: categorielijst.php");
    }
}
