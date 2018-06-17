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

$tpl=new template('dashboard.tpl');

$data0=$sql->query('SELECT count(id) AS id FROM hg3_cat', TRUE);
$data1=$sql->query('SELECT count(id) AS id FROM hg3_img', TRUE);
$data2=$sql->query('SELECT count(id) AS id FROM hg3_comment', TRUE);
$data3=$sql->query('SELECT count(id) AS id FROM hg3_user', TRUE);

$tpl->parse(array(
  'nb_cat'=>$data0['id'],
  'nb_img'=>$data1['id'],
  'nb_comment'=>$data2['id'],
  'nb_user'=>$data3['id']));
  
echo $tpl->out();
?>
