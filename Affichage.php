<?php

include_once 'Billet.php';
include_once 'Categorie.php';
include_once 'Utilisateur.php';


class Affichage{



	function affichageGeneral($articles, $categorie/*$contenu_central, $menu_droite, $menu_gauche*/){
		$file = 'BlogAlex.php';
		$content = file_get_contents($file);
		$content = str_replace("mesarticles", "$articles", $content);
		$content = str_replace("mescategories", "$categorie", $content);
		$content = str_replace("auteurlol", self::infoUser(), $content);
		$content = str_replace("mapagination", self::afficherNbPages(), $content);
		echo $content;
	}


	static function infoUser(){
		$info = 'Utilisateur<br>';
		if (!empty($_SESSION['login'])){
			$info .= 'Bonjour <a href="membre.php">'.htmlentities($_SESSION['login']).'</a><br>';
			$info .= '<a href="deconnexion.php">Se déconnecter</a><br>';
			include_once 'Utilisateur.php';
			if(Utilisateur::estAdmin($_SESSION['login'])==true){
				$info .= 'tu es admin/<br>';
			}else{
				$info .= 'tu es pas admin<br>';
			}
		}else{
			$info .= '<a href="connexion.php">Se connecter</a>';
		}

		return $info;
	}



	static function afficherNbPages(){
		$page = $_GET;

		//SI GET est vide num est égal à 1 
		if(sizeof($page)!=0){
			
			foreach ($page as $key => $value) {
				if ($key=="page"){
					$num = $value;
					break;
				} else $num = 0;
			}
		}
		else {
			$num = 1;
		}
		
		if($num==0) $pagination = '';

		else{
		$pagination = 'Page numéro : << '.$num.' >>';
		$prec = "<<";
		$suiv = ">>";
		$nb_billets = Billet::getNbBillet();
		if($num>1)
			$pagination = str_replace($prec, '<a href="Blog.php?page=' . ($num-1) . '"><<</a>' ,$pagination);

		if($nb_billets > $num*5)
			$pagination = str_replace($suiv, '<a href="Blog.php?page=' . ($num+1) . '">>></a>' ,$pagination);
		}
		return $pagination;
		
	}


	



	/* Fonction qui retourne le code HTML pour un billet */
	static function afficherBillet($billet){
		//Un utilisateur qui n'a pas posté n'est pas censé être admin
		//mais autant avoir 2 vérifications plutôt qu'une
		$croix = '';
		if(isset($_SESSION['login'])){
		if($_SESSION['login']==$billet->getAttr("auteur")){
				$croix = ' [<a href="admin.php?a=del&id='.$billet->getAttr("id"). '">X</a>]';
			}
		}
			

		//TOTO si article n'existe pas, ne pas afficher		

		if ($billet==false) echo 'pas d\'article';


		$date = $billet->getAttr("date");
		$date = substr($date, 0, 11) . "à " . substr($date, 11);
		$code = "<div class=\"Article\">\n" .
				"<h1>" . $billet->getAttr("titre") . "</h1>\n" .
				//"<h1>" . $billet->getAttr("titre") . "</h1><br>\n" . 
				"<p>" . $billet->getAttr("body") . "</p>\n" . 
				"<p id = \"date\"><i>" . "publié le " . $date. "</i> par ". $billet->getAttr("auteur"). $croix . "</p>\n" .
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
			//TODO ajouter pagination
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
			foreach($liste as $billet){
				$id = $billet->getAttr("id");
				$link = '<a id_lien=' .$id . ' href="Blog.php?a=detail&amp;id=' . $id . '">(suite)</a>';
				$date = $billet->getAttr("date");
				$date = substr($date, 0, 11) . "à " . substr($date, 11);
				
				$code = $code . '<div id="lol">';

				$code = $code . "<div class=\"Article\">\n" .
						"<h1>" . $billet->getAttr("titre") . "</h1><br>\n" .
						"<p>" . substr($billet->getAttr("body"),0,220) . "..." . $link . "</p>\n" .
						"<p id=\"date\"><i>" . "publié le " . $date. "</i></p>\n" .
						"</div>\n";
				
						$code = $code . "</div>\n";
				//$code = $code . self::afficherBillet($billet);
				
			}
			
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
			$code = '<span class="menudroitetitre">Liste des catégories</span><br>';
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



	/* FAUTE DE FAIRE UNE AUTRE CLASSE CAR TROP RÉPÉTITIVE
	 * SERONT CI-DESSOUS LES METHODES UTILISÉES POUR L'AFFICHAGE
	 * DE LA PARTIE ADMINISTRATEUR */


	/* Permet d'ajouter un article */
	static function ajouterBillet(){
		/* Je en sais pas si ça marche mais on va essayer */
		if (isset($_POST['envoyer']) && $_POST['envoyer'] == 'Envoyer'){
			if (isset($_POST['ajouterTitre']) && !empty($_POST['ajouterTitre'])){
				if (isset($_POST['ajouterArticle']) && !empty($_POST['ajouterArticle'])){
					$titre = $_POST['ajouterTitre'];
					$body = $_POST['ajouterArticle'];
					$categ = $_POST['categ'];
					$log = $titre . " " . $body . " " . $categ;

					$cat = Categorie::findByTitre($categ);
					$billet = new Billet();
					$b = new Billet();
					$b->setAttr("titre", $titre);
					$b->setAttr("body", $body);
					$b->setAttr("id", '10');
					$b->setAttr("cat_id", $cat->getAttr("id"));
					$b->setAttr("date", date("Y-m-d H:i:s"));
					$b->setAttr("auteur", $_SESSION['login']);


					//echo $b;
					$res = $b->insert();
					if($res==1){
						$log = 'Billet bien publié. Redirection en cours';
						$header = 'Refresh: 2; url=Blog.php?a=detail&id='.$b->getAttr("id");
						header($header);
					} 
					else $log ='Une erreur';

					
				}else{
					$log = "manque l'article";
				}				
			}else{
				$log = "Manque un titre";
			}
		}
		/* Fin du test */



		$code = "<div class=\"AjoutArticle\">\n" ;
		if(Utilisateur::estAdmin($_SESSION['login'])==false){
			//tu peux pas test tarba
			// <label for=\"ajouterTitre\">Titre de l'article</label><br />
			//<input id=\"ajouterTitre\" type=\"text\" name=\"titre\" autofocus>
       			
       			
			$code .= "Tarba t'as rien à faire ici<br>";
		}else{
			$categorie = Categorie::findAll();
			//wesh fais comme chez toi
			$code .= "<h1>Écrire un nouvel article</h1>";
			$code .= "

			<form method=\"post\" action=\"admin.php?a=addM\">
   			
   			<p> <label for=\"ajouterTitre\">Titre de l'article</label><br>
       			<textarea name=\"ajouterTitre\" id=\"ajouterTitre\">";
       			if (isset($_POST['ajouterTitre'])) $code .= $_POST['ajouterTitre'];
       			$code .= "</textarea>
       		</p>


   			<p>
       			<label for=\"ajouterArticle\">Zone d'écriture de l'article</label><br />
       			<textarea name=\"ajouterArticle\" id=\"ajouterArticle\">";
       			if (isset($_POST['ajouterArticle'])) $code .= $_POST['ajouterArticle'];
       			$code .= "</textarea>
   			";

   			$code .= '<input type="submit" name="envoyer" value="Envoyer" />
   			</p>';
   			
   			$code .=  self::listeCategorie();

   			$code .= '</form>';
   			//TODO créer ajoutmessage.php pour insérer dans la table


		
		}

		if (isset($log)){ $code .= '<div class="message">'.$log.'</div>'; }
		
		$code .= "</div>";

		

		return $code;
	}


	/* Créé l'html pour afficher les catégories sous forme
	 * d'une liste */
	static function listeCategorie(){
		$liste = Categorie::findAll();
		$code = "";
		if(sizeof($liste)==0)
			$code = "Aucune catégorie";
		else{
			$code = "<p>
       					<label for=\"pays\">Dans quelle catégorie placez-vous le billet ?</label><br />
       					<select name=\"categ\" id=\"categ\">";
       		foreach ($liste as $categorie) {
       			$code .= "<option value=". $categorie->getAttr("titre") .">" .$categorie->getAttr("titre"). "</option>";
			}
			$code .= "</select></p>";
		}
		return $code;
	}

}

?>