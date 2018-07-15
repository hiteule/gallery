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

if(!isset($id) || empty($id)){ // On liste les surcat
  $tpl=new template('cat.tpl');

  $i=0;
  $j=0;
  $req=$sql->fetchAll('SELECT id, id_cat, id_souscat, name, description, nb_img, nb_souscat FROM hg3_cat WHERE id_cat=0 ORDER BY name');
  foreach ($req as $data) {
    $i++;
    $j++;
    if($i>=$config['cat_per_line']){
      $tpl->parse('', 'CAT.LINE');
      $i=0;
    }
    
    $req5='SELECT hg3_img.id, hg3_img.id_cat, hg3_img.file, hg3_cat.id, hg3_cat.link FROM hg3_img LEFT JOIN hg3_cat ON hg3_cat.id=hg3_img.id_cat WHERE (hg3_img.id_cat='.$data['id'];
    if(!empty($data['id_souscat'])) foreach(explode('-', $data['id_souscat']) as $k=>$v) $req5.=' OR hg3_img.id_cat='.$v;
    $req5.=') ORDER BY rand() LIMIT 1';
    $data5=$sql->fetch($req5);
    
    $tn_link=(isset($data5['link']) && !empty($data5['link']) && is_file('./gallery/'.$data5['link'].'/TN/TN-'.$data5['file'])) ? './gallery/'.$data5['link'].'/TN/TN-'.$data5['file'] : './themes/'.$config['theme'].'/'.$config_theme['no_tn'];
    
    $tpl->parse(array(
      'id'=>$data['id'],
      'name'=>stripslashes($data['name']),
      'tn_link'=>$tn_link,
      'nb_img'=>$data['nb_img'],
      'nb_souscat'=>$data['nb_souscat'],
      'description'=>stripslashes($data['description'])), 'CAT');
  }
  
  if($i!=0 && $i<$config['cat_per_line']){
    for($j=$i; $j<$config['cat_per_line']; $j++) $tpl->parse('', 'EMPTY_CAT');
  }

  if($j==0) $tpl->parse(NULL, 'NO_CAT');
  
  echo $tpl->out();
}
else{ // On liste la catégorie demandé
  $tpl=new template('souscat.tpl');
  
  $data2=$sql->fetch('SELECT id, nb_souscat, nb_img, link FROM hg3_cat WHERE id='.intval($id));
  
  $parent_cat_arr=parent_cat($data2['id'], $sql);
  foreach($parent_cat_arr as $k=>$v){
    $tpl->parse(array(
      'id'=>$k,
      'name'=>$v), 'NAVBAR_CAT');
  }
  
  // Catégorie
  if($data2['nb_souscat']>0){
    $i=0;
    $req3=$sql->fetchAll('SELECT id, id_cat, id_souscat, name, description, nb_img, nb_souscat FROM hg3_cat WHERE id_cat='.$data2['id'].' ORDER BY name');
    foreach ($req3 as $data3) {
      $i++;
      if($i>=$config['cat_per_line']){
        $tpl->parse('', 'CATOK.CAT.LINE');
        $i=0;
      }
      
      $req6='SELECT hg3_img.id, hg3_img.id_cat, hg3_img.file, hg3_cat.id, hg3_cat.link FROM hg3_img LEFT JOIN hg3_cat ON hg3_cat.id=hg3_img.id_cat WHERE (hg3_img.id_cat='.$data3['id'];
      if(!empty($data3['id_souscat'])) foreach(explode('-', $data3['id_souscat']) as $k=>$v) $req6.=' OR hg3_img.id_cat='.$v;
      $req6.=') ORDER BY rand() LIMIT 1';
      
      $data6=$sql->fetch($req6);
      
      $tn_link=(isset($data6['link']) && !empty($data6['link']) && is_file('./gallery/'.$data6['link'].'/TN/TN-'.$data6['file'])) ? './gallery/'.$data6['link'].'/TN/TN-'.$data6['file'] : './themes/'.$config['theme'].'/'.$config_theme['no_tn'];

      $tpl->parse(array(
        'id'=>$data3['id'],
        'name'=>stripslashes($data3['name']),
        'tn_link'=>$tn_link,
        'nb_img'=>$data3['nb_img'],
        'nb_souscat'=>$data3['nb_souscat'],
        'description'=>stripslashes($data3['description'])), 'CATOK.CAT');
    }
    
    if($i!=0 && $i<$config['cat_per_line']){
      for($j=$i; $j<$config['cat_per_line']; $j++) $tpl->parse('', 'CATOK.EMPTY_CAT');
    }
    
    $tpl->parse(NULL, 'CATOK');
  }
  
  // Image
  if($data2['nb_img']>0){
    $i=0;
    $page=(!isset($page) || empty($page) || $page<=0) ? 1 : $page;
    $l0=($page==1) ? 0 : ($config['img_per_line']*$config['line_per_page'])*($page-1);
    $l1=($config['img_per_line']*$config['line_per_page']);
    $nb_page=ceil($data2['nb_img']/$l1);
    
    if($nb_page>1){
      if($page>1){
        $tpl->parse(array(
          'id'=>$data2['id'],
          'page'=>($page-1)), 'PAGE_BACK');
      }
      else $tpl->parse(NULL, 'PAGE_BACK_NOK');

      for($j=1; $j<=$nb_page; $j++){
        if($j==$page) $tpl->parse('page->'.$j, 'PAGEROLL.PAGE_CUR');
        else{
          $tpl->parse(array(
            'id'=>$data2['id'],
            'page'=>$j), 'PAGEROLL.PAGE');
        }

        $tpl->parse(NULL, 'PAGEROLL');
      }

      if($page<$nb_page){
        $tpl->parse(array(
          'id'=>$data2['id'],
          'page'=>($page+1)), 'PAGE_NEXT');
      }
      else $tpl->parse(NULL, 'PAGE_NEXT_NOK');
    }

    $req4=$sql->fetchAll('SELECT id, id_cat, file, name FROM hg3_img WHERE id_cat='.$data2['id'].' ORDER BY '.$config['sort_img'].' LIMIT '.$l0.', '.$l1);
    foreach ($req4 as $data4) {
      $i++;
      if($i>=$config['img_per_line']){
        $tpl->parse('', 'IMG.LINE');
        $i=0;
      }
      
      $tn_link=(is_file('./gallery/'.$data2['link'].'/TN/TN-'.$data4['file'])) ? './gallery/'.$data2['link'].'/TN/TN-'.$data4['file'] : './themes/'.$config['theme'].'/'.$config_theme['no_tn'];

      $tpl->parse(array(
        'id_img'=>$data4['id'],
        'tn_link'=>$tn_link,
        'name'=>stripslashes($data4['name'])), 'IMG');
    }
    
    if($i!=0 && $i<$config['img_per_line']){
      for($j=$i; $j<$config['img_per_line']; $j++) $tpl->parse('', 'EMPTY_IMG');
    }
  }
  
  echo $tpl->out();
}
?>
