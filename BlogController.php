
<?php
/* Gère les actions des visiteurs et
 * la navigation sur le blog
 */
class BlogController{

	public function listAction($param){
		echo "Methode : " . __FUNCTION__ . "<br> Parametre : " . $param;  
	}

	public function detailAction($param){
		echo "Methode : " . __FUNCTION__ . "<br> Parametre : " . $param;  

	}

	public function catAction($param){
		echo "Methode : " . __FUNCTION__ . "<br> Parametre : " . $param;  
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

$b = new BlogController();
$b->listAction(1);

?>