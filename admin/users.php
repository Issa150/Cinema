<?php 
$title = "user";
// include_once "../inc/header.inc.php";
include_once "../inc/functions.inc.php";
?>


<div class="mt-5 d-flex flex-column m-auto table-responsive">
    <h2>Listes des utilisateurs</h2>

    <table class="table table-dark table-bordered mt-5">
        <thead>
            <tr>
                <th>ID</th>
                <th>FirstName</th>
                <th>LasteNema</th>
                <th>Pseudo</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Civility</th>
                <th>Birthday</th>
                <th>Adress</th>
                <th>ZipCode</th>
                <th>City</th>
                <th>Country</th>
                <th>Role</th>
                <th>Supprimer</th>
                <th>Modifier</th>
            </tr>
        </thead>
        <tbody>

        <?php 
            $users = allUsers();

            foreach($users as $user){
        ?>

        <tr>
            <td><?= $user['id_user'] ?></td>
            <td><?= ucfirst($user['firstName']) ?></td>
            <td><?= strtoupper($user['lastName']) ?></td>
            <td><?= $user['pseudo'] ?></td>
            <td><?= $user['email'] ?></td>
            <td><?= $user['phone'] ?></td>
            <td><?= $user['civility'] ?></td>
            <td><?= $user['birthday'] ?></td>
            <td><?= $user['address'] ?></td>
            <td><?= $user['zipCode'] ?></td>
            <td><?= $user['city'] ?></td>
            <td><?= $user['country'] ?></td>
            <td><?= $user['role'] ?></td>
            <td><?php ?></td>
            <td><?php ?></td>
        </tr>

        <?php } ?>
        </tbody>

    </table>
</div>