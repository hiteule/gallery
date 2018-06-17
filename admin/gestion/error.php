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

if(!isset($user) || $user->connect()==FALSE || $user->info['admin']!=1) exit(0);

switch(intval($id)){
  case 1: $error_txt=$lang['ERROR1']; break;
  case 2: $error_txt=$lang['ERROR2']; break;
  case 3: $error_txt=$lang['ERROR3']; break;
  case 4: $error_txt=$lang['ERROR4']; break;
  case 5: $error_txt=$lang['ERROR5']; break;
  case 6: $error_txt=$lang['ERROR6']; break;
  case 7: $error_txt=$lang['ERROR7']; break;
  case 8: $error_txt=$lang['ERROR8']; break;
  case 9: $error_txt=$lang['ERROR9']; break;
  default: $error_txt=$lang['ERRORUNDEFINE']; break;
}

$tpl=new template('error.tpl');
$tpl->parse(array(
  'id_error'=>intval($id),
  'error_txt'=>$error_txt));
echo $tpl->out();
?>
