
<?php
/* Gère les actions des visiteurs et
 * la navigation sur le blog
 * BOULANGER Vincent & DAUSSY Alexandre
 */
include 'Controller.php';
class BlogController extends Controller{

	public function listAction($param){
		echo "Methode : " . __FUNCTION__ . "<br> Parametre : " . $param . "<br>";  
	}

	public function detailAction($param){
		echo "Methode : " . __FUNCTION__ . "<br> Parametre : " . $param . "<br>";  
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
		//echo "Contenu de \$_GET <br> ";
		foreach ($tab as $key => $value) {
			//echo "key : $key <br>  value : $value <br>";
			switch ($value) {
				case 'list':
					$this->listAction($key);
					break;

				case 'detail':
					$this->detailAction($key);
					if(array_search('id', array_keys($tab))==false) echo "Besoin d'un id"; 
					else echo "id : " . $tab['id'];
					break;

				case 'cat':
					$this->catAction($key);
					if(array_search('id', array_keys($tab))==false) echo "Besoin d'un id"; 
					else echo "id : " . $tab['id'];
					break;

				default:
					//if(array_search('id', array_keys($tab))==false)
						echo "action impossible <br>";
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