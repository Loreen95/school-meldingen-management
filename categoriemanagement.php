<?php

require 'includes/header.php';
require 'database/database.php';
require 'includes/navigation.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit'])) {
        if (trim($_POST['naam']) == "" && trim($_POST['beschrijving']) == "") {
            echo '<div class="alert alert-danger" role="alert">Vul alle velden in</div>';
        } elseif (trim($_POST['naam']) == "") {
            echo '<div class="alert alert-danger" role="alert">Vul een naam in</div>';
        } elseif (trim($_POST['beschrijving']) == "") {
            echo '<div class="alert alert-danger" role="alert">Vul een beschrijving in</div>';
        } else {
            $infoNaam = $conn->real_escape_string($_POST['naam']);

            $infoSub = $conn->query("SELECT * FROM categorieen WHERE naam = '" . $infoNaam . "'");

            if ($infoSub->num_rows) {
                echo '<div class="alert alert-danger" role="alert">Deze categorie bestaat al</div>';
            } else {
                $naam = $conn->real_escape_string($_POST['naam']);
                $beschrijving = $conn->real_escape_string($_POST['beschrijving']);

                $sql = "INSERT INTO categorieen (`beschrijving`, `naam`)
            VALUES ('" . $beschrijving . "', '" . $naam . "')";

                if ($conn->query($sql) === TRUE) {
                    echo '<div class="alert alert-success" role="alert">De categorie is aangemaakt.</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Er is een probleem opgetreden tijdens het aanmaken van de categorie.</div>';
                }
            }
        }
    }
}

?>

<div class="col-9">
    <div class="card-header">
    </div>
    <div class="card-body">
        <p class="card-text">
        <form method="post">
            <label for="naam" class="form-label">Naam:</label>
            <input type="text" name="naam" class="form-control" id="naam" placeholder="Naam"><br>
            <label for="beschrijving" class="form-label">Beschrijving:</label>
            <input type="text" name="beschrijving" class="form-control" id="beschrijving" placeholder="Beschrijving"><br>
            <button name="submit" type="submit" class="btn btn-primary mb-3">Invoeren</button>
        </form>
        </p>
    </div>
</div>

<?php

require 'includes/footer.php';

?>