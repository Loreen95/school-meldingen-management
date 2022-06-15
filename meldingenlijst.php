<?php

require 'includes/header.php';
require 'database/database.php';
require 'includes/navigation.php';


$result = $conn->query("SELECT 
    a.voornaam as voornaam,
    b.voornaam as staffvoornaam,
    a.achternaam as achternaam,
    b.achternaam as staffachternaam,
    meldingen.id as id,
    meldingen.titel,
    meldingen.bericht,
    meldingen.status,
    meldingen.datum,
    meldingen.opmerking,
    categorieen.naam
    FROM meldingen 
    LEFT JOIN gebruikers as b ON meldingen.personeel_id=b.id
    LEFT JOIN gebruikers as a ON meldingen.gebruiker_id=a.id
    LEFT JOIN categorieen ON categorieen.id = categorie_id ");

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
                            $id = $conn->real_escape_string($_SESSION['id']);

                            $qUpdateStatus = "UPDATE meldingen SET `status`='$sStatus', `opmerking`='$sopmerking', `personeel_id`='$id' WHERE id='$editStatus'";

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
                    <option selected>Kies een categorie</option>
                    <?php
                    $getStatus = $conn->query("SELECT `status` FROM meldingen");
                    $gGetStatus = $qGetStatus->fetch_assoc();
                    foreach ($ggetStatus as $stat) {
                    ?>
                        <option value="<?php echo $stat['status'] ?>"><?php echo $stat['status'] ?></option>
                    <?php
                    }
                    ?>
                </select><br>
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
                        <td><?php echo $meld['voornaam'] . " " . $meld['achternaam'] ?></td>
                        <?php
                        if ($meld['status'] == 'gesloten') {
                        ?>
                            <td><span class="badge text-bg-danger"><?php echo $meld['status'] ?></td>
                        <?php
                        } else if ($meld['status'] == 'verwerken') {
                        ?>
                            <td><span class="badge text-bg-info"><?php echo $meld['status'] ?></td>
                        <?php
                        } else if ($meld['status'] == 'afgehandeld') {
                        ?>
                            <td><span class="badge text-bg-success"><?php echo $meld['status'] ?></td>
                        <?php
                        }
                        ?>
                        <td><?php echo $meld['staffvoornaam'] . " " . $meld['staffachternaam'] ?></td>
                        <td><?php echo $meld['opmerking'] ?></td>
                        <td><a href="meldingenlijst.php?edit=<?php echo $meld['id'] ?>" style="color: blue;"><i class="bi bi-pencil"></i></a> <a href="deletemelding.php?id=<?php echo $meld['id'] ?>" style="color: red;"><i class="bi bi-x-lg"></i></a></td>
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