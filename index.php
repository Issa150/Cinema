     <?php

     $title = "Accueil";
     require_once "inc/header.inc.php";


     $info = "";
     
     if(!empty($_GET['id_category'])){
          
          $films = filmsByCategoryId($_GET['id_category']);
          $message = "Films à vous proposer dans cette category";
          if(isset($_GET['id_category'])){

               // is_array($films);

               if(count($films) == 0){
                    $info = alert("Désolé, pas de films à aficher, choisissez une autre categorie", "danger");
               }
          }
     }else{
          $films = filmByDate();
          $message = "Films recent!";
     }


     ?>



     <!-- Main -->
     <main class="container-fluid">


          <div class="films container">
               <h2 class="fw-bolder fs-1 my-5 mx-5"><span class="nbreFilms"><?= count($films) ?></span> <?= $message ?? "films en total" ?></h2>
               <?= $info;?>

               <div class="card-group">

                    <?php foreach($films as $film){ ?>
                         <div class="card">
                              <div class="img-wrapper">
                                   <img class="card-img" src="<?= $film['image'] ? RACINE_SITE ."assets/img/" .$film['image'] : RACINE_SITE ."assets/img/video-placeholder.png"?>" alt="">
                              </div>
                              <div class="card-body">
                                   <h3 class="card-title fw-bolder text-danger"><?=strtoupper($film['title'])?></h3>

                                   <p class="text-black"><?= substr($film['synopsis'], 0,90) ?>...</p>
                                   <a class="btn btn-danger fs-5" href="">Voir plus</a>
                              </div>
                         </div>
                    <?php }?>

               </div>


          </div>


          </div>



     </main>



     <?php
     require_once "inc/footer.inc.php";

     ?>
     