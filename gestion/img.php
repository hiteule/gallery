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

if(!isset($id) || empty($id)){
  echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=6">';
  exit(0);
}

$data=$sql->query('SELECT hg3_img.id AS id_img, hg3_img.id_cat, hg3_img.name, hg3_img.file, hg3_img.nb_view, hg3_img.date_add, hg3_cat.id, hg3_cat.nb_img, hg3_cat.link, hg3_cat.sort FROM hg3_img LEFT JOIN hg3_cat ON hg3_cat.id=hg3_img.id_cat WHERE hg3_img.id='.intval($id), TRUE);

if(!isset($data['id_img']) || empty($data['id_img'])){
  echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=6">';
  exit(0);
}

// Ajout d'un commentaire
if(isset($comment) && $config['comm_open']==1 && (($user->connect()==TRUE) || ($config['comm_invit']==1  && $user->connect()==FALSE))){
  if(!empty($comment) && $comment!=' ' && (($user->connect()==TRUE) || ($user->connect()==FALSE && $config['comm_invit']==1 && isset($name) && !empty($name)))){    
    if($user->connect()==TRUE) $name=$user->info['login'];
    else{
      $name=addslashes($name);
      $data5=$sql->query('SELECT login FROM hg3_user WHERE login="'.$name.'"', TRUE);
      
      if(!empty($data5['login'])){
        echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=11">';
        exit(0);
      }
    }

    $data4=$sql->query('SELECT id, id_img, comment FROM hg3_comment WHERE id_img='.$data['id_img'].' ORDER BY id DESC LIMIT 0, 1', TRUE);
    if(strcmp(stripslashes($data4['comment']), $comment)!=0) $sql->query('INSERT INTO hg3_comment VALUES("", '.$data['id_img'].', '.time(NULL).', "'.$name.'", "'.addslashes($comment).'")');
  }
  else{ // Champs NOK
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=1">';
    exit(0);
  }
}

$sql->query('UPDATE hg3_img SET nb_view="'.($data['nb_view']+1).'" WHERE id='.$data['id_img']);

$sort_arr=explode('-', $data['sort']);
$num_img=(array_search($data['id_img'], $sort_arr)+1);
$img_url=($config['watermark']==0) ? './gallery/'.$data['link'].'/'.$data['file'] : './gestion/watermark.php?id='.$data['id_img'];
$page=ceil($num_img/($config['img_per_line']*$config['line_per_page']));
list($width, $height)=getimagesize('./gallery/'.$data['link'].'/'.$data['file']);

$tpl=new template('img.tpl');

$parent_cat_arr=parent_cat($data['id_cat'], $sql);
foreach($parent_cat_arr as $k=>$v){
  $tpl->parse(array(
    'id'=>$k,
    'name'=>$v), 'NAVBAR_CAT');
}

if($num_img>1){
  $data2=$sql->query('SELECT id, file, name FROM hg3_img WHERE id='.$sort_arr[($num_img-2)], TRUE);
  
  $tn_link=(isset($data['link']) && !empty($data['link']) && is_file('./gallery/'.$data['link'].'/TN/TN-'.$data2['file'])) ? './gallery/'.$data['link'].'/TN/TN-'.$data2['file'] : './themes/'.$config['theme'].'/'.$config_theme['no_tn'];

  $tpl->parse(array(
    'id'=>$data2['id'],
    'tn_link'=>$tn_link,
    'name'=>stripslashes($data2['name'])), 'IMG_BACK');
}
else $tpl->parse(NULL, 'IMG_BACK_NOK');

if($num_img<$data['nb_img']){
  $data3=$sql->query('SELECT id, file, name FROM hg3_img WHERE id='.$sort_arr[$num_img], TRUE);
  
  $tn_link=(isset($data['link']) && !empty($data['link']) && is_file('./gallery/'.$data['link'].'/TN/TN-'.$data3['file'])) ? './gallery/'.$data['link'].'/TN/TN-'.$data3['file'] : './themes/'.$config['theme'].'/'.$config_theme['no_tn'];
  
  $tpl->parse(array(
    'id'=>$data3['id'],
    'tn_link'=>$tn_link,
    'name'=>stripslashes($data3['name'])), 'IMG_NEXT');
}
else $tpl->parse(NULL, 'IMG_NEXT_NOK');

$tpl->parse(array(
  'num_img'=>$num_img,
  'nb_img'=>$data['nb_img'],
  'name_img'=>stripslashes($data['name']),
  'img_url'=>$img_url,
  'id_cat'=>$data['id_cat'],
  'page'=>$page,
  'width'=>$width,
  'height'=>$height,
  'size'=>file_size('./gallery/'.$data['link'].'/'.$data['file']),
  'add_date'=>date($config['form_date'], $data['date_add']),
  'add_hour'=>date($config['form_hour'], $data['date_add']),
  'nb_view'=>($data['nb_view']+1),
  ));

$req2=$sql->query('SELECT id, id_img, date, name, comment FROM hg3_comment WHERE id_img='.$data['id_img'].' ORDER BY date');
while($data2=mysql_fetch_array($req2)) $comm_arr[]=$data2;

if(isset($comm_arr) && count($comm_arr)>0){ // Commentaire
  foreach($comm_arr as $k=>$v){
    $tpl->parse(array(
      'id'=>$v['id'],
      'name'=>stripslashes(htmlentities($v['name'], ENT_COMPAT, 'UTF-8')),
      'date_date'=>date($config['form_date'], $v['date']),
      'date_hour'=>date($config['form_hour'], $v['date']),
      'comment'=>stripslashes(nl2br(htmlentities($v['comment'], ENT_COMPAT, 'UTF-8'))),
      ), 'COMM_OK.COMM');
  }
  
  $tpl->parse('nb_comm->'.count($comm_arr), 'COMM_OK');
}
// !Commentaire
else $tpl->parse(NULL, 'COMM_NOK');

// Formulaire d'ajout de commentaire
if($config['comm_open']==1 && (($config['comm_invit']==0 && $user->connect()==TRUE) || ($config['comm_invit']==1))){ // Comentaire ouvert
  if($user->connect()==TRUE) $tpl->parse('name->'.stripslashes($user->info['login']), 'COMM_ADD.NAME');
  else $tpl->parse(NULL, 'COMM_ADD.NAME_INPUT');

  $tpl->parse('id_img->'.$data['id_img'], 'COMM_ADD');
}

echo $tpl->out();
?>
