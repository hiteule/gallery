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

// Parsage du fichier de config général
$config = parse_ini_file('./conf/conf.ini', TRUE);

// Test de l'ouverture de la galerie
if($config['open']!=1) exit('Gallery closed');

// Inclusion du fichier de config SQL
require_once('./conf/conf.php');
// Inclusion de la classe MySQL et User
require_once('./inc/mysql.class.php');
require_once('./inc/user.class.php');

// Instanciation de la classe utilisateur
$user=new user('./conf/conf.php', './inc/mysql.class.php', './conf/conf.ini');

// Inclusion du fichier de fonction
require_once('./inc/function.php');

if(isset($logout) && $user->connect()){ // On se délog
  $user->logout();
  if(isset($uri) && !empty($uri)){
    header('Location: ./'.$uri);
    exit(0);
  }
  else{
    header('Location: ./index.php');
    exit(0);
  }
}
else{ // On se log
  if($user->connect()==TRUE){ // Déjà logué
    header('Location: ./index.php?p=error&id=5');
    exit(0);
  }

  switch($user->login($login, $pass, $connec_auto)){
    case 1: // Login OK
      header('Location: ./'.$uri);
    break;
    case -1: // Champs NOK
      header('Location: ./index.php?p=error&id=1');
    break;
    case -2: // User NOK
      header('Location: ./index.php?p=error&id=2');
    break;
    case -3: // Pass NOK
      header('Location: ./index.php?p=error&id=3');
    break;
    case -4: // Ban
      header('Location: ./index.php?p=error&id=4');
    break;
  }
  exit(0);
}
?>
