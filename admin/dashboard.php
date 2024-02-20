<?php
$title = "Bacoffice";

include_once "../inc/header.inc.php";
// include_once "../inc/functions.inc.php";

if (empty($_SESSION['user'])) {
    header("Location: " . RACINE_SITE . "authentification.php");
} else {
    if ($_SESSION['user']['role'] == 'ROLE_USER') {
        header("Location:" . RACINE_SITE . "profile.php");
    }
}

/*  
    if (empty($_SESSION['user'])) {
        header("Location: " . RACINE_SITE . "authentification.php");

    } else if ($_SESSION['user']['role'] == 'ROLE_USER') {
        header("Location:" . RACINE_SITE . "index.php");

    } else if ($_SESSION['user']['role'] == 'ROLE_ADMIN') {
        // header("Location:" . RACINE_SITE . "admin/dashboard.php");
    }

*/

// include_once "../inc/header.inc.php";
// var_dump($_SESSION['user']);
?>

<main>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-2">
            <div class="d-flex flex-column text-bg-dark sidebarre">
                <ul class="nav nav-pills flex-column mb-auto">
                    <li>
                        <a href="?dashboard_php" class="nav-link text-light">Backoffice</a>
                    </li>

                    <li>
                        <a href="" class="nav-link text-light">Films</a>
                    </li>

                    <li>
                        <a href="" class="nav-link text-light">Catégories</a>
                    </li>

                    <li>
                        <a href="" class="nav-link text-light">Utilisateur</a>
                    </li>

                </ul>
            </div>
        </div>

        <?php
        if (isset($_GET['dashboard_php'])) : ?>


            <div class="w-50 m-auto">
                <h2><?= (isset($_SESSION['user'])) ? "Bonjour chèrs " . $_SESSION['user']['firstName'] : "Please Login" ?></h2>
                <p>Bienvenue sur le Backoffice</p>
                <img class="imggg object-fit-cover" src="<?= RACINE_SITE ?>assets/img/affiche.jpg" alt="Affiche des films sur le Backoffice">
            </div>

        <?php endif ?>

    </div>
</main>











<?php include_once "../inc/footer.inc.php";   ?>