<?php 
include 'Categorie.php';
include_once 'Base.php';

class Billet{

	private $id;
	private $titre;
	private $body;
	private $auteur;
	private $date;
	private $cat_id; //Id de la catégorie
	



	/* Retourne les infos d'un billet */	
	public function __toString(){
		return "[".__CLASS__ . "] <br>
		id : ". $this->getAttr("id") . "<br>
		titre : ". $this->getAttr("titre") ."<br>
		body : ". $this->getAttr("body") ."<br>
		cat_id : ". $this->getAttr("cat_id") ."<br>
		date : ". $this->getAttr("date") . "<br>
		auteur : ". $this->getAttr("auteur");
	}

	//Getter
	public function getAttr($attr_name){
		if(property_exists(__CLASS__, $attr_name)){
			return $this->$attr_name;
		}
		$emess = __CLASS__ . ": unknow member $attr_name (getAttr)";
	}


	//Setter
	public function setAttr($attr_name, $attr_val){
		if(property_exists(__CLASS__, $attr_name)){
			$this->$attr_name = $attr_val;
		}
		$emess = __CLASS__ . ":unknow member $attr_name (setAttr)";
	}


	//Met à jour le billet
	public function update(){
		$c = Base::getConnection();

		$query = $c->prepare ("update billets set titre= ?, body= ?,
			date= ?, cat_id= ?, auteur= ?
			where id= ?");

		//Liaison des paramètres
		$query->bindParam (1, $this->titre, PDO::PARAM_STR);
		$query->bindParam (2, $this->body, PDO::PARAM_STR);
		$today = date("Y-m-d H:i:s");
		$query->bindParam (3, $today, PDO::PARAM_STR);//date est considérée comme String
		$query->bindParam (4, $this->cat_id, PDO::PARAM_STR);
		$query->bindParam (5, $this->auteur, PDO::PARAM_STR);
		$query->bindParam (6, $this->id, PDO::PARAM_STR);

		//exécution de la requête
		return $query->execute();
	}


	//Supprime un billet
	//Retourne 0 si erreur, 1 sinon
	public function delete(){
		$nb = 0;
		if(isset($this->id)){
			$query = "DELETE FROM billets Where id = " . $this->id;
			$c = Base::getConnection();
			$nb = $c->exec($query);
		}
		return $nb;
	}



	//Insère un billet
	//Retourne 0 si erreur, & sinon
	public function insert(){
		$nb = 0;
		$query = "INSERT INTO billets VALUES(null,'".$this->titre."', '".$this->body."', '".$this->cat_id."', '".$this->date."', '".$this->auteur."')";
		$c = Base::getConnection();
		$nb = $c->exec($query);
		$this->setAttr("id", $c->LastInsertId());
		return $nb;
		
	}


	//Recherche un billet par son ID
	public static function findById($id){
		$c = Base::getConnection();
		$query = 'select * from billets where id= :id';
		$dbres = $c->prepare($query);
		$dbres->bindParam(':id', $id);
		$dbres->execute();
		$bill = false;
		$d = $dbres->fetch(PDO::FETCH_OBJ);
		if($d!=false)
		{		
			$bill = new Billet();
			$bill->setAttr("id", $d->id);
			$bill->setAttr("titre", $d->titre);
			$bill->setAttr("body", $d->body);
			$bill->setAttr("cat_id", $d->cat_id);
			$bill->setAttr("date", $d->date);
			$bill->setAttr("auteur", $d->auteur);
		}


		return $bill;
	}



	//Retourne tous les billets dans un tableau
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
			$billet->setAttr("auteur", $ligne["auteur"]);
			array_push($tab, $billet);
		}

		return $tab;
	}




	//Retourne le billet qui a le titre passé en paramètre s'il existe
	public static function findByTitre($titre){
		$query = "select * from billets where titre = :titre";
		$c = Base::getConnection();
		$dbres = $c->prepare($query);
		$dbres->bindParam(':titre', $titre);
		$dbres->execute();
		$d = $dbres->fetch(PDO::FETCH_OBJ);
		$billet = false;
		if($d!=false){
			$billet = new Billet();
			$billet->setAttr("id", $d->id);
			$billet->setAttr("titre", $d->titre);
			$billet->setAttr("body", $d->body);
			$billet->setAttr("cat_id", $d->cat_id);
			$billet->setAttr("date", $d->date);
			$billet->setAttr("auteur", $d->auteur);
		}else{
			echo "Erreur, billet introuvable";
		}

		return $billet;
	}



	//Retourne les billets d'une certains catégorie
	public static function findByCategorie($cat_id){
		$query = "select * from billets where cat_id = :cat_id";
		$c = Base::getConnection();
		$dbres = $c->prepare($query);
		$dbres->bindParam(':cat_id', $cat_id);
		$dbres->execute();
		$d = $dbres->fetchAll();
		$tab = Array();
		if($d!=false){
			foreach ($d as $ligne) {
				$billet = new Billet();
				$billet->setAttr("id", $ligne["id"]);
				$billet->setAttr("titre", $ligne["titre"]);
				$billet->setAttr("body", $ligne["body"]);
				$billet->setAttr("cat_id", $ligne["cat_id"]);
				$billet->setAttr("date", $ligne["date"]);
				$billet->setAttr("auteur", $ligne["auteur"]);
				array_push($tab, $billet);
			}
		}

		return $tab;
	}



	//Retourne un nombre de billet (de $debut à $fin)
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
			$billet->setAttr("auteur", $ligne["auteur"]);
			array_push($tab, $billet);
		}

		return $tab;

	}



	//Retourne le nombre total de billets
	//(utile pour la pagination)
	public static function getNbBillet(){
		$query = "select count(*) as nb from billets";
		$c = Base::getConnection();
		$res = $c->query($query);
		$data = $res->fetch();
		$nb = $data['nb'];

		return $nb;
	}


	//Retourne tous les billets d'un auteur
	public static function findByAuteur($auteur){
		$query = "select * from billets where auteur = :auteur";
		$c = Base::getConnection();
		$dbres = $c->prepare($query);
		$dbres->bindParam(':auteur', $auteur);
		$dbres->execute();
		$d = $dbres->fetchAll();
		$billet = false;
		$tab = Array();
		if($d!=false){
			foreach ($d as $ligne) {
				$billet = new Billet();
				$billet->setAttr("id", $ligne["id"]);
				$billet->setAttr("titre", $ligne["titre"]);
				$billet->setAttr("body", $ligne["body"]);
				$billet->setAttr("cat_id", $ligne["cat_id"]);
				$billet->setAttr("date", $ligne["date"]);
				$billet->setAttr("auteur", $ligne["auteur"]);
				array_push($tab, $billet);
			}

		}

		return $tab;
	}

}

?>