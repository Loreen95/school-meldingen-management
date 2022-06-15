<?php

require 'includes/header.php';
require 'database/database.php';
require 'includes/navigation.php';

$result = $conn->query("SELECT 
meldingen.id, 
meldingen.bericht, 
meldingen.datum, 
gebruikers.id,
gebruikers.voornaam,
gebruikers.achternaam,
meldingen.opmerking, 
staff.voornaam, 
staff.achternaam, 
meldingen.status, 
categorieen.naam,
categorieen.id
FROM `meldingen`
JOIN categorieen ON categorieen.id = categorie_id 
JOIN gebruikers ON gebruikers.id = gebruiker_id 
JOIN gebruikers 
AS staff ON staff.id = personeel_id WHERE staff.rol = 'medewerker' AND gebruikers.id ={$_SESSION['id']}");

$meldingen = $result->fetch_all(MYSQLI_ASSOC);

$result = $conn->query("SELECT * FROM categorieen");
$categories = $result->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit'])) {
        if (trim($_POST['titel']) == "" && trim($_POST['bericht']) == "") {
            echo '<div class="alert alert-danger" role="alert">Vul alle velden in</div>';
        } elseif (trim($_POST['titel']) == "") {
            echo '<div class="alert alert-danger" role="alert">Vul een naam in</div>';
        } elseif (trim($_POST['bericht']) == "") {
            echo '<div class="alert alert-danger" role="alert">Vul een beschrijving in</div>';
        } elseif (trim($_POST['categorie']) == "") {
            echo '<div class="alert alert-danger" role="alert">Kies een categorie</div>';
        } else {
            $naam = $conn->real_escape_string($_POST['titel']);
            $bericht = $conn->real_escape_string($_POST['bericht']);
            $categorie = $conn->real_escape_string($_POST['categorie']);
            $id = $conn->real_escape_string($_SESSION['id']);
            $datum = $conn->real_escape_string($_GET['datum']);
            $medewerker = "Onbekend";

            $sql = "INSERT INTO meldingen (`titel`, `bericht`, `categorie_id`, `datum`, `gebruiker_id`, `personeel_id`)
            VALUES ('$naam', '$bericht', '$categorie', '$datum', '$id', '$medewerker')";

            if ($conn->query($sql) === TRUE) {
                echo '<div class="alert alert-success" role="alert">De melding is aangemaakt.</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Er is een probleem opgetreden tijdens het aanmaken van de melding.</div>';
            }
        }
    }
}

?>
<div class="col-9">
    <div class="card-header">
        <div class="card-body">
            <div class="card-text">
                <div class="m-4">
                    <!-- Button HTML (to Trigger Modal) -->
                    <a href="#myModal" role="button" class="btn btn-lg btn-primary" data-bs-toggle="modal" id="modal">Maak een melding</a>

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
                                        <input type="text" name="titel" class="form-control" id="naam" placeholder="Naam" required><br>

                                        <select class="form-select" name="categorie" id="status" required>
                                            <option selected>Kies een categorie</option>
                                            <?php

                                            foreach ($categories as $cat) :
                                            ?>
                                                <option value="<?php echo $cat['id'] ?>"><?php echo $cat['naam'] ?></option>
                                            <?php
                                            endforeach;
                                            ?>
                                        </select><br>
                                        <label class="form-label" for="textAreaExample" required>Bericht:</label>
                                        <textarea name="bericht" class="form-control" id="textAreaExample" rows="4" required></textarea></br>
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
                        <?php
                        foreach ($meldingen as $meld) :
                        ?>
                            <tr>
                                <td><?php echo $meld['id'] ?></td>
                                <td><?php echo $meld['bericht'] ?></td>
                                <td><?php echo $meld['naam'] ?></td>
                                <td><?php echo $meld['datum'] ?></td>
                                <td><?php echo $meld['status'] ?></td>
                                <td><?php echo $meld['voornaam'] . " " . $meld['achternaam'] ?></td>
                                <td><?php echo $meld['opmerking'] ?></td>
                            </tr>
                        <?php
                        endforeach
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php




require 'includes/footer.php';

?>