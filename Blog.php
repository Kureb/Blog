<?php
echo "<p>passez des parametres valides (cf sujet) pour tester !</p>";
include 'BlogController.php';
$c = new BlogController;
$c->callAction( $_GET );

?>