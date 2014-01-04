<?php
include_once "Utilisateur.php";
//error_reporting(-1);


$log = '';
session_start();
if (!empty($_SESSION['login'])){
	$log .= 'Vous êtes déjà connecté, vous ne pouvez pas vous inscrire.<br>';
	header("Refresh: 2, url=membre.php");
}



//if(isset($_POST['login'], $_POST['pass'], $_POST['pass_c']!=''){
if (isset($_POST['inscription']) && $_POST['inscription'] == 'Inscription'){
	if( (isset($_POST['pseudo']) && !empty($_POST['pseudo']))
		&& (isset($_POST['pass']) && !empty($_POST['pass']))
		&& (isset($_POST['pass_c']) && !empty($_POST['pass_c']))
		&& (isset($_POST['mail']) && !empty($_POST['mail']))){
		//on vérifie le mail
		if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}.[a-z]{2,4}$#", $_POST['mail'])){
			$log .= 'Adresse mail non valide.<br>';
		}	
		elseif($_POST['pass'] != $_POST['pass_c']){
			$log .= 'Les deux mots de passe ne correspondent pas.<br>';
		}else{
			$pseudo = htmlentities($_POST['pseudo']);
			$user = Utilisateur::findByLogin($pseudo);

			if($user!=false){
				$log .= 'Utilisateur déjà enregistré dans la base.<br>';
			}
			else{
				$user = new Utilisateur();
				$user->setAttr("login", $_POST['pseudo']);
				$user->setAttr("password", $_POST['pass']);
				$user->setAttr("mail", $_POST['mail']);
				//$user->setAttr("chmod", "0");
				$user->insert();

				$log .= 'Inscription prise en compte. Merci ! <br>';
			}
		}

	}else{
		$log .= 'Au moins un champ est vide.<br>';
	}
}

?>


<html>
	<head>
		<title>Inscription</title>
		<meta charset="utf-8" />
	</head>

	<body>
		<div id="formulaire">
		<form action="inscription.php" method="post">
	 		Pseudo : 
	 			<input type="text" name="pseudo" value="<?php if (isset($_POST['pseudo'])) echo htmlentities(trim($_POST['pseudo'])); ?>"/><br>
			Mot de passe : 
				<input type="password" name="pass" value="<?php if (isset($_POST['pass'])) echo htmlentities(trim($_POST['pass']))?>"/><br>
			Confirmation mot de passe :
				<input type="password" name="pass_c" value="<?php if (isset($_POST['pass_c'])) echo htmlentities(trim($_POST['pass_c']))?>"/><br>
			E-mail : 
				<input type="text" name="mail" value="<?php if (isset($_POST['mail'])) echo htmlentities(trim($_POST['mail']))?>"/><br>			
			<input type="submit" name="inscription" value="Inscription" />
		</form>
		<?php if (isset($log)) echo '<br />' . $log; ?>
		</div>
	</body>
</html>

<!--
/* Pour éviter l'usage des balises dans les champs
 * j'utilise htmlentities */
if((sizeof($_POST['pseudo'])==0) && (sizeof($_POST['mdp'])==0)){
	$pseudo=htmlentities($_POST['pseudo']);
	$user = Utilisateur::findByLogin($pseudo);
	if($user!=false) {
		$mdp=htmlentities($_POST['mdp']);
		if(sha1($mdp)==$user->getAttr("password"))
			echo "connexion possible";
		else
			echo "mdp incorrecte";
	}//else{
		//echo "utilisateur inconnu";
	//}
}//else{
	//echo "remplissez les 2 champs svp";
//}
-->