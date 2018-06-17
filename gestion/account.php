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

if($user->connect()==FALSE){
  echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=14">';
  exit(0);
}

$tpl=new template('account.tpl');

// Changement d'adresse mail
if(isset($mail, $passwd)){
  if(empty($mail) || empty($passwd)){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=1">';
    exit(0);
  }
  
  if($user->info['pass']!=md5($passwd)){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=3">';
    exit(0);
  }
  
  if(!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $mail)){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=10">';
    exit(0);
  }
  
  $sql->query('UPDATE hg3_user SET mail="'.addslashes($mail).'" WHERE id='.$user->info['id']);
  
  $tpl->parse(NULL, 'OK_MAIL');
}

// Changement passwd
elseif(isset($passwd_old, $passwd_new0, $passwd_new1)){
  if(empty($passwd_old) || empty($passwd_new0) || empty($passwd_new1)){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=1">';
    exit(0);
  }
  
  if($user->info['pass']!=md5($passwd_old)){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=3">';
    exit(0);
  }
  
  if($passwd_new0!=$passwd_new1){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=9">';
    exit(0);
  }
  
  $sql->query('UPDATE hg3_user SET pass="'.md5($passwd_new0).'" WHERE id='.$user->info['id']);

  $tpl->parse(NULL, 'OK_PASS');
}

else $tpl->parse('mail->'.stripslashes($user->info['mail']), 'FORM');

echo $tpl->out();
?>
