<?php
include_once('BlogController.php');
include_once('AdminController.php');
echo "<p>passez des parametres valides (cf sujet) pour tester !</p>";
$c = new BlogController;
$c->callAction( $_GET );

$a = new AdminController();
$a->callAction( $_GET );

?>