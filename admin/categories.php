<?php

$title = "categories";
include_once "../inc/functions.inc.php";


$info = "";
if(!empty($_POST)){
    $verif = true;

    foreach($_POST as $value){
        if(empty($value)){
            
            $verif = false;
        }
    }

    if(!$verif){
        $info = alert("Tous les chemps sont requis", "danger");

    }else{

        $nameCategory = isset($_POST['name']) ? $_POST['name'] : null;
        $description = isset($_POST['description']) ? $_POST['description'] : null;

        if(strlen($nameCategory) < 3 || preg_match('/[0-9]+/', $nameCategory)){
            alert("LE chemps de la gcategorié n'est pas valid !..." ,"danger");
        }

        if(strlen($description) < 20){
            $info .= alert("Il faut que la deciption depsse 40 caractaire.", "danger");
        }

        if(empty($info)){
            $nameCategory = strip_tags($nameCategory);
            $description = strip_tags($description);
            
            addcategory($nameCategory,$description);
            // header('Location:'. RACINE_SITE .'dashboard.php?categories_php');
            $info = alert("Categorie ajouté avec succès", "success");
        }

    }
}


?>

<div class="row mt-5">


    <div class="col-sm-12 col-md-6">
        <h2 class="text-center fw-bolder mb-5 text-danger">Ajout de categories</h2>
        <?= $info?>

        <form action="" method="post">

            <div class="row">

                <div class="col-md-8 mb-5">
                    <label for="name">Nom de la categorie</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="...">

                </div>
                <div class="col-md-12 mb-5">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control"  rows="10"></textarea>
                </div>
                <div class="row justify-content-center">
                    <button id="addCategorie" type="submit" class="btn btn-danger w-25 m-auto p-3 fw-bolder fs-3">Ajoutez</button>
                </div>
            </div>
        </form>
    </div>



    <div class="col-sm-12 col-md-6">

    <h2 class="text-center fw-bolder mb-5 text-danger">Liste des categories</h2>

    <table class="table table-dark table-bordered mt-5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Supprimer</th>
                <th>Modifier</th>
            </tr>
        </thead>
        <tbody>

        <?php 
            $categories = allCategories();

            foreach($categories as $category){
        ?>

        <tr>
            <td><?= $category['id_category'] ?></td>
            <td><?= $category['name'] ?></td>
            <td><?= substr($category['description'],0,30) ?>...</td>
            <td><?php ?></td>
            <td><?php ?></td>
        </tr>

        <?php } ?>
        </tbody>
    </table>

    </div>
</div>

<?php include_once "../inc/footer.inc.php"?>