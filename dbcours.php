<?php 
ini_set('display_errors', 'On');
error_reporting(-1);

define('DB_NAME', 'cours');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_HOST', '127.0.0.1');
define('DB_TABLE', 'form.connexion');

$pseudo = htmlspecialchars($_POST["pseudo"]);
$password = password_hash($_POST["password"], PASSWORD_BCRYPT);
$cours1 = $_POST['cours1'] ;
$cours2 = $_POST['cours2'] ;
$cours3 = $_POST['cours3'] ;

try {
    $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        // set the PDO error mode to exception
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
            {
            echo $sql . "<br>" . $e->getMessage();
            };

//  Récupération de l'utilisateur et de son pass hashé
$req = $bdd->prepare('SELECT utilisateurs.id, utilistaeurs.password FROM utilisateurs INNER JOIN cours ON utilisateurs.id = cours.id_user');
$req->execute(array());
$resultat = $req->fetch();

// Comparaison du pass envoyé via le formulaire avec la base
$isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);


if (!$resultat)
{
    echo 'Mauvais identifiant et/ou mot de passe !';
}
else
{
    if ($isPasswordCorrect) {
        session_start();
        $_SESSION['id'] = $resultat['id'];
        $_SESSION['pseudo'] = $pseudo;
        echo "ce compte existe bien : $pseudo, Bienvenue ! Vous êtes bien inscrit aux cours $cours";
    }
    else {
        echo 'Mauvais identifiant et/ou mot de passe !';
    }
}




   