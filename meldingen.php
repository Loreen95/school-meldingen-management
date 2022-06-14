<?php

require 'includes/header.php';
require 'database/database.php';
require 'includes/navigation.php';

$result = $conn->query("SELECT * FROM meldingen");
$meldingen = $result->fetch_all(MYSQLI_ASSOC);

?>
<div class="col-9">
    <div class="card-header">
        <div class="card-body">
            <p class="card-text">
            <table class=table>
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Bericht</th>
                        <th scope="col">Categorie</th>
                        <th scope="col">Aanmaakdatum</th>
                        <th scope="col">Aangemaakt door</th>
                        <th scope="col">Status</th>
                        <th scope="col">Afgehandeld door</th>
                        <th scope="col">Opmerking personeel</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            </p>
        </div>
    </div>
</div>
<?php




require 'includes/footer.php';

?>