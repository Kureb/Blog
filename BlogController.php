<?php
session_start();
/* Gère les actions des visiteurs et
 * la navigation sur le blog
 * BOULANGER Vincent & DAUSSY Alexandre
 */
include_once 'Controller.php';
include_once 'Affichage.php';

class BlogController extends Controller{

	public function listAction($param){
		$a = new Affichage();
		$b = Billet::findAll();
		$cat = Categorie::findAll();
		$lol = $a->afficheListeCategorie($cat);
		$c = $a->afficheListeBillets($b);
		$a->affichageGeneral($c, $lol);
		
	}


	public function listActionParPage($param){
		$debut = $param * 5 - 5 ;
		$fin = $debut + 5; 
		$a = new Affichage();
		$b = Billet::findUnCertainNombre($debut,$fin);
		$cat = Categorie::findAll();
		$lol = $a->afficheListeCategorie($cat);
		$c = $a->afficheListeBillets($b);
		$a->affichageGeneral($c, $lol);
	}


	public function listParAuteur($param){
		$a = new Affichage();
		$b = Billet::findByAuteur($param);
		$cat = Categorie::findAll();
		$lol = $a->afficheListeCategorie($cat);
		$c = $a->afficheListeBillets($b);
		$a->affichageGeneral($c, $lol);
	}


	public function detailAction($param){
		//echo "Methode : " . __FUNCTION__ . "<br> Parametre : " . $param . "<br>";
		//var_dump($param);
		$a = new Affichage();
		$b = Billet::findById($param);
		$c = $a->afficherBillet($b);
		$cat = Categorie::findAll();
		$lol = $a->afficheListeCategorie($cat);
		$a->affichageGeneral($c, $lol);
		
		
	}

	public function catAction($param){
		echo "Methode : " . __FUNCTION__ . "<br> Parametre : " . $param . "<br>";  
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
		//echo "Contenu de \$_GET <br> " ;
		//var_dump($_GET);

		//si y'a pas de paramètre dans l'URL on affiche les 5 derniers articles
		if(sizeof($tab)==0) {
			$tab = array("page" => 1);
			//$this->listActionParPage(1);
		}

		foreach ($tab as $key => $value) {
			if($key == "page"){
				//var_dump($value);
				$this->listActionParPage($value);
			}
			//echo "key : $key <br>  value : $value <br>";
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
					/*
					}elseif(array_search('user', array_keys($tab))==true){
						if(sizeof($tab['user'])>0){
							$this->listParAuteur($tab['user']);
						}
					}elseif(array_search('user', array_keys($tab))==false){
						echo "Besoin d'un ID";
					}*/

					//TODO gérer quand id=
					//var_dump($tab['id']);
					//else $this->detailAction($tab['id']);
					/*
					if(array_search('id', array_keys($tab))==true)	$this->detailAction($tab['id']);
					if(array_search('user', array_keys($tab))==false) echo "Besoin d'un utilisateur";
					if(array_search('user', array_keys($tab))==true) $this->listParAuteur($tab['user']);
					*/
					break;

				case 'cat':
					if(array_search('id', array_keys($tab))==false) echo "Besoin d'un id"; 
					else /*echo "id : " . $tab['id'];*/
						$this->catAction($key);
						//TODO FAIRE affichage des catégories
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

/* Permet de tester nos fonctions */

/*$b = new BlogController();
$b->listAction("param1"); echo "<br>";
$b->detailAction("param2"); echo "<br>";
echo "<p>Pour tester la methode callAction, ajoutez \"?cle=valeur\" 
a la fin de l'URL (ce que vous voulez, ex ?nom=Daussy ou ?nom=Daussy?id=5) et reactualisez<br></p>";
$tab = $_GET;
if ($tab != null) $b->callAction($tab);*/
/* Fin des tests */


?>