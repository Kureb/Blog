<?php


include_once 'Base.php';
include_once 'Categorie.php';

echo "<h1>Blog test ....</h1>";

echo "<b>Test 1 : parcours des catégories : </b><br/>" ;
$lc = Categorie::findAll();
foreach ($lc as $cat) {
    echo "id : " . $cat->id . "<br/>" ;
    echo "titre : " . $cat->titre . "<br/>" ;
    echo "description : " . $cat->description . "<br/><br/>" ;

}

echo "<b>Test 2 : ajout d'une catégorie : </b><br/>" ;

$c= new Categorie();
$c->titre = "categorie test";
$c->description = "description de la categorie de test";
$c->insert();
echo "Id de la nvelle categorie : " . $c->id .'<br/>';

echo "nouvelle liste : <br/>";
foreach (Categorie::findAll() as $cat) {
    echo "id : " . $cat->id . "<br/>" ;
    echo "titre : " . $cat->titre . "<br/>" ;
    echo "description : " . $cat->description . "<br/><br/>" ;

}

echo "<b>Test 3 : modification de la categorie : </b><br/>" ;
$c->description= "nouvelle descrption de la categorie de test";
$c->update();

echo "<b>Test 4 : retrouver une categorie </b><br/>";
$cm = Categorie::findById($c->id);
echo "id : " . $cm->id . "<br/>" ;
echo "titre : " . $cm->titre. "<br/>" ;
echo "description : " . $cm->description . "<br/><br/>" ;

echo "<b>Test 5 : supprimer une categorie </b><br/>";
$cm->delete();

foreach (Categorie::findAll() as $cat) {
    echo "id : " . $cat->id . "<br/>" ;
    echo "titre : " . $cat->titre . "<br/>" ;
    echo "description : " . $cat->description . "<br/><br/>" ;

}

