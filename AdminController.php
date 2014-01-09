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
		$b = $a->ajouterBillet();
		$a->affichageGeneral($b, $lol);
	}


	public function supprimerArticle($param){
		$billet = Billet::findById($param);

		//echo $billet;
		$n = $billet->delete();
		//header("Refresh: 0; url=Blog.php");
		header("Location: Blog.php");
		
	}

	/* Envoi des données pour ajouter un message */
	public function editerArticle($param){
		$a = new Affichage();
		$billet = Billet::findById($param);
		$cat = Categorie::findAll();
		$lol = $a->afficheListeCategorie($cat);
		$b  = $a->editerBillet($billet);
		$a->affichageGeneral($b, $lol);
	}

	/* Affichage d'un formulaire pour ajouter une catégorie */
	public function addCategorie($param){
		echo "Methode : " . __FUNCTION__ . "<br> Parametre : " . $param . "<br>";
	}

	/* Envoi des données pour ajouter une catégorie */
	public function saveCategorie($param){
		echo "Methode : " . __FUNCTION__ . "<br> Parametre : " . $param . "<br>";
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
					if(array_search('id', array_keys($tab))==true){
						if(sizeof($tab['id'])>0){
							$this->editerArticle($tab['id']);
						}
					}elseif (array_search('id', array_keys($tab))==false) {
						echo "Besoin d'un ID";
					}
					break;

				case 'del':
				if(array_search('id', array_keys($tab))==true){
						if(sizeof($tab['id'])>0){
							$this->supprimerArticle($tab['id']);
						}
					}elseif (array_search('id', array_keys($tab))==false) {
						echo "Besoin d'un ID";
				}
					break;

				default:
					//echo "action impossible <br>";
					break;
			}
		}
	}

	

}
/*
$a = new AdminController();
$a->addMessage(5);
$lol = "lol";
$a->addCategorie($lol);
*/
?>