<?php

/* Déconnecte l'utilisateur */
session_start();
session_unset();
session_destroy();
header('Location: connexion.php');

?>