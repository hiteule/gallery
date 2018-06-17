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
  var $nbr_queries=0;
  var $connect=FALSE;
  var $db='';
  
  function mysql($host, $db, $user, $pass){ // Constructeur où on se connecte
    if(($this->connect=@mysql_connect($host, $user, $pass)) != FALSE){ // On se connect
      if(@mysql_select_db($db)!=FALSE){ // On attache la BDD
        $this->db=$db;
        return TRUE;
      }
      else{
        mysql_close($this->connect);
        die('FATAL ERROR : Database connection fail.');
      }
    }
    else die('FATAL ERROR : Server database connection fail.');
  }
  
  function close(){ // Deconnexion du serveur
    if($this->connect!=FALSE) return mysql_close($this->connect);
    else return FALSE;
  }
  
  function query($query, $fetch_array=FALSE){ // Execution d'une requête
    $this->query=$query;
    if(!empty($this->query) && $this->connect!=FALSE){
      $this->result=mysql_query($this->query,$this->connect);
      $this->nbr_queries++;
      $this->error=($this->result==FALSE) ? TRUE : FALSE;
      if($fetch_array && !$this->error){
        $this->result=mysql_fetch_array($this->result);
        $this->error=($this->result===FALSE) ? TRUE : FALSE;
      }
      $this->result=($this->error) ? $this->query."\n".mysql_errno($this->connect).' : '.mysql_error($this->connect) : $this->result;
      if ($this->error) return $this->error;
      return $this->result;
    }
    $this->error=TRUE;
    $this->result='ERREUR FATALE : La requête SQL est vide.';
    die($this->result);
  }
  
  function last_id(){ // Renvoi le dernier id incrémenté
    return mysql_insert_id($this->connect);
  }
  
  function optimize(){ // Optimisations des tables
    $table=mysql_list_tables($this->db);
    $req2='OPTIMIZE TABLE';

    $req=$this->query('SHOW TABLE STATUS');
    while($data=mysql_fetch_assoc($req)){
      if($data['Data_free']>0){
        $req2.=' `'.$data['Name'].'`,';
      }
    }

    $req2=substr($req2, 0, (strlen($req2)-1));
    if($this->query($req2)==TRUE) return TRUE;
    else return FALSE;
  }
}
?>
