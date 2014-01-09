<?php 

session_start();
if (!isset($_SESSION['login'])){
	header('Location: connexion.php');
}

include_once "Utilisateur.php";

?>

<html>
	<head>
	<title>Mon espace membre</title>
	<meta charset="utf-8" />
	<style type="text/css"></style>
	<link rel="stylesheet" href="Membre.css" />
	</head>
	<body>
		Bienvenue <?php echo $_SESSION['login']; ?><br>
		<a href="Blog.php">Accueil</a>
		<a href="deconnexion.php">D&eacute;connexion</a><br>
		<?php 
			$current_user = Utilisateur::findByLogin($_SESSION['login']);
			$admin = $current_user->getAttr("chmod");
			if($admin==1){
				echo '<a href="blog.php?a=billets&id='.$current_user->getAttr("userid").'"">Voir ses articles</a>.<br>';
				echo '<a href="admin.php?a=addM">&eacutecrire un nouvel article</a>';
			}
		?>

	</body>

