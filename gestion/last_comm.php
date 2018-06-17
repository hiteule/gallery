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

$tpl=new template('last_comm.tpl');

if(!isset($sort) || empty($sort)) $sort='date';
if(!isset($order) || empty($order)) $order='DESC';
if(!isset($since) || empty($since) || $since=='begin') $date='';
elseif($since=='last30day') $date=' WHERE hg3_comment.date>'.(time(NULL)-2592000);
elseif($since=='last7day') $date=' WHERE hg3_comment.date>'.(time(NULL)-604800);
elseif($since=='today') $date=' WHERE hg3_comment.date>'.(time(NULL)-86400);

if(!isset($page) || empty($page) || $page<1) $page=1;

$l0=($page==1) ? 0 : ($config['number_last_comm'])*($page-1);
$l1=($config['number_last_comm']);

$i=0;
$req=$sql->query('SELECT hg3_comment.id AS id_comm, hg3_comment.id_img, hg3_comment.date, hg3_comment.name AS name_comm, hg3_comment.comment, hg3_img.id AS id_img, hg3_img.id_cat, hg3_img.name AS name_img, hg3_img.file, hg3_cat.id, hg3_cat.link
  FROM hg3_comment
  LEFT JOIN hg3_img ON hg3_img.id=hg3_comment.id_img
  LEFT JOIN hg3_cat ON hg3_cat.id=hg3_img.id_cat
  '.$date.' ORDER BY '.$sort.' '.$order.' LIMIT '.$l0.', '.$l1);
while($data=mysql_fetch_array($req)){
  $tn_link=(isset($data['link']) && !empty($data['link']) && is_file('./gallery/'.$data['link'].'/TN/TN-'.$data['file'])) ? './gallery/'.$data['link'].'/TN/TN-'.$data['file'] : './themes/'.$config['theme'].'/'.$config_theme['no_tn'];

  $tpl->parse(array(
    'id_img'=>$data['id_img'],
    'tn_link'=>$tn_link,
    'name_img'=>stripslashes($data['name_img']),
    'name_comm'=>stripslashes($data['name_comm']),
    'date_date'=>date($config['form_date'], $data['date']),
    'date_hour'=>date($config['form_hour'], $data['date']),
    'comment'=>stripslashes(nl2br(htmlentities($data['comment'], ENT_COMPAT, 'UTF-8')))), 'COMM');
  $i++;
}

$data2=$sql->query('SELECT count(hg3_comment.id) AS id_comm, hg3_comment.id_img, hg3_comment.date, hg3_comment.name AS name_comm, hg3_comment.comment, hg3_img.id AS id_img, hg3_img.id_cat, hg3_img.name AS name_img, hg3_img.file, hg3_cat.id, hg3_cat.link
  FROM hg3_comment
  LEFT JOIN hg3_img ON hg3_img.id=hg3_comment.id
  LEFT JOIN hg3_cat ON hg3_cat.id=hg3_img.id_cat
  '.$date, TRUE);

$nb_page=ceil($data2['id_comm']/$l1);

if($nb_page>1){
  if($page>1) $tpl->parse('page->'.($page-1), 'PAGE_BACK');
  else $tpl->parse(NULL, 'PAGE_BACK_NOK');

  for($j=1; $j<=$nb_page; $j++){
    if($j==$page) $tpl->parse('page->'.$j, 'PAGEROLL.PAGE_CUR');
    else $tpl->parse('page->'.$j, 'PAGEROLL.PAGE');

    $tpl->parse(NULL, 'PAGEROLL');
  }

  if($page<$nb_page) $tpl->parse('page->'.($page+1), 'PAGE_NEXT');
  else $tpl->parse(NULL, 'PAGE_NEXT_NOK');
}

echo $tpl->out();
?>
