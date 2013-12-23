<?php

//include_once 'Base.php';
include_once 'Utilisateur.php';

echo "<h1>Utilisateur test...</h1>";

echo "<b>Test 1 : Parcours des utilisateurs :</b><br/>";
$lc = Utilisateur::findAll();
foreach($lc as $utilisateur) {
	echo $utilisateur . "<br><br>" ;
}



echo "<br><b>Test 2 : ajout d'un utilisateur :</b><br>";
$u = new Utilisateur();
$u->setAttr("login", "login_de_test2");
$u->setAttr("password", "4Wh9zuZ7");
$u->setAttr("mail", "michou.test@aol.com");

$u->insert();
echo $u;
echo "<br><br>";



echo "<b>Test 4 : retrouver par Id</b><br>";
$um = Utilisateur::findById("2");
echo $um;
echo "<br><br>";


echo "<b>Test 3 : modification d'un utilisateur : </b><br>";
$um->setAttr("login", "mr_grognon");
$um->update();
echo $um;
echo "<br><br>";



echo "<b>Test 5 : supprimer un utilisateur </b></br> ";
$num = $u->getAttr("userid");
$u->delete();
foreach(Utilisateur::findAll() as $utilisateur){
	echo "$utilisateur <br><br>";
}


echo "<b>Test 6 : afficher le nombre d'utilisateurs</b><br>";
$nb = Utilisateur::getNbUser();
echo $nb;


?>