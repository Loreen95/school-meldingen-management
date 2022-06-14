<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <!-- Container wrapper -->
  <div class="container">
    <!-- Navbar brand -->
    <a class="navbar-brand me-2" href="index.php">
      <img src="includes/images/logo3.jpg" height="16" alt="MDB Logo" loading="lazy" style="margin-top: -1px;" />
    </a>

    <!-- Toggle button -->
    <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarButtonsExample" aria-controls="navbarButtonsExample" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php
        if (!isset($_SESSION['id'])) {
        ?>
          <li class="nav-item">

            <a class="nav-link login_link" href="login.php">Login</a>
          </li>
        <?php
        } else {
        ?>

          <li class="nav-item dropdown login_link">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?php
              $uID = $conn->real_escape_string($_SESSION['id']);

              $qUser = $conn->query("SELECT * FROM gebruikers where id = '" . $uID . "'");
              $fUser = $qUser->fetch_assoc();

              echo $fUser['voornaam'];
              ?>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="dashboard.php">Instellingen</a></li>
              <li><a class="dropdown-item" href="meldingen.php">Melding maken</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <?php
              if ($fUser['rol'] == 'medewerker') {
              ?>
                <li><a class="dropdown-item" href="meldingenlijst.php">Meldingen</a></li>
                <li><a class="dropdown-item" href="klantenlijst.php">Klantenlijst</a></li>
                <li><a class="dropdown-item" href="categorielijst.php">Categorielijst</a></li>
                <li><a class="dropdown-item" href="personeelslijst.php">Personeelslijst</a></li>
                <li><a class="dropdown-item" href="categoriemanagement.php">Categorie Management</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
              <?php
              }
              ?>
              <li><a class="dropdown-item" href="logout.php">Uitloggen</a></li>
            </ul>
          </li>
        <?php
        }
        ?>
      </ul>
    </div>
  </div>
  <!-- Collapsible wrapper -->
  </div>
  <!-- Container wrapper -->
</nav>
<!-- Navbar -->