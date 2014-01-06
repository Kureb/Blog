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
	</head>
	<body>
		Bienvenue <?php echo $_SESSION['login']; ?><br>
		<a href="Blog.php">Accueil</a>
		<a href="deconnexion.php">D&eacute;connexion</a><br>
		<?php 
			$current_user = Utilisateur::findByLogin($_SESSION['login']);
			$admin = $current_user->getAttr("chmod");
			if($admin==1){
				echo 'Voir ses articles.<br>';
			}
		?>

	</body>

