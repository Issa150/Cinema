<?php

$title = "categories";
include_once "../inc/functions.inc.php";

if(!isset($_SESSION['user'])){
    
    header("location: ".RACINE_SITE."authentification.php");

}else{
    if($_SESSION['user']['role'] == 'ROLE_USER'){
        header('Location:' . RACINE_SITE.'index.php');
    }
}


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
//////////////////////////////////////////////////

if(isset($_GET['action']) && $_GET['action'] == 'update'){
    $id_category = $_GET['id_category'];

    $pdo = connexionBdd();
    $sql = "SELECT * FROM categories WHERE id_category = $id_category";
    // $sql = "SELECT * FROM films WHERE id_category = :id";
    // $request = $pdo->query($sql);
    // $request->execute(array(
    //     ':id' => $id_category
    // ));
    $request = $pdo->query($sql);
    $category = $request->fetch();
    
}
///////////////////////////////:::://////////////////
//*****   Delete   *************************
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $pdo = connexionBdd();
    $id_category = $_GET['id_category'];
    // Delete the user with the specified id_category
    $sql = "DELETE FROM categories WHERE id_category = :id";

    // $sql = "UPDATE films SET category_id = unknown WHERE category_id = :id;DELETE FROM categories WHERE id_category = :id";

    $stmt = $pdo->prepare($sql);
    // $stmt->bind_param("i", $id_category);
    $stmt->execute(array(
        ":id" => $id_category
    ));

}

?>

<div class="row mt-5">


    <div class="col-sm-12 col-md-6">
        <h2 class="text-center fw-bolder mb-5 text-danger"><?= isset($category) ? "Modifiez une category" : "Ajoutez une category"?></h2>
        <?= $info?>

        <form action="" method="post">

            <div class="row">

                <div class="col-md-8 mb-5">
                    <label for="name">Nom de la categorie</label>
                    <input type="text" id="name" name="name" class="form-control fs-4" placeholder="..." value="<?= isset($category) ? $category['name'] : ""?>">

                </div>
                <div class="col-md-12 mb-5">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control fs-4"  rows="10"><?= isset($category) ? $category['description'] : ""?></textarea>
                </div>
                <div class="row justify-content-center">
                    <button id="addCategorie" type="submit" class="btn btn-danger w-25 m-auto p-3 fw-bolder fs-4"><?= isset($category) ? "Modifiez" : "Ajoutez"?></button>
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
            <td><?php ?><a href="?categories_php&action=delete&id_category=<?=$category['id_category']?>">
                <i class="bi bi-trash3-fill text-danger"></i>
            </a></td>

            <td><?php ?><a href="?categories_php&action=update&id_category=<?=$category['id_category']?>">
                <i class="bi bi-pen-fill text-info"></i></a>
            </td>
        </tr>

        <?php } ?>
        </tbody>
    </table>

    </div>
</div>

<?php include_once "../inc/footer.inc.php"?>