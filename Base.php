<?php
 /*
  * Permet d'établir la connexion
  * avec la base de données
  */
class Base{


	private static $connexion;

	/* Permet d'obtenir une connexion à la base 
	 * (Les paramètres de connexions sont stockés dans un fichier) 
	 * Il faut créer une connexion PDO distante
	 */
	public static function getConnection(){
		
		if(isset(self::$connexion)){ //si on a déjà une connexion OU isset($this->connection)
			return self::$connexion; //on la retourne
			//return $this->connexion;
		}else{//sinon
			require_once 'param_co.php';
			global $host_db, $user_db, $password_db, $bdd_db;
			try{
				$dns="mysql:host=$host;dbname=$base";
				$connexion = new PDO($dsn, $user,$pass, 
				array(PDO::ERRMODE_EXCEPTION=>true, 
				PDO::ATTR_PERSISTENT=>true));
				}catch(PDOException $e){				
					throw new BaseException("connection: $dsn ".$e->getMessage(). '<br/>');
				}
				return $connexion;
		}
	}

}

?>