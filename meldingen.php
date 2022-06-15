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
            <div class="card-text">
                <form class="row g-2" action="meldingen.php" method="POST">
                    <div class="col-auto ms-auto">
                        <label for="search" class="visually-hidden">Zoeken</label>
                        <input type="text" class="form-control form-control-sm" name="search" id="search" placeholder="Zoeken">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-sm mb-3" value="search">Zoeken</button>
                    </div>
                </form>
                <div class="m-4">
                    <!-- Button HTML (to Trigger Modal) -->
                    <a href="#myModal" role="button" class="btn btn-lg btn-primary" data-bs-toggle="modal">Maak een melding</a>

                    <!-- Modal HTML -->
                    <form class="row g-2" action="meldingen.php" method="POST">
                        <div id="myModal" class="modal fade" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Melding</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="naam" class="form-label">Titel:</label>
                                        <input type="text" name="naam" class="form-control" id="naam" placeholder="Naam"><br>
                                        <div class="invalid-feedback">Check this checkbox to continue.</div>
                                        <label class="form-label" for="textAreaExample" required>Bericht:</label>
                                        <textarea class="form-control" id="textAreaExample" rows="4" required></textarea></br>
                                        <div class="invalid-feedback">Check this checkbox to continue.</div>
                                    </div>
                                    <div class=" modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button name="submit" type="submit" class="btn btn-primary">Verstuur</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <table class=table>
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Bericht</th>
                            <th scope="col">Categorie</th>
                            <th scope="col">Aanmaakdatum</th>
                            <th scope="col">Status</th>
                            <th scope="col">Afgehandeld door</th>
                            <th scope="col">Opmerking personeel</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php




require 'includes/footer.php';

?>