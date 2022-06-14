<?php

require 'includes/header.php';
require 'database/database.php';
require 'includes/navigation.php';

?>
<div class="col-9">
    <div class="card-header">
    </div>
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

                        $qUpdateStatus = "UPDATE meldingen SET `status`='$sStatus' WHERE id='$editStatus'";

                        if ($conn->query($qUpdateStatus) === TRUE) {
                            echo '<div class="alert alert-success">De status is aangepast.</div>';
                        } else {
                            echo '<div class="alert alert-danger">Er is een fout opgetreden tijdens het aanpassen van de status. Probeer het later nog eens.</div>';
                        }
                    }
                }
            ?>
                <?php
                $result = $conn->query("SELECT * FROM meldingen");
                $meldingen = $result->fetch_all(MYSQLI_ASSOC);
                foreach ($meldingen as $meld) {
                ?>
        <form action="meldingenlijst.php?&edit=<?php echo $_GET['edit']; ?>" method="POST">
            <select class="form-select" name="status" id="status">
                <option selected>Selecteer de status van de melding</option>
                <option value="verwerken" <?php if ($meld['status'] == 'verwerken') {
                                                echo 'selected';
                                            } ?>>Verwerken</option>
                <option value="gesloten" <?php if ($meld['status'] == 'gesloten') {
                                                echo 'selected';
                                            } ?>>Gesloten</option>
            </select>
        <?php
                }
        ?>
        <br>
        <button name="submit">Invoeren</button>
        </form>

        <br>
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
                    <th scope="col">Opmerking</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $meld['id'] ?></td>
                    <td><?php echo $meld['bericht'] ?></td>
                    <td><?php echo $meld['categorie_id'] ?></td>
                    <td><?php echo $meld['datum'] ?></td>
                    <td><?php echo $meld['gebruiker_id'] ?></td>
                    <td><?php echo $meld['status'] ?></td>
                    <td><?php echo $meld['personeel_id'] ?></td>
                    <td><?php echo $meld['opmerking'] ?></td>
                    <td><a href="meldingenlijst.php?edit=<?php echo $meld['id'] ?>" style="color: blue;"><i class="bi bi-pencil"></i></a> <a href="deleteproduct.php?id=<?php echo $meld['id'] ?>" style="color: red;"><i class="bi bi-x-lg"></i></a></td>
                </tr>
            </tbody>
        </table>
    <?php }   ?>
    </p>
    </div>
</div>
<?php

require 'includes/footer.php';

?>