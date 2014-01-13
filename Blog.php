<?php

include_once 'BlogController.php';
include_once 'Base.php';

/* Même modèle que admin.php 
 * Construit le contrôleur adéquat 
 * puis appelle fonction principale en 
 * passant en paramètre l'URL
 */

$c = new BlogController();
$c->callAction( $_GET );


?>