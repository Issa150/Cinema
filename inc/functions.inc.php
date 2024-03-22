<!-- Fichier qui contient les fonctions php à utiliser dans notre site -->
<?php

session_start();

define("RACINE_SITE", "/PHP/Course/PHP-2/cinema_php/"); // constante qui définit les dossiers dans lesquels se situe le site pour pouvoir déterminer des chemin absolus à partir de localhost (on ne prend pas locahost). Ainsi nous écrivons tous les chemins (exp : src, href) en absolus avec cette constante.


///////////////////////////// Fonction de débugage //////////////////////////

function debug($var)
{

    echo '<pre class="border border-dark bg-light text-primary w-50 p-3">';

    var_dump($var);

    echo '</pre>';
}


////////////////////// Fonction d'alert ////////////////////////////////////////

function alert(string $contenu, string $class)
{

    return "<div class='alert alert-$class alert-dismissible fade show text-center w-50 m-auto mb-5' role='alert'>
        $contenu

            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>

        </div>";
}


///////////////////////////// Fonction de déconnexion/////////////////////////

function logOut()
{

    if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == 'deconnexion') {


        unset($_SESSION['user']);
        // On supprime l'indice "user " de la session pour se déconnecter // cette fonction détruit les variables  stocké  comme 'firstName' et 'email'.

        //session_destroy(); // Détruit toutes les données de la session déjà  établie . cette fonction détruit la session sur le serveur 

        header("location:" . RACINE_SITE . "index.php");
    }
}
// logOut();


///////////////////////////  Fonction de connexion à la BDD //////////////////////////

/**
 * On va utiliser l'extension PHP Data Object (PDO), elle définit une excellente interface pour accèder à une base de données depuis PHP et d'éxécuter des requêtes SQL.
 * pour se connecter à la BDD avec PDO, il faut créer une instance de cette Class/Objet (PDO) qui représente une connexion à la BDD.
 */

// On déclare des constantes d'environnement qui vont contenir les informations à la connexion à la BDD

// Constante du serveur => localhost
define("DBHOST", "localhost");

// Constante de l'utilisateur de la BDD du serveur en local  => root
define("DBUSER", "root");

// Constante pour le mot de passe de serveur en local => pas de mot de passe
define("DBPASS", "");

// Constante pour le nom de la BDD
define("DBNAME", "cinema");


function connexionBdd()
{

    // Sans la variable $dsn et sans le constantes, on se connecte à la BDD :

    // $pdo = new PDO('mysql:host=localhost;dbname=cinema;charset=utf8', 'root', '');

    // avec la variable DSN (Data Source Name) et les constantes

    // $dsn = "mysql:host=localhost;dbname=cinema;charset=utf8";

    $dsn = "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8";

    try {

        $pdo = new PDO($dsn, DBUSER, DBPASS);

        // On définit le mode d'erreur de PDO sur Exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {

        die($e->getMessage());
    }

    return $pdo;
}
// connexionBdd();


///////////////// Une fonction pour créer la table users ////////////////////
function createTableUsers()
{

    $pdo = connexionBdd();

    $sql = "CREATE TABLE IF NOT EXISTS users (
            id_user INT PRIMARY KEY AUTO_INCREMENT,
            firstName VARCHAR(50) NOT NULL,
            lastName VARCHAR(50) NOT NULL,
            pseudo VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL,
            mdp VARCHAR(255) NOT NULL,
            phone VARCHAR(30) NOT NULL,
            civility ENUM('f', 'h') NOT NULL,
            birthday DATE NOT NULL,
            address VARCHAR(50) NOT NULL,
            zipCode VARCHAR(50) NOT NULL,
            city VARCHAR(50) NOT NULL,
            country VARCHAR(50) NOT NULL,
            role ENUM('ROLE_USER', 'ROLE_ADMIN') DEFAULT 'ROLE_USER'
        )";

    $request = $pdo->exec($sql);
}

// createTableUsers();


// ////////////////////////////////////


//////////////////// Fonctions du CRUD pour les utilisateurs Users /////////////////////

function inscriptionUsers(string $firstName, string $lastName, string $pseudo, string $email, string $mdp, string $phone, string $civility, string $birthday, string $address, string $zipCode, string $city, string $country): void
{

    $pdo = connexionBdd(); // je stock ma connexion  à la BDD dans une variable

    $sql = "INSERT INTO users 
        (firstName, lastName, pseudo, email, mdp, phone, civility, birthday, address, zipCode, city, country)
        VALUES
        (:firstName, :lastName, :pseudo, :email, :mdp, :phone, :civility, :birthday, :address, :zipCode, :city, :country)"; // Requête d'insertion que je stock dans une variable
    $request = $pdo->prepare($sql); // Je prépare ma requête et je l'exécute
    $request->execute(
        array(
            ':firstName' => $firstName,
            ':lastName' => $lastName,
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

        )
    );
}
////////////////////////////////////////:
////// fonction pour récuperer tout les utilisateur //////:
function allUsers(): array
{
    $pdo = connexionBdd();
    $sql = "SELECT * FROM users";
    $request = $pdo->query($sql);
    $resultat = $request->fetchAll();
    return $resultat;
}

////////////////// Fonction pour vérifier si un email existe dans la BDD ///////////////////////////////

function checkEmailUser(string $email): mixed
{
    $pdo = connexionBdd();
    $sql = "SELECT * FROM users WHERE email = :email";
    $request = $pdo->prepare($sql);
    $request->execute(array(
        ':email' => $email

    ));

    $resultat = $request->fetch();
    return $resultat;
}

////////////////// Fonction pour vérifier si un pseudo existe dans la BDD ///////////////////////////////

function checkPseudoUser(string $pseudo)
{
    $pdo = connexionBdd();
    $sql = "SELECT * FROM users WHERE pseudo = :pseudo";
    $request = $pdo->prepare($sql);
    $request->execute(array(
        ':pseudo' => $pseudo

    ));

    $resultat = $request->fetch();
    return $resultat;
}

/////////// Fonction pour vérifier un utilisateur ////////////////////

function checkUser(string $email, string $pseudo): mixed
{

    $pdo = connexionBdd();

    $sql = "SELECT * FROM users WHERE pseudo = :pseudo AND email = :email";
    $request = $pdo->prepare($sql);
    $request->execute(array(
        ':pseudo' => $pseudo,
        ':email' => $email


    ));
    $resultat = $request->fetch();
    return $resultat;
}
///////////////////// Récupérer et afficher un seul utilisteur  ////////////////////////

function showUser(int $id): array
{
    $pdo = connexionBdd();
    $sql = "SELECT * FROM users WHERE id_user = :id_user";
    $request = $pdo->prepare($sql);
    $request->execute(array(

        ':id_user' => $id

    ));
    $result = $request->fetch();
    return $result;
}

//////////////////////////////////  fonctions pour supprimer un utilisateur //////////////////////


function deleteUser(int $id): void
{
    $pdo = connexionBdd();
    $sql = "DELETE FROM users WHERE id_user = :id_user";
    $request = $pdo->prepare($sql);
    $request->execute(array(

        ':id_user' => $id

    ));
}
///////////////////////////////////////////////////// Fonction pour modifier le rôle//////////////////////////////

function updateRole(string $role, int $id): void
{
    $pdo = connexionBdd();
    $sql = "UPDATE users SET role = :role WHERE id_user = :id_user";
    $request = $pdo->prepare($sql);
    $request->execute(array(
        ':role' => $role,
        ':id_user' => $id

    ));
}


///////////////// Une fonction pour créer la table films ////////////////////

function createTableFilms()
{

    $pdo = connexionBdd();

    $sql = "CREATE TABLE IF NOT EXISTS films (
            id_film INT PRIMARY KEY AUTO_INCREMENT,
            category_id INT NOT NULL,
            title VARCHAR(100) NOT NULL,
            director VARCHAR(100) NOT NULL,
            actors VARCHAR(100) NOT NULL,
            ageLimit VARCHAR(5) NULL,
            duration TIME NOT NULL,
            synopsis TEXT NOT NULL,
            date DATE NOT NULL,
            image VARCHAR(255) NOT NULL,
            price FLOAT NOT NULL,
            stock INT NOT NULL

        )";

    $request = $pdo->exec($sql);
}

/* 
    INSERT INTO films (category_id, title, directors, actors, ageLimit, duration, synopsis, date, image, price, stock)
    VALUES (29, 'The Shawshank Redemption', 'Frank Darabont', 'Tim Robbins, Morgan Freeman, Bob Gunton', 'R', '02:22:00', 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.', '1994-10-14', 'shawshank-redemption.jpg', 9.99, 50);

    INSERT INTO films (category_id, title, directors, actors, ageLimit, duration, synopsis, date, image, price, stock)
    VALUES (36, 'The Godfather', 'Francis Ford Coppola', 'Marlon Brando, Al Pacino, James Caan', 'R', '02:55:00', 'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.', '1972-03-24', 'godfather.jpg', 14.99, 30);

    INSERT INTO films (category_id, title, directors, actors, ageLimit, duration, synopsis, date, image, price, stock)
    VALUES (33, 'The Dark Knight', 'Christopher Nolan', 'Christian Bale, Heath Ledger, Aaron Eckhart', 'PG-13', '02:30:00', 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, the caped crusader must come to terms with one of the greatest psychological tests of his ability to fight injustice.', '2008-07-18', 'dark-knight.jpg', 12.99, 75);

    INSERT INTO films (category_id, title, directors, actors, ageLimit, duration, synopsis, date, image, price, stock)
    VALUES(29, 'The Matrix', 'Lana Wachowski, Lilly Wachowski', 'Keanu Reeves, Laurence Fishburne, Carrie-Anne Moss', 'R', '02:16:00', 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.', '1999-03-31', 'matrix.jpg', 11.99, 40);

    INSERT INTO films (category_id, title, directors, actors, ageLimit, duration, synopsis, date, image, price, stock)
    VALUES (30, 'Fight Club', 'David Fincher', 'Brad Pitt, Edward Norton, Helena Bonham Carter', 'R', '02:19:00', 'An insomniac office worker and a devil-may-care soapmaker form an underground fight club that evolves into something much, much more.', '1999-10-15', 'fight-club.jpg', 13.99, 25);

    INSERT INTO films (category_id, title, directors, actors, ageLimit, duration, synopsis, date, image, price, stock)
    VALUES (33, 'Inception', 'Christopher Nolan', 'Leonardo DiCaprio, Joseph Gordon-Levitt, Ellen Page', 'PG-13', '02:28:00', 'A thief who steals information by infiltrating the subconscious is offered a chance to have his criminal history erased as payment for the implantation of an idea into a CEO\'s subconscious.', '2010-07-16', 'inception.jpg', 12.99, 80);

    INSERT INTO films (category_id, title, directors, actors, ageLimit, duration, synopsis, date, image, price, stock)
    VALUES (38, 'Pulp Fiction', 'Quentin Tarantino', 'John Travolta, Uma Thurman, Samuel L. Jackson', 'R', '02:34:00', 'The lives of two mob hitmen, a boxer, a gangster andhis wife, and a pair of diner bandits intertwine in four tales of violence and redemption.', '1994-10-14', 'pulp-fiction.jpg', 11.99, 55);

    INSERT INTO films (category_id, title, directors, actors, ageLimit, duration, synopsis, date, image, price, stock)
    VALUES (36, 'The Godfather: Part II', 'Francis Ford Coppola', 'Al Pacino, Robert De Niro, Robert Duvall', 'R', '03:20:00', 'The early life and career of Vito Corleone in 1920s New York is portrayed while his son, Michael, expands and tightens his grip on the family crime syndicate.', '1974-12-20', 'godfather-part-ii.jpg', 14.99, 35);

    INSERT INTO films (category_id, title, directors, actors, ageLimit, duration, synopsis, date, image, price, stock)
    VALUES (33, 'The Prestige', 'Christopher Nolan', 'Hugh Jackman, Christian Bale, Michael Caine', 'PG-13', '02:10:00', 'After a tragic accident, two stage magicians engage in a battle to create the ultimate illusion while sacrificing everything they have to outwit the other.', '2006-10-20', 'prestige.jpg', 9.99, 70);

    INSERT INTO films (category_id, title, directors, actors, ageLimit, duration, synopsis, date, image, price, stock)
    VALUES (38, 'Interstellar', 'Christopher Nolan', 'Matthew McConaughey, Anne Hathaway, Jessica Chastain', 'PG-13', '02:49:00', 'A group of explorers make use of a newly discovered wormhole to surpass the limitations on human space travel and conquer the vast distances involved in an interstellar voyage.', '2014-11-05', 'interstellar.jpg', 12.99, 45);

*/

// createTableFilms();
//////////////////////////// Ajouter un film ///////////
function addFilm(int $category_id,string $title,string $directors, string $actors, int $ageLimit,  $duration, string $synopsis,  $date,string $image, $price, $stock): void{
    $pdo = connexionBdd();
    $sql = "INSERT INTO films 
    (category_id,title,directors, actors, ageLimit, duration, synopsis, date, image,price,stock) 
    VALUE (:category_id,:title,:directors, :actors, :ageLimit, :duration, :synopsis, :date, :image,:price,:stock)";

    $request = $pdo->prepare($sql);
    $request->execute(array(
        ":category_id"=> $category_id,
        ":title"=> $title,
        ":directors"=> $directors,
        ":actors"=> $actors,
        ":ageLimit"=> $ageLimit,
        ":duration"=> $duration,
        ":synopsis"=> $synopsis,
        ":date"=> $date,
        ":image"=> $image,
        ":price"=> $price,
        ":stock"=> $stock
    ));
}







///////////////// Une fonction pour créer la table categories ////////////////////

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
/*
    INSERT INTO films (category_id, title, directors, actors, ageLimit, duration, synopsis, date, image, price, stock)
    VALUES (1, 'Film 1', 'Director 1', 'Actor 1, Actor 2', 'PG-13', '02:30:00', 'This is the synopsis for Film 1.', '2022-01-01', 'image1.jpg', 12.99, 50);

    INSERT INTO films (category_id, title, directors, actors, ageLimit, duration, synopsis, date, image, price, stock)
    VALUES (2, 'Film 2', 'Director 2', 'Actor 3, Actor 4', 'R', '01:50:00', 'This is the synopsis for Film 2.', '2022-02-01', 'image2.jpg', 14.99, 30);

    INSERT INTO films (category_id, title, directors, actors, ageLimit, duration, synopsis, date, image, price, stock)
    VALUES (3, 'Film 3', 'Director 3', 'Actor 5, Actor 6', 'PG', '01:45:00', 'This is the synopsis for Film 3.', '2022-03-01', 'image3.jpg', 9.99, 75);

    INSERT INTO films (category_id, title, directors, actors, ageLimit, duration, synopsis, date, image, price, stock)
    VALUES (1, 'Film 4', 'Director 1', 'Actor 1, Actor 7', 'PG-13', '02:00:00', 'This is the synopsis for Film 4.', '2022-04-01', 'image4.jpg', 11.99, 40);

    INSERT INTO films (category_id, title, directors, actors, ageLimit, duration, synopsis, date,image, price, stock)
    VALUES (2, 'Film 5', 'Director 2', 'Actor 3, Actor 8', 'R', '01:30:00', 'This is the synopsis for Film 5.', '2022-05-01', 'image5.jpg', 13.99, 25);

    INSERT INTO films (category_id, title, directors, actors, ageLimit, duration, synopsis, date, image, price, stock)
    VALUES (3, 'Film 6', 'Director 3', 'Actor 5, Actor 9', 'PG', '01:20:00', 'This is the synopsis for Film 6.', '2022-06-01', 'image6.jpg', 8.99, 80);

    INSERT INTO films (category_id, title, directors, actors, ageLimit, duration, synopsis, date, image, price, stock)
    VALUES (1, 'Film 7', 'Director 1', 'Actor 1, Actor 10', 'PG-13', '02:15:00', 'This is the synopsis for Film 7.', '2022-07-01', 'image7.jpg', 12.49, 55);

    INSERT INTO films (category_id, title, directors, actors, ageLimit, duration, synopsis, date, image, price, stock)
    VALUES (2, 'Film 8', 'Director 2', 'Actor 3, Actor 11', 'R', '01:40:00', 'This is the synopsis for Film 8.', '2022-08-01', 'image8.jpg', 14.49, 35);

    INSERT INTO films (category_id, title, directors, actors, ageLimit, duration, synopsis, date, image, price, stock)
    VALUES (3, 'Film 9', 'Director 3', 'Actor 5, Actor 12', 'PG', '01:35:00', 'This is thesynopsis for Film 9.', '2022-09-01', 'image9.jpg', 9.49, 70);

    INSERT INTO films (category_id, title, directors, actors, ageLimit, duration, synopsis, date, image, price, stock)
    VALUES (1, 'Film 10', 'Director 1', 'Actor 1, Actor 13', 'PG-13', '02:20:00', 'This is the synopsis for Film 10.', '2022-10-01', 'image10.jpg', 11.49, 45);
*/
/////////////////////////////////////////////////////
////     une function pour ajouter une categorie  ///

function addcategory(string $nameCategory, string $description): void
{
    $pdo = connexionBdd();
    $sql = "INSERT INTO categories (name,description) VALUES(:name,:description)";

    $request = $pdo->prepare($sql);
    $request->execute(array(
        ':name' => $nameCategory,
        ':description' => $description
    ));
}

//////////////////////////////////::
///   une function pour requmerer tous les categoryes ////

function allCategories()
{
    $pdo = connexionBdd();
    $sql = "SELECT * FROM categories";
    $request = $pdo->query($sql);
    $resultat = $request->fetchAll();
    return $resultat;
}
//////    Récouperer les film selon leur category  /////
function filmsByCategoryId(int $id){
    $pdo = connexionBdd();
    $sql = "SELECT * FROM films WHERE category_id = :id";
    $request = $pdo->prepare($sql);
    $request->execute(array(
        ':id' => $id
    ));
    $resultat = $request->fetchAll();
    return $resultat;

}
///////////////:
///////////////////////////////////////////////////////////////

//////   fune function pour recupérer les films et aficher tout les films

function  allFilms(): array
{
    $pdo = connexionBdd();
    $sql = "SELECT films.*, categories.name AS genre
    FROM films
    LEFT JOIN categories
    ON films.category_id = categories.id_category 
    ORDER BY films.id_film DESC";
    $request = $pdo->query($sql);
    $resultat = $request->fetchAll();
    return $resultat;
}

//////////////////////////:
///  delete one item ////
// function deleteItem($table, $column, $id) {

//     // try {
//         $pdo = connexionBdd();
//         $sql = "DELETE FROM $table WHERE $column = :id";
//         $stmt = $pdo->prepare($sql);
//         $stmt->execute(array(
//             ":id" => $id
//         ));

//         return true;
//     // } catch (PDOException $e) {
//     //     // Handle exceptions here
//     //     return false;
//     // }
// }


/////////////// les films recents
function filmByDate(){
    $pdo = connexionBdd();
    $sql = "SELECT * FROM films ORDER BY date DESC LIMIT 6";
    $request = $pdo->query($sql);
    $resultat = $request->fetchALL();
    return $resultat;
}

//////  


function validateFormFilm($info){
    if ($_FILES['image']['error'] != 0 || $_FILES['image']['size'] == 0 || !isset($_FILES['image']['type'])) {
        $info .= alert("L'image n'est pas valide", "danger");
    }

    if (empty($_FILES['image'])) {
        $info .= alert("choizissez une image", "danger");
    }

    if (!isset($_POST['title']) || (strlen($_POST['title']) < 3 && trim($_POST['title'])) || preg_match('/[0-9]+/', $_POST['title'])) {


        $info .= alert("Le champ titre n'est pas valide", "danger");
    }

    if (!isset($_POST['director']) || (strlen($_POST['director']) < 2 && trim($_POST['director'])) || preg_match('/[0-9]+/', $_POST['director'])) {

        $info .= alert("Le champs Réalisateur n'est pas valide", "danger");
    }

    if (!isset($_POST['actors']) || (strlen($_POST['actors']) < 3 && trim($_POST['actors'])) || preg_match('/[0-9]+/', $_POST['actors'])) {
        // valider que l'utilisateur a bien inséré le symbole '/' : chaîne de caractères qui contient au moins un caractère avant et après le symbole /.

        $info .= alert("Le champs acteurs n'est pas valide, il faut séparer les acteurs avec le symbole", "danger");
    }
    // elseif(!preg_match('/.*\/.*/', $_POST['actors'])){
    //     $info .= alert("sssss", "danger");
    // }

    if (!isset($_POST['categories'])) {

        $info .= alert("Le champs catégories n'est pas valide", "danger");
    }

    if (!isset($_POST['synopsis']) || strlen($_POST['synopsis']) < 5) {

        $info .= alert("Le champs synopsis n'est pas valide", "danger");
    }

    if (!isset($_POST['duration'])) {

        $info .= alert("Le champs catégories n'est pas valide", "danger");
    }

    if (!isset($_POST['date'])) {

        $info .= alert("Le champs date n'est pas valide", "danger");
    }

    if (!isset($_POST['price']) || !is_numeric($_POST['price'])) {

        $info .= alert("Le prix n'est pas valide", "danger");
    }

    if (!isset($_POST['stock'])) {

        $info .= alert("Le stock n'est pas valide", "danger");
    }
}
///////////////////

    function actorsArray(string $string): array
{

    $array = explode(',', trim($string));
    return $array;
}

///////////////////////////
function updateFilm($id_film,$category_id,$title,$directors,$actors,$ageLimit,$duration,$synopsis,$date,$image,$price,$stock){
    $pdo = connexionBdd();
    $sql = "UPDATE films 
    SET category_id = :category_id,
    title = :title,
    directors = :directors,
    actors = :actors,
    ageLimit = :ageLimit,
    duration = :duration,
    synopsis = :synopsis,
    date = :date,
    image = :image,
    price = :price,
    stock = :stock
    WHERE id_film = :id_film";

    $request = $pdo->prepare($sql);
    $request->execute(array(
        ":id_film" => $id_film,
        ":category_id" => $category_id,
        ":title" => $title,
        ":directors" => $directors,
        ":actors" => $actors,
        ":ageLimit" => $ageLimit,
        ":duration" => $duration,
        ":synopsis" => $synopsis,
        ":date" => $date,
        ":image" => $image,
        ":price" => $price,
        ":stock" => $stock
    ));
}

////////////////////// Une fonction pour la création des clés étrangères //////////////////////////

// $tableF : table où on va créer la clé étrangère
// $tableP : table à partir de laquelle on récupère la clé primaire
// $foreign : le nom de la clé étrangère
// $primary : le nom de la clé primaire

function foreignKey(string $tableF, string $foreign, string $tableP, string $primary)
{

    $pdo = connexionBdd();

    $sql = "ALTER TABLE $tableF ADD CONSTRAINT FOREIGN KEY ($foreign) REFERENCES $tableP ($primary)";

    $request = $pdo->exec($sql);
}

// Création de la clé étrangère dans la table films
// foreignKey('films', 'category_id', 'categories', 'id_category');




?>