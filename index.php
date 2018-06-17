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
// Microtime de début d'éxécution
$time_start=microtime(NULL);

// Initialisation des sessions
session_start();

// Parsage du fichier de config général
$config=parse_ini_file('./conf/conf.ini', TRUE);
// Parsage du fichier de config du thème
$config_theme=parse_ini_file('./themes/'.$config['theme'].'/theme.ini', TRUE);

// Test de l'installation de la galerie
if($config['installed']!='1') exit('Gallery not installed. Go to "install" dir to make your install');

// Test de l'ouverture de la galerie
if($config['open']!='1') exit('Gallery closed');

date_default_timezone_set($config['timezone']);

// Inclusion du fichier de config SQL
require('./conf/conf.php');

// Inclusion de la classe de gestion MySQL
require_once('./inc/mysql.class.php');

// Instanciation de la classe MySQL et connection à la bdd
$sql=new mysql(DBHOST, DBNAME, DBUSER, DBPASSWORD);
// On spécifie qu'on bosse en utf8
$sql->query("SET NAMES 'utf8'");

// Inclusion du fichier de fonction
require_once('./inc/function.php');

if (isset($_POST['view_password'])) {
  $_SESSION['view_password']=$_POST['view_password'];
  header('Location: '.$uri);
}

// Configuration et inclusion du moteur de template et de language. Un grand merci à Stackouse pour ces fameuses classes !
define('TPL_EXT', 'tpl');
define('DIR_TEMPLATE', './themes/default');
define('TPL_SYNCHRONISE', TRUE); // Synchroniser les templates par theme ?
define('CONSTANT_PARSE', TRUE); // Doit-on parser les constantes
define('STYLE', '../'.$config['theme']); // Style

require_once('./inc/template.class.php');

define('DIR_LANGUAGE', './lang'); // Repertoire ou sont stockés les langues
define('DEF_LANGUAGE', $config['lang']); // Langue a utiliser par defaut

require_once('./inc/language.class.php');
// Inclusion et instanciation de la classe d'utilisateur
require_once('./inc/user.class.php');

$user=new user('./conf/conf.php', './inc/mysql.class.php', './conf/conf.ini'); // Instanciation de la classe de gestion utilisateur
if($user->connect()) $user->info(); // Récupération des infos de l'utilisateur courant

// Test d'ouverture de la feuille de langue courante
if(($langopen=@fopen('./locales/'.$config['lang'].'/main.lang.php', r))!=TRUE) exit('FATAL ERROR : File language fail.');
fclose($langopen);

// Définition de la langue courante à utiliser dans les templates
$tpl_lang=new language($config['lang'], './locales');
$tpl_lang->load('main.lang.php');
// Inclusion de la feuille de langue courante
require('./locales/'.$config['lang'].'/main.lang.php');

$tpl=new template('header.tpl');
$tpl->parse(array(
  'title'=>$config['title'],
  'description'=>$config['description']));
echo $tpl->out();

$tpl=new template('menu.tpl');
if($user->connect()==FALSE){
  $uri_arr=explode('/', $_SERVER['REQUEST_URI']);
  
  $tpl->parse('uri->'.urlencode(end($uri_arr)), 'LOGOUT');
}
else{
  if($user->info['admin']==1) $tpl->parse(NULL, 'LOGIN.ADMIN');
  $tpl->parse('login->'.stripslashes($user->info['login']), 'LOGIN');
}
echo $tpl->out();

$tpl=new template('content_before.tpl');
echo $tpl->out();

// Inclusion de la page courante
$p=(!isset($p) || empty($p)) ? 'cat' : $p;
if (have_to_view_login()) {
  $p = 'view_login';
}
$array_p=array(
  '404'=>'./gestion/404.php',
  'error'=>'./gestion/error.php',
  'cat'=>'./gestion/cat.php',
  'img'=>'./gestion/img.php',
  'login'=>'./gestion/login.php',
  'subscribe'=>'./gestion/subscribe.php',
  'pass_lost'=>'./gestion/pass_lost.php',
  'last_comm'=>'./gestion/last_comm.php',
  'most_viewed'=>'./gestion/most_viewed.php',
  'account'=>'./gestion/account.php',
  'view_login'=>'./gestion/view_login.php',
);
if(!array_key_exists($p, $array_p) || !is_file($array_p[$p])) include($array_p['404']); // Fichier non trouvé, on redirige en 404
else include($array_p[$p]); // On inclus la page

$tpl=new template('content_after.tpl');
echo $tpl->out();

// Affectation du pluriel ou du singulié en fonction du nombre de requête SQL
$lang_query=($sql->nbr_queries>1) ? $lang['QUERYS'] : $lang['QUERY'];

$tpl=new template('footer.tpl');
$tpl->parse(array(
  'nbquery'=>$sql->nbr_queries,
  'lang_query'=>$lang_query,
  'exec_time'=>exec_time($time_start, microtime(NULL))));
echo $tpl->out();
?>
