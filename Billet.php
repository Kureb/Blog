<?php 
include 'Categorie.php';
include_once 'Base.php';

class Billet{

	private $id;
	private $titre;
	private $body;
	private $auteur;
	private $date;
	private $cat_id;


	public function __construct(){}

	
public function __toString(){
	return "[".__CLASS__ . "] <br>
			id : ". $this->id . "<br>
			titre : ". $this->getAttr("titre") ."<br>
			body : ". $this->getAttr("body") ."<br>
			cat_id : ". $this->getAttr("cat_id") ."<br>
			date : ". $this->getAttr("date") ;
}

	public function getAttr($attr_name){
		if(property_exists(__CLASS__, $attr_name)){
			return $this->$attr_name;
		}
		$emess = __CLASS__ . ": unknow member $attr_name (getAttr)";
	}


	public function setAttr($attr_name, $attr_val){
		if(property_exists(__CLASS__, $attr_name)){
			$this->$attr_name = $attr_val;
		}
		$emess = __CLASS__ . ":unknow member $attr_name (setAttr)";
	}


	public function update(){
		if(!isset($this->id)){
			throw new Exception(__CLASS__ . ": Primary Key undifined : cannot update");	
		}

		$c = Base::getConnection();

		$query = $c->prepare ("update billets set titre= ?, body= ?,
								date= ?, cat_id= ?
								where id= ?");

		//Liaison des paramètres
		$query->bindParam (1, $this->titre, PDO::PARAM_STR);
		$query->bindParam (2, $this->body, PDO::PARAM_STR);
		//$query->bindParam (3, $this->auteur, PDO::PARAM_STR);
		$today = date("Y-m-d H:i:s");
		$query->bindParam (3, $today, PDO::PARAM_STR);//date est considérée comme String
		$query->bindParam (4, $this->cat_id, PDO::PARAM_STR);
		$query->bindParam (5, $this->id, PDO::PARAM_STR);

		//exécution de la requête
		//return 
		return $query->execute();
	}


	public function delete(){
		$nb = 0;
		if(isset($this->id)){
			$query = "DELETE FROM Billets Where id = " . $this->id;
			$c = Base::getConnection();
			$nb = $c->exec($query);
		}

		return $nb;
	}



	public function insert(){
		$nb = 0;
	    $query = "INSERT INTO Billets VALUES(null,'".$this->titre."', '".$this->body."', '".$this->cat_id."', '".$this->date."')";
/*
		$query = "INSERT INTO Billets VALUES(null,
											 ".$this->getAttr("titre").",
											 ".$this->getAttr("body").",
											 ".$this->getAttr("cat_id").",
											 ".$this->getAttr("date").")";
*/
		$c = Base::getConnection();
		$nb = $c->exec($query);
		$this->setAttr("id", $c->LastInsertId());
		return $nb;
		
	}



	public static function findById($id){
		$c = Base::getConnection();
		$query = 'select * from billets where id= :id';
		$dbres = $c->prepare($query);
		$dbres->bindParam(':id', $id);
		$dbres->execute();
		$bill = false;
		$d = $dbres->fetch(PDO::FETCH_OBJ);
		//echo "var_dump(d)";
		//var_dump($d);
		$bill = new Billet();
		$bill->setAttr("id", $d->id);
		$bill->setAttr("titre", $d->titre);
		$bill->setAttr("body", $d->body);
		$bill->setAttr("cat_id", $d->cat_id);
		$bill->setAttr("date", $d->date);


		return $bill;
	}




	public static function findAll(){
		$query = "select * from billets";
		$pdo = Base::getConnection();
		$dbres = $pdo->prepare($query);
		$dbres->execute();
		$d = $dbres->fetchAll();
		$tab = Array();
		foreach($d as $ligne){
			$billet = new Billet();
			$billet->setAttr("id", $ligne["id"]);
			$billet->setAttr("titre", $ligne["titre"]);
			$billet->setAttr("body", $ligne["body"]);
			$billet->setAttr("cat_id", $ligne["cat_id"]);
			$billet->setAttr("date", $ligne["date"]);
			array_push($tab, $billet);
		}

		return $tab;
	}




	public static function findByTitre($titre){
		$query = "select * from billets where titre = :titre";
		$c = Base::getConnection();
		$dbres = $c->prepare($query);
		$dbres->bindParam(':titre', $titre);
		$dbres->execute();
		$billet = false;
		if($dbres!=false){
			$d = $dbres->fetch(PDO::FETCH_OBJ);
			$billet = new Billet();
			$billet = new Billet();
			$billet->setAttr("id", $d->id);
			$billet->setAttr("titre", $d->titre);
			$billet->setAttr("body", $d->body);
			$billet->setAttr("cat_id", $d->cat_id);
			$billet->setAttr("date", $d->date);
		}else{
			echo "Erreur, billet introuvable";
		}

		return billet;
	}



	public static function findUnCertainNombre($debut, $fin){
		$query = "select * from billets order by date DESC LIMIT " . $debut .", " . $fin;
		$c = Base::getConnection();
		$dbres = $c->prepare($query);
		$dbres->execute();
		$d = $dbres->fetchAll();
		$tab = Array();
		foreach($d as $ligne){
			$billet = new Billet();
			$billet->setAttr("id", $ligne["id"]);
			$billet->setAttr("titre", $ligne["titre"]);
			$billet->setAttr("body", $ligne["body"]);
			$billet->setAttr("cat_id", $ligne["cat_id"]);
			$billet->setAttr("date", $ligne["date"]);
			array_push($tab, $billet);
		}

		return $tab;

	}

}

?>