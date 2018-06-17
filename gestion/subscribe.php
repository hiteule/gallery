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

if($user->connect()==TRUE){
  echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=8">';
  exit(0);
}

$valid=0;

if(isset($login, $passwd, $passwd_confirm, $mail, $code, $_SESSION['code']) && !empty($_SESSION['code'])){
  if(empty($login) || empty($passwd) || empty($passwd_confirm) || empty($mail)){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=1">';
    exit(0);
  }
  
  if(strcmp($passwd, $passwd_confirm)!=0){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=9">';
    exit(0);
  }
  
  if(!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $mail)){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=10">';
    exit(0);
  }
  
  $data=$sql->fetch('SELECT login FROM hg3_user WHERE login="'.addslashes($login).'"');
  
  if(!empty($data['login'])){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=11">';
    exit(0);
  }

  if(strcmp($_SESSION['code'], strtoupper($code))!=0){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=12">';
    exit(0);
  }

  $sql->query('INSERT INTO hg3_user (login, pass, hash, mail, ban, admin) VALUES("'.addslashes($login).'", "'.md5($passwd).'", "'.md5(rand(0, 9999999999)).'", "'.addslashes($mail).'", 0, 0)');
  
  $valid=1;
}

$tpl=new template('subscribe.tpl');

if($valid) $tpl->parse(NULL, 'VALID');
else $tpl->parse(NULL, 'FORM');

echo $tpl->out();
?>
