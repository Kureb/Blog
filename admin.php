<?php

include_once 'AdminController.php';
include_once 'Base.php';


$c = new AdminController();
$c->callAction( $_GET );