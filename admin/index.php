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
$config=parse_ini_file('../conf/conf.ini', TRUE);

// Test de l'installation de la galerie
if($config['installed']!='1') exit('Gallery not installed. Go to "install" dir to make your install');

// Parsage du fichier de config de thème
$config_theme=(is_file('./themes/'.$config['theme'].'/theme.ini')) ? parse_ini_file('./themes/'.$config['theme'].'/theme.ini') : parse_ini_file('./themes/default/theme.ini');

// Inclusion du fichier de config SQL
require('../conf/conf.php');

// Inclusion de la classe de gestion MySQL
require_once('../inc/mysql.class.php');

// Instanciation de la classe MySQL et connection à la bdd
$sql=new mysql(DBHOST, DBNAME, DBUSER, DBPASSWORD);
// On spécifie qu'on bosse en utf8
$sql->query("SET NAMES 'utf8'");

// Inclusion du fichier de fonction
require_once('./inc/function.php');

// Configuration et inclusion du moteur de template et de language. Un grand merci à Stackouse pour ces fameuses classes !
define('TPL_EXT', 'tpl');
define('DIR_TEMPLATE', './themes/default');
define('TPL_SYNCHRONISE', TRUE); // Synchroniser les templates par theme ?
define('CONSTANT_PARSE', TRUE); // Doit-on parser les constantes
define('STYLE', '../'.$config['theme']); // Style

require_once('../inc/template.class.php');

define('DIR_LANGUAGE', './lang'); // Repertoire ou sont stockés les langues
define('DEF_LANGUAGE', $config['lang']); // Langue a utiliser par defaut

require_once('../inc/language.class.php');
// Inclusion et instanciation de la classe d'utilisateur
require_once('../inc/user.class.php');

$user=new user('../conf/conf.php', '../inc/mysql.class.php', '../conf/conf.ini'); // Instanciation de la classe de gestion utilisateur
if($user->connect()) $user->info(); // Récupération des infos de l'utilisateur courant

// Test d'ouverture de la feuille de langue courante
if(($langopen=@fopen('../locales/'.$config['lang'].'/admin.lang.php', r))!=TRUE) exit('FATAL ERROR : File language fail.');
fclose($langopen);

// Définition de la langue courante à utiliser dans les templates
$tpl_lang=new language($config['lang'], '../locales');
$tpl_lang->load('admin.lang.php');
// Inclusion de la feuille de langue courante
require('../locales/'.$config['lang'].'/admin.lang.php');

if($user->connect()==FALSE || $user->info['admin']!=1){
  echo '<meta http-equiv="Refresh" content="0; URL=../?p=login">';
  exit(0);
}

$tpl=new template('header.tpl');
$tpl->parse(array(
  'title'=>$config['title'],
  'version'=>VERSION));
echo $tpl->out();

$tpl_menu=new template('menu.tpl');
$tpl=new template('content_before.tpl');
$tpl->parse('menu->'.$tpl_menu->out());
echo $tpl->out();

// Inclusion de la page courante
$p=(!isset($p) || empty($p)) ? 'dashboard' : $p;
$array_p=array(
  '404'=>'./gestion/404.php',
  'error'=>'./gestion/error.php',
  'dashboard'=>'./gestion/dashboard.php',
  'comments'=>'./gestion/comments.php',
  'cat'=>'./gestion/cat.php',
  'img'=>'./gestion/img.php',
  'tn'=>'./gestion/tn.php',
  'img_add'=>'./gestion/img_add.php',
  'cat_add'=>'./gestion/cat_add.php',
  'user'=>'./gestion/user.php',
  'conf'=>'./gestion/conf.php',
  'about'=>'./gestion/about.php',
  'maintenance'=>'./gestion/maintenance.php',
  'sync'=>'./gestion/sync.php',
  'theme'=>'./gestion/theme.php',
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
