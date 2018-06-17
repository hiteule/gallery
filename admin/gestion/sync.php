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

$tpl=new template('sync.tpl');

if(isset($sync)){
  $cat_dir_arr=array();
  $img_dir_arr=array();
  $cat_db_arr=array();
  $img_db_arr=array();

  function sync_get_dir($dir=''){
    global $cat_dir_arr, $img_dir_arr;

    if($hdl=opendir('../gallery'.$dir)){
      while(($file=readdir($hdl))!==FALSE){
        if(is_special_str($file)==TRUE && $file!='.' && $file!='..'){
          rename('../gallery'.$dir.'/'.$file, '../gallery'.format_str(utf8_encode($dir)).'/'.format_str(utf8_encode($file)));
          $file=format_str(utf8_encode($file));
        }
      
        if(is_dir('../gallery/'.$dir.'/'.$file) && $file!='.' && $file!='..' && $file!='TN'){
          $cat_dir_arr[]=(substr($dir.'/'.$file, 0, 1)=='/') ? substr($dir.'/'.$file, 1) : $dir.'/'.$file;
          sync_get_dir($dir.'/'.$file);
        }
        elseif(is_img($file) && $file!='.' && $file!='..' && $file!='TN'){
          $img_dir_arr[]=(substr($dir.'/'.$file, 0, 1)=='/') ? substr($dir.'/'.$file, 1) : $dir.'/'.$file;
        }
      }
      closedir($hdl);
    }
  }

  function sync_get_db(){
    global $cat_db_arr, $img_db_arr, $sql;

    $req=$sql->query('SELECT link FROM hg3_cat');
    while($data=mysql_fetch_array($req)) $cat_db_arr[]=$data['link'];

    $req2=$sql->query('SELECT hg3_img.id_cat, hg3_img.file, hg3_cat.id, hg3_cat.link FROM hg3_img LEFT JOIN hg3_cat ON hg3_cat.id=hg3_img.id_cat');
    while($data2=mysql_fetch_array($req2)) $img_db_arr[]=$data2['link'].'/'.$data2['file'];
  }

  sync_get_dir();
  sync_get_db();

  $del_cat=0;
  $del_img=0;
  $add_cat=0;
  $add_img=0;
  $cat_maj_arr=array();

  // Suppression d'image
  foreach(array_diff($img_db_arr, $img_dir_arr) as $k=>$v){
    $del_img++;
    $file=end(explode('/', $v));
    $link=substr($v, 0, -(strlen($file)+1));

    if(is_file('../gallery/'.$link.'/TN/TN-'.$file)) unlink('../gallery/'.$link.'/TN/TN-'.$file);
    $sql->query('DELETE hg3_comment FROM hg3_comment, hg3_img, hg3_cat WHERE hg3_img.file="'.$file.'" AND hg3_img.id_cat=hg3_cat.id AND hg3_cat.link="'.$link.'" AND hg3_comment.id_img=hg3_img.id');
    $sql->query('DELETE hg3_img FROM hg3_img, hg3_cat WHERE hg3_img.file="'.$file.'" AND hg3_img.id_cat=hg3_cat.id AND hg3_cat.link="'.$link.'"');
    
    if(!in_array($link, $cat_maj_arr)) $cat_maj_arr[]=$link; // maj order et nb img de la cat
  }

  // Suppression de categorie
  foreach(array_diff($cat_db_arr, $cat_dir_arr) as $k=>$v){
    $del_cat++;
    $sql->query('DELETE FROM hg3_cat WHERE link="'.$v.'"');
    $i=1;
    $maj_cat='';
    foreach(explode('/', $v) as $k1=>$v1){
      if($i<count(explode('/', $v))) $maj_cat.='/'.$v1;
      $i++;
    }
    $maj_cat=substr($maj_cat, 1);
    if(!in_array($maj_cat, $cat_maj_arr)) $cat_maj_arr[]=$maj_cat; // maj de la surcat
  }

  // Ajout de catégorie
  foreach(array_diff($cat_dir_arr, $cat_db_arr) as $k=>$v){
    $add_cat++;
    if(count(explode('/', $v))==1) $sql->query('INSERT INTO hg3_cat VALUES("", 0, "", 0, 0, "'.$v.'", "'.end(explode('/', $v)).'", "", "")');
    else{
      $sql->query('INSERT INTO hg3_cat(id, id_cat, id_souscat, nb_img, nb_souscat, link, name, description, sort) SELECT "", id, "", 0, 0, "'.$v.'", "'.end(explode('/', $v)).'", "", "" FROM hg3_cat WHERE link="'.substr($v, 0, -(strlen(end(explode('/', $v)))+1)).'"');
      $i=1;
      $maj_cat='';
      foreach(explode('/', $v) as $k1=>$v1){
        if($i<count(explode('/', $v))) $maj_cat.='/'.$v1;
        $i++;
      }
      $maj_cat=substr($maj_cat, 1);
      if(!in_array($maj_cat, $cat_maj_arr)) $cat_maj_arr[]=$maj_cat; // maj de la surcat
    }
  }

  // Ajout d'image
  foreach(array_diff($img_dir_arr, $img_db_arr) as $k=>$v){
    $add_img++;
    $file=end(explode('/', $v));
    $ext=substr(strrchr($file, '.'), 1);
    $name=basename($file, '.'.$ext);
    $link=substr($v, 0, -(strlen($file)+1));

    $sql->query('INSERT INTO hg3_img (id, id_cat, date_add, file, name, nb_view) SELECT "", id, '.time(NULL).', "'.$file.'", "'.$name.'", 0 FROM hg3_cat WHERE link="'.$link.'"');
    if(!in_array($link, $cat_maj_arr)) $cat_maj_arr[]=$link; // maj de la surcat
  }

  foreach($cat_maj_arr as $k=>$v){
    $data3=$sql->query('SELECT id, link FROM hg3_cat WHERE link="'.$v.'"', TRUE);
    maj_cat($data3['id'], $v);
  }
  
  if($add_img>0) $tpl->parse(NULL, 'RESULT.GO_TN');

  $tpl->parse(array(
  'del_cat'=>$del_cat,
  'del_img'=>$del_img,
  'add_cat'=>$add_cat,
  'add_img'=>$add_img), 'RESULT');
}
else $tpl->parse(NULL, 'FORM');

echo $tpl->out();
?>
