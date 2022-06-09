<?php

require 'includes/header.php';
require 'includes/navigation.php';
require 'database/database.php';


if (isset($_SESSION['id'])) {
    header('Location: index.php');
} else {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Controleer of er geen lege velden zijn
        if (trim($_POST['email']) == "" && trim($_POST['password']) == "") {
            echo '<div class="alert">Vul alle velden in</div>';
        } elseif (trim($_POST['email']) == "") {
            echo '<div class="alert">Vul je e-mail adres in</div>';
        } elseif (trim($_POST['wachtwoord']) == "") {
            echo '<div class="alert">Vul je wachtwoord in</div>';
        } else {
            $sEmail = $conn->real_escape_string($_POST['email']);

            //Haal de gebruiker op uit de database
            $qUser = $conn->query("SELECT * FROM gebruikers WHERE email = '" . $sEmail . "'");
            $fUser = $qUser->fetch_assoc();

            //Controleer of de gebruiker bestaat
            if ($qUser->num_rows == 0) {
                    echo'<div class="alert">Deze gebruiker bestaat niet.</div>';
            } else {
                //Controleer of het wachtwoord klopt
                if (password_verify($_POST['wachtwoord'], $fUser['wachtwoord'])) {
                    //Wachtwoord klopt
                    $_SESSION["id"] = $fUser['id'];
                    header('Location: index.php');
                } else {
                    //Wachtwoord klopt niet
                    echo'<div class="alert">Deze gebruiker bestaat niet.</div>';
                }
            }
        }
    }
  }
?>

<section class="vh-100" style="background-color: #eee;">
  <div class="mask d-flex align-items-center h-100" style="background-color: #D6D6D6;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card text-black" style="border-radius: 25px;">
            <div class="card-body p-md-5">
              <div class="card-body p-5 text-center">

                <div class="my-md-5 pb-5">

                  <h1 class="fw-bold mb-0">Welcome</h1>

                  <i class="fas fa-user-astronaut fa-3x my-5"></i>
                  <form class="mx-1 mx-md-4" method="post">

                  <div class="form-outline form-white mb-4">
                    <input type="email" id="typeEmail" class="form-control form-control-lg" name="email"/>
                    <label class="form-label" for="typeEmail">Email</label>
                  </div>

                  <div class="form-outline form-white mb-4">
                    <input type="password" id="typePassword" class="form-control form-control-lg" name="wachtwoord"/>
                    <label class="form-label" for="typePassword">Password</label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                    <label class="form-check-label" for="flexCheckDefault">
                      Remember me
                    </label>
                  </div>
                </div>

                <button name="submit" class="btn btn-primary btn-lg btn-rounded gradient-custom text-body px-5" type="submit">Inloggen</button>

              </div>

              <div>
                <p class="mb-0">Heb je nog geen account? <a href="register.php" class="text-body fw-bold">Registreer</a></p>
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