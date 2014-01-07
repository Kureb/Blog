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

	/* Envoi des données pour ajouter un message */
	public function saveMessage($param){
		echo "Methode : " . __FUNCTION__ . "<br> Parametre : " . $param . "<br>";

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
			//Faire affichage par défaut
			//Donc faire méthode
			//TODO faire la méthode
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

				case 'saveC':
					$this->saveCategorie($key);
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