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

session_start();

$list='346789ABCDEFGIJKLMNPQRTWY';
$txt='';
for($i=0; $i<=4; $i++){
  $txt_arr[$i]=$list[rand(0, 24)];
  $txt.=$txt_arr[$i];
}

$_SESSION['code']=$txt;

$fond=imagecreatefrompng('../static/img/captcha_background.png');
list($width, $height)=getimagesize('../static/img/captcha_background.png');

$img=imagecreate($width, $height);
imagecopy($img, $fond, 0, 0, 0, 0, $width, $height);
imagedestroy($fond);

$font_arr=array('kill_switch.ttf', 'kiss_me.ttf', 'mc_kloud_black.ttf', 'tamagotchi_normal.ttf', 'tape_loop.ttf', 'temhoss.ttf');

$x=10;
foreach($txt_arr as $v){
  $font='../static/font/'.$font_arr[rand(0, 5)];
  $color=imagecolorallocate($img, rand(0, 255), rand(0, 255), rand(0, 255));
  $angle=rand(-40, 40);
  
  imagettftext($img, 30, $angle, $x, 50, $color, $font, $v);
  $x+=30;
}

header('Content-type: image/png');
imagepng($img);
imagedestroy($img);
?>
