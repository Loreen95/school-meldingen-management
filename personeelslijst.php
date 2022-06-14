<?php

require 'includes/header.php';
require 'database/database.php';
require 'includes/navigation.php';

$result = $conn->query("SELECT * FROM gebruikers WHERE rol = 'medewerker'");
$users = $result->fetch_all(MYSQLI_ASSOC);
foreach ($users as $user) {


?>

    <div class="col-9">
        <div class="card-header">
        </div>
        <div class="card-body">
            <p class="card-text">
            <table class=table>
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Voornaam</th>
                        <th scope="col">Achternaam</th>
                        <th scope="col">Geboortedatum</th>
                        <th scope="col">Emailadres</th>
                        <th scope="col">Telefoonnummer</th>
                        <th scope="col">Rol</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $user['id'] ?></td>
                        <td><?php echo $user['voornaam'] ?></td>
                        <td><?php echo $user['achternaam'] ?></td>
                        <td><?php echo $user['geboortedatum'] ?></td>
                        <td><?php echo $user['email'] ?></td>
                        <td><?php echo $user['telefoonnummer'] ?></td>
                        <td><?php echo $user['rol'] ?></td>
                        <td><a href="&edit=<?php echo $user['id'] ?>" style="color: blue;"><i class="bi bi-pencil"></i></a> <a href="deleteproduct.php?id=<?php echo $user['id'] ?>" style="color: red;"><i class="bi bi-x-lg"></i></a></td>
                    </tr>
                </tbody>
            </table>
        <?php } ?>
        </p>
        </div>
    </div>


    <?php

    require 'includes/footer.php';

    ?>