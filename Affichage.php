<?php

include 'Billet.php';
include_once 'Categorie.php';

class Affichage{

	function affichageGeneral($b/*$contenu_central, $menu_droite, $menu_gauche*/){

		echo "
		<!DOCTYPE html>

		<html>
			<head>
				<title>Blog S3</title>
		        <meta charset=\"utf-8\" />
				<style type=\"text/css\"></style>
				<link rel=\"stylesheet\" href=\"Blog1.css\" />
			</head>

			<body>

		<!-- 	<h1>Ceci est un simple Test... </h1>

			<p>My first paragraph.</p> -->

			<div id=\"banniere\">
		<!-- 		<img src=\"LOL.jpg\"></div>
		 -->	

			<div id = \"Auteur\">
				<p>Ici, devra être le cadre qui
			 servira pour dire qui est l'auteur de ce super anticonstitutionnellement énorme anticonstitutionnellement</p>
				<p>Je vous emmerde et je rentre à ma maison ! </p>
			</div>

			<div id = \"Article\" > 
				<p>".$b."Test 2<br>Test 2<br>Test 2<br></p>
			</div>
			</body>
		</html>
		";

	}




	public static function afficherBillet($billet){
		$code = "<h1>" . $billet->getAttr("titre") . "</h1><br>";
		return $code;
	}

}

$a = new Affichage();
$b = Billet::findById(2);
$a->affichageGeneral($b);

?>