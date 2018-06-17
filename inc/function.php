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

// Retourne un array des catégories parente
function parent_cat($id, $sql){
  $parent_cat_arr=array();
  while($id>0){
    $data4=$sql->query('SELECT id, id_cat, name FROM hg3_cat WHERE id='.$id, TRUE);
    $parent_cat_arr[$data4['id']]=stripslashes($data4['name']);
    $id=$data4['id_cat'];
  }
  return array_reverse($parent_cat_arr, TRUE);
}

// Retourne la taille d'un fichier
function file_size($file){
  $size=filesize($file);

  if($size>=1073741824) $size=round(($size/1073741824*100)/100, 2).' Go';
  elseif($size>=1048576) $size=round(($size/1048576*100)/100, 2).' Mo';
  elseif($size>=1024) $size=round(($size/1024*100)/100, 2).' Ko';
  else $size=$size.' o';
  return $size;
}

// Variables à récupérer en global pour send_mail()
$contact_nom=$config['contact_nom'];
$contact_mail=$config['contact_mail'];

// Envoi de mail comme il faut
function send_mail($mail_addr, $subject, $message_html, $message_txt=FALSE){
  global $contact_nom, $contact_mail;

  if($message_txt==FALSE) $message_txt=$message_html;

  $frontiere = "-----=".md5(uniqid(mt_rand()));

  $headers ="From: \"".$contact_nom."\"<".$contact_mail.">\n";
  $headers.="Reply-To: \"".$contact_mail."\"<".$contact_mail.">\n";
  $headers.="MIME-Version: 1.0\n";
  $headers.="Content-Type: multipart/alternative;\n boundary=\"".$frontiere."\"\n";

  $message="";
  $message.="--".$frontiere."\n";
  $message.="Content-Type: text/plain; charset=\"utf8\"\n";
  $message.="Content-Transfer-Encoding: 8bit\n\n";
  $message.=$message_txt."\n\n";
  $message.="--".$frontiere."\n";

  $message.="Content-Type: text/html; charset=\"utf8\"\n";
  $message.="Content-Transfer-Encoding: 8bit\n\n";
  $message.="<html><head></head><body><div>";
  $message.=$message_html;
  $message.="</div></body></html>\n\n";
  $message.="--".$frontiere."--\n";
  $message.="--".$frontiere."--\n";

  if(mail($mail_addr, $subject, $message, $headers)) return TRUE;
  else return FALSE;
}
function have_to_view_login(){
  if(!defined('VIEW_PASSWORD') || 0===strcmp('', VIEW_PASSWORD)){
    return false;
  }

  if(isset($_SESSION['view_password']) && 0===strcmp(VIEW_PASSWORD, $_SESSION['view_password'])){
    return false;
  }

  return true;
}
?>
