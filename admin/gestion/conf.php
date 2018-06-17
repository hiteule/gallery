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

if(isset($open, $language_new, $title, $description, $cat_per_line, $img_per_line, $line_per_page, $form_date, $form_hour, $timezone, $comm_open, $comm_invit, $watermark, $contact_nom, $contact_mail, $number_last_comm, $number_most_viewed)){
  if($open=='' || empty($language_new) || empty($title) || empty($cat_per_line) || empty($img_per_line) || empty($line_per_page) || empty($form_date) || empty($form_hour) || empty($timezone) || $comm_open=='' || $comm_invit=='' || empty($sort_img) || $watermark=='' || empty($contact_nom) || empty($contact_mail) || empty($number_last_comm) || empty($number_most_viewed)){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=1">';
    exit(0);
  }
  
  if(isset($_FILES['upfile']['name']) && !empty($_FILES['upfile']['name'])){
      $ext_arr=array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG');
      $extup=substr(strrchr($_FILES['upfile']['name'], '.') , 1);
      if(!in_array($extup, $ext_arr)){ // Mauvais format
        echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=5">';
        exit(0);
      }

      $file='watermark_'.time(NULL).'_'.$_FILES['upfile']['name'];

      if(move_uploaded_file($_FILES['upfile']['tmp_name'], '../themes/'.$config['theme'].'/img/'.$file)==TRUE){
        $config_theme_tmp=parse_ini_file('../themes/'.$config['theme'].'/theme.ini');
        unlink('../themes/'.$config['theme'].'/'.$config_theme_tmp['watermark_image_path']);
        $config_theme_tmp['watermark_image_path']='img/'.$file;
        
        maj_conf($config_theme_tmp, '../themes/'.$config['theme'].'/theme.ini');
      }
    }
  
  $config['open']=intval($open);
  $config['lang']=$language_new;
  $config['title']=str_replace('"', '&quot;', $title);
  $config['description']=str_replace('"', '&quot;', $description);
  $config['cat_per_line']=intval($cat_per_line);
  $config['img_per_line']=intval($img_per_line);
  $config['line_per_page']=intval($line_per_page);
  $config['form_date']=str_replace('"', '&quot;', $form_date);
  $config['form_hour']=str_replace('"', '&quot;', $form_hour);
  $config['timezone']=str_replace('"', '&quot;', $timezone);
  $config['comm_open']=intval($comm_open);
  $config['comm_invit']=intval($comm_invit);
  $config['watermark']=intval($watermark);
  $config['contact_nom']=str_replace('"', '&quot;', $contact_nom);
  $config['contact_mail']=str_replace('"', '&quot;', $contact_mail);
  $config['number_last_comm']=intval($number_last_comm);
  $config['number_most_viewed']=intval($number_most_viewed);
  
  if(strcmp($config['sort_img'], $sort_img)!=0){
    $config['sort_img']=$sort_img;
    
    $req=$sql->query('SELECT id FROM hg3_cat');
    while($data=mysql_fetch_array($req)) maj_cat($data['id']);
  }
  
  maj_conf($config);
}

$tpl=new template('conf.tpl');

if($hdl=opendir('../locales')){
  while(($file=readdir($hdl))!==FALSE){
    if(is_dir('../locales/'.$file) && $file!='.' && $file!='..'){
      $config_lang=parse_ini_file('../locales/'.$file.'/lang.ini');
      $tpl->parse(array(
        'selected'=>($config_lang['dir']==$config['lang']) ? 'selected="selected"' : '',
        'name'=>$config_lang['name'],
        'value'=>$config_lang['dir']), 'LANG');
    }
  }
  closedir($hdl);
}

$tpl->parse(array(
  'selected_open_open'=>($config['open']==1) ? 'selected="selected"' : '',
  'selected_open_close'=>($config['open']!=1) ? 'selected="selected"' : '',
  'title'=>$config['title'],
  'description'=>$config['description'],
  'cat_per_line'=>$config['cat_per_line'],
  'img_per_line'=>$config['img_per_line'],
  'line_per_page'=>$config['line_per_page'],
  'form_date'=>$config['form_date'],
  'form_hour'=>$config['form_hour'],
  'timezone'=>$config['timezone'],
  'selected_comm_open_open'=>($config['comm_open']==1) ? 'selected="selected"' : '',
  'selected_comm_open_close'=>($config['comm_open']!=1) ? 'selected="selected"' : '',
  'selected_comm_invit_open'=>($config['comm_invit']==1) ? 'selected="selected"' : '',
  'selected_comm_invit_close'=>($config['comm_invit']!=1) ? 'selected="selected"' : '',
  'selected_sort_img_date_add'=>($config['sort_img']=='date_add') ? 'selected="selected"' : '',
  'selected_sort_img_date_add_desc'=>($config['sort_img']=='date_add DESC') ? 'selected="selected"' : '',
  'selected_sort_img_name'=>($config['sort_img']=='name') ? 'selected="selected"' : '',
  'selected_sort_img_name_desc'=>($config['sort_img']=='name DESC') ? 'selected="selected"' : '',
  'selected_sort_img_nb_view'=>($config['sort_img']=='nb_view') ? 'selected="selected"' : '',
  'selected_sort_img_nb_view_desc'=>($config['sort_img']=='nb_view DESC') ? 'selected="selected"' : '',
  'selected_watermark_yes'=>($config['watermark']=='1') ? 'selected="selected"' : '',
  'selected_watermark_no'=>($config['watermark']=='0') ? 'selected="selected"' : '',
  'contact_nom'=>$config['contact_nom'],
  'contact_mail'=>$config['contact_mail'],
  'number_last_comm'=>$config['number_last_comm'],
  'number_most_viewed'=>$config['number_most_viewed'],
));

echo $tpl->out();
?>
