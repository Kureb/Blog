
<?php

include_once 'AdminController.php';
include_once 'Base.php';

/* Même modèle que blog.php 
 * Construit le contrôleur adéquat 
 * puis appelle fonction principale en 
 * passant en paramètre l'URL
 */


$c = new AdminController();
$c->callAction( $_GET );


?>