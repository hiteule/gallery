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

// Initialisation des sessions
session_start();

// Inclusion du fichier de config SQL
require('../../conf/conf.php');

// Inclusion de la classe de gestion MySQL
require_once('../../inc/mysql.class.php');

// Instanciation de la classe MySQL et connection à la bdd
$sql=new mysql(DBHOST, DBNAME, DBUSER, DBPASSWORD);
// On spécifie qu'on bosse en utf8
$sql->query("SET NAMES 'utf8'");

// Inclusion et instanciation de la classe d'utilisateur
require_once('../../inc/user.class.php');

$user=new user('../../conf/conf.php', '../../inc/mysql.class.php', '../../conf/conf.ini'); // Instanciation de la classe de gestion utilisateur
if($user->connect()) $user->info(); // Récupération des infos de l'utilisateur courant

if($user->connect()==FALSE || $user->info['admin']!=1) exit(0);
else{
  $backup="--\n-- Dump of ".$sql->db." at ".date('d-m-Y  H\hi:s')."\n--\n";

  $req0=$sql->query('SHOW TABLES');
  while(list($data0)=mysql_fetch_row($req0)){
    if(substr($data0, 0, 4)=='hg3_'){
      $backup.="\n--\n-- Table ".$data0."\n--\n\nDROP TABLE IF EXISTS ".$data0.";\n";

      $req1=$sql->query('SHOW CREATE TABLE '.$data0);
      $data1=mysql_fetch_array($req1);
      $backup.=$data1[1].";\n\n--\n-- Insert ".$data0."\n--\n\n";

      $req2=$sql->query("SELECT * FROM ".$data0);
      while($data2=mysql_fetch_assoc($req2)){
        $l_i="INSERT INTO ".$data0." (";
        $l_v=") VALUES (";
        foreach($data2 as $k=>$v){
          $l_i.="`".$k."`, ";
          $l_v.="'".mysql_real_escape_string($v)."', ";
        }
        $l_i=substr($l_i, 0, -2);
        $l_v=substr($l_v, 0, -2);
        $backup.=$l_i.$l_v.");\n";
      }
    }
  }
  
  $sql->close();

  header("Content-type: text/sql");
  header("Content-disposition: attachment; filename=".$sql->db."-".date('d_m_Y').".sql");
  echo $backup;
}
?>
