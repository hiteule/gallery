<?php
// Language class version 1.0 by Stackouse
// ---------------------------------------
// Started on Mon, 25 of december 2006
// ---------------------------------------
// Cette petite classe vous permet d'avoir plusieurs langages dans votre site,
// en chargant les fichiers de la langue correspondante pour parsing automatique
// dans les templates.
// A utiliser avec la template class 3.0 by Stackouse
// For any questions contact me at stackouse@hotmail.com
// ----------------------------------------
// $var = new language($_GET['your_language_variable'], $default_lang_directory);
// $var->load($file)
// ----------------------------------------

// Configuration de la classe
// ----------------------------------------
// Reporté hor de la classe
// ----------------------------------------

class language{
      var $language = '';
      var $dir = DIR_LANGUAGE;
      
      function language($toload = '', $dir = DIR_LANGUAGE){
            if(!empty($toload) and is_dir($dir.'/'.$toload)){
                  $this->language = $toload;
                  $this->dir = $dir.'/'.$toload.'/';
                  setcookie('language', $toload, time()+360*24*3600);
            }
            else{
                  if(!empty($_COOKIE['language']) and is_dir($dir.'/'.$_COOKIE['language'])){
                        $this->language = $_COOKIE['language'];
                        $this->dir = $dir.'/'.$_COOKIE['language'].'/';
                  }
            }
            
            if(empty($this->language)){
                  $this->language = DEF_LANGUAGE;
                  $this->dir = $dir.'/'.DEF_LANGUAGE.'/';
                  setcookie('language', DEF_LANGUAGE, time()+360*24*3600);
            }
            
            define("LANGUAGE", $this->language);
      }
      
      function load($file){
            if(is_file($this->dir.$file)){
                  include_once($this->dir.$file);
                  foreach($lang as $k => $v) define('LANG_'.strtoupper($k), $v);
            }
            else
                  print 'Unable to load "'.$this->dir.$file.'": this file has not been found';
      }
}
?>
