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
  echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=7">';
  exit(0);
}

$tpl=new template('login.tpl');

if(!isset($uri) || empty($uri) || $uri=='?p=login' || $uri=='?p=subscribe') $uri='index.php';

$tpl->parse('uri->'.urldecode($uri));

echo $tpl->out();
?>
