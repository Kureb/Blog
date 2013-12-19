<?php

include 'Billet.php';
include_once 'Categorie.php';

class Affichage{

	function affichageGeneral($b/*$contenu_central, $menu_droite, $menu_gauche*/){

		echo 
		"
		<!DOCTYPE html>

		<html>
			<head>
				<title>EMIN3M rules them'al</title>
		        <meta charset=\"utf-8\" />
				<style type=\"text/css\"></style>
				<link rel=\"stylesheet\" href=\"Blog1.css\" />
			</head>

			<body>

			<div id=\"banniere\">
				<img id=\"ban\" src=\"LOL.jpg\">
			</div>

		<!-- 	<div id=\"share\">
				<img id=\"sharing\" src=\"Share.png\">
			</div>
		 -->
			<div id=\"gauche\">
				<img id=\"sharing\" src=\"Share.png\">
				<p id = \"Auteur\">
					Ici, devra être le cadre qui
				 servira pour dire qui est l'auteur de ce super anticonstitutionnellement énorme anticonstitutionnellement<br>Je vous emmerde et je rentre à ma maison ! 
				</p>
				<p id=\"categorie\">
					Et juste là, un petit géranium <br> <br> <br> Nan, sérieux, la liste des catégories. 
				</p>
			</div>

			" . $b . "

			
			</body>
		</html>

		";

	}



	/* Fonction qui retourne le code HTML pour un billet */
	static function afficherBillet($billet){
		$code = "<div id = \"Article\" >" .
				"<h1>" . $billet->getAttr("titre") . "</h1><br>" . 
				"<p>" . $billet->getAttr("body") . "</p>" . 
				"<p>" . $billet->getAttr("date") . "</p>" .
				"</div>";

		return $code;
	}

	/* Fonction qui retourne le code HTML pour plusieurs billets
	 * sous la forme d'un tableau */
	static function afficheListeBillets($liste){
		$code = "";
		if(sizeof($liste)==0)
			$code = "Aucun billet";
		else{
			$code = $code . "<table>\n";
			foreach($liste as $billet){
				$code = $code . "<tr><td>\n";
				$code = $code . "<div id = \"Article\" >" .
						"<h1>" . $billet->getAttr("titre") . "</h1><br>" .
						"<p>" . substr($billet->getAttr("body"),0,20) . "...(suite)</p>" .
						"<p>" . $billet->getAttr("date") . "</p>" .
						"</div>";
				//$code = $code . "bonjour";
				$code = $code . "</div>";
				//$code = $code . self::afficherBillet($billet);
				$code = $code . "\n</td></tr>\n";
			}
			$code = $code . "</table>";
		}
		return $code;
	}

}

$a = new Affichage();

//$b = Billet::findById(2);
//$c = $a->afficherBillet($b);
//$a->affichageGeneral($c);

$b = Billet::findAll();
$c = $a->afficheListeBillets($b);
$a->affichageGeneral($c);
/*
*/
?>