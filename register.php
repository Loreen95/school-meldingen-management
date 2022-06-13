<?php

require 'includes/header.php';
require 'database/database.php';
require 'includes/navigation.php';


?>
<section class="vh-100">
    <div class="mask d-flex align-items-center h-100 gradient-custom-3">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-7">
                    <div class="card" style="border-radius: 15px;">
                        <div class="card-body p-5">
                            <h2 class="text-uppercase text-center mb-5">Create an account</h2>
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                                if (isset($_POST['submit'])) {
                                    if (isset($_POST['terms'])) {
                                        if (trim($_POST['voornaam']) == "" && trim($_POST['achternaam']) == "" && trim($_POST['email']) == "" && trim($_POST['telefoon']) == "" && trim($_POST['dob']) == "" && trim($_POST['wachtwoord']) == "" && trim($_POST['password2']) == "") {
                                            echo '<div class="alert alert-danger" role="alert">Vul alle velden in</div>';
                                        } elseif (trim($_POST['voornaam']) == "") {
                                            echo '<div class="alert alert-danger" role="alert">Vul je voornaam in</div>';
                                        } elseif (trim($_POST['achternaam']) == "") {
                                            echo '<div class="alert alert-danger" role="alert">Vul je achternaam in</div>';
                                        } elseif (trim($_POST['email']) == "") {
                                            echo '<div class="alert alert-danger" role="alert">Vul je e-mail adres in</div>';
                                        } elseif (trim($_POST['wachtwoord']) == "") {
                                            echo '<div class="alert alert-danger" role="alert">Vul je wachtwoord in</div>';
                                        } elseif (trim($_POST['password2']) == "") {
                                            echo '<div class="alert alert-danger" role="alert">Vul je wachtwoord nog een keer in</div>';
                                        } elseif ($_POST['wachtwoord'] != $_POST['password2']) {
                                            echo '<div class="alert alert-danger" role="alert">De wachtwoorden zijn niet gelijk!</div>';
                                        } elseif (trim($_POST['dob']) == "") {
                                            echo '<div class="alert alert-danger" role="alert">Vul je geboortedatum nummer in</div>';
                                        } elseif (trim($_POST['telefoon']) == "") {
                                            echo '<div class="alert alert-danger" role="alert">Vul je telefoon nummer in</div>';
                                        } else {
                                            $infoEmail = $conn->real_escape_string($_POST['email']);

                                            $infoUser = $conn->query("SELECT * FROM gebruikers WHERE email = '" . $infoEmail . "'");

                                            if ($infoUser->num_rows) {
                                                echo '<div class="alert alert-danger" role="alert">Deze gebruiker bestaat al</div>';
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
                                                    echo '<div class="alert alert-success" role="alert">Je account is aangemaakt, je kan nu <a href="login.php">inloggen</a>.</div>';
                                                } else {
                                                    echo '<div class="alert alert-danger" role="alert">Er is een probleem opgetreden tijdens het aanmaken van je account.</div>';
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            ?>
                            <form method="post">
                                <div class="d-flex flex-row align-items-center mb-4">
                                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                    <div class="form-outline flex-fill mb-0">
                                        <input type="text" id="form3Example1c" class="form-control" placeholder="Voornaam" name="voornaam" />
                                    </div>
                                </div>

                                <div class="d-flex flex-row align-items-center mb-4">
                                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                    <div class="form-outline flex-fill mb-0">
                                        <input type="text" id="form3Example1c" class="form-control" placeholder="Achternaam" name="achternaam" />
                                    </div>
                                </div>

                                <div class="d-flex flex-row align-items-center mb-4">
                                    <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                    <div class="form-outline flex-fill mb-0">
                                        <input type="email" id="form3Example3c" class="form-control" placeholder="Emailadres" name="email" />
                                    </div>
                                </div>

                                <div class="d-flex flex-row align-items-center mb-4">
                                    <i class="fa-solid fa-phone fa-lg me-3 fa-fw"></i>
                                    <div class="form-outline flex-fill mb-0">
                                        <input type="text" id="form3Example4c" class="form-control" placeholder="Telefoonnummr" name="telefoon" />
                                    </div>
                                </div>


                                <div class="d-flex flex-row align-items-center mb-4">
                                    <i class="fas fa-cake-candles fa-lg me-3 fa-fw"></i>
                                    <div class="form-outline flex-fill mb-0">
                                        <input type="date" id="form3Example4c" class="form-control" name="dob" />
                                    </div>
                                </div>

                                <div class="d-flex flex-row align-items-center mb-4">
                                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                    <div class="form-outline flex-fill mb-0">
                                        <input type="password" id="form3Example4c" class="form-control" placeholder="Wachtwoord" name="wachtwoord" />
                                    </div>
                                </div>

                                <div class="d-flex flex-row align-items-center mb-4">
                                    <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                    <div class="form-outline flex-fill mb-0">
                                        <input type="password" id="form3Example4cd" class="form-control" placeholder="Herhaal wachtwoord" name="password2" />
                                    </div>
                                </div>

                                <div class="form-check d-flex justify-content-center mb-5">
                                    <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3c" name="terms" />
                                    <label class="form-check-label" for="form2Example3">
                                        Ik ga akkoord met de <a href="#!">Algemene voorwaarden</a>
                                    </label>
                                </div>

                                <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                    <button name="submit" class="btn btn-primary btn-lg">Registreer</button>
                                </div>
                            </form>
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