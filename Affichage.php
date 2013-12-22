<?php

include 'Billet.php';
include_once 'Categorie.php';

class Affichage{

	function affichageGeneral($articles, $categorie/*$contenu_central, $menu_droite, $menu_gauche*/){
		$file = 'BlogAlex.html';
		$content = file_get_contents($file);
		$artc = "mesarticles";
		$cat = "mescategories";
		$content = str_replace($artc, "$articles", $content);
		$content = str_replace($cat, "$categorie", $content);
		echo $content;
}



	/* Fonction qui retourne le code HTML pour un billet */
	static function afficherBillet($billet){
		$date = $billet->getAttr("date");
		$date = substr($date, 0, 11) . "à " . substr($date, 11);
		$code = "<div class=\"Article\">\n" .
				"<h1>" . $billet->getAttr("titre") . "</h1><br>\n" . 
				"<p>" . $billet->getAttr("body") . "</p>\n" . 
				"<p id = \"date\"><i>" . "publié le " . $date. "</i></p>\n" .
				"</div>";

		return $code;
	}

	/* Fonction qui retourne le code HTML pour plusieurs billets
	 * sous la forme d'un tableau */
	static function afficheListeBillets($liste){
		$code = "";
		//var_dump($liste);
		if(sizeof($liste)==0){
			$code = "<div class=\"Article\">\n";
			$code = $code . "Aucun billet";
			$code = $code . "</div>";
			return $code;
		}else if(sizeof($liste)==1){
			foreach ($liste as $billet) {
				$id = $billet->getAttr("id");
				$link = '<a href="Blog.php?a=detail&amp;id=' . $id . '">(suite)</a>';
				$date = $billet->getAttr("date");
				$date = substr($date, 0, 11) . "à " . substr($date, 11);
				$code = $code . "<div class=\"Article\" >\n" .
						"<h1>" . $billet->getAttr("titre") . "</h1><br>\n" .
						"<p>" . substr($billet->getAttr("body"),0,220) . "..." . $link . "</p>\n" .
						"<p id=\"date\"><i>" . "publié le " . $date. "</i></p>\n" .
						"</div>\n";
				//$code = $code . "</div>\n";
			}
			//$code = self::afficherBillet();
		}
		else{
			$code = $code . "<table>\n";
			foreach($liste as $billet){
				$id = $billet->getAttr("id");
				$link = '<a id_lien=' .$id . ' href="Blog.php?a=detail&amp;id=' . $id . '">(suite)</a>';
				$date = $billet->getAttr("date");
				$date = substr($date, 0, 11) . "à " . substr($date, 11);
				$code = $code . "<tr><td>\n";
				$code = $code . "<div class=\"Article\">\n" .
						"<h1>" . $billet->getAttr("titre") . "</h1><br>\n" .
						"<p>" . substr($billet->getAttr("body"),0,220) . "..." . $link . "</p>\n" .
						"<p id=\"date\"><i>" . "publié le " . $date. "</i></p>\n" .
						"</div>\n";
				//$code = $code . "</div>\n";
				//$code = $code . self::afficherBillet($billet);
				$code = $code . "</td></tr>\n";
			}
			
		$code = $code . "</table>\n";
		}
		$page = $_GET;

		//SI GET est vide num est égal à 1 
		if(sizeof($page)!=0){
			
			foreach ($page as $key => $value) {
				if ($key=="page") $num = $value; break;
			}
		}
		else $num = 1;
		
		$pagination = '<div id="pagination">Page numéro : << '.$num.' >> </div>';
		$prec = "<<";
		$suiv = ">>";
		$nb_billets = Billet::getNbBillet();
		if($num>1)
			$pagination = str_replace($prec, '<a href="Blog.php?page=' . ($num-1) . '"><<</a>' ,$pagination);

		if($nb_billets > $num*5)
			$pagination = str_replace($suiv, '<a href="Blog.php?page=' . ($num+1) . '">>></a>' ,$pagination);
		
		$code = $code . $pagination;
		
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
				$titre = $categorie->getAttr("titre");
				$span = $categorie->getAttr("description");
				$code = $code . $titre . "<br>";
				//TODO Ajouter span et petit icone, en faire une liste
				//$code = $code . "<span TITLE =\"" . $span . ">" . $titre . "</span> <br>\n\t";
			}
		}
		return $code;
	}

}

//$a = new Affichage();

/*
$b = Billet::findById(4);
$c = $a->afficherBillet($b);
$a->affichageGeneral($c);
*/
/*
$b = Billet::findAll();
$cat = Categorie::findAll();
$lol = $a->afficheListeCategorie($cat);
$c = $a->afficheListeBillets($b);
$a->affichageGeneral($c, $lol);
*/
?>