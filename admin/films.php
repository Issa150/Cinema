<?php
$title = "Films";
include_once "../inc/functions.inc.php";


if (!isset($_SESSION['user'])) {

    header("location: " . RACINE_SITE . "authentification.php");
} else {
    if ($_SESSION['user']['role'] == 'ROLE_USER') {
        header('Location:' . RACINE_SITE . 'index.php');
    }
}


$allfilm = allFilms();

//****  Delete  *****************
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $pdo = connexionBdd();
    $id_film = $_GET['id_film'];
    // Delete the user with the specified id_film
    $sql = "DELETE FROM films WHERE id_film = :id";
    $stmt = $pdo->prepare($sql);
    // $stmt->bind_param("i", $id_film);
    $stmt->execute(array(
        ":id" => $id_film
    ));
    // Redirect the user back to the user list
    header("Location: " . RACINE_SITE . "dashboard.php?films_php");
    exit();
}
// ******************************************************





include_once "../inc/header.inc.php";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<main>

    <div class="d-flex flex-column m-auto mt-5">

        <h2 class="text-center fw-bolder mb-5 text-danger">Liste des films</h2>
        <a href="gestionFilms.php" class="btn btn-primary p-3 fs-3 align-self-end "> Ajouter un film</a>
        <table class="table table-dark table-bordered mt-5 ">
            <thea>
                <tr>
                    <!-- th*7 -->
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Affiche</th>
                    <th>Réalisateur</th>
                    <th>Acteurs</th>
                    <th>Àge limite</th>
                    <th>Genre</th>
                    <th>Durée</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Synopsis</th>
                    <th>Date de sortie</th>
                    <th>Supprimer</th>
                    <th> Modifier</th>
                </tr>
            </thea>
            <tbody>

                <?php
                foreach ($allfilm as $film) {
                    $actors = actorsArray($film['actors']);
                ?>
                    <tr>

                        <!-- Je récupére les valeus de mon tabelau $film dans des td -->
                        <td><?= $film['id_film'] ?></td>
                        <td><?= $film['title'] ?></td>

                        <td class="film-img">
                            <!-- <img src="<? //= RACINE_SITE . "assets/img/".$film['image']
                                            ?>" alt="affiche du film" class="img-fluid"> -->
                            <img class="img-fluid" src="<?= $film['image'] ? RACINE_SITE . "assets/img/" . $film['image'] : RACINE_SITE . "assets/img/video-placeholder.png" ?>" alt="">
                        </td>

                        <td><?= $film['directors'] ?></td>
                        <td>
                            <ul>
                                <?php
                                foreach ($actors as $actor) {
                                ?>
                                    <li><?= $actor; ?></li>
                                <?php

                                }


                                ?>
                            </ul>
                        </td>
                        <td><?= $film['ageLimit'] ?></td>
                        <!-- <td><? //= $film['genre'] 
                                    ?></td> -->
                        <?php
                        // if(!$film['genre']){
                        //     echo "<td>$film[category_id]</td>";
                        // }else{
                        //     echo "<td>$film[genre]</td>";
                        // }
                        // echo $film['genre'] ?? $film['category_id'];
                        echo $film['genre'] ? "<td>$film[genre]</td>" : "<td>-- ! --</td>";
                        // echo $film['category_id'] ?? "<td>$film[category_id]</td>";
                        ?>
                        <td><?= $film['duration'] ?></td>
                        <td><?= $film['price'] ?>€</td>
                        <td><?= $film['stock'] ?></td>
                        <td><?= substr($film['synopsis'], 0, 130) ?>...</td>
                        <!-- <td><? //= $film['date'] 
                                    ?></td> -->
                        <td><?= date('Y', strtotime($film['date'])) ?></td>


                        <td class="text-center">
                            <a href="films.php?action=delete&id_film=<?= $film['id_film'] ?>">
                                <i class="bi bi-trash3-fill text-danger"></i>
                            </a></td>
                        <td class="text-center">
                            <a href="gestionFilms.php?action=update&id_film=<?= $film['id_film'] ?>">
                                <i class="bi bi-pen-fill text-info"></i>
                            </a>
                        </td>

                    </tr>
                <?php } ?>


            </tbody>


        </table>


    </div>

</main>


<?php include_once "../inc/footer.inc.php"; ?>