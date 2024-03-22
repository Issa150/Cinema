<?php 
$title = "user";
// include_once "../inc/header.inc.php";
include_once "../inc/functions.inc.php";

if(!isset($_SESSION['user'])){
    
    header("location: ".RACINE_SITE."authentification.php");

}else{
    if($_SESSION['user']['role'] == 'ROLE_USER'){
        header('Location:' . RACINE_SITE.'index.php');
        exit();
    }
}

// ///////////////////////////////////:


// if (isset($_GET['action']) && $_GET['action'] == 'delete') {
//     $pdo = connexionBdd();
//     $id_category = $_GET['id_user'];
//     // Delete the user with the specified id_category
//     $sql = "DELETE FROM users WHERE id_user = :id";
//     $stmt = $pdo->prepare($sql);
//     // $stmt->bind_param("i", $id_category);
//     $stmt->execute(array(
//         ":id" => $id_category
//     ));
//     // Redirect the user back to the user list
//     // header("Location: users_php");
//     // exit();
// }

///////////////////////////////////// Fonction pour modifier le rôle//////////////////////////////





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

            <td><?php ?><a href="?users_php&action=delete&id_user=<?=$user['id_user']?>$user">
                <i class="bi bi-trash3-fill text-danger"></i>
            </a></td>

            <td><?php ?><a class="btn btn-danger fs-4" href="?users_php&action=update&id_user=<?=$user['id_user']?>">
            <?= $user['role'] ?></a>
            </td>
        </tr>

        <?php } ?>
        </tbody>

    </table>
</div>