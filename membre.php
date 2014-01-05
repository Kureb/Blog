<?php 

session_start();
if (!isset($_SESSION['login'])){
	header('Location: connexion.php');
}

?>

<html>
	<head>
	<title>Mon espace membre</title>
	</head>
	<body>
		Bienvenue <?php echo $_SESSION['login']; ?><br>
		<a href="Blog.php">Accueil</a>
		<a href="deconnexion.php">D&eacute;connexion</a>

	</body>

