<?php

require 'includes/header.php';
require 'database/database.php';
require 'includes/navigation.php';

if ($fUser['rol'] != 'medewerker') {
    '<div class="alert alert-danger" rol="alert">Om deze pagina te bekijken moet je ingelogd zijn.</div>';
} else {
}

$allUsers = $conn->query("SELECT * FROM gebruikers WHERE rol <> 'medewerker' ");
$users = $allUsers->fetch_all(MYSQLI_ASSOC);

$medewerkers = $conn->query("SELECT * FROM gebruikers WHERE rol = 'medewerker'");
$result = $medewerkers->fetch_all(MYSQLI_ASSOC);

$categorieen = $conn->query("SELECT * FROM categorieen");
$categorie = $categorieen->fetch_all(MYSQLI_ASSOC);

?>

<div class="row align-items-start" style="width:90%;">
    <div class="col-3" style="width:20%;">
        <div class="card">
            <div class="card-header">
                Dashboard
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="personeeldashboard.php?categorielijst">Categorielijst</a></li>
                <li class="list-group-item"><a href="personeeldashboard.php?categoriemanagement">Categoriemanagement</a></li>
                <li class="list-group-item"><a href="personeeldashboard.php?klantenlijst">Klantenlijst</a></li>
                <li class="list-group-item"><a href="personeeldashboard.php?personeellijst">Personeellijst</a></li>
                <li class="list-group-item"><a href="personeeldashboard.php?meldingenlijst">Meldingenlijst</a></li>
            </ul>
        </div>
    </div>
    <div class="col-9" style="width:65%;">
        <div class="card">
            <div class="card-header">
                <?php
                if (isset($_GET['categorielijst'])) {
                    echo 'Categorielijst';
                } elseif (isset($_GET['categoriemanagement'])) {
                    echo 'Categoriemanagement';
                } elseif (isset($_GET['klantenlijst'])) {
                    echo 'Klantenlijst';
                } elseif (isset($_GET['personeellijst'])) {
                    echo 'Personeellijst';
                } elseif (isset($_GET['meldingenlijst'])){
                    echo 'Meldingenlijst';
                }else{
                    echo 'Overigen';
                }
                ?>
            </div>
            <div class="card-body">
                <p class="card-text">
                    <?php
                    if (isset($_GET['categorielijst'])) {
                        if (isset($_GET['edit'])) {
                            $editID = $conn->real_escape_string($_GET['edit']);

                            $qGetCat = $conn->query("SELECT * FROM categorieen WHERE id = '" . $editID . "'");
                            $fGetCat = $qGetCat->fetch_assoc();

                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (trim($_POST['naam']) == '' && trim($_POST['beschrijving']) == '') {
                                    echo 'Vul alle velden in';
                                } elseif (trim($_POST['naam']) == '') {
                                    echo 'Er is geen naam ingevuld';
                                } elseif (trim($_POST['beschrijving']) == '') {
                                    echo 'Geef een beschrijving op';
                                } else {
                                    $pName = $conn->real_escape_string($_POST['naam']);
                                    $pBeschrijving = $conn->real_escape_string($_POST['beschrijving']);

                                    $qUpdateCat = "UPDATE categorieen SET `naam`='$pName', `beschrijving`=$pBeschrijving' WHERE id='$editID'";

                                    if ($conn->query($qUpdateCat) === TRUE) {
                                        echo '<div class="alert alert-success">De categorie is aangepast.</div>';
                                    } else {
                                        echo '<div class="alert alert-danger">Er is een fout opgetreden tijdens het aanpassen van de categorie. Probeer het later nog eens.</div>';
                                    }
                                }
                            }
                    ?>
                <form action="personeeldashboard.php?categorielijst&edit=<?php echo $_GET['edit']; ?>" method="POST">
                    <label for="name" class="form-label">Naam:</label>
                    <input type="text" name="naam" class="form-control" id="naam" placeholder="Naam" value="<?php echo $fGetCat['naam']; ?>">
                    <label for="beschrijving" class="form-label">Beschrijving:</label>

                    <button type="submit" class="btn btn-primary mb-3">Opslaan</button>
                </form>
            <?php
                        } else {
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                                if (trim($_POST['search']) == '') {
                                    echo 'Vul een zoekterm in';
                                    $sql = "SELECT * FROM categorieen";
                                } else {
                                    $search = $conn->real_escape_string($_POST['search']);
                                    $sql = "SELECT * FROM categorieen WHERE name LIKE '%$search%'";
                                }
                            } else {
                                $sql = "SELECT * FROM categorieen";
                            }
                            $qcategories = $conn->query($sql);
                            $fcategories = $qcategories->fetch_all(MYSQLI_ASSOC);
            ?>
                <form class="row g-2" action="personeeldashboard.php?categorielijst" method="POST">
                    <div class="col-auto ms-auto">
                        <label for="search" class="visually-hidden">Zoeken</label>
                        <input type="text" class="form-control form-control-sm" name="search" id="search" placeholder="Zoeken">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-sm mb-3" value="search">Zoeken</button>
                    </div>
                </form>
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Naam</th>
                            <th scope="col">Beschrijving</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fcategories as $categorie) { ?>
                            <tr>
                                <td><?php echo $categorie['id'] ?></td>
                                <td><?php echo $categorie['naam'] ?></td>
                                <td><?php echo $categorie['beschrijving'] ?></td>
                                <td><a href="personeeldashboard.php?categorielijst&edit=<?php echo $categorie['id'] ?>" style="color: blue;"><i class="bi bi-pencil"></i></a> <a href="deletecategorie.php?id=<?php echo $categorie['id'] ?>" style="color: red;"><i class="bi bi-x-lg"></i></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php
                }
                    } elseif (isset($_GET['categoriemanagement'])) {

                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            if (trim($_POST['naam']) == '' && trim($_POST['beschrijving']) == '') {
                                echo 'Vul alle velden in';
                            } elseif (trim($_POST['naam']) == '') {
                                echo 'Er is geen naam ingevuld';
                            } elseif (trim($_POST['beschrijving']) == '') {
                                echo 'Er is geen beschrijving ingevuld';

                            } else {

                                $name = $conn->real_escape_string($_POST['naam']);
                                $beschrijving = $conn->real_escape_string($_POST['beschrijving']);

                                $qAddCat= "INSERT INTO categorieen (`name`,  `beschrijving`)
                                VALUES ('" . $name . "', '" . $beschrijving . "')";

                                if ($conn->query($qAddCat) === TRUE) {
                                    echo '<div class="alert alert-success">Het categorie is toegevoegd.</div>';
                                } else {
                                    echo "Error: " . $sql . "<br>" . $conn->error;
                                }
                            }
                        }
            ?>
            <h5>Voer een nieuwe categorie in:</h5>
            <form action="personeeldashboard.php?categoriemanagement" method="POST">
                <label for="name" class="form-label">Naam:</label>
                <input type="text" name="naam" class="form-control" id="name" placeholder="Naam">
                <label for="beschrijving" class="form-label">Beschrijving:</label>
                <input type="text" name="beschrijving" class="form-control" id="beschrijving" placeholder="Beschrijving"><br>
                <button type="submit" class="btn btn-primary mb-3">Invoeren</button>
            </form>
            <?php
                    } elseif (isset($_GET['klantenlijst'])) {
                        if (isset($_GET['edit'])) {
                            $editUserID = $conn->real_escape_string($_GET['edit']);

                            $qGetUser = $conn->query("SELECT * FROM gebruikers WHERE id = '" . $editUserID . "'");
                            $fGetUser = $qGetUser->fetch_assoc();
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (trim($_POST['voornaam']) == '' && trim($_POST['achternaam']) == '' && trim($_POST['email']) == '' && trim($_POST['telefoonnummer']) == '') {
                                    echo 'Vul alle velden in';
                                } elseif (trim($_POST['voornaam']) == '') {
                                    echo 'Er is geen naam ingevuld';
                                } elseif (trim($_POST['achternaam']) == '') {
                                    echo 'Er is geen achternaam ingevuld';
                                } elseif (trim($_POST['email']) == '') {
                                    echo 'Er is geen emailadres ingevuld';
                                } elseif (trim($_POST['telefoonnummer']) == '') {
                                    echo 'er is geen telefoonnummer ingevuld';
                                } else {
                                    $uFname = $conn->real_escape_string($_POST['voornaam']);
                                    $uLname = $conn->real_escape_string($_POST['achternaam']);
                                    $uEmail = $conn->real_escape_string($_POST['email']);
                                    $uPhone = $conn->real_escape_string($_POST['telefoonnummer']);
                                    $urol = $conn->real_escape_string($_POST['rol']);

                                    $qUpdateUser = "UPDATE gebruikers SET `voornaam`='$uFname', `achternaam`='$uLname', `email`= '$uEmail', `telefoonnummer`='$uPhone', `rol`='$urol' WHERE id='$editUserID'";

                                    if ($conn->query($qUpdateUser) === TRUE) {
                                        echo '<div class="alert alert-success">De gegevens van de gebruiker zijn aangepast.</div>';
                                    } else {
                                        echo '<div class="alert alert-danger">Er is een fout opgetreden tijdens het aanpassen van de gegevens. Probeer het later nog eens.</div>';
                                    }
                                }
                            }
            ?>
                <form action="personeeldashboard.php?klantenlijst&edit=<?php echo $_GET['edit']; ?>" method="POST">
                    <label for="name" class="form-label">Voornaam:</label>
                    <input type="text" name="voornaam" class="form-control" id="voornaam" placeholder="Naam" value="<?php echo $fGetUser['voornaam']; ?>">
                    <label for="achternaam" class="form-label">Achternaam:</label>
                    <input type="text" name="achternaam" class="form-control" id="achternaam" placeholder="Achternaam" value="<?php echo $fGetUser['achternaam']; ?>">
                    <label for="email" class="form-label">Emailadres:</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Emailadres" value="<?php echo $fGetUser['email']; ?>">
                    <label for="telefoonnummer" class="form-label">Telefoonnummer:</label>
                    <input type="text" name="telefoonnummer" class="form-control" id="telefoonnummer" placeholder="Telefoonnummer" value="<?php echo $fGetUser['telefoonnummer']; ?>">
                    <?php
                            if ($fUser['rol'] == 'manager') {
                    ?>
                        <label for="rol" class="form-label">Rank:</label>
                        <select class="form-select" name="rol" id="rol">
                            <option value="manager" <?php if ($fGetUser['rol'] == 'manager') {
                                                        echo 'selected';
                                                    } ?>>Manager</option>
                            <option value="medewerker" <?php if ($fGetUser['rol'] == 'medewerker') {
                                                            echo 'selected';
                                                        } ?>>Medewerker</option>
                            <option value="klant" <?php if ($fGetUser['rol'] == 'klant') {
                                                        echo 'selected';
                                                    } ?>>Klant</option>
                        </select>
                    <?php
                            }
                    ?>
                    <br />
                    <button type="submit" class="btn btn-primary mb-3">Opslaan</button>
                </form>
            <?php
                        } else {
            ?>
                <form class="row g-2">
                    <div class="col-auto ms-auto">
                        <label for="search" class="visually-hidden">Zoeken</label>
                        <input type="text" class="form-control form-control-sm" name="zoek" id="zoek" placeholder="Zoeken">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-sm mb-3" name="zoek" value="zoek">Zoeken</button>
                    </div>
                </form>
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Voornaam</th>
                            <th scope="col">Achternaam</th>
                            <th scope="col">Emailadres</th>
                            <th scope="col">Geboortedatum</th>
                            <th scope="col">Telefoonnummer</th>
                            <th scope="col">Rol</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) { ?>
                            <tr>
                                <td><?php echo $user['id'] ?></td>
                                <td><?php echo $user['voornaam'] ?></td>
                                <td><?php echo $user['achternaam'] ?></td>
                                <td><?php echo $user['telefoonnummer'] ?></td>
                                <td><?php echo $user['email'] ?></td>
                                <?php if ($fUser['rol'] == 'manager') { ?>
                                    <td><a href="personeeldashboard.php?klantenlijst&edit=<?php echo $user['id'] ?>" style="color: blue;"><i class="bi bi-pencil"></i></a> <a href="deleteuser.php?id=<?php echo $user['id'] ?>" style="color: red;"><i class="bi bi-x-lg"></i></a></td>
                    </tbody>
                </table>
                <?php
                    } elseif (isset($_GET['personeellijst'])) {
                        if (isset($_GET['edit'])) {
                            $editUserID = $conn->real_escape_string($_GET['edit']);

                            $qGetUser = $conn->query("SELECT * FROM gebruikers WHERE id = '" . $editUserID . "'");
                            $fGetUser = $qGetUser->fetch_assoc();
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (trim($_POST['voornaam']) == '' && trim($_POST['achternaam']) == '' && trim($_POST['email']) == '' && trim($_POST['telefoonnummer']) == '') {
                                    echo 'Vul alle velden in';
                                } elseif (trim($_POST['voornaam']) == '') {
                                    echo 'Er is geen naam ingevuld';
                                } elseif (trim($_POST['achternaam']) == '') {
                                    echo 'Er is geen achternaam ingevuld';
                                } elseif (trim($_POST['email']) == '') {
                                    echo 'Er is geen emailadres ingevuld';
                                } elseif (trim($_POST['telefoonnummer']) == '') {
                                    echo 'er is geen telefoonnummer ingevuld';
                                } else {
                                    $uFname = $conn->real_escape_string($_POST['voornaam']);
                                    $uLname = $conn->real_escape_string($_POST['achternaam']);
                                    $uEmail = $conn->real_escape_string($_POST['email']);
                                    $uPhone = $conn->real_escape_string($_POST['telefoonnummer']);
                                    $urol = $conn->real_escape_string($_POST['rol']);

                                    $qUpdateUser = "UPDATE gebruikers SET `voornaam`='$uFname', `achternaam`='$uLname', `email`= '$uEmail', `telefoonnummer`='$uPhone', `rol`='$urol' WHERE id='$editUserID'";

                                    if ($conn->query($qUpdateUser) === TRUE) {
                                        echo '<div class="alert alert-success">De gegevens van de gebruiker zijn aangepast.</div>';
                                    } else {
                                        echo '<div class="alert alert-danger">Er is een fout opgetreden tijdens het aanpassen van de gegevens. Probeer het later nog eens.</div>';
                                    }
                                }
                            }
                ?>
                <form class="row g-2">
                    <div class="col-auto ms-auto">
                        <label for="search" class="visually-hidden">Zoeken</label>
                        <input type="text" class="form-control form-control-sm" name="zoek" id="zoek" placeholder="Zoeken">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-sm mb-3" name="zoek" value="zoek">Zoeken</button>
                    </div>
                </form>
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Voornaam</th>
                            <th scope="col">Achternaam</th>
                            <th scope="col">Emailadres</th>
                            <th scope="col">Geboortedatum</th>
                            <th scope="col">Telefoonnummer</th>
                            <th scope="col">Rol</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $employee) { ?>
                            <tr>
                                <td><?php echo $employee['id'] ?></td>
                                <td><?php echo $employee['voornaam'] ?></td>
                                <td><?php echo $employee['achternaam'] ?></td>
                                <td><?php echo $employee['telefoonnummer'] ?></td>
                                <td><?php echo $employee['email'] ?></td>
                                <?php if ($fUser['rol'] == 'manager') { ?>
                                    <td><a href="personeeldashboard.php?klantenlijst&edit=<?php echo $employee['id'] ?>" style="color: blue;"><i class="bi bi-pencil"></i></a> <a href="deleteuser.php?id=<?php echo $employee['id'] ?>" style="color: red;"><i class="bi bi-x-lg"></i></a></td>
                    </tbody>
                </table>
                <?php 

                                }}}}}}}

                ?>
                </p>
            </div>
        </div>
    </div>
</div>
<?php

    require 'includes/footer.php';

?>