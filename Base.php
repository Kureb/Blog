<?php
 /*
  * Permet d'établir la connexion
  * avec la base de données
  * BOULANGER Vincent & DAUSSY Alexandre
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
			//echo "deja connecte";
		}else{//sinon
			require_once 'param_co.php';
			global $host, $user, $pass, $base;
			try{
				$dns="mysql:host=$host;dbname=$base";
				$connexion = new PDO($dns, $user,$pass,	
					array(PDO::ERRMODE_EXCEPTION=>true, 
					PDO::ATTR_PERSISTENT=>true));
				$connexion->exec("SET CHARACTER SET utf8");
				}catch(PDOException $e){				
					throw new BaseException("connection: $dsn ".$e->getMessage(). '<br/>');
				}
				//echo "connexion !";
				return $connexion;
		}
	}

}

?>