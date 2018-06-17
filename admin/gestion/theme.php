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

if(isset($dir_theme) && !empty($dir_theme)){
  $config['theme']=$dir_theme;
  maj_conf($config);
}

$tpl=new template('theme.tpl');

if($hdl=opendir('../themes')){
  while(($file=readdir($hdl))!==FALSE){
    if(is_dir('../themes/'.$file) && $file!='.' && $file!='..' && is_file('../themes/'.$file.'/theme.ini')){
      $config_theme_tmp=parse_ini_file('../themes/'.$file.'/theme.ini');
      $tpl->parse(array(
        'name'=>$config_theme_tmp['name'],
        'dir'=>$file,
        'preview'=>$config_theme_tmp['preview'],
        'version'=>$config_theme_tmp['version'],
        'author'=>$config_theme_tmp['author'],
        'checked'=>(strcmp($config['theme'], $file)==0) ? 'checked="checked"' : ''), 'THEME');
    }
  }
  closedir($hdl);
}

echo $tpl->out();
?>
