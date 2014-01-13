<?php

include_once 'Billet.php';
include_once 'Categorie.php';
include_once 'Utilisateur.php';


class Affichage{



	function affichageGeneral($articles, $categorie, $derniersarticles/*$contenu_central, $menu_droite, $menu_gauche*/){
		$file = 'BlogAlex.php';
		$content = file_get_contents($file);
		$content = str_replace("mesderniersarticles", "$derniersarticles", $content);
		$content = str_replace("mesarticles", "$articles", $content);
		$content = str_replace("mescategories", "$categorie", $content);
		$content = str_replace("auteurlol", self::infoUser(), $content);
		$content = str_replace("mapagination", self::afficherNbPages(), $content);
		echo $content;
	}


	static function infoUser(){
		$info = '';
		if (!empty($_SESSION['login'])){
			$info .= 'Bonjour <a href="membre.php" title="accéder à mon espace membre">'.htmlentities($_SESSION['login']).'</a><br>';
			$info .= '<a href="deconnexion.php">Se déconnecter</a><br>';
			include_once 'Utilisateur.php';
			if(Utilisateur::estAdmin($_SESSION['login'])==true){
				$info .= '';
			}else{ //TODO mettre une image (étoile?) pour les admins
				$info .= '';
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

		//Lien pour revenir en arrière si on est sur une page sans article
		//Se base sur l'historique
		if(($num>1 && ($nb_billets < ($num-1)*5)) || $num==0){
			$pagination = '<a href="javascript:history.back();" title="Précédent">Précédent</a>';
		} 

		
		return $pagination;
		
	}


	



	/* Fonction qui retourne le code HTML pour un billet */
	static function afficherBillet($billet){
		$croix = '';
		$edit = '';
		if(isset($_SESSION['login'])){
		if($_SESSION['login']==$billet->getAttr("auteur")){
				$croix = '<a href="admin.php?a=del&id='.$billet->getAttr("id"). '"><img src="suppr.png" id="edit" title="Supprimer le billet" alt="suppression" border="0"></img></a>';
				$edit = '  <a href="admin.php?a=edit&id='.$billet->getAttr("id"). '"><img src="edit.png" id="edit" title="Editer le billet" alt="edition" border="0"></img></a>';
			}
		}
			

		//TOTO si article n'existe pas, ne pas afficher		
		if ($billet==false){
			$code = '<div class="Article">'; 
			$code .= 'Cette article n\'existe pas.';	
			$code .= '</div>';
		} 
		else{
			$categ = $billet->getAttr("cat_id");
			$n_cat = Categorie::findById($categ);
			$contenu = str_replace("\n","<br/>", $billet->getAttr("body")); 
			$date = $billet->getAttr("date");
			$date = substr($date, 0, 11) . "à " . substr($date, 11);
			$code = "<div class=\"Article\">\n" .
					"<h2>" . $billet->getAttr("titre") . "</h2>\n" .
					//"<h2>" . $billet->getAttr("titre") . "</h2><br>\n" . 
					"<p>" . $contenu . "</p>\n" .
					"<p id=\"date\"><i>publié le " . $date. "</i> par ". $billet->getAttr("auteur").' '.$croix.' '.$edit ."<br>dans la catégorie " .$n_cat->getAttr("titre")."</p>\n" .
					"</div>";
		}		
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
						"<h2>" . $billet->getAttr("titre") . "</h2><br>\n" .
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
				
				$code = $code . "<div class=\"Article\">\n" .
						"<h2>" . $billet->getAttr("titre") . "</h2><br>\n" .
						"<p>" . substr($billet->getAttr("body"),0,220) . "..." . $link . "</p>\n" .
						"<p id=\"date\"><i>" . "publié le " . $date. "</i></p>\n"
						 .
						"</div>\n";
				
						
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
			$code = 'Liste des catégories<br>';
			foreach ($liste as $categorie) {
				$titre = $categorie->getAttr("titre");
				$span = $categorie->getAttr("description");
				$id = Categorie::findByTitre($titre)->getAttr("id");
				$lien = '<a href="blog.php?a=cat&id='. $id .'">+</a> ';
				$code .= $lien . $titre . "<br>\n";
				

			}
		}
		return $code;
	}



	/* Affiche liste des 10 derniers articles
	 * (mais juste le titre)
	 */
	static function afficheTitre10Derniers($liste){
		$code = "";
		//var_dump($liste);
		if(sizeof($liste)==0){
			$code = $code . "Aucun article";
		}else if(sizeof($liste)==1){
			foreach ($liste as $billet) {
				$code = $billet->getAttr("titre") . "</h2><br>\n";
			}
		}else{
			foreach($liste as $billet){
				$lien = '<a href="blog.php?a=detail&id='. $billet->getAttr("id") .'">+</a> ';
				$code .= $lien . $billet->getAttr("titre") . "<br>\n";
				//$code = $code . $titre . ' <a href="blog.php?a=cat&id='. $billet->getAttr("titre") .'">+</a><br>';
			
			}
			
		}

		
		
		return $code;
	}



	/* FAUTE DE FAIRE UNE AUTRE CLASSE CAR TROP RÉPÉTITIVE
	 * SERONT CI-DESSOUS LES METHODES UTILISÉES POUR L'AFFICHAGE
	 * DE LA PARTIE ADMINISTRATEUR */
	
	/* Permet d'ajouter un article */
	static function ajouterArticle(){
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
		if(!isset($_SESSION['login'])){
			$code .= "Tu n'es pas connecté, tu n'as donc pas accès à cette partie";
			$code .= 'Peut-être veux-tu te connecter, ou bien t\'inscrire.';
		}else{


		if(Utilisateur::estAdmin($_SESSION['login'])==false){
			//tu peux pas test tarba
			// <label for=\"ajouterTitre\">Titre de l'article</label><br />
			//<input id=\"ajouterTitre\" type=\"text\" name=\"titre\" autofocus>
       			
       		$code .= $_SESSION['login'] . ", vous n'avez pas les droits nécessaires pour écrire un nouvel article";	
		}else{
			$categorie = Categorie::findAll();
			//wesh fais comme chez toi
			$code .= "<h2>Écrire un nouvel article</h2>";
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
		}
		if (isset($log)){ $code .= '<div class="message">'.$log.'</div>'; }
		
		$code .= "</div>";

		

		return $code;
	}


	/* Créé l'html pour afficher les catégories sous forme
	 * d'une liste */
	static function listeCategorie(){
		//Si l'url de la page a edit et id
		//on réupère l'id pour récupérer la categorie du billet et la garder en mémoire
		$nom = '';
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$art = Billet::findById($id);
			$cat = $art->getAttr("cat_id");
			$lol = Categorie::findById($cat);
			$nom = $lol->getAttr("titre");
		}
		

		$liste = Categorie::findAll();
		$code = "";
		if(sizeof($liste)==0)
			$code = "Aucune catégorie";
		else{
			/* Si on n'est pas en train d'ajouter une catégorie (càd on ajoute billet ou on l'édite) */
			if(!$_GET['a']=='addC'){
			$code = '<p>
       					<label for="categ">Dans quelle catégorie placez-vous le billet ?</label><br />
       					<select name="categ" id="categ">';
       		/* Mais si on est en train d'ajouter une catégorie on change le label */
       		}else{
       		$code = '<p>
       					<label for="categ">Voici les catégorie déjà existantes : </label><br />
       					<select name="categ" id="categ">';
       		}

       		foreach ($liste as $categorie) {
       			if($categorie->getAttr("titre")==$nom)
       				$code .= "<option value=". $categorie->getAttr("titre") ." selected>" .$categorie->getAttr("titre"). "</option>";
       			else
       				$code .= "<option value=". $categorie->getAttr("titre") .">" .$categorie->getAttr("titre"). "</option>";
			}
			//$code .= '<select name="'.$nom.'" id="'.$nom.'">';
			$code .= "</select></p>";
		}
		return $code;
	}






	static function editerBillet($billet){
		if (isset($_POST['envoyer']) && $_POST['envoyer'] == 'Envoyer'){
			if (isset($_POST['ajouterTitre']) && !empty($_POST['ajouterTitre'])){
				if (isset($_POST['ajouterArticle']) && !empty($_POST['ajouterArticle'])){
					$titre = $_POST['ajouterTitre'];
					$body = $_POST['ajouterArticle'];
					$categ = $_POST['categ'];

					$cat = Categorie::findByTitre($categ);
					$billet->setAttr("titre", $titre);
					$billet->setAttr("body", $body);
					$billet->setAttr("id", $billet->getAttr("id"));
					$billet->setAttr("cat_id", $billet->getAttr("cat_id"));
					$billet->setAttr("date", $billet->getAttr("date"));
					$billet->setAttr("auteur", $billet->getAttr("auteur"));


					//echo $b;
					$res = $billet->update();
					if($res==1){
						$log = 'Billet bien édité. Redirection en cours';
						$header = 'Refresh: 2; url=Blog.php?a=detail&id='.$billet->getAttr("id");
						header($header);
					} 
					else $log ='Une erreur est arrivée.';

					
				}else{
					$log = "Vous ne pouvez pas supprimer le contenu de l'article.";
				}				
			}else{
				$log = "Vous ne pouvez pas supprimer le titre.";
			}
		}
		



		$code = "<div class=\"EditArticle\">\n" ;
		if(!isset($_SESSION['login'])){
			$code .= "Tu n'es pas connecté, tu n'as donc pas accès à cette partie";
			$code .= 'Peut-être veux-tu te connecter, ou bien t\'inscrire.';
		}else{


		if(Utilisateur::estAdmin($_SESSION['login'])==false){	
       		$code .= $_SESSION['login'] . ", vous n'avez pas les droits nécessaires pour éditer cet article";	
		}else{
			$categorie = Categorie::findAll();
			
			$code .= "<h2>Éditer un article</h2>";
			$code .= "

			<form method=\"post\" action=\"\">
   			
   			<p> <label for=\"ajouterTitre\">Titre de l'article</label><br>
       			<textarea name=\"ajouterTitre\" id=\"ajouterTitre\">";
       			$code .= $billet->getAttr("titre");
       			$code .= "</textarea>
       		</p>


   			<p>
       			<label for=\"ajouterArticle\">Zone d'écriture de l'article</label><br />
       			<textarea name=\"ajouterArticle\" id=\"ajouterArticle\">";
       			$code .= $billet->getAttr("body");
       			$code .= "</textarea>
   			";

   			$code .= '<input type="submit" name="envoyer" value="Envoyer" />
   			</p>';
   			
   			$code .=  self::listeCategorie();

   			$code .= '</form>';
   			

		
		}
		}
		if (isset($log)){ $code .= '<div class="message">'.$log.'</div>'; }
		
		$code .= "</div>";

		

		return $code;
	}




	static  function ajouterCategorie(){
		if (isset($_POST['envoyer']) && $_POST['envoyer'] == 'Envoyer'){
			if (isset($_POST['ajouterTitre']) && !empty($_POST['ajouterTitre'])){
				if (isset($_POST['ajouterCategorie']) && !empty($_POST['ajouterCategorie'])){
					$titre = $_POST['ajouterTitre'];
					$body = $_POST['ajouterCategorie'];
					

					$c = new Categorie();
					$c->setAttr("titre", $titre);
					$c->setAttr("description", $body);

					$res = $c->insert();


					//echo $b;
					if($res==1){
						$log = 'Catégorie bien ajoutée. Redirection en cours vers l\'accueil.';
						$header = 'Refresh: 2; url=blog.php';
						header($header);
					} 
					else $log ='Une erreur est survenue. Veuillez réessayer.';

					
				}else{
					$log = "Il manque la description.";
				}				
			}else{
				$log = "Il manque un titre.";
			}
		}




		$code = "<div class=\"AjoutArticle\">\n" ;
				if(!isset($_SESSION['login'])){
					$code .= "Tu n'es pas connecté, tu n'as donc pas accès à cette partie";
					$code .= 'Peut-être veux-tu te connecter, ou bien t\'inscrire.';
				}else{


				if(Utilisateur::estAdmin($_SESSION['login'])==false){
					//tu peux pas test tarba
					// <label for=\"ajouterTitre\">Titre de l'article</label><br />
					//<input id=\"ajouterTitre\" type=\"text\" name=\"titre\" autofocus>
		       			
		       		$code .= $_SESSION['login'] . ", vous n'avez pas les droits nécessaires pour écrire un nouvel article";	
				}else{
					$categorie = Categorie::findAll();
					//wesh fais comme chez toi
					$code .= "<h2>Ajouter une catégorie</h2>";
					$code .= "

					<form method=\"post\" action=\"admin.php?a=addC\">
		   			
		   			<p> <label for=\"ajouterTitre\">Titre de la catégorie</label><br>
		       			<textarea name=\"ajouterTitre\" id=\"ajouterTitre\" maxlength=\"5\">";
		       			if (isset($_POST['ajouterTitre'])) $code .= $_POST['ajouterTitre'];
		       			$code .= "</textarea>
		       		</p>


		   			<p>
		       			<label for=\"ajouterCategorie\">Description de la catégorie</label><br />
		       			<textarea name=\"ajouterCategorie\" id=\"ajouterCategorie\">";
		       			if (isset($_POST['ajouterCategorie'])) $code .= $_POST['ajouterCategorie'];
		       			$code .= "</textarea>
		   			";

		   			$code .= '<input type="submit" name="envoyer" value="Envoyer" />
		   			</p>';
		   			
		   			$code .=  self::listeCategorie();

		   			$code .= '</form>';
		   			//TODO créer ajoutmessage.php pour insérer dans la table


				
				}
				}
				if (isset($log)){ $code .= '<div class="message">'.$log.'</div>'; }
				
				$code .= "</div>";

				

				return $code;
	}




}

?>