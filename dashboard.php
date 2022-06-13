<?php

require 'includes/header.php';
require 'database/database.php';
require 'includes/navigation.php';


?>


<div class="row align-items-start" style="width:90%;">
    <div class="col-3" style="width:20%;">
        <div class="card">
            <div class="card-header">
                Instellingen
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="dashboard.php?name">Naam aanpassen</a></li>
                <li class="list-group-item"><a href="dashboard.php?email">E-mail aanpassen</a></li>
                <li class="list-group-item"><a href="dashboard.php?wachtwoord">Wachtwoord aanpassen</a></li>
                <li class="list-group-item"><a href="dashboard.php?delete" style="color: red;">Account verwijderen</a></li>
            </ul>
        </div>
    </div>
    <div class="col-9" style="width:65%;">
        <div class="card">
            <div class="card-header">
                <?php
                //Toon welke pagina de gebruiker aan het bekijken is
                if (isset($_GET['name'])) {
                    echo 'Naam veranderen';
                } elseif (isset($_GET['email'])) {
                    echo 'E-mail adres veranderen';
                } elseif (isset($_GET['wachtwoord'])) {
                    echo 'Wachtwoord veranderen';
                } elseif (isset($_GET['delete'])) {
                    echo 'Account verwijderen';
                } else {
                    echo 'Naam veranderen';
                }
                ?>
            </div>
            <div class="card-body">
                <p class="card-text">
                    <?php
                    if (isset($_GET['name'])) {
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if (trim($_POST['voornaam']) == '' && trim($_POST['achternaam']) == '') {
                                echo '<div class="alert alert-danger" role="alert" role="alert">Vul alle velden in.</div>';
                            } elseif (trim($_POST['voornaam']) == '') {
                                echo '<div class="alert alert-danger" role="alert" role="alert">Vul jouw voornaam in.</div>';
                            } elseif (trim($_POST['achternaam']) == '') {
                                echo '<div class="alert alert-danger" role="alert" role="alert">Vul jouw achternaam in.</div>';
                            } else {
                                $rFirstName = $conn->real_escape_string($_POST['voornaam']);
                                $rLastName = $conn->real_escape_string($_POST['achternaam']);

                                $qUpdateName = "UPDATE gebruikers SET voornaam='$rFirstName', achternaam='$rLastName' WHERE id='$uID'"; //Update de naam van de gebruiker

                                if ($conn->query($qUpdateName) === TRUE) { //Voer query uit
                                    echo '<div class="alert alert-success" role="alert">Je naam is aangepast.</div>';
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">Er is een fout opgetreden tijdens het aanpassen van jouw naam. Probeer het later nog eens.';
                                }
                            }
                        }
                    ?>
                <form action="dashboard.php?name" method="POST">
                    <label for="firstname" class="form-label">Voornaam:</label>
                    <input type="text" name="voornaam" class="form-control" id="firstname" placeholder="Voornaam" value="<?php echo $fUser['voornaam']; ?>">
                    <label for="lastname" class="form-label">Achternaam:</label>
                    <input type="text" name="voornaam" class="form-control" id="lastname" placeholder="Achternaam" value="<?php echo $fUser['achternaam']; ?>"><br />
                    <button type="submit" class="btn btn-primary mb-3">Opslaan</button>
                </form>
            <?php
                    } elseif (isset($_GET['email'])) {
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if (trim($_POST['email']) == '') {
                                echo '<div class="alert alert-danger" role="alert" role="alert">Vul een email adres in.</div>';
                            } else {
                                $rEmail = $conn->real_escape_string($_POST['email']);

                                $qUpdateMail = "UPDATE gebruikers SET email='$rEmail' WHERE id='$uID'"; //Query voor het updaten van de mail

                                if ($conn->query($qUpdateMail) === TRUE) { //Voer query uit
                                    echo '<div class="alert alert-success" role="alert">Je email is aangepast.</div>';
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">Er is een fout opgetreden tijdens het aanpassen van jouw email. Probeer het later nog eens.';
                                }
                            }
                        }
            ?>
                <form action="dashboard.php?mail" method="POST">
                    <label for="email" class="form-label">Email:</label>
                    <input type="text" name="email" class="form-control" id="mail" placeholder="Email" value="<?php echo $fUser['email']; ?>"><br/>
                    <button type="submit" class="btn btn-primary mb-3">Opslaan</button>
                </form>
            <?php
                    } elseif (isset($_GET['wachtwoord'])) {
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if (trim($_POST['wachtwoord']) == '' && trim($_POST['wachtwoord1']) == '' && trim($_POST['wachtwoord2']) == '') {
                                echo '<div class="alert alert-danger" role="alert" role="alert">Vul alle velden in.</div>';
                            } elseif (trim($_POST['wachtwoord']) == '') {
                                echo '<div class="alert alert-danger" role="alert" role="alert">Vul jouw oude wachtwoord in.</div>';
                            } elseif (trim($_POST['wachtwoord1']) == '') {
                                echo '<div class="alert alert-danger" role="alert" role="alert">Vul een nieuw wachtwoord in.</div>';
                            } elseif (trim($_POST['wachtwoord2']) == '') {
                                echo 'Vul jouw nieuwe wachtwoord nog een keer in';
                            } elseif ($_POST['wachtwoord2'] != $_POST['wachtwoord1']) { //Wachtwoorden komen niet overeen
                                echo '<div class="alert alert-danger" role="alert" role="alert">De wachtwoorden komen niet overeen.</div>';
                            } else {
                                if (password_verify($_POST['wachtwoord'], $fUser['wachtwoord'])) {
                                    $rPassword = $conn->real_escape_string(password_hash($_POST['wachtwoord1'], PASSWORD_BCRYPT)); //Hash het wachtwoord

                                    $qUpdatePass = "UPDATE gebruikers SET password='$rPassword' WHERE id='$uID'"; //Query voor het updaten van het wachtwoord

                                    if ($conn->query($qUpdatePass) === TRUE) {
                                        echo '<div class="alert alert-success" role="alert">Je wachtwoord is aangepast.</div>';
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert">Er is een fout opgetreden tijdens het aanpassen van jouw wachtwoord. Probeer het later nog eens.</div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger" role="alert" role="alert">Je oude wachtwoord klopt niet.</div>';
                                }
                            }
                        }
            ?>
                <form action="dashboard.php?password" method="POST">
                    <label for="password" class="form-label">Huidig wachtwoord:</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Huidig wachtwoord">
                    <label for="password1" class="form-label">Nieuw wachtwoord:</label>
                    <input type="password" name="password1" class="form-control" id="password1" placeholder="Nieuw wachtwoord">
                    <label for="password2" class="form-label">Herhaal nieuw wachtwoord:</label>
                    <input type="password" name="password2" class="form-control" id="password2" placeholder="Herhaal nieuw wachtwoord"><br />
                    <button type="submit" class="btn btn-primary mb-3">Opslaan</button>
                </form>
                <?php
                    } elseif (isset($_GET['delete'])) {
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if (trim($_POST['wachtwoord']) == '') {
                                echo '<div class="alert alert-danger" role="alert" role="alert">Vul jouw wachtwoord in.</div>';
                            } else {
                                if (password_verify($_POST['wachtwoord'], $fUser['wachtwoord'])) { //Controleer of het ingevoerde wachtwoord juist is door het ingevulde wachtwoord te vergelijken met wat in de database staat

                                    $qDelete = "DELETE FROM gebruikers WHERE id=$uID"; //Query voor het verwijderen van de gebruiker

                                    if ($conn->query($qDelete) === TRUE) { //Voer de query uit
                                        echo '<div class="alert alert-success" role="alert">Jouw account is verwijderd. Je wordt doorgestuurd naar de home pagina.</div>';

                                        session_unset();

                                        session_destroy();
                ?>
                                <meta http-equiv="refresh" content="5; URL=index.php" />
                <?php
                                    } else {
                                        echo '';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger" role="alert" role="alert">Het wachtwoord klopt niet</div>';
                                }
                            }
                        }
                        echo '<div class="alert alert-danger" role="alert" role="alert">Om jouw account te verwijderen moet je jouw wachtwoord opgeven.</div>';
                ?>

                <form action="dashboard.php?delete" method="POST">
                    <label for="password" class="form-label">Wachtwoord</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Wachtwoord"><br />
                    <button type="submit" class="btn btn-danger mb-3">Verwijder account</button>
                </form>

            <?php
                    } else {
            ?>
                <form action="dashboard.php?name" method="POST">
                    <label for="firstname" class="form-label">Voornaam:</label>
                    <input type="text" name="firstname" class="form-control" id="firstname" placeholder="Voornaam" value="<?php echo $fUser['voornaam']; ?>">
                    <label for="lastname" class="form-label">Achternaam:</label>
                    <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Achternaam" value="<?php echo $fUser['achternaam']; ?>"><br />
                    <button type="submit" class="btn btn-primary mb-3">Opslaan</button>
                </form>
            <?php
                    }
            ?>
            </p>
            </div>
        </div>
    </div>
</div>
<?php

require 'includes/footer.php';

?>