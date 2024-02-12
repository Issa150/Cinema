<!-- header.inc.php  -->
<?php
require_once"inc/functions.inc.php";
require_once"inc/header.inc.php";

$username;
// createTableFilms();
if(isset($_POST)){
    // $username = $_POST['username'];
    $username = filter_input(INPUT_POST,'username', FILTER_SANITIZE_SPECIAL_CHARS);
}

?>

     <!-- Main -->
    <main class="container-fluid">  


          <div class="films">
            <h2 class="fw-bolder fs-1 my-5 mx-5"><span class="nbreFilms">0</span> films à vous porposer.</h2> 
            <!-- <div class="row"> -->
                    <form action="" method="post">
                        <input type="text" placeholder="username" name="username">
                        <button>Send</button>
                    </form>
                    <p class="text-light">Result: 
                        </p>
                        <?php if(isset($username)) echo $username?>
                    

                
                            <!-- <div class="col-sm-12 col-md-6 col-lg-4 col-xxl-3">
                                <div class="card">
                                    <img src="assets/" alt="Affiche du film image " >
                                    <div class="card-body">
                                            <h3>Titre FILM</h3>     
                                            <h4>Titre DIRECTOR</h4>
                                            <p><span class="fw-bolder">Resumé : </span>SYNOPSIS</p>
                                    
                                            <a href="#" class="btn">Voir Plus</a>                            
                                               
                                    </div>
                                    
                                </div>
                            </div> -->
                        
                        <!--  -->

                                <!-- <div class="col-12 text-center">
                                        <a href="index.php" class="btn p-4 fs-3 ">Voir Plus</a>  
                                </div> -->
                        <!--  -->

            <!-- </div> -->


          </div>
<!-- footer.inc.php -->
    </main>


<?php
require_once"inc/footer.inc.php";
?>