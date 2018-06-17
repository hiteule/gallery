<?php
// Template class 4.0 par Stackouse
// Contact: stackouse@hotmail.com
// ---------------------------------------
// Script commencé le: 17/05/2007
// Dernière modifications: 25/12/2008
// ---------------------------------------
// Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon
// les termes de la Licence Creative Commons:
// Paternité-Pas d'utilisation commerciale-Partage des Conditions Initiales à
// l'Identique 2.0 France
// http://creativecommons.org/licenses/by-nc-sa/2.0/fr/
// ----------------------------------------
// Liste des constantes à définir:
// > Temmplates
// TPL_EXT          => extension des fichiers templates, sans point
// DIR_TEMPLATE     => repertoire par defaut des templates
// TPL_SYNCHRONISE  => synchro des templates par style ? (true/false)
// CONSTANT_PARSE   => parsing des constantes automatiquement (true/false)
// > Extras
// EXTRA_PARSE      => parsing des blocs "extras"
// EXTRA_JS         => centralisation des fichiers javascript dans un fichier ? (true/false)
// DIR_JS           => Dossier des fichiers js a enregistrer
// > Style
// STYLE            => Style en cours
// -----------------------------------------
// Aucun paramètrage en dehors de ces constantes n'est requis.
// Enjoy :)

class template {
    var $file = ''; // Chemin du fichier template en cours d'utilisation
    var $filename = ''; // Fichier template en cours d'utilisation
    var $style_sync = false; // Le fichier template est-il synchronisé par style ? (t/f)
    var $content = ''; // Contenu de $file
    var $structure = array(); // Structure du fichier $file
    var $switches = array(); // Liste des switchs
    var $tampon = array(); // Tableau tampon pour le contenu des blocks enfants
    var $parsed = false; // Etat de parse de $file (t/f)

    function template($file = '', $dir = DIR_TEMPLATE) {

        if ($this->_is_valid($file, $dir)) {
            // Si on synchronise les templates, alors on regarde si un fichier n'est pas spécifique au theme actuel
            if (TPL_SYNCHRONISE == true and $this->_is_valid($file, $dir . '/' . STYLE)) {
                $this->file = $dir . '/' . STYLE . '/' . $file;
                $this->style_sync = true;
            }
            // Si pas de template spécifique, on charge le fichier demandé
            if (empty($this->file)) $this->file = $dir . '/' . $file;
            // Fichier en cours
            $this->filename = $file;
        }
        // Sinon si le fichier n'est pas valide
        else {
            print 'Impossible de charger "' . $dir . '/' . $file . '": fichier non trouvé';
            return false;
        }

        // On a donc maintenant un fichier valide, le découpage sera effectué au premier appel de $this->parse
        $this->_load_first_pass();
        $this->_load_second_pass();

        return true;
    }

    # Retourne la validité du fichier $dir/$file:
    # - retourne true si le fichier existe et à bien l'extention désirée
    # - retourne false dans le cas contraire
    function _is_valid($file, $dir) {
        $i = strlen(TPL_EXT) + 1;
        return (is_file($dir . '/' . $file) and substr($file, -$i) == '.' . TPL_EXT) ? true : false;
    }

    # Cette fonction précharge a proprement dit le fichier $file qui est
    # nécessairement valide. Au programme: parsing des variables de langue,
    # des constantes, puis decoupage en blocs
    function _load_first_pass($content = '', $blockname = 'CORE') {
        // Chargement du contenu du fichier
        if ($content == '') {
            $content = file_get_contents($this->file);
            //Si le parsing des constantes est activé, alors on l'execute
            if (CONSTANT_PARSE == true) $content = preg_replace_callback("`{([-A-Z0-9_]+)}`", array($this, '_callback_const'), $content);
            $this->content = $content;
        }

        // On va maintenant découper le fichier en blocks, sous blocks
        preg_match_all('`<!-- ([-A-Z0-9_]+) -->(.+)<!-- /\\1 -->`isU', $content, $out, PREG_SET_ORDER);

        for ($i = 0; $i < count($out); $i++) {
            if ($out[$i][1] != 'CORE') {
                $this->_load_first_pass($out[$i][2], $blockname . '.' . $out[$i][1]);
                $inner = preg_replace('`<!-- ([-A-Z0-9_]+) -->.+<!-- /\\1 -->`isU', "<!-- $1 -->", $out[$i][2]);
                $this->structure[$blockname . '.' . $out[$i][1]] = $inner;

                // Si premier niveau
                if ($blockname == 'CORE') {
                    $this->content = preg_replace("`<!-- " . $out[$i][1] . " -->.+<!-- /" . $out[$i][1] ." -->`isU", "<!-- " . $out[$i][1] . " -->", $this->content);
                    //$this->structure['CORE'] = preg_replace("`<!-- ".$out[$i][1]." -->.+<!-- /".$out[$i][1]." -->`isU", "<!-- ".$out[$i][1]." -->", $this->structure['CORE']);
                }
            } else {
                print 'Impossible d\'utiliser "' . $this->file .'": un block "CORE" à été détecté !';
            }
        }

        // La structure du fichier est déterminée :)
        unset($out);
    }

    # Deuxieme partie du chargement du fichier: on ajoute juste le block principal
    # à la liste des blocks :) (_load_first_pass étant récursive, inutile de le faire
    # x fois de suite pour le meme résultat)
    function _load_second_pass() {
        $this->structure['CORE'] = $this->content;
    }


    # Callback du preg_replace_callback de la fonction _load(), qui permet le parsing des constantes
    function _callback_const($matches) {
        if (defined($matches[1])) return constant($matches[1]);
    }

    # Cette fonction se charge de parser les variables passées dans le tableau $parse
    # et contenues dans le block $block. Si $block est vide, alors les variables sont
    # parsées dans le core
    function parse($parse = '', $block = 'CORE') {

        // Premiere preoccupation, est ce que le block existe
        $block = $this->_check_core($block);

        if (array_key_exists($block, $this->structure)) {
            // Si parse n'est pas un tableau, le script supporte la syntaxe:
            // 'variable->valeur' et vas le reconnaître comme tableau

            if (!is_array($parse) and !empty($parse)) {
                $temp = explode('->', $parse, 2);
                unset($parse);
                $parse[$temp[0]] = $temp[1];
            }

            // Si on a rien a parser, on parse un tableau vide
            if (empty($parse)) $parse = array();

            // Bon bah avec tout ca, on ne peut que parser un tableau, non ?
            // On met quand meme un contrôle, on sait jamais qu'une chaîne chinoise du FBI
            // ait réussi à s'insinuer jusqu'ici :P
            if (is_array($parse)) {
                // Si c'est bien un tableau, on le traite comme tel :)
                foreach ($parse as $k => $v) {
                    $parse['{' . $k . '}'] = $v;
                    unset($parse[$k]);
                }

                // A chercher maintenant: est ce qu'on est dans un sous block ?
                // Easy win: si il y a + d'un point dans le block, on est dans un sous block :D
                $level = substr_count($block, '.') - 1;

                // Premiere etape: on parse
                $content = str_replace(array_keys($parse), array_values($parse), $this->structure[$block]);

                // Deuxieme étape: on recupere le tampon
                // Listing des blocks dedans
                // On regarde si on en a en tampon
                preg_match_all("`<!-- ([-A-Z0-9_]+) -->`is", $this->structure[$block], $inner);

                foreach ($inner[1] as $tampon) {
                    // Si on a du tampon
                    if (isset($this->tampon[$block . '.' . $tampon]) && $this->tampon[$block . '.' . $tampon] != '') {
                        $content = preg_replace('`<!-- ' . $tampon . ' -->`', $this->tampon[$block . '.' .$tampon], $content);
                        // On efface le tampon avant
                        unset($this->tampon[$block . '.' . $tampon]);
                    }
                }

                // Troisieme étape: on met en tampon si besoin
                if ($level >= 1) {
                    if (array_key_exists($block, $this->tampon)) {
                        $this->tampon[$block] .= $content;
                    } else {
                        $this->tampon[$block] = $content;
                    }
                } elseif ($level < 1) {
                    $name = substr($block, 5);
                    //$this->content = ($block != 'CORE') ? preg_replace('`<!-- ' . $name . ' -->`', $content .'<!-- ' . $name . ' -->', $this->content) : $content;
                    $this->structure['CORE'] = ($block != 'CORE') ? preg_replace('`<!-- ' . $name .' -->`', $content . '<!-- ' . $name . ' -->', $this->structure['CORE']) : $content;
                }
            }
        } else {
            print 'Unable to find block ' . substr($block, 5) . ' !';
            return false;
        }
    }

    # Le block courant est-il dans le core ?
    function _check_core($block) {
        $block = strtoupper($block);
        if ($block == '') $block = 'CORE';
        $block = (substr($block, 0, 4) == 'CORE') ? $block : 'CORE' . '.' . $block;

        return $block;
    }

    # Cette fonction parse les blocs 'extras' du contenu global, et les injecte
    # dans la variable correspondante du fichier template $tpl
    function inject(&$extra) {

        if (EXTRA_PARSE and is_object($extra)) {
            // On recupère les blocs extras
            preg_match_all('`<!-- (extra\.[-A-Z0-9_]+) -->(.+)<!-- /\\1 -->`isU', $this->structure['CORE'], $out, PREG_SET_ORDER);

            if (!empty($out)) {
                // Preparation des remplacements à effectuer
                $replace = array();

                for ($i = 0; $i < count($out); $i++) {
                    $block = "{" . strtolower($out[$i][1]) . "}";

                    // Si on a un block javascript a extraire, on met en tampon
                    if ($block == '{extra.js}' and EXTRA_JS) {
                        $this->tampon['_JS_'] .= $out[$i][2];
                    } else {
                        $replace[$block] .= $out[$i][2];
                    }

                    $this->structure['CORE'] = str_replace(trim($out[$i][0]), '', $this->structure['CORE']);
                }

                // Si le fichier n'existe pas
                if (EXTRA_JS and !empty($this->tampon['_JS_'])) {
                    // Enregistrement du javascript
                    $dir = ($this->style_sync == true) ? DIR_JS . '/' . STYLE . '/' : DIR_JS . '/';
                    $file = substr($this->filename, 0, -strlen(TPL_EXT) - 1);
                    $js = $dir . $file;
                    $js .= '_' . filemtime($this->file) . '.js';

                    if (!is_file($js)) {
                        //on nettoie les fichiers js plus anciens
                        $d = dir($dir);
                        while (false !== ($entry = $d->read())) if (preg_match('`' . $file . '_[0-9]+\.js`', $entry) == true) unlink($dir . $entry);
                        $d->close();

                        // On enregistre le fichier
                        $h = fopen($js, "w");
                        fwrite($h, $this->tampon['_JS_']);
                        fclose($h);
                    }

                    $extra->structure['CORE'] = str_replace('{extra.js}', '<script language="javascript" src="' . $js . '" /></script>{extra.js}', $extra->structure['CORE']);
                }

                $extra->structure['CORE'] = str_replace(array_keys($replace), array_values($replace),$extra->structure['CORE']);
            }
        }
    }

    # Cette fonction retourne le contenu du fichier parsé, après nettoyage
    # Ou le contenu du block, si requis
    function out($block = 'CORE') {
        // Premiere preoccupation, est ce que le block est dans le core ?
        $block = $this->_check_core($block);

        if (array_key_exists($block, $this->structure)) {
            $content = $this->structure[$block];
        } else {
            $content = $this->structure['CORE'];
        }

        // Nettoyage...
        $content = preg_replace("`{[-A-Za-z0-9_]+}`", '', $content); // Variables/constantes
        $content = preg_replace("`{extra\.[-A-Za-z0-9_]+}`", '', $content); // Variables 'extras'
        $content = preg_replace('`<!-- [-A-Za-z0-9_]+ -->`', '', $content); // Blocks
        $content = str_replace('noparse.', '', $content); // Blocks non parsés

        // Variables switch
        $content = preg_replace_callback("`{switch\.([-A-Za-z0-9_]+)=\"(.+,*)\"}`", array($this, '_callback_out'), $content);

        return $content;
    }

    # Callback pour les variables switch
    function _callback_out($matches) {
        if (array_key_exists($matches[1], $this->switches)) {
            $current = $this->switches[$matches[1]]['current'];
            $max = count($this->switches[$matches[1]]) - 2;
            $this->switches[$matches[1]]['current'] = (++$current > $max) ? 0 : $current;
        } else {
            $list = explode(',', $matches[2]);
            for ($i = 0; $i < count($list); $i++) if (!empty($list[$i])) $this->switches[$matches[1]][] = $list[$i];
            $this->switches[$matches[1]]['current'] = 0;
        }

        return $this->switches[$matches[1]][$this->switches[$matches[1]]['current']];
    }
}

?>