<?php

ini_set('display_errors', 'On');
error_reporting(-1);

$nom = htmlspecialchars($_POST["nom"]);
$pseudo = htmlspecialchars($_POST["pseudo"]);
$email = htmlspecialchars($_POST["email"]);
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

	
if(isset($_POST['submitconnexion'])) {
	
	if(!empty($_POST['nom']) AND !empty($_POST['pseudo']) AND !empty($_POST['email']) AND !empty($_POST['password'])) {
			
			$pseudolength = strlen($pseudo);
			
			if($pseudolength <= 150) {
				
				if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$reqmail = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = ?");
	                $reqmail->execute(array($email));
	                $mailexist = $reqmail->rowCount();

	                if($mailexist == 0) {

	                	if(filter_var($pseudo, FILTER_DEFAULT)) {
	                		$reqpseudo = $bdd->prepare("SELECT * FROM utilisateurs WHERE pseudo = ?");
	                		$reqpseudo->execute(array($pseudo));
	                		$pseudoexist = $reqpseudo->rowCount();
	                			
	                			if($pseudoexist == 0) { 

	
	$sql = "INSERT INTO utilisateurs (nom, pseudo, email, password)
		    VALUES ('$nom', '$pseudo', '$email', '$password')";
		    // use exec() because no results are returned
		    $bdd->exec($sql);
		    /*echo "En cours d'édition";*/

	$bdd = null;

	header('location: index.html');

								} else {
									echo "Ce pseudo existe déjà !";
								}

							} else {
								echo "Le format du pseudo est incorrect";
							}
						
						} else {
							echo "Ce mail existe déjà";
						}

					} else {
						echo "Veuillez rentrer un mail au format valide";
					}
			
			} else {
				echo "Votre pseudonyme est trop long.";
			}

	} else {
		echo "Veuillez remplir tout les champs.";
	}

} else {
	echo "Merde";
}



?>