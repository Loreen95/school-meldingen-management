<?php

require 'includes/header.php';
require 'includes/navigation.php';
require 'database/database.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit'])) {
        if (isset($_POST['terms'])) {
            if (trim($_POST['voornaam']) == "" && trim($_POST['achternaam']) == "" && trim($_POST['email']) == "" && trim($_POST['telefoon']) == "" && trim($_POST['dob']) == "" && trim($_POST['wachtwoord']) == "" && trim($_POST['password2']) == "") {
                echo '<div class="alert">Vul alle velden in</div>';
            } elseif (trim($_POST['voornaam']) == "") {
                echo '<div class="alert">Vul je voornaam in</div>';
            } elseif (trim($_POST['achternaam']) == "") {
                echo '<div class="alert">Vul je achternaam in</div>';
            } elseif (trim($_POST['email']) == "") {
                echo '<div class="alert">Vul je e-mail adres in</div>';
            } elseif (trim($_POST['wachtwoord']) == "") {
                echo '<div class="alert">Vul je wachtwoord in</div>';
            } elseif (trim($_POST['password2']) == "") {
                echo '<div class="alert">Vul je wachtwoord nog een keer in</div>';
            } elseif ($_POST['wachtwoord'] != $_POST['password2']) {
                echo '<div class="alert">De wachtwoorden zijn niet gelijk!</div>';
            } elseif (trim($_POST['dob']) == "") {
                echo '<div class="alert">Vul je geboortedatum nummer in</div>';
            } elseif (trim($_POST['telefoon']) == "") {
                echo '<div class="alert">Vul je telefoon nummer in</div>';
            } else {
                $infoEmail = $conn->real_escape_string($_POST['email']);

                $infoUser = $conn->query("SELECT * FROM gebruikers WHERE email = '" . $infoEmail . "'");

                if ($infoUser->num_rows) {
                    echo '<div class="alert">Deze gebruiker bestaat al</div>';
                } else {
                    $voornaam = $conn->real_escape_string($_POST['voornaam']);
                    $achternaam = $conn->real_escape_string($_POST['achternaam']);
                    $telefoon = $conn->real_escape_string($_POST['telefoon']);
                    $email = $conn->real_escape_string($_POST['email']);
                    $dob = $conn->real_escape_string($_POST['dob']);
                    $password = $conn->real_escape_string(password_hash($_POST['wachtwoord'], PASSWORD_BCRYPT)); //We hashen hier het wachtwoord zodat het niet te zien is in de database

                    //Maak de gebruiker aan
                    $sql = "INSERT INTO gebruikers (`voornaam`, `achternaam`, `email`, `wachtwoord`, `geboortedatum`, `telefoonnummer`, `rol`)
            VALUES ('" . $voornaam . "', '" . $achternaam . "', '" . $email . "', '" . $password . "', '" . $dob . "',  '" . $telefoon . "', 'gebruiker')";

                    if ($conn->query($sql) === TRUE) {
                        echo '<div class="alertsuccess">Je account is aangemaakt, je kan nu <a href="login.php">inloggen</a>.</div>';
                    } else {
                        echo '<div class="alert">Er is een probleem opgetreden tijdens het aanmaken van je account.</div>';
                    }
                }
            }
        }
    }
}

?>
<section class="vh-90" style="background-color: #eee;">
    <div class="container h-90">
        <div class="row d-flex justify-content-center align-items-center h-90">
            <div class="col-lg-8 col-xl-9">
                <div class="card text-black" style="border-radius: 25px;">
                    <div class="card-body p-md-6">
                        <div class="row justify-content-center">
                            <div class="col-md-8 col-lg-8 col-xl-4 order-2 order-lg-1">

                                <p class="text-center h1 fw-bold mb-5 mx-4 mx-md-6 mt-4">Registreren</p>

                                <form class="mx-1 mx-md-4" method="post">

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="text" id="form3Example1c" class="form-control" name="voornaam" />
                                            <label class="form-label" for="form3Example1c">Voornaam</label>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="text" id="form3Example1c" class="form-control" name="achternaam" />
                                            <label class="form-label" for="form3Example1c">Achternaam</label>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="email" id="form3Example3c" class="form-control" name="email" />
                                            <label class="form-label" for="form3Example3c">Emailadres</label>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-cake-candles fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="date" id="form3Example4c" class="form-control" name="dob" />
                                            <label class="form-label" for="form3Example4c">Geboortedatum</label>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fa-solid fa-phone fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="text" id="form3Example4c" class="form-control" name="telefoon" />
                                            <label class="form-label" for="form3Example4c">Telefoonnummer</label>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="password" id="form3Example4c" class="form-control" name="wachtwoord" />
                                            <label class="form-label" for="form3Example4c">Wachtwoord</label>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                        <div class="form-outline flex-fill mb-0">
                                            <input type="password" id="form3Example4cd" class="form-control" name="password2" />
                                            <label class="form-label" for="form3Example4cd">Herhaal wachtwoord</label>
                                        </div>
                                    </div>

                                    <div class="form-check d-flex justify-content-center mb-5">
                                        <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3c" name="terms" />
                                        <label class="form-check-label" for="form2Example3">
                                            Ik ga akkoord met de <a href="#!">Algemene voorwaarden</a>
                                        </label>
                                    </div>

                                    <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                        <button name="submit" class="btn btn-primary btn-lg">Register</button>
                                    </div>

                                </form>
                            </div>
                            <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                <img src="includes/images/teachers1.jpeg" class="img-fluid" alt="Sample image">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php

require 'includes/footer.php';

?>