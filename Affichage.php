<?php

include 'Billet.php';
include_once 'Categorie.php';

class Affichage{

	function affichageGeneral($articles, $categorie/*$contenu_central, $menu_droite, $menu_gauche*/){
		$file = 'Blog1.html';
		$content = file_get_contents($file);
		$artc = "mesarticles";
		$cat = "mescategories";
		$link = "(suite)";
		$content = str_replace($artc, "$articles", $content);
		$content = str_replace($cat, "$categorie", $content);
		$content = str_replace($link, '<a href="http://9gag.com/">(suite)</a>', $content);
		echo $content;
}



	/* Fonction qui retourne le code HTML pour un billet */
	static function afficherBillet($billet){
		$code = "<div id = \"Article\" >\n" .
				"<h1>" . $billet->getAttr("titre") . "</h1><br>\n" . 
				"<p>" . $billet->getAttr("body") . "</p>\n" . 
				"<p>" . $billet->getAttr("date") . "</p>\n" .
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
				$code = $code . "<div id = \"Article\" >\n" .
						"<h1>" . $billet->getAttr("titre") . "</h1><br>\n" .
						"<p>" . substr($billet->getAttr("body"),0,220) . "...(suite)</p>\n" .
						"<i>" . "publié le " . $billet->getAttr("date") . "</i>\n" .
						"</div>\n";
				$code = $code . "</div>\n";
				//$code = $code . self::afficherBillet($billet);
				$code = $code . "\n</td></tr>\n";
			}
			$code = $code . "</table>\n";
		}
		return $code;
	}


	/* Retourne le code HTML pour afficher tous les catégories
	 * présentent dans la BDD*/
	static function afficheListeCategorie($liste){
		$code = "";
		if(sizeof($liste)==0)
			$code = "Aucune catégorie";
		else{
			$code = "<b>Liste des catégories</b><br>\n\t";
			foreach ($liste as $categorie) {
				$code = $code . $categorie->getAttr("titre") . " <br>\n\t";
			}
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
$cat = Categorie::findAll();
$lol = $a->afficheListeCategorie($cat);
$c = $a->afficheListeBillets($b);
$a->affichageGeneral($c, $lol);

?>