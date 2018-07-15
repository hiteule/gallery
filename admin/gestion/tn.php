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

if(isset($_POST['list']) && !empty($_POST['list'])){
  foreach($_POST['list'] as $k=>$v){
    $data2=$sql->fetch('SELECT hg3_img.id AS id_img, hg3_img.file, hg3_img.name AS name_img, hg3_cat.id AS id_cat, hg3_cat.name AS name_cat, hg3_cat.link
      FROM hg3_img LEFT JOIN hg3_cat ON hg3_img.id_cat=hg3_cat.id  WHERE hg3_img.id='.intval($v).' ORDER BY hg3_cat.name');

    if(!is_dir('../gallery/'.$data2['link'].'/TN')) mkdir('../gallery/'.$data2['link'].'/TN', 0700);

    $src_link='../gallery/'.$data2['link'].'/'.$data2['file'];

    $extjpg=array('jpg', 'jpeg', 'JPG', 'JPEG');
    $extgif=array('gif', 'GIF');
    $extpng=array('png', 'PNG');
    $extup=substr(strrchr($data2['file'], '.') , 1);

//echo $src_link;
    $img_size=getimagesize($src_link);
    if($img_size[0]>128 || $img_size[1]>128){ // Image trop grande, on redimentionne
      if(in_array($extup, $extjpg)) $src=imagecreatefromjpeg($src_link);
      elseif(in_array($extup, $extgif)) $src=imagecreatefromgif($src_link);
      elseif(in_array($extup, $extpng)) $src=imagecreatefrompng($src_link);

      if($img_size[0]>$img_size[1]){
        $w=128;
        $h=$img_size[1]/($img_size[0]/128);
      }
      else{
        $w=$img_size[0]/($img_size[1]/128);
        $h=128;
      }

      $tn=imagecreatetruecolor($w, $h);
      imagecopyresampled($tn, $src, 0, 0, 0, 0, $w, $h, imagesx($src), imagesy($src));

      if(in_array($extup, $extjpg)) imagejpeg($tn, '../gallery/'.$data2['link'].'/TN/TN-'.$data2['file']);
      elseif(in_array($extup, $extgif)) imagegif($tn, '../gallery/'.$data2['link'].'/TN/TN-'.$data2['file']);
      elseif(in_array($extup, $extpng)) imagepng($tn, '../gallery/'.$data2['link'].'/TN/TN-'.$data2['file']);
    }
    else copy($src_link, '../gallery/'.$data2['link'].'/TN/TN-'.$data2['file']);
  }
}

$tpl=new template('tn.tpl');

$i=0;
$tn_arr=array();
$req=$sql->fetchAll('SELECT hg3_img.id AS id_img, hg3_img.file, hg3_img.name AS name_img, hg3_cat.id AS id_cat, hg3_cat.name AS name_cat, hg3_cat.link
  FROM hg3_img LEFT JOIN hg3_cat ON hg3_img.id_cat=hg3_cat.id ORDER BY hg3_cat.name');
foreach ($req as $data) {
  if(!is_file('../gallery/'.$data['link'].'/TN/TN-'.$data['file'])){
    $tn_arr[$i]['id_img']=$data['id_img'];
    $tn_arr[$i]['name_cat']=stripslashes($data['name_cat']);
    $tn_arr[$i]['name_img']=stripslashes($data['name_img']);
    $i++;
  }
}

if($i==0) $tpl->parse(NULL, 'TN_NOLOST');
else{
  for($j=0; $j<$i; $j++){
    $tpl->parse(array(
      'id_img'=>$tn_arr[$j]['id_img'],
      'name_cat'=>$tn_arr[$j]['name_cat'],
      'name_img'=>$tn_arr[$j]['name_img']), 'TN_LOST.TN');
  }
  
  $tpl->parse('nb_tn->'.($i), 'TN_LOST');
}

echo $tpl->out();
?>
