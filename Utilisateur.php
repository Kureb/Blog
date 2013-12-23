<?php

include 'Base.php';

class Utilisateur{

	private $userid;
	private $login;
	private $password;
	private $mail;


	public function __toString(){
		return "[".__CLASS__ . "] <br>
			userid : ". $this->userid . "<br>
			login : ". $this->getAttr("login") ."<br>
			password : ". $this->getAttr("password") ."<br>
			mail : ". $this->getAttr("mail") ;
	}



	public function getAttr($attr_name){
		if(property_exists(__CLASS__, $attr_name)){
			return $this->$attr_name;
		}
		$emess = __CLASS__ . ": unknown member $attr_name (getAttr)";
		throw new Exception($emess, 45);
	}



	public function setAttr($attr_name, $attr_val){
		if(property_exists(__CLASS__, $attr_name)){
			$this->$attr_name=$attr_val;
			return $this->$attr_name;
		}
		$emess = __CLASS__ . ": unknown member $attr_name (setAttr)";
		throw new Exception($emess, 45);
	}




	public function update(){
		if(!isset($this->userid)){
			throw new Exception(__CLASS__ . ":Clé primaire non définie, update impossible");
		}

		$c = Base::getConnection();

		$this->password = sha1($this->password);
		$query = $c->prepare("update utilisateurs set login= ?, 
					password= ?, mail= ?
					where userid= ?");

		$query->bindParam (1, $this->login, PDO::PARAM_STR);
		$query->bindParam (2, $this->password, PDO::PARAM_STR);
		$query->bindParam (3, $this->mail, PDO::PARAM_STR);
		$query->bindParam (4, $this->userid, PDO::PARAM_STR);


		return $query->execute();

	}





	public function delete(){
		$nb = 0;
		if(isset($this->userid)){
			$query = "DELETE FROM Utilisateurs Where userid =" . $this->userid;
			$c = Base::getConnection();
			$nb = $c->exec($query);
		}
		return $nb;
	}



	public function insert(){
		$nb = 0;
		$query = "INSERT INTO Utilisateurs VALUES(null, '".$this->login."','".sha1($this->password)."', '".$this->mail."')";
		$c = Base::getConnection();
		$nb = $c->exec($query);
		$this->setAttr("userid", $c->LastInsertId());

		return $nb;
	}



	public static function findById($userid){
		$c = Base::getConnection();
		$query = 'select * from utilisateurs where userid= :userid';
		$dbres = $c->prepare($query);
		$dbres->bindParam(':userid', $userid);
		$dbres->execute();
		$user = false;
		$d = $dbres->fetch(PDO::FETCH_OBJ);

		$user = new Utilisateur();
		$user->setAttr("userid", $d->userid);
		$user->setAttr("login", $d->login);
		$user->setAttr("password", $d->password);
		$user->setAttr("mail", $d->mail);

		return $user;
	}




	public static function findAll(){
		$query = "select * from utilisateurs";
		$c = Base::getConnection();
		$dbres = $c->prepare($query);
		$dbres->execute();
		$d = $dbres->fetchAll();
		$tab = Array();
		foreach ($d as $ligne) {
			$user = new Utilisateur();
			$user->setAttr("userid", $ligne["userid"]);
			$user->setAttr("login", $ligne["login"]);
			$user->setAttr("password", $ligne["password"]);
			$user->setAttr("mail", $ligne["mail"]);
			array_push($tab, $user);
		}

		return $tab;
	}




	public static function findByLogin($login){
		$c = Base::getConnection();
		$query = 'select * from utilisateurs where login= :login';
		$dbres = $c->prepare($query);
		$dbres->bindParam(':login', $login);
		$user = false;
		$d = $dbres->fetch(PDO::FETCH_OBJ);

		$user = new Utilisateur();
		$user->setAttr("userid", $d->userid);
		$user->setAttr("login", $d->login);
		$user->setAttr("password", $d->password);
		$user->setAttr("mail", $d->mail);

		return $user;
	}



	public static function getNbUser(){
		$query = "select count(*) as nb from utilisateurs";
		$c = Base::getConnection();
		$res = $c->query($query);
		$data = $res->fetch();
		$nb = $data['nb'];

		return $nb;
	}


}

?>