<!-- Fichier qui contient les fonctions php à utliser dans notre site  -->

<?php

use FTP\Connection;

session_start();




///////////////////// Fonction de debugage///////////////////////////
function debug($var)
{

    echo '<pre class="border border-dark bg-light text-primary w-50 p-3">';

    var_dump($var);

    echo '</pre>';
}

////////    Function Alert ///////////////////:
function alert(string $contenu, string $class){
    return "<div class= 'alert alert-$class alert-dismissible fade show text-center w-50 m-auto mb-5' role='alert'> $contenu
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";

}

///////////////////// Fonctions de connexion à la BDD //////////////////////


/**
 * On va utliser l'xtension PHP Data Object (PDO),elle définit une excellente interface pour accéder à une
 * de données depuis PHP et d'éxécuter des requêtes SQL
 * Pour se connecter à la base de données avec PDO il faut créer une instance de cette classe/Objet (PDO) qui
 * représente une connexion à la BDD.
 */


// On déclare des constantes d'environnement qui vont contenir les informations à la connexion à la BDD
define('DBHOST', 'Localhost');

//Constante de l'utlisateur à la BDD du serveur en local =>
define('DBUSER', 'root');

//Constante pour le mot de passe de serveur en local => pas de mot de passe
define('DBPASS', '');

// Constante pour le nom de la BDD
define('DBNAME', 'cinema');


function connexionBdd()
{
    //Sans la variable $dsn et sans les constantes, on se connecte à la BDD;
    // $pdo= new PDO(' mysql:host=localhost;dbname=cinema;charset=utf8'','root','');

    // avec la variable  DSN ( Data Source Name ) et les constantes 

    // $dsn='mysql:host=localhost;dbname=cinema;charset=utf8';

    $dsn = "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8";

    try {
        $pdo = new PDO($dsn, DBUSER, DBPASS);


        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
    return $pdo;
}
// ConnexionBDD();

////////////////Une fonction pour créer la table users/////////////////

function createTableUsers()
{
    $pdo = connexionBdd();
    $sql = "CREATE TABLE IF NOT EXISTS users(
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    pseudo VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    mdp VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    civility ENUM('f', 'h') NOT NULL,
    birthday DATE NOT NULL,
    address VARCHAR(50) NOT NULL,
    zipCode VARCHAR(50) NOT NULL,
    city VARCHAR(50) NOT NULL,
    country VARCHAR(50) NOT NULL,
    role ENUM('ROLE_USER','ROLE_ADMIN') DEFAULT 'ROLE_USER'

   )";
    $_REQUEST = $pdo->exec($sql);
}
// createTableUsers();

//////////////  Functions du CRUD pour les Utilisateurs Users  ////////////////:

function inscriptionUsers(string $firstname, string $lastname, string $pseudo, string $mdp, string $email, string $phone, string $civility, string $birthday, string $address, string $zipCode, string $city, string $country): void /*:void indicate that this function does not return*/
{
    $pdo = connexionBdd();

    $sql = "INSERT INTO users (firstname, lastname, pseudo, email, mdp, phone, civility, birthday, address, zipCode, city, country) 
            VALUES(:firstname, :lastname, :pseudo, :email, :mdp, :phone, :civility, :birthday, :address, :zipCode, :city, :country)";

    $request = $pdo->prepare($sql);
    $request->execute(array(
        ':firstname' => $firstname,
        ':lastname' => $lastname,
        ':pseudo' => $pseudo,
        ':email' => $email,
        ':mdp' => $mdp,
        ':phone' => $phone,
        ':civility' => $civility,
        ':birthday' => $birthday,
        ':address' => $address,
        ':zipCode' => $zipCode,
        ':city' => $city,
        ':country' => $country
    ));
}


////////// Function pour vérifier si un email exist dans la BDD  ////////////////

function checkEmailUSer(string $email) :mixed{
    $pdo = connexionBdd();
    $sql = "SELECT * FROM users WHERE email = :email";

    $request = $pdo->prepare($sql);
    $request->execute(array(
        ':email' => $email
    ));

    $resultat = $request->fetch();
}
////////// Function pour vérifier si un pseudo exist dans la BDD  ////////////////
function checkPseudoUSer(string $pseudo) :mixed{
    $pdo = connexionBdd();
    $sql = "SELECT * FROM users WHERE pseudo = :pseudo";

    $request = $pdo->prepare($sql);
    $request->execute(array(
        ':pseudo' => $pseudo
    ));

    $resultat = $request->fetch();
}

///////////// Une fonction pour créer la table films//////////////////
function createTableFilms()
{
    $pdo = connexionBdd();
    $sql = "CREATE TABLE IF NOT EXISTS films(
        id_film INT PRIMARY KEY AUTO_INCREMENT,
        category_id INT NOT NULL,
        title VARCHAR(100) NOT NULL,
        directors VARCHAR(100) NOT NULL,
        actors VARCHAR(100) NOT NULL,
        ageLimit VARCHAR(5)  NULL,
        duration Time NOT NULL,
        synopsis Text NOT NULL,
        date  DATE  NOT NULL,
        image VARCHAR(255) NOT NULL,
        price FLOAT NOT NULL,
        stock INT NOT NULL
        
    )";
    $_REQUEST = $pdo->exec($sql);
}
// createTableFilms();



////:  une function pour créer la table categorie ://////////////////////

function createTableCategories()
{
    $pdo = connexionBdd();
    $sql = "CREATE TABLE IF NOT EXISTS categories (
    id_category INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    description TEXT NULL
    )";
    $request = $pdo->exec($sql);
}
// createTableCategories();




/////////////////////: Une fonctions pour la création des clés étrangers :://///////////::::

function foreignKey(string $tableF, string $foreign, string $tableP, string $primary)
{
    $pdo = connexionBdd();
    $sql = "ALTER TABLE $tableF ADD CONSTRAINT FOREIGN KEY ($foreign) REFERENCES $tableP($primary)";
    $request = $pdo->exec($sql);
}

//// Création de la clé étranger dans la tabke films
// foreignKey('films', 'category_id', 'categories', 'id_category');



?>