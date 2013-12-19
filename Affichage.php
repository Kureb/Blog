<?php

include 'Billet.php';
include_once 'Categorie.php';

class Affichage{

	function affichageGeneral($articles/*$contenu_central, $menu_droite, $menu_gauche*/){
		$file = 'Blog1.html';
		$content = file_get_contents($file);
		$search = "mesarticles";
		$content = str_replace($search, "$articles", $content);
		echo $content;
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

/*
$b = Billet::findById(4);
$c = $a->afficherBillet($b);
$a->affichageGeneral($c);
*/

$b = Billet::findAll();
$c = $a->afficheListeBillets($b);
$a->affichageGeneral($c);

?>