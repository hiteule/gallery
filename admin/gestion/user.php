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

$tpl=new template('user.tpl');

// MAJ infos perso
if(isset($id_edit, $login, $mailaddr, $statut) && !empty($id_edit) && ($statut=='user' || $statut=='admin' || $statut=='ban')){
  if(empty($login) || empty($mailaddr) || empty($statut)){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=1">';
    exit(0);
  }
  
  $data3=$sql->query('SELECT id, login FROM hg3_user WHERE login="'.addslashes($login).'" AND id!='.intval($id_edit), TRUE);
  if(!empty($data3['id'])){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=7">';
    exit(0);
  }
  
  if(!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $mailaddr)){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=8">';
    exit(0);
  }
  
  $ban=($statut=='ban' && $user->info['id']!=intval($id_edit)) ? 1 : 0;
  $admin=($statut=='admin' || ($user->info['id']==intval($id_edit) && $user->info['admin']==1)) ? 1 : 0;
  
  $sql->query('UPDATE hg3_user SET login="'.addslashes($login).'", mail="'.$mailaddr.'", ban='.$ban.', admin='.$admin.' WHERE id='.intval($id_edit));
}

// MAJ passwd
if(isset($id_edit, $pass0, $pass1) && !empty($id_edit)){
  if(empty($pass0) || empty($pass1)){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=1">';
    exit(0);
  }
  
  if(strcmp($pass0, $pass1)){
    echo '<meta http-equiv="Refresh" content="0; URL=./?p=error&amp;id=9">';
    exit(0);
  }
  
  $sql->query('UPDATE hg3_user SET pass="'.md5($pass0).'" WHERE id='.intval($id_edit));
}

// Formulaire
if(isset($id) && !empty($id)){
  $data2=$sql->query('SELECT id, login, mail, ban, admin FROM hg3_user WHERE id='.intval($id), TRUE);
  
  $selected_user=($data2['ban']!=1 && $data2['admin']!=1) ? 'selected="selected"' : '';
  $selected_admin=($data2['ban']!=1 && $data2['admin']==1) ? 'selected="selected"' : '';
  $selected_ban=($data2['ban']==1) ? 'selected="selected"' : '';
  
  $tpl->parse(array(
    'id'=>$data2['id'],
    'login'=>stripslashes($data2['login']),
    'mail'=>$data2['mail'],
    'selected_user'=>$selected_user,
    'selected_admin'=>$selected_admin,
    'selected_ban'=>$selected_ban), 'FORM');
}
// Liste
else{
  $req=$sql->query('SELECT id, login, ban, admin FROM hg3_user ORDER BY login');
  while($data=mysql_fetch_array($req)){
    if($data['ban']==1) $block='BAN';
    elseif($data['admin']==1) $block='ADMIN';
    else $block='USER';
  
    $tpl->parse(array(
      'id'=>$data['id'],
      'login'=>stripslashes($data['login'])), 'LIST.USER_LIST.'.$block);
      
    $tpl->parse(NULL, 'LIST.USER_LIST');
  }

  $tpl->parse(NULL, 'LIST');
}

echo $tpl->out();
?>
