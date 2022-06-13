<?php

require 'includes/header.php';
require 'database/database.php';
require 'includes/navigation.php';

if ($fUser['rol'] != 'medewerker') {
    header('Location: login.php?error=Om deze pagina te bekijken moet je ingelogd zijn.');
} else {
}

?>

<div class="row align-items-start" style="width:90%;">
    <div class="col-3" style="width:20%;">
        <div class="card">
            <div class="card-header">
                Dashboard
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="personeeldashboard.php?meldingenlijst">Meldingenlijst</a></li>
                <li class="list-group-item"><a href="personeeldashboard.php?categorieen">Categorieën</a></li>
                <li class="list-group-item"><a href="personeeldashboard.php?categoriemanagement">Categoriemanagement</a></li>
                <li class="list-group-item"><a href="personeeldashboard.php?klantenlijst">Klantenlijst</a></li>
                <li class="list-group-item"><a href="personeeldashboard.php?personeelslijst">Personeelslijst</a></li>
            </ul>
        </div>
    </div>
    <div class="col-9" style="width:65%;">
        <div class="card">
            <div class="card-header">
                <?php
                if (isset($_GET['meldingenlijst'])) {
                    echo 'Meldingenlijst';
                } elseif (isset($_GET['categorieen'])) {
                    echo 'Categorieën';
                } elseif (isset($_GET['categoriemanagement'])) {
                    echo 'Categoriemanagement';
                } elseif (isset($_GET['klantenlijst'])) {
                    echo 'Klantenlijst';
                } elseif (isset($_GET['personeelslijst'])) {
                    echo 'Personeelslijst';
                } else {
                    echo 'Productenlijst';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
require 'includes/footer.php';
?>