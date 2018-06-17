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

if(isset($cat)){
  if(empty($cat)){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=4">';
    exit(0);
  }
  
  $ext_arr=array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG');

  for($i=0; $i<=3; $i++){
    if(isset(${'name'.$i}, $_FILES['upfile'.$i]['name']) && !empty($_FILES['upfile'.$i]['name'])){
      $extup=substr(strrchr($_FILES['upfile'.$i]['name'], '.') , 1);
      if(!in_array($extup, $ext_arr)){ // Mauvais format
        echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=5">';
        exit(0);
      }

      $data2=$sql->query('SELECT id, link FROM hg3_cat WHERE id='.intval($cat), TRUE);

      $file=(is_file('../gallery/'.$data2['link'].'/'.$_FILES['upfile'.$i]['name'])) ? time(NULL).$i.'_'.$_FILES['upfile'.$i]['name'] : $_FILES['upfile'.$i]['name'];

      move_uploaded_file($_FILES['upfile'.$i]['tmp_name'], '../gallery/'.$data2['link'].'/'.$file);
      $name=(empty(${'name'.$i})) ? basename($_FILES['upfile'.$i]['name'], '.'.$extup) : ${'name'.$i};
      $sql->query('INSERT INTO hg3_img (id, id_cat, date_add, file, name, nb_view) VALUES ("", '.intval($cat).', '.time(NULL).', "'.$file.'", "'.addslashes($name).'", 0)');
    }
  }
  
  maj_cat(intval($cat));
  
  if(isset($submit_tn)) echo '<meta http-equiv="Refresh" content="0; URL=./?p=tn">';
}

$tpl=new template('img_add.tpl');

$req=$sql->query('SELECT id, id_cat, name FROM hg3_cat WHERE id_cat=0 ORDER BY name');
while($data=mysql_fetch_array($req)){
  $cat_arr[$my]['id']=$data['id'];
  $cat_arr[$my]['name']=$data['name'];
  $cat_arr[$my]['niv']=0;
  $my++;
  get_sous_cat($data['id']);
}

foreach($cat_arr as $k=>$v){
  for($j=1; $j<=$v['niv']; $j++) $tpl->parse(NULL, 'CAT.CAT_N');

  $tpl->parse(array(
    'selected'=>(isset($cat) && intval($cat)==$k) ? 'selected="selected"' : '',
    'id'=>$v['id'],
    'name'=>stripslashes($v['name'])), 'CAT');
}

echo $tpl->out();
?>
