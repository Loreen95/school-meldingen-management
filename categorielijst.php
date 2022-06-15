<?php

require 'includes/header.php';
require 'database/database.php';
require 'includes/navigation.php';

$result = $conn->query("SELECT * FROM categorieen");
$categories = $result->fetch_all(MYSQLI_ASSOC);

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
                    <th scope="col">Naam</th>
                    <th scope="col">Beschrijving</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $cat) { ?>
                    <tr>
                        <td><?php echo $cat['id'] ?></td>
                        <td><?php echo $cat['naam'] ?></td>
                        <td><?php echo $cat['beschrijving'] ?></td>
                        <td><a href="&edit=<?php echo $cat['id'] ?>" style="color: blue;"><i class="bi bi-pencil"></i></a> <a href="deletecategorie.php?id=<?php echo $cat['id'] ?>" style="color: red;"><i class="bi bi-x-lg"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        </p>
    </div>
</div>


<?php

require 'includes/footer.php';

?>