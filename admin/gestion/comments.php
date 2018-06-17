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

define('NB_COMM_PER_PAGE', 30);

$tpl=new template('comments.tpl');

// Supression
if(isset($_POST['comm']) && !empty($_POST['comm'])){
  foreach($_POST['comm'] as $k=>$v) $sql->query('DELETE FROM hg3_comment WHERE id='.$k);
}

$data2=$sql->fetch('SELECT count(*) AS nb_comm FROM hg3_comment');

if(!isset($page) || empty($page) || $page<1) $page=1;
$l0=($page==1) ? 0 : (NB_COMM_PER_PAGE*($page-1));
$nb_page=ceil($data2['nb_comm']/NB_COMM_PER_PAGE);

if(isset($author) && !empty($author)) $where=' WHERE hg3_comment.name="'.addslashes($author).'"';
else{
  $where='';
  $author='';
}

$req=$sql->fetchAll('SELECT hg3_comment.id AS id_comm, hg3_comment.id_img, hg3_comment.date, hg3_comment.name AS auteur, hg3_comment.comment, hg3_img.id AS id_img, hg3_img.name FROM hg3_comment LEFT JOIN hg3_img ON hg3_img.id=hg3_comment.id_img'.$where.' ORDER BY hg3_comment.date DESC LIMIT '.$l0.', '.NB_COMM_PER_PAGE);
foreach ($req as $data) {
  $content=(strlen($data['comment'])<=40) ? stripslashes(htmlentities($data['comment'], ENT_COMPAT, 'UTF-8')) : substr(htmlentities($data['comment'], ENT_COMPAT, 'UTF-8'), 0, 40).' '.$lang['TEXT_CUT'];
  
  $tpl->parse(array(
    'id_comm'=>$data['id_comm'],
    'id_img'=>$data['id_img'],
    'content'=>$content,
    'auteur'=>stripslashes($data['auteur']),
    'name'=>stripslashes($data['name']),
    'date_date'=>date($config['form_date'], $data['date']),
    'date_hour'=>date($config['form_hour'], $data['date']),
    ), 'COMMENT');
}

if($page>1){
  $tpl->parse(array(
    'author'=>$author,
    'page'=>($page-1)), 'PAGE_BACK');
}
else $tpl->parse(NULL, 'PAGE_BACK_NOK');

for($j=1; $j<=$nb_page; $j++){
  if($j==$page) $tpl->parse('page->'.$j, 'PAGEROLL.PAGE_CUR');
  else{
    $tpl->parse(array(
      'author'=>$author,
      'page'=>$j), 'PAGEROLL.PAGE');
  }

  $tpl->parse(NULL, 'PAGEROLL');
}

if($page<$nb_page){
  $tpl->parse(array(
    'author'=>$author,
    'page'=>($page+1)), 'PAGE_NEXT');
}
else $tpl->parse(NULL, 'PAGE_NEXT_NOK');

echo $tpl->out();
?>
