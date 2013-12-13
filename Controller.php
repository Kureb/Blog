<?php

/* Classe abstraite qui définit la méthode callAction
 * dont va hériter AdminController et BlogController
 * BOULANGER Vincent & DAUSSY Alexandre 
 */
abstract class Controller{

	abstract public function callAction($tab);

}

?>