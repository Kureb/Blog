<?php 
	

include_once 'Base.php';
include_once 'Billet.php';

echo "<h1>Billet test ....</h1>";

echo "<b>Test 1 : Parcours des billets : </b><br/>";
$lc = Billet::findAll();
foreach($lc as $billet){
	echo "id : " . $billet->getAttr("id") . "<br>";
	echo "titre : " . $billet->getAttr("titre") . "<br>";
	echo "contenu : " . $billet->getAttr("body") . "<br/>";
	echo "categeorie : " . $billet->getAttr("cat_id") . "<br/>";
	echo "date : " . $billet->getAttr("date") . "<br/><br>";
}



echo "<br><b>Test 2: ajout d'un billet :</b></br>";
$b = new Billet();
$b->setAttr("titre", "Billet test lol");
$b->setAttr("body", "Mangeol aime manger");
$b->setAttr("id", 5);
$b->setAttr("cat_id", 1);
$b->setAttr("date", date("Y-m-d H:i:s"));

$b->insert();
echo "titre du nouveau billet : " . $b->getAttr("titre") ."<br>";
echo $b;
echo "<br><br>";



echo "<b>Test 3 : modification d'un billet : </b><br>";
$b->setAttr("body", "Je modifie le body wesh");
$b->update();
echo $b;
echo "<br><br>";


echo "<b>Test 4 : retrouver par Id</b><br>";
//var_dump($b->getAttr("id"));
$bm = Billet::findById(/*$b->getAttr("id")*/2);
echo $bm;
echo "<br><br>";


echo "<b>Test 5 : supprimer un billet </b></br> ";
$b->delete();
foreach(Billet::findAll() as $billet){
	echo "id : " . $billet->getAttr("id") . "<br>";
	echo "titre : " . $billet->getAttr("titre") . "<br>";
	echo "contenu : " . $billet->getAttr("body") . "<br/>";
	echo "categeorie : " . $billet->getAttr("cat_id") . "<br/>";
	echo "date : " . $billet->getAttr("date") . "<br/><br>";
}



echo "<b>Test 6 : afficher que X billets </b><br>";
foreach(Billet::findUnCertainNombre(0,2) as $billet){
	echo "id : " . $billet->getAttr("id") . "<br>";
	echo "titre : " . $billet->getAttr("titre") . "<br>";
	echo "contenu : " . $billet->getAttr("body") . "<br/>";
	echo "categeorie : " . $billet->getAttr("cat_id") . "<br/>";
	echo "date : " . $billet->getAttr("date") . "<br/><br>";
}


?>