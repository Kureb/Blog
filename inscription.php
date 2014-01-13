<?php
include_once "Utilisateur.php";
//error_reporting(-1);



session_start();
if (!empty($_SESSION['login'])){
	$log = 'Vous êtes déjà connecté, vous ne pouvez pas vous inscrire.<br>';
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
			$log = 'Adresse mail non valide.<br>';
		}	
		elseif($_POST['pass'] != $_POST['pass_c']){
			$log = 'Les deux mots de passe ne correspondent pas.<br>';
		}else{
			$pseudo = htmlentities($_POST['pseudo']);
			$user = Utilisateur::findByLogin($pseudo);
			$mail = Utilisateur::findByMail($_POST['mail']);

			if($user!=false){
				$log = 'Utilisateur déjà enregistré dans la base.<br>';
			}elseif($mail!=false){
				$log = 'Adresse mail déjà enregistrée dans la base de donnée.';
			}
			else{
				$user = new Utilisateur();
				$user->setAttr("login", $_POST['pseudo']);
				$user->setAttr("password", $_POST['pass']);
				$user->setAttr("mail", $_POST['mail']);
				//$user->setAttr("chmod", "0");
				$user->insert();

				$log = 'Inscription prise en compte. Merci '. $pseudo .' ! <br>';
				$log .= 'Connexion en cours. <br>';

				$_SESSION['login'] = $_POST['pseudo'];
				header("Refresh: 1; url=Blog.php");
			}
		}

	}else{
		$log = 'Au moins un champ est vide.<br>';
	}
}else if(isset($_POST['accueil']) && $_POST['accueil'] == 'Accueil') {
	header("Location: blog.php");
}

?>


<html>
	<head>
		<title>Inscription</title>
		<meta charset="utf-8" />
		<style type="text/css"></style>
		<link rel="stylesheet" href="Inscription.css" />
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