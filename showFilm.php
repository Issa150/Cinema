<?php

require_once "inc/functions.inc.php";

/*
if (!empty($_GET)) {

    $idFilm = htmlentities($_GET['id_film']);

    $film = showFilm($idFilm);

    if ($_GET['id_film'] != $film['id_film']) {

        header("location:" . RACINE_SITE . "index.php");
    } else {

        $actors = stringToArray($film['actors']);
        $date_time = new DateTime($film['duration']);
        $duration = $date_time->format('H:i');
    }
}
*/


if (isset($_GET['id_film'])) {


    $id_film = $_GET['id_film'];
    $film = showFilm($id_film);

    if ($_GET['id_film'] != $film['id_film']) {
        header('Location: ' . RACINE_SITE);
    }

    $duration = $film['duration'];
}


$title = "shoFilm";
require_once "inc/header.inc.php";


?>

<main class="mt-5">
    <div class="film bg-dark">

        <div class="back">
            <a href="<?= RACINE_SITE ?>"><i class="bi bi-arrow-left-circle-fill"></i></a>
        </div>
        <div class="cardDetails row mt-5">
            <h2 class="text-center mb-5"></h2>
            <div class="col-12 col-xl-5 row p-5">
                <img class="card-img" src="<?= $film['image'] ? RACINE_SITE . "assets/img/" . $film['image'] : RACINE_SITE . "assets/img/video-placeholder.png" ?>" alt="">

                <form action="boutique/panier.php" method="POST" enctype="multipart/form-data" class="w-50 m-auto row justify-content-center p-5">

                    <input type="hidden" name="id_film" value="<?= $film['id_film'] ?>">
                    <input type="hidden" name="title" value="<?= $film['title'] ?>">
                    <input type="hidden" name="price" value="<?= $film['price'] ?>">
                    <input type="hidden" name="stock" value="<?= $film['stock'] ?>">
                    <input type="hidden" name="image" value="<?= $film['image'] ?>">
                    <select name="quantity" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                            <?php for ($i = 1; $i <= $film['stock']; $i++) { ?>

                                <option value="<?= $i ?>"><?= $i ?></option>

                            <?php } ?>


                    </select>

                    <input class="btn btn-outline-danger mt-3 w-100" type="submit" value="Ajouter au panier" name="ajout_panier" id="addCart">

                </form>

            </div>
            
                
            
            <div class="detailsContent  col-md-7 p-5">
                <div class="container mt-5">
                    <div class="row">
                        <h3 class="col-4"><span>Realisateur :</span></h3>
                        <ul class="col-8">
                            <li><?= isset($film) ? $film['directors'] : "" ?></li>

                        </ul>
                        <hr>
                    </div>
                    <div class="row">
                        <h3 class="col-4"><span>Acteur :</span></h3>
                        <ul class="col-8">


                            <?php
                            $actors = actorsArray($film['actors']);
                            foreach ($actors as $actor) {

                            ?>
                                <li><?= $actor; ?></li>
                            <?php } ?>


                        </ul>
                        <hr>
                    </div>
                    <div class="row">
                        <h3 class="col-4"><span>Àge limite :</span></h3>
                        <ul class="col-8">
                            <li><?= isset($film) ? $film['ageLimit'] : "" ?></li>


                        </ul>
                        <hr>
                    </div>
                    <div class="row">
                        <h3 class="col-4"><span>Genre : </span></h3>
                        <ul class="col-8">
                            <li><?= isset($film) ? $film['genre'] : "" ?></li>

                        </ul>
                        <hr>
                    </div>
                    <div class="row">
                        <h3 class="col-4"><span>Durée : </span></h3>
                        <ul class="col-8">
                            <li><?= isset($film) ? $film['duration'] : "" ?></li>


                        </ul>
                        <hr>
                    </div>
                    <div class="row">
                        <h3 class="col-4"><span>Date de sortie:</span></h3>
                        <ul class="col-8">
                            <li><?= isset($film) ? $film['date'] : "" ?></li>

                        </ul>
                        <hr>
                    </div>
                    <div class="row">
                        <h3 class="col-4"><span>Prix : </span></h3>
                        <ul class="col-8">
                            <li><?= isset($film) ? $film['price'] : "" ?></li>

                        </ul>
                        <hr>
                    </div>
                    <div class="row">
                        <h3 class="col-4"><span>Stock :</span> </h3>
                        <ul class="col-8">
                            <li><?= isset($film) ? $film['stock'] : "" ?></li>

                        </ul>
                        <hr>
                    </div>
                    <div class="row">
                        <h3 class="col-4"><span>Synopsis :</span></h5>
                            <ul class="col-8">
                                <?= isset($film) ? $film['synopsis'] : "" ?>

                            </ul>
                    </div>
                </div>
            </div>
        </div>


    </div>
</main>



<?php
require_once "inc/footer.inc.php";


?>