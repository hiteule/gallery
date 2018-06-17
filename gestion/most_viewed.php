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

$tpl=new template('most_viewed.tpl');

$req=$sql->query('SELECT id, id_cat, id_souscat, link, name FROM hg3_cat WHERE id_souscat=0 ORDER BY link');
while($data=mysql_fetch_array($req)){
  $id=NULL;
  $name=NULL;
  
  foreach(parent_cat($data['id'], $sql) as $k=>$v){
    if($id!=NULL) $name.=' &raquo; ';
    $name.=$v;
    $id=$k;
  }
  
  $tpl->parse(array(
    'name'=>$name,
    'id'=>$id), 'CAT');
}

$i=0;
$where=(isset($cat) && !empty($cat) && $cat!='all') ?  ' WHERE hg3_img.id_cat='.intval($cat) : '';

$req=$sql->query('SELECT hg3_img.id AS id_img, hg3_img.id_cat, hg3_img.file, hg3_img.name, hg3_img.nb_view, hg3_cat.id AS id_cat, hg3_cat.link FROM hg3_img LEFT JOIN hg3_cat ON hg3_cat.id=hg3_img.id_cat'.$where.' ORDER BY hg3_img.nb_view DESC LIMIT 0, '.intval($config['number_most_viewed']));
while($data=mysql_fetch_array($req)){
  $i++;
  if($i>=$config['img_per_line']){
    $tpl->parse('', 'IMG.LINE');
    $i=0;
  }

  $tn_link=(isset($data['link']) && !empty($data['link']) && is_file('./gallery/'.$data['link'].'/TN/TN-'.$data['file'])) ? './gallery/'.$data['link'].'/TN/TN-'.$data['file'] : './themes/'.$config['theme'].'/'.$config_theme['no_tn'];

  $tpl->parse(array(
    'id_img'=>$data['id_img'],
    'tn_link'=>$tn_link,
    'name'=>stripslashes($data['name']),
    'nb_view'=>$data['nb_view']), 'IMG');
}

if($i!=0 && $i<$config['img_per_line']){
  for($j=$i; $j<$config['img_per_line']; $j++) $tpl->parse('', 'EMPTY_IMG');
}

echo $tpl->out();
?>
