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

class user{
  var $info=NULL;
  var $config=array();
  var $sql=NULL;
  
  function user($conf, $mysql, $confini){
    require_once($conf);
    require_once($mysql);
    // Parsage du fichier de config général
    $this->config=parse_ini_file($confini, TRUE);
  }

  function login($login, $pass, $connec_auto){
    if(($login=='') || ($pass=='')) return -1; // Tous les champs n'ont pas étés remplis
    
    // Instanciation de la classe MySQL et connection à la bdd
    $this->sql=new mysql(DBHOST, DBNAME, DBUSER, DBPASSWORD);
    $data=$this->sql->fetch('SELECT id, login, pass, hash, ban FROM hg3_user WHERE login="'.addslashes($login).'"');
    
    if(empty($data['login'])) return -2; // l'utilisateur n'éxiste pas
    if($data['pass']!=md5($pass)) return -3; // Mot de passe incorect
    if($data['ban']!=0) return -4; // Compte banni
    if(!empty($_POST['connec_auto'])){ //Connection automatique (cookie)
      $time=time()+2592000; // 30 jours
      setcookie("hg3_userid", $data['id'], $time);
      setcookie("hg3_hash", $data['hash'], $time);
    }
    else{ // Connection temporaire (session)
      $_SESSION['hg3_userid']=$data['id'];
      $_SESSION['hg3_hash']=$data['hash'];
    }
    
    return 1;
  }
  
  function logout(){
    setcookie('hg3_userid', 0, (time(NULL)-1));
    setcookie('hg3_hash', 0, (time(NULL)-1));
    session_destroy();
    $this->info=NULL;
    
    return TRUE;
  }
  
  function connect(){ // Renvoi l'état de la connexion
    if(isset($_COOKIE['hg3_userid']) && isset($_COOKIE['hg3_hash']) && !empty($_COOKIE['hg3_userid']) && !empty($_COOKIE['hg3_hash'])){
      $this->sql=new mysql(DBHOST, DBNAME, DBUSER, DBPASSWORD);
      $data=$this->sql->fetch('SELECT id, hash FROM hg3_user WHERE id='.$_COOKIE['hg3_userid']);
      
      if($data['hash']==$_COOKIE['hg3_hash']) return $_COOKIE['hg3_userid'];
      else return FALSE;
    }
    elseif(isset($_SESSION['hg3_userid']) && !empty($_SESSION['hg3_userid']) && isset($_SESSION['hg3_hash']) && !empty($_SESSION['hg3_hash'])){
      $this->sql=new mysql(DBHOST, DBNAME, DBUSER, DBPASSWORD);
      $data=$this->sql->fetch('SELECT id, hash FROM hg3_user WHERE id='.$_SESSION['hg3_userid']);
      
      if($data['hash']==$_SESSION['hg3_hash']) return $_SESSION['hg3_userid'];
      else return FALSE;
    }
    else return FALSE;
  }
  
  function info(){ // Renvoi les infos de l'utilisateurs courant
    if($this->connect()!=FALSE){
      $this->sql=new mysql(DBHOST, DBNAME, DBUSER, DBPASSWORD);
      
      $req=$this->sql->fetch('SELECT * FROM hg3_user WHERE id='.$this->connect());
      
      $this->info=$req;
      $this->info=array_map("stripslashes", $this->info);
      
      return TRUE;
    }
    else return FALSE;
  }
}
?>
