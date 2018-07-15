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

// Formatage des GET, POST et COOKIE
foreach($_GET as $k=>$v){
  if(get_magic_quotes_gpc()) ${$k}=stripslashes($v);
  else ${$k}=$v;
}

foreach($_POST as $k=>$v){
  if(get_magic_quotes_gpc()) ${$k}=stripslashes($v);
  else ${$k}=$v;
}

foreach($_COOKIE as $k=>$v){
  if(get_magic_quotes_gpc()) ${$k}=stripslashes($v);
  else ${$k}=$v;
}

// Calcul du temps d'éxécution
function exec_time($time_start, $time_end){
  $start=explode(' ', $time_start);
  $end=explode(' ', $time_end);
  
  return round(($end[0]+$end[1])-($start[0]+$start[1]), 3);
}

// Renvoi les sous catégories
$cat_arr=array();
$my=0;
function get_sous_cat($id_souscat, $niv=1){
  global $sql, $cat_arr, $my;

  $req=$sql->fetchAll('SELECT id, id_cat, name, nb_souscat, nb_img FROM hg3_cat WHERE id_cat='.intval($id_souscat).' ORDER BY name');
  foreach ($req as $data) {
    $cat_arr[$my]['id']=$data['id'];
    $cat_arr[$my]['name']=$data['name'];
    $cat_arr[$my]['niv']=$niv;
    $cat_arr[$my]['nb_img']=$data['nb_img'];
    $my++;
    if($data['nb_souscat']>0) get_sous_cat($data['id'], ($niv+1));
  }
}

// Met à jour le nombre d'image d'une catégorie
function maj_cat($id_cat, $link_cat=''){
  global $sql, $config;

  $i=0;
  $j=0;
  $order_str='';
  $req=$sql->fetchAll('SELECT id, date_add, name, nb_view FROM hg3_img WHERE id_cat='.intval($id_cat).' ORDER BY '.$config['sort_img']);
  foreach ($req as $data) {
    if($i==0){
      $i++;
      $order_str.=$data['id'];
    }
    else $order_str.='-'.$data['id'];
    
    $j++;
  }
  
  if(!empty($link_cat)){
    $id_souscat='';
    $nb_souscat=0;
    
    $req2=$sql->fetchAll('SELECT id, link FROM hg3_cat WHERE link LIKE "'.$link_cat.'/%"');
    foreach ($req2 as $data2) {
      if($nb_souscat>0) $id_souscat.='-';
      $id_souscat.=$data2['id'];
      $nb_souscat++;
    }
    
    $sql->query('UPDATE hg3_cat SET id_souscat="'.$id_souscat.'", nb_souscat='.$nb_souscat.', sort="'.$order_str.'", nb_img='.$j.' WHERE id='.intval($id_cat));
  }
  else $sql->query('UPDATE hg3_cat SET sort="'.$order_str.'", nb_img='.$j.' WHERE id='.intval($id_cat));
}

// Formatage d'une chaine
function format_str($string){
  $string = stripslashes($string);
  $string = str_replace(array('?', '!', ','), '', $string);
  $string = trim($string);
  $string = str_replace(array('€', '#', '+', '*', ' ', "'", '"', '²', '&', '~', '{', '(', '[', '|', '`', '^', ')', '}', '=', ']', '}', '^', '$', '£', '¤', '%', '*', ';', ':', '', '§', '>', '°', '-', '@', '§', '©', '<', '/'), '_', $string);
  $string = str_replace(array('ê', 'ë', 'é', 'è'), 'e', $string);
  $string = str_replace(array('ù', 'µ', 'û', 'ü'), 'u', $string);
  $string = str_replace(array('à', 'ä', 'â'), 'a', $string);
  $string = str_replace(array('ô', 'ö', 'ò'), 'o', $string);
  $string = str_replace(array('î', 'ï', 'ì', ), 'i', $string);
  $string = str_replace(array('ÿ'), 'y', $string);
  $string = str_replace(array('ç'), 'c', $string);
  $string = str_replace(array('ñ'), 'n', $string);
  $string = strtolower($string);

  return $string;
}

// Vérifie si une chaine comporte un ou plusieurs caractères spéciaux
function is_special_str($string){
  $special_char_arr=array(
    '?', '!', ',', '€', '#', '+', '*', ' ', "'", '"', '²', '&', '~', '{', '(', '[', '|', '`', '^', ')',
    '}', '=', ']', '}', '^', '$', '£', '¤', '%', '*', ';', ':', '§', '>', '°', '@', '§', '©', '<', 'ê',
    'ë', 'é', 'è', 'ù', 'µ', 'û', 'ü', 'à', 'ä', 'â', 'ô', 'ö', 'ò', 'î', 'ï', 'ì', 'ÿ', 'ç', 'ñ', '/');
    
  foreach($special_char_arr as $k=>$v){
    if(strstr($string, $v)!=FALSE) return TRUE;
  }
  
  return FALSE;
}

// Vérifie si le fichier est une image
function is_img($file){
  $ext_arr=array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG');

  $ext=substr(strrchr($file, '.'), 1);
  if(in_array($ext, $ext_arr)) return TRUE;
  else return FALSE;
}

// Supression d'un dossier et de son contenu
function delete_dir($link){
  if(is_dir($link)){
    $fp=opendir($link);
    while($item=readdir($fp)){
      if($item!='.' && $item!='..'){
        if(is_dir($link.'/'.$item)) delete_dir($link.'/'.$item);
        else unlink($link.'/'.$item);
      }
    }
    closedir($fp);
    if(rmdir($link)==TRUE) return TRUE;
    else{
      $trash_arr=explode(' ', microtime(NULL));
      rename($link, '../trash/'.$trash_arr[1].'_'.substr($trash_arr[0], 2));
      return TRUE;
    }
  }
  else return FALSE;
}

// Mise à jour du fichier de config .ini
function maj_conf($config_arr, $file='../conf/conf.ini'){
  $content="; Hiteule Gallery\n";
  $content.="; Par Hiteule Créative - http://hiteulegallery.hiteule-creative.fr\n;\n";
  $content.="; Cette application est libre et livrée sous licence Creative Commons\n";
  $content.="; Paternité-Partage des Conditions Initiales à l'Identique 3.0 Unported\n";
  $content.="; http://creativecommons.org/licenses/by-sa/3.0/deed.fr\n;\n";
  $content.="; This software is free and distributed with the term of Creative Commons licence\n";
  $content.="; Attribution-Share Alike 3.0 Unported\n";
  $content.="; http://creativecommons.org/licenses/by-sa/3.0/deed.en\n\n";

  foreach($config_arr as $k=>$v) $content.=$k." = \"".$v."\"\n";

  if(file_put_contents($file, $content)===FALSE) return FALSE;
  else return TRUE;
}
?>
