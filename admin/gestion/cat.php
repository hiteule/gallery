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

$tpl=new template('cat.tpl');

// Edit d'une catégorie
if(isset($id_edit, $name, $description) && !empty($id_edit)){
  if(empty($name)){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=1">';
    exit(0);
  }
  
  $sql->query('UPDATE hg3_cat SET name="'.addslashes($name).'", description="'.addslashes($description).'" WHERE id='.intval($id_edit));
}

// Suppression d'une catégorie
if(isset($del) && !empty($del)){
  $data3=$sql->query('SELECT id, id_cat, nb_img, nb_souscat, link FROM hg3_cat WHERE id='.intval($del), TRUE);
  $link=substr($data3['link'], 0, -(strlen(end(explode('/', $data3['link'])))+1));
  
  if($data3['nb_img']>0){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=2">';
    exit(0);
  }
  if($data3['nb_souscat']>0){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=3">';
    exit(0);
  }

  $sql->query('DELETE FROM hg3_cat WHERE id='.$data3['id']);
  delete_dir('../gallery/'.$data3['link']);
  maj_cat($data3['id_cat'], $link);
}

// Form
if(isset($id) && !empty($id)){
  $data2=$sql->query('SELECT id, name, description FROM hg3_cat WHERE id='.intval($id), TRUE);
  
  $tpl->parse(array(
    'id'=>$data2['id'],
    'name'=>stripslashes($data2['name']),
    'description'=>$data2['description']), 'FORM');
}
// Liste
else{
  $req=$sql->query('SELECT id, id_cat, nb_img, name FROM hg3_cat WHERE id_cat=0 ORDER BY name');
  while($data=mysql_fetch_array($req)){
    $cat_arr[$my]['id']=$data['id'];
    $cat_arr[$my]['name']=$data['name'];
    $cat_arr[$my]['niv']=0;
    $cat_arr[$my]['nb_img']=$data['nb_img'];
    $my++;
    get_sous_cat($data['id']);
  }

  foreach($cat_arr as $k=>$v){
    for($j=1; $j<=$v['niv']; $j++) $tpl->parse(NULL, 'LIST.CAT.CAT_N');

    $tpl->parse(array(
      'id'=>$v['id'],
      'nb_img'=>$v['nb_img'],
      'name'=>stripslashes($v['name'])), 'LIST.CAT');
  }

  $tpl->parse(NULL, 'LIST');
}

echo $tpl->out();
?>
