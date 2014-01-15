<?php

session_start();
/*
 * Gestion de la partie admin
 * BOULANGER Vincent & DAUSSY Alexandre
 */
include_once 'Controller.php';
include_once 'Affichage.php';

class AdminController extends Controller {


	/* Affichage d'un formulaire pour ajouter un message */
	public function addMessage($param){
		$a = new Affichage();
		$cat = Categorie::findAll();
		$lol = $a->afficheListeCategorie($cat);
		$b = $a->ajouterArticle();
		$liste = Billet::findUnCertainNombre(0,10);
		$t = $a->afficheTitre10Derniers($liste);
		$a->affichageGeneral($b, $lol, $t);
	}


	/* Permet de supprimer un article */
	public function supprimerArticle($param){
		$billet = Billet::findById($param);

		//Vérification si l'utilisateur courant à cette permission ou on
		if($billet->getAttr('auteur')==$_SESSION['login']){
			$n = $billet->delete();
			header("Location: blog.php");
		}else{
			echo "Tu n'as pas le droit de supprimer cet article.";
		}
	}



	/* Permet de supprimer son compte */
	public function supprimerCompte(){
		//Si un utilisateur veut supprimer son compte
		//on le déconnecte puis on supprime son compte
		if(isset($_SESSION['login'])){
			$current = Utilisateur::findByLogin($_SESSION['login']);
			session_unset();
			session_destroy();
			$n = $current->delete();
			header("Location: blog.php");
		//Sinon c'est qu'il a atteint cette url sans en avoir l'autorisation
		}else{
			echo "Vous n'avez rien à faire ici";
		}	
	}


	/* Envoi des données pour ajouter un message */
	public function editerArticle($param){
		$a = new Affichage();
		$billet = Billet::findById($param);
		$cat = Categorie::findAll();
		$lol = $a->afficheListeCategorie($cat);
		$b  = $a->editerBillet($billet);
		$liste = Billet::findUnCertainNombre(0,10);
		$t = $a->afficheTitre10Derniers($liste);
		$a->affichageGeneral($b, $lol, $t);
	}


	/* Affichage d'un formulaire pour ajouter une catégorie */
	public function addCategorie($param){
		$a = new Affichage();
		$cat = Categorie::findAll();
		$lol = $a->afficheListeCategorie($cat);
		$liste = Billet::findUnCertainNombre(0,10);
		$c = $a->ajouterCategorie();
		$t = $a->afficheTitre10Derniers($liste);
		$t = $a->affichageGeneral($c, $lol, $t);
	}

	
	


	public function callAction($tab){
		//Voir BlogController.php pour voir les commentaires

		//Si pas de paramètre dans l'url on affiche un menu
		//nous permettant de choisir ce que l'on va faire
		if(sizeof($tab)==0) {
			header("Location: membre.php");
		}
		foreach ($tab as $key => $value) {
			switch ($value) {
				case 'addM':
					$this->addMessage($key);
					break;

				case 'saveM':
					$this->saveMessage($key);
					break;

				case 'addC':
					$this->addCategorie($key);
					break;

				case 'edit':
					//Fonctionne seulement si l'id d'un article est spécifié
					if(array_search('id', array_keys($tab))==true){
						if(sizeof($tab['id'])>0){
							$this->editerArticle($tab['id']);
						}
					}elseif (array_search('id', array_keys($tab))==false) {
						Header('Location: blog.php');
					}
					break;

				case 'del':
					//Fonctionne seulement si l'id d'un article est précisé
					if(array_search('id', array_keys($tab))==true){
						if(sizeof($tab['id'])>0){
							$this->supprimerArticle($tab['id']);
						}
					}elseif (array_search('id', array_keys($tab))==false) {
						Header('Location: blog.php');
				}
					break;

				case 'supp':
					$this->supprimerCompte();
					break;



				default:
					break;
			}
		}
	}

	

}

?>