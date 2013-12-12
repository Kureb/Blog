
<?php
/* Gère les actions des visiteurs et
 * la navigation sur le blog
 * BOULANGER Vincent & DAUSSY Alexandre
 */
class BlogController{

	public function listAction($param){
		echo "Methode : " . __FUNCTION__ . "<br> Parametre : " . $param . "<br>";  
	}

	public function detailAction($param){
		echo "Methode : " . __FUNCTION__ . "<br> Parametre : " . $param . "<br>";  
	}

	public function catAction($param){
		echo "Methode : " . __FUNCTION__ . "<br> Parametre : " . $param . "<br>";  
	}

	public function callAction($tab_param){

		/*
		swich()
		case x :
			methode;
			break;
		break;
		*/
	}



}

/* Permet de tester nos fonctions */
$b = new BlogController();
$b->listAction(1);
/* Fin des tests */

?>