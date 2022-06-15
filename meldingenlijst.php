<?php

require 'includes/header.php';
require 'database/database.php';
require 'includes/navigation.php';

$result = $conn->query("SELECT 
meldingen.id, 
meldingen.bericht, 
meldingen.datum, 
gebruikers.voornaam as geb_voornaam, 
gebruikers.achternaam as geb_achternaam, 
meldingen.opmerking, 
staff.voornaam, 
staff.achternaam, 
meldingen.status, 
categorieen.naam 
FROM `meldingen` 
JOIN categorieen ON categorieen.id = categorie_id 
JOIN gebruikers ON gebruikers.id = gebruiker_id 
JOIN gebruikers 
AS staff ON staff.id = personeel_id WHERE staff.rol = 'medewerker'");


$meldingen = $result->fetch_all(MYSQLI_ASSOC);

?>
<div class="col-9">
    <div class="card-header">
        <div class="card-body">
            <p class="card-text">
                <?php
                if (isset($_GET['edit'])) {
                    $editStatus = $conn->real_escape_string($_GET['edit']);

                    $qGetStatus = $conn->query("SELECT `status` FROM meldingen WHERE id = '" . $editStatus . "'");
                    $fGetStatus = $qGetStatus->fetch_assoc();

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if (trim($_POST['status']) == '') {
                            echo 'Geef een status mee';
                        } else {
                            $sStatus = $conn->real_escape_string($_POST['status']);
                            $sopmerking = $conn->real_escape_string($_POST['opmerking']);

                            $qUpdateStatus = "UPDATE meldingen SET `status`='$sStatus', `opmerking`='$sopmerking' WHERE id='$editStatus'";

                            if ($conn->query($qUpdateStatus) === TRUE) {
                                echo '<div class="alert alert-success">De status is aangepast.</div>';
                            } else {
                                echo '<div class="alert alert-danger">Er is een fout opgetreden tijdens het aanpassen van de status. Probeer het later nog eens.</div>';
                            }
                        }
                    }
                ?>
            <form action="meldingenlijst.php?edit=<?php echo $_GET['edit']; ?>" method="POST">
                <label for="opmerking" class="form-label">Status:</label>
                <select class="form-select" name="status" id="status" required>
                    <option selected>Selecteer de status van de melding</option>
                    <option value="verwerken">Verwerken</option>
                    <option value="gesloten">Gesloten</option>
                </select>
                <label for="opmerking" class="form-label">Opmerking:</label>
                <textarea name="opmerking" class="form-control" id="textAreaExample" rows="4" required></textarea></br>
                <br>
                <button name="submit">Invoeren</button>
            </form>
            <?php
                    if (isset($_POST['submit'])) {
                        header('Refresh: 0; url=meldingenlijst.php');
                    }
            ?>
            <br>
        <?php
                }
        ?>
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
                <?php
                foreach ($meldingen as $meld) :
                ?>
                    <tr>
                        <td><?php echo $meld['id'] ?></td>
                        <td><?php echo $meld['bericht'] ?></td>
                        <td><?php echo $meld['naam'] ?></td>
                        <td><?php echo $meld['datum'] ?></td>
                        <td><?php echo $meld['geb_voornaam'] . " " . $meld['geb_achternaam'] ?></td>
                        <td><?php echo $meld['status'] ?></td>
                        <td><?php echo $meld['voornaam'] . " " . $meld['achternaam'] ?></td>
                        <td><?php echo $meld['opmerking'] ?></td>
                        <td><a href="meldingenlijst.php?edit=<?php echo $meld['id'] ?>" style="color: blue;"><i class="bi bi-pencil"></i></a> <a href="deleteproduct.php?id=<?php echo $meld['id'] ?>" style="color: red;"><i class="bi bi-x-lg"></i></a></td>
                    </tr>
                <?php
                endforeach
                ?>
            </tbody>
        </table>
        </p>
        </div>
    </div>
</div>
<?php

require 'includes/footer.php';

?>