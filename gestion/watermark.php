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

if(!isset($_GET['id']) || empty($_GET['id'])) exit('ID missing');

// Parsage du fichier de config général
$config=parse_ini_file('../conf/conf.ini', TRUE);
// Parsage du fichier de config du thème
$config_theme=parse_ini_file('../themes/'.$config['theme'].'/theme.ini', TRUE);

// Test de l'ouverture de la galerie
if($config['open']!=1) exit('Gallery closed');

// Inclusion du fichier de config SQL
require_once('../conf/conf.php');

// Inclusion de la classe de gestion MySQL
require_once('../inc/mysql.class.php');

// Instanciation de la classe MySQL et connection à la bdd
$sql=new mysql(DBHOST, DBNAME, DBUSER, DBPASSWORD);
// On spécifie qu'on bosse en utf8
$sql->query("SET NAMES 'utf8'");

$data=$sql->fetch('SELECT hg3_img.id AS id_img, hg3_img.id_cat, hg3_img.file, hg3_cat.id AS id_cat, hg3_cat.link FROM hg3_img LEFT JOIN hg3_cat ON hg3_img.id_cat=hg3_cat.id WHERE hg3_img.id='.intval($_GET['id']));

$dest_link='../gallery/'.$data['link'].'/'.$data['file'];
$dest_exp = explode('.', $dest_link);
$dest_ext=strtolower(array_pop($dest_exp));

$src_link='../themes/'.$config['theme'].'/'.$config_theme['watermark_image_path'];
$src_exp = explode('.', $src_link);
$src_ext=strtolower(array_pop($src_exp));

$jpeg_arr=array('jpg', 'jpeg');

// Header + Src

if(in_array($src_ext, $jpeg_arr)){
  header ("Content-type: image/jpeg");
  $src=imagecreatefromjpeg($src_link);
}
elseif($src_ext=='gif'){
  header ("Content-type: image/gif");
  $src=imagecreatefromgif($src_link);
}
else{
  header ("Content-type: image/png");
  $src=imagecreatefrompng($src_link);
}

// Dest
if(in_array($dest_ext, $jpeg_arr)) $dest=imagecreatefromjpeg($dest_link);
elseif($dest_ext=='gif') $dest=imagecreatefromgif($dest_link);
else $dest=imagecreatefrompng($dest_link);

list($width_src, $height_src)=getimagesize($src_link);
list($width_dest, $height_dest)=getimagesize($dest_link);

$x_dest=($width_dest-$width_src)-5;
$y_dest=($height_dest-$height_src-5);

imagecopymerge($dest, $src, $x_dest, $y_dest, 0, 0, $width_src, $height_src, 70);

if(in_array($dest_ext, $jpeg_arr)) imagejpeg($dest);
elseif($dest_ext=='gif') imagegif($dest);
else imagepng($dest);
?>
