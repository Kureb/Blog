<?php
include 'BlogController.php';
echo "<p>passez des parametres valides (cf sujet) pour tester !</p>";
$c = new BlogController;
$c->callAction( $_GET );

?>