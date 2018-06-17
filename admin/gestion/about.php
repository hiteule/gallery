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

$tpl= new template('about.tpl');

$data=$sql->query('SELECT count(*) AS nb_img FROM hg3_img', TRUE);
$data2=$sql->query('SELECT count(*) AS nb_cat FROM hg3_cat', TRUE);
$data3=$sql->query('SELECT count(*) AS nb_comm FROM hg3_comment', TRUE);
$data4=$sql->query('SELECT count(*) AS nb_user FROM hg3_user', TRUE);

$version_php_arr=explode('-', phpversion());
$version_mysql_arr=explode('-', mysql_get_server_info());

$tpl->parse(array(
  'nb_img'=>$data['nb_img'],
  'nb_cat'=>$data2['nb_cat'],
  'nb_comm'=>$data3['nb_comm'],
  'nb_user'=>$data4['nb_user'],
  'version_hg'=>VERSION,
  'version_php'=>$version_php_arr[0],
  'version_mysql'=>$version_mysql_arr[0],
  ));

echo $tpl->out();
?>
