<?php

include_once 'BlogController.php';
// include_once('AdminController.php');
include_once 'Base.php';


$c = new BlogController();
$c->callAction( $_GET );

/*
$a = new AdminController();
$a->callAction( $_GET );
*/
?>