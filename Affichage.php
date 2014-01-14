<?php

include_once 'Billet.php';
include_once 'Categorie.php';
include_once 'Utilisateur.php';

/* Le code HTML est généré par cette classe 
 * En fonction de l'utilisateur courant on ne va pas afficher les mêmes choses.
 */


class Affichage{


	/* Cette fonction prend 3 paramètres
	 * Menu gauche : $categorie
	 * Menu droit : $derniersarticles
	 * Menu central : $articles
 	 */
	function affichageGeneral($articles, $categorie, $derniersarticles){
		//accueil.php contient la structure basique de notre site.
		//quelques mots-clés définis sont glissés à certains endroits propice.
		//C'est ici que nous remplaçons ces mots-clés par notre code généré.
		$file = 'accueil.php';
		$content = file_get_contents($file);
		$content = str_replace("mesderniersarticles", "$derniersarticles", $content);
		$content = str_replace("mesarticles", "$articles", $content);
		$content = str_replace("mescategories", "$categorie", $content);
		$content = str_replace("auteur", self::infoUser(), $content);
		$content = str_replace("mapagination", self::afficherNbPages(), $content);

		echo $content;
	}



	/* Affiche les informations d'un utilisateurs s'il est connecté
	 * Invite le visiteur à se connecté s'il ne l'est pas.
	 * Permet d'accéder à son espace membre.
	 */
	static function infoUser(){
		$info = '';
		if (!empty($_SESSION['login'])){
			if($_SESSION['login']=='Vincent')
				$info .= '<img id="avatar" src="img/test.jpg">';
			elseif($_SESSION['login']=='Alexandre')
				$info .= '<img id="avatar" src="img/alex.jpg">';
			elseif($_SESSION['login']=='Professeur')
				$info .= '<img id="avatar" src="img/professeur.jpg">';
			else $info.= '<img id="avatar" src="img/utilisateur.jpg">';
				
			$info .= 'Bonjour <a href="#">'.htmlentities($_SESSION['login']).'</a><br>';
			$info .= '<a href="deconnexion.php">Se déconnecter</a><br>';
			include_once 'Utilisateur.php';
			if(Utilisateur::estAdmin($_SESSION['login'])==true){
				//$info .= '<a href="blog.php?a=billets&id='.$current_user->getAttr("userid").'"">Voir ses articles</a>.<br>';
				$info .= '<br><br><br>';
				$info .= '<a href="admin.php?a=addM">&eacutecrire un nouvel article</a><br>';
				$info .= '<a href="admin.php?a=addC">Ajouter une catégorie</a><br>';
			;
			}else{ //TODO mettre une image (étoile?) pour les admins
				$info .= '';
			}
		}else{
			$info .= '<img id="avatar" src="img/pasco.jpg">';
			$info .= '<a href="connexion.php">Se connecter</a>';
		}

		return $info;
	}



	/* Génère le code pour la pagination */
	static function afficherNbPages(){
		$page = $_GET;

		//SI GET est vide num est égal à 1 car c'est qu'on est sur la première page
		//Sinon on récupère le numéro de la page
		if(sizeof($page)!=0){			
			foreach ($page as $key => $value) {
				if ($key=="page"){
					$num = $value;
					break;
				}else{
					$num = 0;	
				} 
			}
		}else{
			$num = 1;
		}
		
		//Si le numéro de page est nulle on affiche rien
		if($num==0){
			$pagination = '';
		//Sinon on créé des liens pour les pages suivantes et précédentes.
		}else{
			$pagination = 'Page numéro : << '.$num.' >>';
			$prec = "<<";
			$suiv = ">>";
			$nb_billets = Billet::getNbBillet();
			//On affiche seulement le lien vers la page précédente si on est au minimum à la page 2
			if($num>1)
				$pagination = str_replace($prec, '<a href="blog.php?page=' . ($num-1) . '" title="Page précédente"><<</a>' ,$pagination);
			//On affiche seulement le lien vers la page suivante si il reste des articles après la page courante (5 par page)
			if($nb_billets > $num*5)
				$pagination = str_replace($suiv, '<a href="blog.php?page=' . ($num+1) . '" title="Page suivante">>></a>' ,$pagination);
		}

		//Lien pour revenir en arrière si on est sur une page sans article
		//Se base sur l'historique
		if(($num>1 && ($nb_billets < ($num-1)*5)) || $num==0){
			$pagination = '<a href="javascript:history.back();" title="Précédent">Précédent</a>';
		} 

		//Ajout du copyright
		$pagination .= '<br><br><span id="copyright">BOULANGER Vincent <br> DAUSSY Alexandre<br>';
		$pagination .= 'S3C 2013-2014</span>';
		
		return $pagination;
		
	}


	



	/* Fonction qui retourne le code HTML pour un billet */
	static function afficherBillet($billet){
		//Si l'utilisateur connecté courant est l'auteur du billet qu'il est en train de lire
		//alors on lui donne l'autorisation d'éditer son billet ou de le supprimer
		$croix = '';
		$edit = '';
		if(isset($_SESSION['login'])){
			if($_SESSION['login']==$billet->getAttr("auteur")){
				$croix = '<a href="admin.php?a=del&id='.$billet->getAttr("id"). '"><img src="img/suppr.png" id="edit" title="Supprimer le billet" alt="suppression" border="0"></img></a>';
				$edit = '  <a href="admin.php?a=edit&id='.$billet->getAttr("id"). '"><img src="img/edit.png" id="edit" title="Editer le billet" alt="edition" border="0"></img></a>';
			}
		}
			

		//Si un article n'existe pas, on prévient l'utilisateur.
		if ($billet==false){
			$code = '<div class="Article">'; 
			$code .= 'Cette article n\'existe pas.';	
			$code .= '</div>';
		}else{
			//Sinon on affiche le billet
			//En commençant par le titre, puis le contenu
			//La date, l'auteur, la catégorie (et édition/suppression si autorisé)
			$categ = $billet->getAttr("cat_id");
			$n_cat = Categorie::findById($categ);
			$contenu = str_replace("\n","<br/>", $billet->getAttr("body")); 
			$date = $billet->getAttr("date");
			$date = substr($date, 0, 11) . "à " . substr($date, 11);
			$code = "<div class=\"Article\">\n" .
					"<h2>" . $billet->getAttr("titre") . "</h2>\n" .
					"<p>" . $contenu . "</p>\n" .
					"\n " .
					"</div>".
					"<div id=\"info\"><span id=\"cat\">Dans la catégorie : " .$n_cat->getAttr("titre")."</span>
					<span id=\"date\"><i>publié le : " . $date. "</i> par <b>". $billet->getAttr("auteur").' '.$croix.' '.$edit ."</b></span></div>";
		}		
		return $code;
	}







	/* Fonction qui retourne le code HTML pour plusieurs billets
	 * sous la forme d'un tableau 
	 * Prend comme paramètre la liste des articles à afficher 
	 */
	static function afficheListeBillets($liste){
		$code = "";
		//Si la liste est vide on prévient l'utilisateur
		if(sizeof($liste)==0){
			$code = "<div class=\"Article\">\n";
			$code = $code . "Aucun billet";
			$code = $code . "</div>";
		//S'il n'y en a qu'un on l'affiche, sans dévoiler tout le contenu
		}else if(sizeof($liste)==1){
			foreach ($liste as $billet) {
				$id = $billet->getAttr("id");
				$link = '<a href="blog.php?a=detail&amp;id=' . $id . '" title="afficher la suite">(suite)</a>';
				$date = $billet->getAttr("date");
				$date = substr($date, 0, 11) . "à " . substr($date, 11);

				
				$code = $code . "<div class=\"Article\" >\n" .
						"<h2>" . $billet->getAttr("titre") . "</h2><br>\n" .
						"<p>" . substr($billet->getAttr("body"),0,220) . "..." . $link . "</p>\n" .
						"<span id=\"date2\"><i>" . "publié le " . $date. "</i></span>\n" .
						"</div>\n";
				
			}
		//Si il y a plusieurs articles, on les affiche tous sans en dévoiler tout le contenu
		}else{
			foreach($liste as $billet){
				$id = $billet->getAttr("id");
				$link = '<a id_lien=' .$id . ' href="blog.php?a=detail&amp;id=' . $id . '" title="afficher la suite">(suite)</a>';
				$date = $billet->getAttr("date");
				$date = substr($date, 0, 11) . "à " . substr($date, 11);
				
				$code = $code . "<div class=\"Article\">\n" .
						"<h2>" . $billet->getAttr("titre") . "</h2><br>\n" .
						"<p>" . substr($billet->getAttr("body"),0,220) . "..." . $link . "</p>\n" .
						"<p id=\"date2\"><i>" . "publié le " . $date. "</i></p>\n"
						 .
						"</div>\n";
			}
			
		}
	return $code;
	}


	/* Retourne le code HTML pour afficher tous les catégories
	 * présentent dans la BDD 
	 * Prend comme paramètre la liste des Catégories */
	static function afficheListeCategorie($liste){
		$code = "";
		if(sizeof($liste)==0)
			$code = "Aucune catégorie.";
		else{
			$code = 'Liste des catégories :<br><br>';
			foreach ($liste as $categorie) {
				$titre = $categorie->getAttr("titre");
				$span = $categorie->getAttr("description");
				$id = Categorie::findByTitre($titre)->getAttr("id");
				$lien = '<a href="blog.php?a=cat&id='. $id .'" title="'. $span .'">';
				$code .= $lien . $titre . "</a><br>\n";
			}
		}
		return $code;
	}



	/* Affiche le titre des 10 derniers articles 
	 * Prend en paramètre la liste des 10 derniers articles */
	static function afficheTitre10Derniers($liste){
		$code = "";
		if(sizeof($liste)==0){
			$code = $code . "Aucun article";
		}else if(sizeof($liste)==1){
			foreach ($liste as $billet) {
				$date = $billet->getAttr("date");
				$auteur = $billet->getAttr("auteur");
				$lien = '<a href="blog.php?a=detail&id='. $billet->getAttr("id") .'" title="publié le '. $date .' par ' . $auteur .'" ';
				$code = $billet->getAttr("titre") . "</a></h2><br>\n";
			}
		}else{
			foreach($liste as $billet){
				$date = $billet->getAttr("date");
				$auteur = $billet->getAttr("auteur");
				$lien = '<a href="blog.php?a=detail&id='. $billet->getAttr("id") .'" title="publié le '. $date .' par ' . $auteur .'"> ';
				$code .= $lien . $billet->getAttr("titre") . "</a><br>\n";
			}
			
		}
		return $code;
	}



	
	/* Fragment HTML qui nous permet d'ajouter un article */
	static function ajouterArticle(){
		/* Si le formulaire est bien envoyé */
		if (isset($_POST['envoyer']) && $_POST['envoyer'] == 'Envoyer'){
			// Et qu'il possède bien un titre
			if (isset($_POST['ajouterTitre']) && !empty($_POST['ajouterTitre'])){
				//Ainsi qu'un contenu
				if (isset($_POST['ajouterArticle']) && !empty($_POST['ajouterArticle'])){
					//Alors on sauvegarde les informations récupérés par $_POST
					$titre = $_POST['ajouterTitre'];
					$body = $_POST['ajouterArticle'];
					$categ = $_POST['categ'];
					$log = $titre . " " . $body . " " . $categ;

					$cat = Categorie::findByTitre($categ);
					$billet = new Billet();
					//Et on créé un nouveau billet
					$b = new Billet();
					$b->setAttr("titre", $titre);
					$b->setAttr("body", $body);
					$b->setAttr("cat_id", $cat->getAttr("id"));
					$b->setAttr("date", date("Y-m-d H:i:s"));
					$b->setAttr("auteur", $_SESSION['login']);
					//qu'on insère dans la BDD
					$res = $b->insert();
					//Si pas d'erreur on prévient l'utilisateur et on le redirige vers son article
					if($res==1){
						$log = 'Billet bien publié. Redirection en cours';
						$header = 'Refresh: 2; url=blog.php?a=detail&id='.$b->getAttr("id");
						header($header);
					}
					//Sinon on lui dit qu'il y a eu une erreur
					else{
						$log ='Une erreur est survenue.';	
					}
				}else{
					$log = "manque l'article";	
				}			
			}else{
				$log = "Manque un titre";
			}
		}
		/* Fin du test */


		//Si aucun n'utilisateur n'est connecté on lui proposer d'aller se connecter
		$code = "<div class=\"AjoutArticle\">\n" ;
		if(!isset($_SESSION['login'])){
			$code .= "Tu n'es pas connecté, tu n'as donc pas accès à cette partie<br>";
			$code .= 'Peut-être veux-tu te connecter, ou bien t\'inscrire.';
		}else{
			//S'il est connecté mais qu'il n'a pas les droit d'admin, on le luit dit
			if(Utilisateur::estAdmin($_SESSION['login'])==false){
				$code .= $_SESSION['login'] . ", vous n'avez pas les droits nécessaires pour écrire un nouvel article";	
			}else{
				//Sinon tout est bon, on affiche le formulaire
				$categorie = Categorie::findAll();
				$code .= "<h2>Écrire un nouvel article</h2>";
				$code .= "

				<form method=\"post\" action=\"admin.php?a=addM\">
   			
   				<p> <label for=\"ajouterTitre\">Titre de l'article</label><br>
       				<textarea name=\"ajouterTitre\" id=\"ajouterTitre\" maxlength=\"64\">";
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
   		
			}
		}

		//S'il y a des log on les affiches
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
			$code .= "</select></p>";
		}
		return $code;
	}





	/* Génère le code HTML qui va nous permettre
	 * d'éditer un billet dont l'id est passé en paramètre 
	 */
	static function editerBillet($billet){
		//Imbrication des 3 if, si le formulaire est envoyé et est complétement rempli
		if (isset($_POST['envoyer']) && $_POST['envoyer'] == 'Envoyer'){
			if (isset($_POST['ajouterTitre']) && !empty($_POST['ajouterTitre'])){
				if (isset($_POST['ajouterArticle']) && !empty($_POST['ajouterArticle'])){
					//On récupère les valeurs envoyées
					$titre = $_POST['ajouterTitre'];
					$body = $_POST['ajouterArticle'];
					$categ = $_POST['categ'];

					$cat = Categorie::findByTitre($categ);

					//On met à jour les attribus
					$billet->setAttr("titre", $titre);
					$billet->setAttr("body", $body);
					$billet->setAttr("id", $billet->getAttr("id"));
					$billet->setAttr("cat_id", $billet->getAttr("cat_id"));
					$billet->setAttr("date", $billet->getAttr("date"));
					$billet->setAttr("auteur", $billet->getAttr("auteur"));

					//Et on update la base
					$res = $billet->update();
					//Si tout va bien, ou notifie l'utilisateur et on le redirige vers l'article édité
					if($res==1){
						$log = 'Billet bien édité. Redirection en cours';
						$header = 'Refresh: 2; url=blog.php?a=detail&id='.$billet->getAttr("id");
						header($header);
					} 
					//Sinon on le prévient qu'il y a eu une erreur
					else $log ='Une erreur est arrivée.';
				}else{
					$log = "Vous ne pouvez pas supprimer le contenu de l'article.";
				}				
			}else{
				$log = "Vous ne pouvez pas supprimer le titre.";
			}
		}
		


		//Si personne n'est connecté, il n'a pas le droit d'accéder à cette page
		$code = "<div class=\"EditArticle\">\n" ;
		if(!isset($_SESSION['login'])){
			$code .= "Tu n'es pas connecté, tu n'as donc pas accès à cette partie";
			$code .= 'Peut-être veux-tu te connecter, ou bien t\'inscrire.';
		}else{

			//S'il n'est pas admin il n'a pas le droit d'éditer d'article	
			if(Utilisateur::estAdmin($_SESSION['login'])==false){	
       			$code .= $_SESSION['login'] . ", vous n'avez pas les droits nécessaires pour éditer cet article";	
			}else{
				//Sinon tout va bien on affiche le formulaire
				$categorie = Categorie::findAll();
				
				$code .= "<h2>Éditer un article</h2>";
				$code .= "
	
				<form method=\"post\" action=\"\">
   			
   				<p> <label for=\"ajouterTitre\">Titre de l'article</label><br>
       				<textarea name=\"ajouterTitre\" id=\"ajouterTitre\" maxlength=\"64\">";
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
		//S'il y a des erreurs on les affiche
		if (isset($log)){ $code .= '<div class="message">'.$log.'</div>'; }
		
		$code .= "</div>";

		

		return $code;
	}



	/* Retourne le code HTML pour ajouter une catégorie */
	//Fonctionne pareil que ajouter un article, je ne vais donc pas détailler
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
						$code .= $_SESSION['login'] . ", vous n'avez pas les droits nécessaires pour écrire un nouvel article";	
					}else{
						$categorie = Categorie::findAll();
						$code .= "<h2>Ajouter une catégorie</h2>";
						$code .= "

						<form method=\"post\" action=\"admin.php?a=addC\">
		   			
		   				<p> <label for=\"ajouterTitre\">Titre de la catégorie</label><br>
		       				<textarea name=\"ajouterTitre\" id=\"ajouterTitre\" maxlength=\"64\">";
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
		   			}
				}
				if (isset($log)){ $code .= '<div class="message">'.$log.'</div>'; }
				
				$code .= "</div>";

				

				return $code;
	}




}

?>