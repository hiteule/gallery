<?php
/*
* Hiteule Gallery v3
* Par Hiteule Créative - http://hiteulegallery.hiteule-creative.fr
*
* Cette application est libre et livrée sous licence Creative Commons
* Paternité-Partage des Conditions Initiales à l'Identique 3.0 Unported
* http://creativecommons.org/licenses/by-sa/3.0/deed.fr
*
* This software is free and distributed with the term of Creative Commons licence
* Attribution-Share Alike 3.0 Unported
* http://creativecommons.org/licenses/by-sa/3.0/deed.en
*/

class mysql{
  public $nbr_queries=0;

  private $pdo;
  
  function mysql($host, $db, $user, $pass){ // Constructeur où on se connecte

    try {
      $this->pdo = new PDO(sprintf('mysql:host=%s;dbname=%s', $host, $db), $user, $pass);
    } catch (PDOException $e) {
      die('FATAL ERROR : DB connection fail.');
    }
  }
  
  function query($query){ // Execution d'une requête
    $st = $this->pdo->prepare($query);
    $st->execute();

    $this->nbr_queries++;

    return $st;
  }

  function fetch($query){
    $st = $this->query($query);

    return $st->fetch();
  }

  function fetchAll($query){
    $st = $this->query($query);

    return $st->fetchAll();
  }
  
  function last_id(){ // Renvoi le dernier id incrémenté
    return $this->pdo->lastInsertId();
  }
  
  function optimize(){ // Optimisations des tables
    return TRUE;
  }

  function get_attribute($attr) {
    return $this->pdo->getAttribute($attr);
  }
}
?>
