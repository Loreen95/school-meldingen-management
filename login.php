<?php

require 'includes/header.php';
require 'includes/navigation.php';
require 'database/database.php';

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

                  <div class="form-outline form-white mb-4">
                    <input type="email" id="typeEmail" class="form-control form-control-lg" />
                    <label class="form-label" for="typeEmail">Email</label>
                  </div>

                  <div class="form-outline form-white mb-4">
                    <input type="password" id="typePassword" class="form-control form-control-lg" />
                    <label class="form-label" for="typePassword">Password</label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                    <label class="form-check-label" for="flexCheckDefault">
                      Remember me
                    </label>
                  </div>
                </div>

                <button class="btn btn-primary btn-lg btn-rounded gradient-custom text-body px-5" type="submit">Inloggen</button>

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