<?php
include_once "Utilisateur.php";

echo '
<html>
	<head>
		<title>inscription</title>
		<meta charset="utf-8" />
	</head>

	<body>
		<div id="formulaire">
		<form action="inscription.php" method="post">
	 		Pseudo : 
	 			<input type="text" name="pseudo"/><br>
			Mot de passe : 
				<input type="password" name="mdp"/><br>
			Confirmation du mot de passe :
				<input type="password" name="cmdp"/><br>
			E-Mail :
				<input type="text" name="mail"/><br>
						
			<input type="submit" value="Valider" />
		</form>

		</div>
	</body>


</html>';




/* Pour éviter l'usage des balises dans les champs
 * j'utilise htmlentities 
if((sizeof($_POST['pseudo'])==0) && (sizeof($_POST['mdp'])==0)){
	$pseudo=htmlentities($_POST['pseudo']);
	$user = Utilisateur::findByLogin($pseudo);
	if($user!=false) {
		$mdp=htmlentities($_POST['mdp']);
		if(sha1($mdp)==$user->getAttr("password"))
			echo "connexion possible";
		else
			echo "mdp incorrecte";
	}else{
		echo "utilisateur inconnu";
	}
}else{
	echo "remplissez les 2 champs svp";
}
 */















?>