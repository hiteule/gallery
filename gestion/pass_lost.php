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

$tpl=new template('pass_lost.tpl');

if(isset($login, $mail, $code, $_SESSION['code']) && !empty($_SESSION['code'])){

  if(empty($login) || empty($mail) || empty($code)){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=1">';
    exit(0);
  }
  
  if(!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $mail)){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=10">';
    exit(0);
  }
  
  $data=$sql->fetch('SELECT id, login, mail FROM hg3_user WHERE login="'.addslashes($login).'" AND mail="'.addslashes($mail).'"');
  
  if(empty($data['id'])){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=13">';
    exit(0);
  }
  
  if(strcmp($_SESSION['code'], strtoupper($code))!=0){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=12">';
    exit(0);
  }
  
  $list='0123456789ABCDEFGHIJKLMNOPQRSTWXYZ';
  $pass_gen='';
  for($i=0; $i<=4; $i++) $pass_gen.=$list[rand(0, 33)];
  
  $sql->query('UPDATE hg3_user SET pass="'.md5($pass_gen).'" WHERE id='.$data['id']);
  
  $message_html=$lang['PASS_LOST_MAIL0']."<br /><br />".$lang['PASS_LOST_MAIL1']."<br /><br />".$lang['PASS_LOST_MAIL2']." ".stripslashes($data['login'])."<br />".$lang['PASS_LOST_MAIL3']." ".$pass_gen."<br />";
  $message_txt=$lang['PASS_LOST_MAIL0']."\n\n".$lang['PASS_LOST_MAIL1']."\n\n".$lang['PASS_LOST_MAIL2']." ".stripslashes($data['login'])."\n".$lang['PASS_LOST_MAIL3']." ".$pass_gen."\n";
  
  send_mail(stripslashes($data['mail']), $config['title']." - Récupération de votre mot de passe", $message_html, $message_txt);

  $tpl->parse(NULL, 'VALID');
}
else $tpl->parse(NULL, 'FORM');

echo $tpl->out();
?>
