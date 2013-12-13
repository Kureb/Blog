<?php
/*
 * Gestion du blog
 * BOULANGER Vincent & DAUSSY Alexandre
 */
include_once('Controller.php');
class AdminController extends Controller {


	/* Affichage d'un formulaire pour ajouter un message */
	public function addMessage($param){
		echo "Methode : " . __FUNCTION__ . "<br> Parametre : " . $param . "<br>";
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
					echo "action impossible <br>";
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