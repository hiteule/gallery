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

if(!isset($user) || $user->connect()==FALSE || $user->info['admin']!=1) exit(0);

$tpl=new template('cat_add.tpl');

// Ajout de la catégorie
if(isset($cat, $name, $description)){
  if(empty($name)){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=6">';
    exit(0);
  }
  
  if(!empty($cat)){
    $data2=$sql->fetch('SELECT id, link FROM hg3_cat WHERE id='.intval($cat));
    $lnk='../gallery/'.$data2['link'].'/'.format_str($name);
    
    $sql->query('INSERT INTO hg3_cat (id, id_cat, id_souscat, nb_img, nb_souscat, link, name, description, sort) VALUES ("", '.$data2['id'].', "", 0, 0, "'.$data2['link'].'/'.format_str($name).'", "'.addslashes($name).'", "'.addslashes($description).'", "")');
    maj_cat($data2['id'], $data2['link']);
  }
  else{
    $lnk='../gallery/'.format_str($name);
    
    $sql->query('INSERT INTO hg3_cat (id, id_cat, id_souscat, nb_img, nb_souscat, link, name, description, sort) VALUES ("", 0, "", 0, 0, "'.format_str($name).'", "'.addslashes($name).'", "'.addslashes($description).'", "")');
  }
  
  mkdir($lnk, 0700);
  
  $tpl->parse(NULL, 'OK');
}
// Formulaire
else{
  $req=$sql->fetchAll('SELECT id, id_cat, name FROM hg3_cat WHERE id_cat=0 ORDER BY name');
  foreach ($req as $data) {
    $cat_arr[$my]['id']=$data['id'];
    $cat_arr[$my]['name']=$data['name'];
    $cat_arr[$my]['niv']=0;
    $my++;
    get_sous_cat($data['id']);
  }

  foreach($cat_arr as $k=>$v){
    for($j=1; $j<=$v['niv']; $j++) $tpl->parse(NULL, 'FORM.CAT.CAT_N');

    $tpl->parse(array(
      'id'=>$v['id'],
      'name'=>stripslashes($v['name'])), 'FORM.CAT');
  }
  
  $tpl->parse(NULL, 'FORM');
}

echo $tpl->out();
?>
