<?php
$title = "Gestion / Films";
include_once "../inc/functions.inc.php";

if (!isset($_SESSION['user'])) {

    header("location: " . RACINE_SITE . "authentification.php");
} else {
    if ($_SESSION['user']['role'] == 'ROLE_USER') {
        header('Location:' . RACINE_SITE . 'index.php');
    }
}
/////////////////////////////////////////////////////:
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
    header("Location: " . RACINE_SITE . "admin/dashboard.php?films_php");
    exit();
}



// update  *******************

if (isset($_GET['action']) && $_GET['action'] == 'update') {
    $id_film = $_GET['id_film'];

    $pdo = connexionBdd();
    $sql = "SELECT * FROM films WHERE id_film = $id_film";
    $request = $pdo->query($sql);
    $film = $request->fetch();

    // function doUpdateFilm($id_film, $category_id, $title, $directors, $actors, $ageLimit, $duration, $synopsis, $date, $image, $price, $stock){

    //     updateFilm($id_film, $category_id, $title, $directors, $actors, $ageLimit, $duration, $synopsis, $date, $image, $price, $stock);
    // }


    // $category_id = $film['category_id'];
}
//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////



echo '<br> <br> <br> <br> <br> ';
$info = "";

if (!empty($_POST)) {

    $verif = true;
    // debug($_POST);
    foreach ($_POST as $value) {
        if (empty(trim($value))) {
            $verif = false;
        }
    }



    if (!$verif) {
        $info = alert("tout les chemps sont requis", "danger");
    } else {
        // if ($_FILES['image']['error'] != 0 || $_FILES['image']['size'] == 0 || !isset($_FILES['image']['type'])) {
        //     $info .= alert("L'image n'est pas valide", "danger");
        // }

        validateFormFilm($info);
        

        ////////////////
        if (empty($info)) {

            $title = htmlentities(trim($_POST['title']));
            $director = htmlentities(trim($_POST['director']));
            $actors = htmlentities(trim($_POST['actors']));
            $category = $_POST['categories'];
            $duration = $_POST['duration'];
            $synopsis = htmlentities(trim($_POST['synopsis']));
            $dateSortie = $_POST['date'];
            $price = (float) htmlentities(trim($_POST['price']));
            $stock = (int) $_POST['stock'];
            $ageLimit = $_POST['ageLimit'];
            $category_id = isset($_POST['categories']) ? $_POST['categories'] : null;
            $image = $_FILES['image']['name'];

            // $resultat = addFilm( $category_id, $title, $director,  $actors,  $ageLimit,  $duration,  $synopsis,  $dateSortie, $image,  $price, $stock);
            if($_GET['action'] == "update"){
                updateFilm($id_film, $category_id, $title, $director, $actors, $ageLimit, $duration, $synopsis, $dateSortie, $image, $price, $stock);
                // move_uploaded_file($_FILES['image']['tmp_name'], '../assets/img/' . $image);
            }else{
                addFilm($category_id, $title, $director,  $actors,  $ageLimit,  $duration,  $synopsis,  $dateSortie, $image,  $price, $stock);
            }
            move_uploaded_file($_FILES['image']['tmp_name'], '../assets/img/' . $image);
            header('Location: films.php');
            // debug($title, $director, $actors, $category_id, $duration, $synopsis, $dateSortie, $price, $stock, $dateSortie, $ageLimit, $image);
            // la superglobal $_FILES a un indice "image" qui correspond au "name" de l'input type="file" du formulaire, ainsi qu'un indice "name" qui contient le nom du fichier en cours de téléchargement.


        }
    }
}



//////////////////////////////////////
//////////////////////                 ////////////////////////                 //////////////////////////


include_once "../inc/header.inc.php";
echo $info;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<main>
    <h2 class="text-center fw-bolder text-danger"><?= isset($film) ? "Modifiez un film" : "Ajoutez un film" ?></h2>
    <form action='' method='post' enctype='multipart/form-data'>
        <!-- L'atribut entype specifie que le formulaire envoi des fichiers en plus des données texte => permet de UPLODER un fichier(photo) il est obligatoir -->
        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="title">Titre de Film</label>
                <input type="text" name="title" id="title" class="form-control fs-4" value="<?= isset($film) ? $film['title'] : "" ?>">
            </div>

            <div class="col-md-6 mb-5">
                <label for="image">Photo <?= $imageName ?? ""?></label>
                <input type="file" name="image" id="image" class="form-control fs-4">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="image_film">Réalisateur</label>
                <input type="text" name="director" id="director" class="form-control fs-4" placeholder="" value="<?= isset($film) ? $film['directors'] : "" ?>">
            </div>

            <div class="col-md-6 mb-5">
                <label for="acteur">Acteur</label>
                <input type="text" name="actors" id="actors" class="form-control fs-4" value="<?= isset($film) ? $film['actors'] : "" ?>">
            </div>

        </div>

        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="directeur">Age limite</label>

                <select multiple class="form-control form-select-lg fs-4" name="ageLimit" id="ageLimit">
                    <option <?= (isset($film) && $film['ageLimit'] == "10") ? "selected" : "" ?> value="10">10</option>
                    <option <?= (isset($film) && $film['ageLimit'] == "13") ? "selected" : "" ?> value="13">13</option>
                    <option <?= (isset($film) && $film['ageLimit'] == "16") ? "selected" : "" ?> value="16">16</option>
                </select>
            </div>
        </div>

        <div class="row">
            <label for="categories">Genre du film</label>

            <?php
            $categories = allCategories();
            foreach ($categories as $category) {
            ?>

                <div class="form-check col-sm-12 col-md-4">
                    <input class="form-check-input fs-4" type="radio" name="categories" id="flexRadioDefault" value="<?= $category['id_category'] ?>" <?= (isset($film['category_id']) && $film['category_id'] == $category['id_category']) ? "checked" : "" ?>>
                    <label class="form-check-label" for="flexRadioDefault"><?= $category['name'] ?></label>
                </div>

            <?php }  ?>
        </div>

        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="duration">Dure du fim</label>
                <input name="duration" type="time" class="form-control fs-4" id="duration" value="<?= isset($film) ? $film['duration'] : "" ?>">
            </div>

            <div class="col-md-6 mb-5">
                <label for="date">Date de sortie</label>
                <input type="date" name="date" id="date" class="form-control fs-4" value="<?= isset($film) ? $film['date'] : "" ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="price">Prix</label>
                <div class="input-group">
                    <input name="price" type="text" class="form-control fs-4" id="price" aria-label="EU
                    uros amount(with dot and decimal places)" value="<?= isset($film) ? $film['price'] : "" ?>">
                    <span class="input-group-text">$</span>
                </div>
            </div>

            <div class="col-md-6 mb-5">
                <label for="stock">Stock</label>
                <input type="Number" name="stock" id="stock" class="form-control fs-4" min="0" value="<?= isset($film) ? $film['stock'] : "" ?>">
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <label for="synopsis">Synopsis</label>
                <textarea type="text" name="synopsis" id="synopsis" rows="10" class="form-control fs-4"><?= isset($film) ? $film['synopsis'] : "" ?>
                </textarea>
            </div>
        </div>

        <div class="row justify-content-center">
            <button type="submit" class="btn btn-danger w-25 p-3 fs-4 mt-5"><?= isset($film) ? "Modifiez" : "Ajoutz" ?></button>
        </div>

    </form>
</main>

<?php include_once "../inc/footer.inc.php"; ?>