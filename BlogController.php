<?php
session_start();

/* Gère les actions des visiteurs et
 * la navigation sur le blog
 * BOULANGER Vincent & DAUSSY Alexandre
 */
include_once 'Controller.php';
include_once 'Affichage.php';

class BlogController extends Controller{

	//Affichage de base de la page d'accueil
	public function listAction($param){
		$a = new Affichage();
		$b = Billet::findByCategorie($param);
		$cat = Categorie::findAll();
		$lol = $a->afficheListeCategorie($cat);
		$liste = Billet::findUnCertainNombre(0,10);
		$t = $a->afficheTitre10Derniers($liste);
		if (sizeof($b)==1) $c = $a->afficherBillet($b);
		else $c = $a->afficheListeBillets($b);
		$a->affichageGeneral($c, $lol, $t);
		
	}

	//Affiche les articles d'un auteur
	public function listAuteur($param){
		$a = new Affichage();
		$nom = Utilisateur::findById($param)->getAttr("login");
		$b = Billet::findByAuteur($nom);
		$cat= Categorie::findAll();
		$lol = $a->afficheListeCategorie($cat);
		$c = $a->afficheListeBillets($b);
		$liste = Billet::findUnCertainNombre(0,10);
		$t = $a->afficheTitre10Derniers($liste);
		$a->affichageGeneral($c, $lol, $t);
	}



	//Affiche les articles en fonction du numéro de page
	public function listActionParPage($param){
		$debut = $param * 5 - 5 ;
		$fin = $debut + 5; 
		$a = new Affichage();
		$b = Billet::findUnCertainNombre($debut,$fin);
		$cat = Categorie::findAll();
		$lol = $a->afficheListeCategorie($cat);
		$c = $a->afficheListeBillets($b);
		$liste = Billet::findUnCertainNombre(0,10);
		$t = $a->afficheTitre10Derniers($liste);
		$a->affichageGeneral($c, $lol, $t);
	}


	//Affiche un seul article (trouvé par son Id, passé en param)
	public function detailAction($param){
		$a = new Affichage();
		$b = Billet::findById($param);
		$c = $a->afficherBillet($b);
		$cat = Categorie::findAll();
		$lol = $a->afficheListeCategorie($cat);
		$liste = Billet::findUnCertainNombre(0,10);
		$t = $a->afficheTitre10Derniers($liste);
		$a->affichageGeneral($c, $lol, $t);
	}
	


	

	/* Analyse les paramètres reçus dans la requête et appelle
	 * la méthode adéquate
	 * @param tab tableau contenant les paramètres de la requête HTTP
	 * ($tab = $_GET en faite)
	 */
	public function callAction($tab){
		/* On regarde chaque valeur du tableau
		 * En fonction du résultat on appelle une fonction
		 * Si la clé est detail ou cat, on aura alors aussi
		 * besoin de son id
		 */
		
		//si y'a pas de paramètre dans l'URL on affiche les 5 derniers articles
		if(sizeof($tab)==0) {
			$tab = array("page" => 1);
			//$this->listActionParPage(1);
		}

		foreach ($tab as $key => $value) {
			if($key == "page"){
				$this->listActionParPage($value);
			}
			switch ($value) {
				case 'list':
					$this->listActionParPage($value);
					break;

				case 'detail':
					if(array_search('id', array_keys($tab))==true){
						if(sizeof($tab['id'])>0){
							$this->detailAction($tab['id']);
						}
					}elseif (array_search('id', array_keys($tab))==false) {
						echo "Besoin d'un ID";
					}
					break;

				case 'cat':
					if(array_search('id', array_keys($tab))==false) echo "Besoin d'un id"; 
					else $this->listAction($tab['id']);
					break;

				case 'billets':
					if(array_search('id', array_keys($tab))==false) echo "Besoin d'un id"; 
					else $this->listAuteur($tab['id']);
					break;



				default:
					//if(array_search('id', array_keys($tab))==false)
					//echo "action impossible <br>";
					//$this->detailAction(null);
					break;
			}
		}
		
	}



}

?>