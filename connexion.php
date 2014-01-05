<?php
include_once "Utilisateur.php";


//$log = '';
session_start();
if (!empty($_SESSION['login'])){
	$log = 'Vous êtes déjà connecté, vous ne pouvez pas vous reconnecter.<br>';
	header("Refresh: 2, url=membre.php");
}

if (isset($_POST['connexion']) && $_POST['connexion'] == 'Connexion'){
	if (isset($_POST['pseudo']) && !empty($_POST['pseudo'])
		&& (isset($_POST['pass']) && !empty($_POST['pass']))){

		$pseudo = htmlentities($_POST['pseudo']);
		$user = Utilisateur::findByLogin($pseudo);

		if($user==false){
			$log = "Cet utilisateur n'existe pas.<br>";
		}else{
			$mdp = $user->getAttr("password");
			if($mdp != sha1($_POST['pass'])){
				$log = 'Mot de passe incorrecte.<br>';
			}else{
				$log = 'Connexion en cours.<br>';
				//session_start();
				$_SESSION['login'] = $_POST['pseudo'];
				header("Refresh: 1; url=membre.php"); 
				//header('Location: Blog.php');
			}
		}


	}else{
		$log = 'Au moins un champ est vide.<br>';
	}
}

?>



<html>
	<head>
		<title>Connexion</title>
		<meta charset="utf-8" />
		<style type="text/css"></style>
		<link rel="stylesheet" href="test.css" />
	</head>

	<body>
		<div id="formulaire">
		<form action="connexion.php" method="post">
		<div class="center">
			<span class="label">Pseudo : </span>
	 		<input class="champ" type="text" name="pseudo" value="<?php if (isset($_POST['pseudo'])) echo htmlentities(trim($_POST['pseudo'])); ?>"/><br>
			<span class="label">Mot de passe : </span>
			<input class="champ" type="password" name="pass" value="<?php if (isset($_POST['pass'])) echo htmlentities(trim($_POST['pass']))?>"/><br>
			<input type="submit" name="connexion" value="Connexion" />
		</div>
		</form>
		<?php 
		if (isset($log))
			echo '<div class="message">'.$log.'</div>'; 
		 ?>
		</div>
	</body>
</html>