<?php
require_once "inc/functions.inc.php";

/*
    $firstname = filter_input(INPUT_POST, 'firstname',FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_input(INPUT_POST, 'lastname',FILTER_SANITIZE_SPECIAL_CHARS);
    $pseudo = filter_input(INPUT_POST, 'pseudo',FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email',FILTER_SANITIZE_SPECIAL_CHARS);
    $mdp = filter_input(INPUT_POST, 'mdp',FILTER_SANITIZE_SPECIAL_CHARS);
    $phone = filter_input(INPUT_POST, 'phone',FILTER_SANITIZE_SPECIAL_CHARS);
    $civility = filter_input(INPUT_POST, 'civility',FILTER_SANITIZE_SPECIAL_CHARS);
    $birthday = filter_input(INPUT_POST, 'birthday',FILTER_SANITIZE_SPECIAL_CHARS);
    $address = filter_input(INPUT_POST, 'address',FILTER_SANITIZE_SPECIAL_CHARS);
    $zipCode = filter_input(INPUT_POST, 'zipCode',FILTER_SANITIZE_SPECIAL_CHARS);
    $city = filter_input(INPUT_POST, 'city',FILTER_SANITIZE_SPECIAL_CHARS);
    $country = filter_input(INPUT_POST, 'country',FILTER_SANITIZE_SPECIAL_CHARS);
    */

// debug($_POST);

// if($_SERVER["REQUEST_METHOD"] == "POST"){
// if (isset($_POST['submit'])) {
//     inscriptionUsers($firstname, $lastname, $pseudo, $email, $mdp, $phone, $civility, $birthday, $address, $zipCode, $city, $country);
// }




$year = ((int) date('Y') -12);
$month = (date('m'));
$day = (date('d'));
$dateLimitMax = $year."-" . $month . "-" . $day;

$year2 = ((int) date('Y') - 90);
$dateLimitMin =  $year2."-" . $month . "-" . $day;
if (!empty($_POST)) {

    $verify = true;

    foreach ($_POST as $key => $value) {
        if (empty(trim($value))) {
            $verify = false;
        }
    }


    if (!$verify) {
        $info = alert("Veuillez rensegner tout les champs", "danger");
    } else {
        $firstname = trim($_POST["firstname"]);
        $lastname = trim($_POST["lastname"]);
        $pseudo = trim($_POST["pseudo"]);
        $email = trim($_POST["email"]);
        $mdp = trim($_POST["mdp"]);
        $confirmMdp = trim($_POST["confirmMdp"]);
        $phone = trim($_POST["phone"]);
        $civility = trim($_POST["civility"]);
        $birthday = trim($_POST["birthday"]);
        $address = trim($_POST["address"]);
        $zipCode = trim($_POST["zipCode"]);
        $city = trim($_POST["city"]);
        $country = trim($_POST["country"]);
    }

    if(!isset($firstname) || strlen($firstname) < 2 || preg_match('/[0-9]+/', $firstname)) {
        $info .= alert("Le prénom n'est pas valid!" , "danger");
    }
    if(!isset($lastname) || strlen($lastname) < 2 || preg_match('/[0-9]+/', $lastname)) {
        $info .= alert("Le nom n'est pas valid!" , "danger");
    }
    if(!isset($pseudo) || strlen($pseudo) < 2) {
        $info .= alert("Le pseudo n'est pas valid!" , "danger");
    }
    if(!isset($mdp) || strlen($mdp) < 5  || strlen($mdp) > 15){
        $info .= alert("Le mot de pass n'est pas valid!" , "danger");
    }
    if(!isset($confirmMdp) || $mdp !== $confirmMdp){
        $info .= alert("le mot de pass n'est pas identique!" , "danger");
    }
    if(!isset($email) || strlen($email) > 50 || filter_var($email, FILTER_VALIDATE_EMAIL)){
        $info .= alert("Le mail  n'est pas valid!" , "danger");
    }
    if(!isset($phone) || !preg_match('#^[0-9]+$#',$phone)){
        $info .= alert("Le téléphone  n'est pas valid!" , "danger");
    }
    if(!isset($civility) || ($civility !='f' && $civility != 'h') ){
        $info .= alert("La civilité  n'est pas valid!" , "danger");
    }
    if(!isset($address) || strlen($address) < 5 || strlen($address) >50 ){
        $info .= alert("L'adresse n'est pas valid!" , "danger");
    }
    if(!isset($zipCode) || !preg_match('#^[0-9]+$#',$zipCode) ){
        $info .= alert("Le code postal n'est pas valid!" , "danger");
    }
    if(!isset($city) || strlen($city) >50 ){
        $info .= alert("La ville n'est pas valid!" , "danger");
    }
    if(!isset($country) || strlen($country) < 5 || strlen($country) > 50 ){
        $info .= alert("Le payes  n'est pas valid!" , "danger");
    }
    if(!isset($birthday) || ($birthday > $dateLimitMax && $birthday < $dateLimitMin)){
        $info .= alert("La date de naissance n'est pas valid!" , "danger");
    }


}


/////////////////////////////////////////
////////////////////////////////////////
///////////////////////////////////////
$title = "Inscription";
include "inc/header.inc.php";
echo '<br> <br> <br> <br> <br>';
// debug($_POST);

?>



<main style="background: url(assets/img/5818.png) center/cover; background-attachment:fixed;" class="">
    <div class="container" style="background: rgba(20,20,20,0.9);">
        <h2 class="text-center p-3 mt-5">Créer un compte</h2>
        <form action="#" method="post" class="p-5">

            <div class="row mb-3">
                <div class="col-md-6 mb-5">
                    <label for="lastname" class="form-label mb-3">Nom</label>
                    <input type="text" class="form-control fs-5 p-3" id="lastname" name="lastname">
                </div>
                <div class="col-md-6 mb-5">
                    <label for="firstname" class="form-label mb-3">Prenom</label>
                    <input type="text" class="form-control fs-5 p-3" id="firstname" name="firstname">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 mb-5">
                    <label for="pseudo" class="form-label mb-3">Pseudo</label>
                    <input type="text" class="form-control fs-5 p-3" id="pseudo" name="pseudo">
                </div>
                <div class="col-md-4 mb-5">
                    <label for="email" class="form-label mb-3">Email</label>
                    <input type="text" class="form-control fs-5 p-3" id="email" name="email" placeholder="example@gmail.com">
                </div>
                <div class="col-md-4 mb-5">
                    <label for="phone" class="form-label mb-3">Téléphone</label>
                    <input type="text" class="form-control fs-5 p-3" id="phone" name="phone" placeholder="01 23 45 67 890">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 mb-5">
                    <label for="mdp" class="form-label mb-3">Mot de pass</label>
                    <input type="password" class="form-control fs-5 p-3" id="mdp" name="mdp" placeholder="Entrez votre mot de pass">
                </div>
                <div class="col-md-6 mb-5">
                    <label for="confirmMdp" class="form-label mb-3">Confirmation mot de pass</label>
                    <input type="password" class="form-control fs-5 p-3" id="confirmMdp" name="confirmMdp" placeholder="Confirmez votre mot de pass">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 mb-5">
                    <label class="form-label mb-3">Civilité</label>
                    <select class="form-select fs-5 p-3" name="civility" id="">
                        <option value="h">Homme</option>
                        <option value="f">Femme</option>
                    </select>

                </div>
                <div class="col-md-6 mb-5">
                    <label class="form-label mb-3">Ate de naissance</label>
                    <input type="date" class="form-control fs-5 p-3" name="birthday" id="birthday">

                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12 mb-5">
                    <label for="address" class="form-label mb-3">Adresse</label>
                    <input type="text" class="form-control fs-5 p-3" name="address" id="address">

                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 mb-5">
                    <label for="zipCode" class="form-label mb-3">Code postal</label>
                    <input type="text" class="form-control fs-5-3 p-3" id="zipCode" name="zipCode">

                </div>
                <div class="col-md-5">
                    <label for="city" class="form-label mb-3">Ville</label>
                    <input type="text" class="form-control fs-5-3 p-3" id="city" name="city">
                </div>
                <div class="col-md-4">
                    <label for=“country" class="form-label mb-3">Pays</label>
                    <input type="text" class="form-control fs-5-3 p-3" id="country" name="country">
                </div>
            </div>

            <div class="row mt-5">
                <button class="w-25 m-auto btn btn-danger fs-5 p-3" name="submit">S'inscrire</button>
            </div>
        </form>
    </div>
</main>

















<?php include "inc/footer.inc.php"; ?>