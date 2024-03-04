<?php

$title = "Backoffice";
require_once "../inc/header.inc.php";
?>

<main>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-2">

            <div class="d-flex flex-column text-bg-dark p-3 sidebarre">

                <ul class="nav nav-pills flex-column mb-auto">
                    <li>
                        <a href="?dashboard_php" class="nav-link text-light">Backoffice</a>
                    </li>
                    <li>
                        <a href="" class="nav-link text-light">Films</a>
                    </li>
                    <li>
                        <a href="?categories_php" class="nav-link text-light">Catégories</a>
                    </li>
                    <li>
                        <a href="?users_php" class="nav-link text-light">Utilisateurs</a>
                    </li>

                </ul>
            </div>
        </div>

        <?php
        if (isset($_GET['dashboard_php'])) :
        ?>

            <div class="w-50 m-auto">
                <h2><?= (isset($_SESSION['user'])) ? "Bonjour chèrs " . $_SESSION['user']['firstName'] : "Please Login" ?></h2>
                <p>Bienvenue sur le backoffice</p>
                <img src="<?= RACINE_SITE ?>assets/img/affiche.jpg" alt="Affiche des films sur le backoffice" width="500" height="800">
            </div>

        <?php

        endif;

        ?>
        <div class="col-sm-12">

            <?php
            /*_GET represente les données qui transitent par l'URL. Il s'agit d'une superglobal, et comme toutes les superglobales,
            c'est un tableau (array)
            *"superglobal" signifie que cette variable est disponible partout dans le script, y compris au sein des fonctions
            (pas besoin de faire global $GET)
            *Les informations transiteent dans l'URL selon la systaxe suivante :
            *
            * exp : page.php?indice1=valeur1&indice2=valeur2&indiceN=valeurN*
            *Quand on receptionne les données, $_GET est remplit selon le schéma suivant:

            $_GET = array(

            'indice1' => 'valeur1'
            'indice2' => 'valeur2'
            'indiceN' => 'valeurN'
            )
            */


            if (!empty($_GET)) {


                if (isset($_GET['films.php'])) {
                    require_once "films.php";
                } else if (isset($_GET['categories_php'])) {
                    require_once "categories.php";
                } else if (isset($_GET['users_php'])) {
                    require_once "users.php";
                } else {
                    require_once "dashboard.php";
                }
            }
            ?>
        </div>

    </div>
</main>


<?php
require_once "../inc/footer.inc.php";



?>