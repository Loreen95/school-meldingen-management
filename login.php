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
              <h2 class="text-uppercase text-center mb-5">Inloggen</h2>
              <?php
              if (isset($_SESSION['id'])) {
                header('Location: index.php');
              } else {

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                  //Controleer of er geen lege velden zijn
                  if (trim($_POST['email']) == "" && trim($_POST['wachtwoord']) == "") {
                    echo '<div class="alert alert-danger" role="alert">Geen e-mail en wachtwoord ingevuld.</div>';
                  } elseif (trim($_POST['email']) == "") {
                    echo '<div class="alert alert-danger" role="alert">Geen e-mail ingevuld.</div>';
                  } elseif (trim($_POST['wachtwoord']) == "") {
                    echo '<div class="alert alert-danger" role="alert">Geen wachtwoord ingevuld.</div>';
                  } else {
                    $sEmail = $conn->real_escape_string($_POST['email']);

                    //Haal de gebruiker op uit de database
                    $qUser = $conn->query("SELECT * FROM gebruikers WHERE email = '" . $sEmail . "'");
                    $fUser = $qUser->fetch_assoc();

                    //Controleer of de gebruiker bestaat
                    if ($qUser->num_rows == 0) {
                      echo '<div class="alert alert-danger" role="alert">Deze gebruiker bestaat niet.</div>';
                    } else {
                      //Controleer of het wachtwoord klopt door het ingevulde wachtwoord te vergelijken met het wachtwoord in de database
                      if (password_verify($_POST['wachtwoord'], $fUser['wachtwoord'])) {
                        //Wachtwoord klopt
                        $_SESSION["id"] = $fUser['id'];
                        header('Location: index.php');
                      } else {
                        //Wachtwoord klopt niet
                        echo '<div class="alert alert-danger" role="alert">Deze gebruiker bestaat niet.</div>';
                      }
                    }
                  }
                }
              }
              ?>
              <form class="mx-1 mx-md-4" method="post">

                <div class="d-flex flex-row align-items-center mb-4">
                  <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                  <div class="form-outline flex-fill mb-0">
                    <input type="email" id="form3Example3c" class="form-control" placeholder="Emailadres" name="email" />
                  </div>
                </div>

                <div class="d-flex flex-row align-items-center mb-4">
                  <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                  <div class="form-outline flex-fill mb-0">
                    <input type="password" id="form3Example4c" class="form-control" placeholder="Wachtwoord" name="wachtwoord" />
                  </div>
                </div>

                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                  <label class="form-check-label" for="flexCheckDefault">
                    Remember me
                  </label>
                </div>
            </div>

            <p class="mb-0" id="registertxt">Heb je nog geen account? <a href="register.php" class="text-body fw-bold">Registreer</a></p>

            <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
              <button name="submit" class="btn btn-primary btn-lg">Inloggen</button>
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