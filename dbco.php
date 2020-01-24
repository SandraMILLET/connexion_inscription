<?php
ini_set('display_errors', 'On');
error_reporting(-1);


$pseudo = htmlspecialchars($_POST["pseudo"]);
$password = password_hash($_POST["password"], PASSWORD_BCRYPT);
$user = 'root';
$pass = 'root';

try {
        $bdd = new PDO('mysql:host=127.0.0.1;dbname=form.connexion', $user, $pass);
        // set the PDO error mode to exception
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
            {
            echo $sql . "<br>" . $e->getMessage();
            };

//validation connexion

//  Récupération de l'utilisateur et de son pass hashé
$req = $bdd->prepare('SELECT id, password FROM utilisateurs WHERE pseudo = :pseudo');
$req->execute(array(
    'pseudo' => $pseudo));
$resultat = $req->fetch();

// Comparaison du pass envoyé via le formulaire avec la base
$isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);

if (!$resultat)
{
    echo 'Mauvais identifiant ou mot de passe !';
}
else
{
    if ($isPasswordCorrect) {
        session_start();
        $_SESSION['id'] = $resultat['id'];
        $_SESSION['pseudo'] = $pseudo;
        echo 'Vous êtes connecté !';
    }
    else {
        echo 'Mauvais identifiant ou mot de passe !';
    }
}
/*//affiche erreurs
ini_set('display_errors', 'On');
error_reporting(-1);

//connexion BDD
 
  try{
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=form.connexion;charset=utf8', 'root', 'root');
}catch (Exception $e){
    die('Erreur : ' . $e->getMessage());
}
//requete doublon avant insertion
//requete insertion de données    
    $pdoStat = $bdd->prepare('INSERT INTO utilisateurs($pseudo, $nom, $email, $password) 
    SELECT :pseudo, :nom, :email, :password 
    FROM DUAL WHERE NOT EXISTS (SELECT 1 FROM utilisateurs WHERE $pseudo=:pseudo AND $email=:email)');


// liaison marqueurs -> valeurs
$pdoStat -> bindValue(':pseudo', htmlspecialchars($_POST['pseudo']), PDO::PARAM_STR);
$pdoStat -> bindValue(':nom', htmlspecialchars($_POST['nom']), PDO::PARAM_STR);
$pdoStat -> bindValue(':email', htmlspecialchars($_POST['email']), PDO::PARAM_STR);
$pdoStat -> bindValue(':password', password_hash($_POST["password"], PASSWORD_BCRYPT), PDO::PARAM_STR);


//sécurisation des données
    $pseudo = valid_donnees($_POST["pseudo"]);
    $nom = valid_donnees($_POST["nom"]);
    $email = valid_donnees($_POST["email"]);
    
    //$password = valid_donnees($_POST["password"]);
    function valid_donnees($donnees){
        $donnees = trim($donnees);
        $donnees = stripslashes($donnees);
        $donnees = htmlspecialchars($donnees);
        return $donnees;
    }
// execution requete preprare
    $insertIsOk = $pdoStat->execute();
        if($insertIsOk){
    echo $message="L'enregistrement a été effectué";
        }else {
        echo $message="Echec ! $pseudo et/ou $email sont déjà utilisés";
    }
    if($req->rowCount() == 0){
        echo "Doublon --> pas d'insertion";
        }else {
        echo "Inscription effectué";
        }
?>  */

