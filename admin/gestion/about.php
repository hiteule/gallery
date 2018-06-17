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

$data=$sql->fetch('SELECT count(*) AS nb_img FROM hg3_img');
$data2=$sql->fetch('SELECT count(*) AS nb_cat FROM hg3_cat');
$data3=$sql->fetch('SELECT count(*) AS nb_comm FROM hg3_comment');
$data4=$sql->fetch('SELECT count(*) AS nb_user FROM hg3_user');

$version_php_arr=explode('-', phpversion());
$version_mysql_arr=explode('-', $sql->get_attribute(PDO::ATTR_SERVER_VERSION));

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
