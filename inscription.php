<?php
include_once "Utilisateur.php";



session_start();
//Si l'utilisateur est déjà connecté on l'amène sur son espace membre
if (!empty($_SESSION['login'])){
	$log = 'Vous êtes déjà connecté, vous ne pouvez pas vous inscrire.<br>';
	header("Refresh: 2, url=blog.php");
}


//Si tout est bon
if (isset($_POST['inscription']) && $_POST['inscription'] == 'Inscription'){
	if( (isset($_POST['pseudo']) && !empty($_POST['pseudo']))
		&& (isset($_POST['pass']) && !empty($_POST['pass']))
		&& (isset($_POST['pass_c']) && !empty($_POST['pass_c']))
		&& (isset($_POST['mail']) && !empty($_POST['mail']))){

		//on vérifie le mail
		if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}.[a-z]{2,4}$#", $_POST['mail'])){
			$log = 'Adresse mail non valide.<br>';
		}
		//Les mots de passe	
		elseif($_POST['pass'] != $_POST['pass_c']){
			$log = 'Les deux mots de passe ne correspondent pas.<br>';
		}else{
			//On vérifie que ni le pseudo ni le mail n'est déjà dans notre base de données
			$pseudo = htmlentities($_POST['pseudo']);
			$user = Utilisateur::findByLogin($pseudo);
			$mail = Utilisateur::findByMail($_POST['mail']);

			if($user!=false){
				$log = 'Utilisateur déjà enregistré dans la base.<br>';
			}elseif($mail!=false){
				$log = 'Adresse mail déjà enregistrée dans la base de donnée.';
			}
			else{
				//Tout ba bien, on crée l'utilisateur
				$user = new Utilisateur();
				$user->setAttr("login", $_POST['pseudo']);
				$user->setAttr("password", $_POST['pass']);
				$user->setAttr("mail", $_POST['mail']);
				//On l'insère dans la BDD
				$user->insert();

				$log = 'Inscription prise en compte. Merci '. $pseudo .' ! <br>';
				$log .= 'Connexion en cours. <br>';
				//On le redirige vers l'accueil
				$_SESSION['login'] = $_POST['pseudo'];
				header("Refresh: 1; url=blog.php");
			}
		}

	}else{
		$log = 'Au moins un champ est vide.<br>';
	}
//S'il appuie sur le bouton accueil on l'envoie à l'accueil
}else if(isset($_POST['accueil']) && $_POST['accueil'] == 'Accueil') {
	header("Location: blog.php");
}

?>


<html>
	<head>
		<title>Inscription</title>
		<meta charset="utf-8" />
		<style type="text/css"></style>
		<link rel="stylesheet" href="CSS/Inscription.css" />
	</head>

	<body>
		<div class="formulaire">
		<form action="inscription.php" method="post">
	 	<div class="center">
	 		<span class="label">Pseudo</span>
	 		<input class="champ" type="text" name="pseudo" maxlength="20" value="<?php if (isset($_POST['pseudo'])) echo htmlentities(trim($_POST['pseudo'])); ?>"/><br>
			<span class="label">Mot de passe</span>
			<input class="champ" type="password" name="pass" maxlength="20" value="<?php if (isset($_POST['pass'])) echo htmlentities(trim($_POST['pass']))?>"/><br>
			<span class="label">Mot de passe (bis)</span>
			<input class="champ" type="password" name="pass_c" maxlength="20" value="<?php if (isset($_POST['pass_c'])) echo htmlentities(trim($_POST['pass_c']))?>"/><br>
			<span class="label">E-mail</span>
			<input class="champ" type="text" name="mail" maxlength="50" value="<?php if (isset($_POST['mail'])) echo htmlentities(trim($_POST['mail']))?>"/><br>			
			<br><br>
			<input type="submit" name="inscription" value="Inscription" />
			<input type="submit" name="accueil" value="Accueil" />
		</div>
		</form>
		<?php
			if (isset($log)) 
				echo '<div class="message">' . $log . '</div>'; 
		?>
		</div>
	</body>
</html>