<?php

  /**
   * File : Categorie.php
   *
   * @author G. Canals
   *
   *
   * @package blog
   */

/**
 *  La classe Categorie
 *
 *  La Classe Categorie  realise un Active Record sur la table categorie
 *  
 *
 *  @package blog
 */
class Categorie {



  /**
   *  Identifiant de categorie
   *  @access private
   *  @var integer
   */
  private $id ; 


  /**
   *  libelle de categorie
   *  @access private
   *  @var String
   */
  private $titre;

  /**
   *  description de categorie
   *  @access private
   *  @var String
   */
  private $description;





  /**
   *  Constructeur de Categorie
   *
   *  fabrique une nouvelle categorie vide
   */
  
  public function __construct() {
    // rien à faire
  }


  /**
   *  Magic pour imprimer
   *
   *  Fonction Magic retournant une chaine de caracteres imprimable
   *  pour imprimer facilement un Ouvrage
   *
   *  @return String
   */
  public function __toString() {
        return "[". __CLASS__ . "] id : ". $this->id . ":
				   titre  ". $this->titre  .":
				   description ". $this->description  ;
  }

  /**
   *   Getter magique
   *
   *   fonction d'acces aux attributs d'un objet.
   *   Recoit en parametre le nom de l'attribut accede
   *   et retourne sa valeur.
   *  
   *   @param String $attr_name attribute name 
   *   @return mixed
   */


  
   
   public function __get($attr_name) {
    if (property_exists( __CLASS__, $attr_name)) { 
      return $this->$attr_name;
    } 
    $emess = __CLASS__ . ": unknown member $attr_name (getAttr)";
    throw new Exception($emess, 45);
  }

  
  /**
   *   Setter magique
   *
   *   fonction de modification des attributs d'un objet.
   *   Recoit en parametre le nom de l'attribut modifie et la nouvelle valeur
   *  
   *   @param String $attr_name attribute name 
   *   @param mixed $attr_val attribute value
   *   @return mixed new attribute value
   */
    public function __set($attr_name, $attr_val) {
    
    /**
     *   A ECRIRE
     */


    //$emess = __CLASS__ . ": unknown member $attr_name (setAttr)";
    throw new Exception("methode setAttr à écrire");
    
  }

  /**
   *   mise a jour de la ligne courante
   *   
   *   Sauvegarde l'objet courant dans la base en faisant un update
   *   l'identifiant de l'objet doit exister (insert obligatoire auparavant)
   *   méthode privée - la méthode publique s'appelle save
   *   @acess public
   *   @return int nombre de lignes mises à jour
   */
  public function update() {
    
    if (!isset($this->id)) {
      throw new Exception(__CLASS__ . ": Primary Key undefined : cannot update");
    } 

    $c = Base::getConnection();
    

    $query = $c->prepare( "update categorie set titre= ?, description= ?
				                   where id=?");
    
    /* 
     * liaison des paramêtres : 
    */
    $query->bindParam (1, $this->titre, PDO::PARAM_STR);
    $query->bindParam (2, $this->description, PDO::PARAM_STR); 
    $query->bindParam (3, $this->id, PDO::PARAM_INT); 

    /*
     * exécution de la requête
     */

    return $query->execute();


  }


  /**
   *   Suppression dans la base
   *
   *   Supprime la ligne dans la table corrsepondant à l'objet courant
   *   L'objet doit posséder un OID
   */
  public function delete() {
    
    /**
     *  A ECRIRE
     *  CONSTRUIT PUIS EXECUTE LA REQUETE
     *  DELETE FROM Categorie Where id = xxx
     *  RETOURNE LE NOMBRE DE LIGNES SUPPRIMEES
     *
     */
    throw new Exception("méthode delete() non implantée");
  }
		
		
  /**
   *   Insertion dans la base
   *
   *   Insère l'objet comme une nouvelle ligne dans la table
   *   l'objet doit posséder  un code_rayon
   *
   *   @return int nombre de lignes insérées
   */									
  public function insert() {

   /*
    *  A ECRIRE :
    *  CONSTRUIT et exécute LA REQUETE
    *  INSERT INTO Categorie (titre, description) VALUES ( 'titre', 'desription' )
    *  PUIS PLACE LA VALEUR DE ID (AUTO-INCREMENT)
    *  DANS L'OBJET COURANT (UTILISE pour cela LA méthode pdo LastInsertId)
    *
    *
    */
   throw new Exception("méthode insert() non implantée");
  }
		

 /**
   *   Finder sur ID
   *
   *   Retrouve la ligne de la table correspondant au ID passé en paramètre,
   *   retourne un objet
   *  
   *   @static
   *   @param integer $id OID to find
   *   @return Categorie renvoie un objet de type Categorie
   */
    public static function findById($id) {

      $c = Base::getConnection();
      $query = $c->prepare("select * from categorie where id=?") ;
      $query->bindParam(1, $id, PDO::PARAM_INT);
      $dbres = $query->execute();

      $d = $query->fetch(PDO::FETCH_BOTH);
      

      /**
       *   A COMPLETER : CREER UN OBJET A PARTIR DE LA LIGNE
       *   OBJET INSTANCE DE LA CLASSE Categorie
       *
       */
      throw new Exception("méthode findById() à completer");

    }

    
    /**
     *   Finder All
     *
     *   Renvoie toutes les lignes de la table categorie
     *   sous la forme d'un tableau d'objet
     *  
     *   @static
     *   @return Array renvoie un tableau de categorie
     */
    
    public static function findAll() {

    /**
     *    A ECRIRE ENTIEREMENT
     *    SELECTIONNE TOUTES LES LIGNES DE LA TABLE
     *    ET LES RETOURNE SOUS LA FORME D'UN TABLEU D'OBJETS
     *
     *
     */

    }
}

