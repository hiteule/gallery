<?php
/*
* Hiteule Gallery v3.0.1
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

define('IMG_PER_LINE', 3);

// Mise à jour des noms
if(isset($_POST['img_name']) && !empty($_POST['img_name']) && is_array($_POST['img_name'])){
  foreach($_POST['img_name'] as $k=>$v) $sql->query('UPDATE hg3_img SET name="'.addslashes($v).'" WHERE id='.$k);
}
// Transferts d'images
if(isset($_POST['img_check'], $transfert_del, $transfert_cat, $cur_cat) && !empty($_POST['img_check']) && !empty($transfert_del) && !empty($transfert_cat) && $transfert_del=='transfert' && $transfert_cat!='none' && !empty($cur_cat) && is_array($_POST['img_check'])){
  foreach($_POST['img_check'] as $k=>$v){
    $data4=$sql->query('SELECT hg3_img.id AS id_img, hg3_img.file, cat_old.id AS id_old, cat_old.link AS link_old, cat_new.id AS id_new, cat_new.link AS link_new
      FROM hg3_cat AS cat_old LEFT JOIN hg3_cat AS cat_new ON cat_new.id='.intval($transfert_cat).' LEFT JOIN hg3_img ON hg3_img.id='.intval($k).'
      WHERE cat_old.id='.intval($cur_cat), TRUE);

    rename('../gallery/'.$data4['link_old'].'/'.$data4['file'], '../gallery/'.$data4['link_new'].'/'.$data4['file']);
    if(!is_dir('../gallery/'.$data4['link_new'].'/TN')) mkdir('../gallery/'.$data4['link_new'].'/TN', 0700);
    if(is_file('../gallery/'.$data4['link_old'].'/TN/TN-'.$data4['file'])) rename('../gallery/'.$data4['link_old'].'/TN/TN-'.$data4['file'], '../gallery/'.$data4['link_new'].'/TN/TN-'.$data4['file']);
    $sql->query('UPDATE hg3_img SET id_cat='.intval($transfert_cat).' WHERE id='.intval($k));
    maj_cat($transfert_cat, $data4['link_new']);
    maj_cat($cur_cat, $data4['link_old']);
  }
}
// Suppression d'images
if(isset($_POST['img_check'], $transfert_del, $cur_cat) && !empty($_POST['img_check']) && !empty($transfert_del) && $transfert_del=='del' && !empty($cur_cat) && is_array($_POST['img_check'])){
  foreach($_POST['img_check'] as $k=>$v){
    $data5=$sql->query('SELECT hg3_img.id AS id_img, hg3_img.id_cat AS id_cat, hg3_img.file, hg3_cat.id, hg3_cat.link FROM hg3_img LEFT JOIN hg3_cat ON hg3_img.id_cat=hg3_cat.id WHERE hg3_img.id='.intval($k), TRUE);

    unlink('../gallery/'.$data5['link'].'/'.$data5['file']);
    if(is_file('../gallery/'.$data5['link'].'/TN/TN-'.$data5['file'])) unlink('../gallery/'.$data5['link'].'/TN/TN-'.$data5['file']);
    $sql->query('DELETE FROM hg3_img WHERE id='.$data5['id_img']);
    $sql->query('DELETE FROM hg3_comment WHERE id_img='.$data5['id_img']);
  }
  maj_cat($cur_cat, $data5['link']);
}

$tpl=new template('img.tpl');

if(isset($id) && !empty($id)){
  $i=0;
  $req2=$sql->query('SELECT hg3_img.id AS id_img, hg3_img.id_cat, hg3_img.file, hg3_img.name, hg3_cat.id AS id_cat, hg3_cat.link FROM hg3_img LEFT JOIN hg3_cat ON hg3_cat.id=hg3_img.id_cat WHERE hg3_img.id_cat='.intval($id));
  while($data2=mysql_fetch_array($req2)){
    $i++;
    $tn_url=(is_file('../gallery/'.$data2['link'].'/TN/TN-'.$data2['file'])) ? '../gallery/'.$data2['link'].'/TN/TN-'.$data2['file'] : './themes/'.$config_theme['theme'].'/'.$config_theme['no_tn'];
  
    $tpl->parse(array(
      'id'=>$data2['id_img'],
      'tn_url'=>$tn_url,
      'name'=>stripslashes($data2['name'])), 'FORM.IMG');
      
    if($i>=IMG_PER_LINE){
      $tpl->parse(NULL, 'FORM.IMG.IMG_LINE');
      $i=0;
    }
  }
  
  if($i<=IMG_PER_LINE && $i!=0){
    for($j=$i; $j<IMG_PER_LINE; $j++) $tpl->parse(NULL, 'FORM.IMG_EMPTY');
  }
  
  $req3=$sql->query('SELECT id, id_cat, name FROM hg3_cat WHERE id_cat=0 ORDER BY name');
  while($data3=mysql_fetch_array($req3)){
    $cat_arr[$my]['id']=$data3['id'];
    $cat_arr[$my]['name']=$data3['name'];
    $cat_arr[$my]['niv']=0;
    $my++;
    get_sous_cat($data3['id']);
  }
  
  foreach($cat_arr as $k=>$v){
    for($j=1; $j<=$v['niv']; $j++) $tpl->parse(NULL, 'FORM.CAT.CAT_N');

    $tpl->parse(array(
      'id'=>$v['id'],
      'name'=>stripslashes($v['name'])), 'FORM.CAT');
  }

  
  
  $tpl->parse(array(
    'img_per_line'=>IMG_PER_LINE,
    'id_cat'=>intval($id)), 'FORM');
}
else{
  $req=$sql->query('SELECT id, id_cat, nb_img, name FROM hg3_cat WHERE id_cat=0 ORDER BY name');
  while($data=mysql_fetch_array($req)){
    $cat_arr[$my]['id']=$data['id'];
    $cat_arr[$my]['name']=$data['name'];
    $cat_arr[$my]['niv']=0;
    $cat_arr[$my]['nb_img']=$data['nb_img'];
    $my++;
    get_sous_cat($data['id']);
  }

  foreach($cat_arr as $k=>$v){
    for($j=1; $j<=$v['niv']; $j++) $tpl->parse(NULL, 'LIST.CAT.CAT_N');

    $tpl->parse(array(
      'id'=>$v['id'],
      'nb_img'=>$v['nb_img'],
      'name'=>stripslashes($v['name'])), 'LIST.CAT');
  }

  $tpl->parse(NULL, 'LIST');
}

echo $tpl->out();
?>
