     <?php

     $title = "Accueil";
     require_once "inc/header.inc.php";


     $info = "";

     if (isset($_GET) && !empty($_GET)) {
          if (isset($_GET['id_category'])) {
               $message = "films à vous proposer dans cette categorie";
               $films = filmsByCategoryId($_GET['id_category']);

               if (count($films) == 0) {
                    $info = alert("Aucun film dans cette categorie", "danger");
               }
          } else if (isset($_GET['voirplus'])) {
               $films = allFilms();
               $message = "films à vous proposer.";
          }
     }else{
          $films = filmByDate();
          $message = "films récents à vous proposer.";
     }


     ?>



     <!-- Main -->
     <main class="container-fluid">


          <div class="films container">
               <h2 class="fw-bolder fs-1 my-5 mx-5"><span class="nbreFilms"><?= count($films) ?></span> <?= $message ?? "films en total" ?></h2>
               <?= $info; ?>

               <div class="card-group">

                    <?php foreach ($films as $film) { ?>
                         <div class="card">
                              <div class="img-wrapper">
                                   <img class="card-img" src="<?= $film['image'] ? RACINE_SITE . "assets/img/" . $film['image'] : RACINE_SITE . "assets/img/video-placeholder.png" ?>" alt="">
                              </div>
                              <div class="card-body d-flex flex-wrap align-content-between justify-content-start">

                                   <div class="content w-100">
                                        <h3 class="card-title fw-bolder text-danger"><?= strtoupper($film['title']) ?></h3>
                                        <p class="text-black"><?= substr($film['synopsis'], 0, 90) ?>...</p>
                                   </div>

                                   <a href="<?= RACINE_SITE . "showFilm.php?id_film=" . $film['id_film'] ?>" class="btn btn-danger w-50 fs-3 mx-auto ">Plus de détails</a>
                              </div>
                         </div>
                    <?php } ?>


                    
               </div>
               
               <div class="col-12 text-center mt-5">
                    <a href="<?= RACINE_SITE ?>index.php?voirplus" class="btn p-4 fs-3 bg-light text-black">Voir plus</a>
               </div>

          </div>


          </div>



     </main>



     <?php
     require_once "inc/footer.inc.php";

     ?>