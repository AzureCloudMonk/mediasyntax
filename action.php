<?php
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Esther Brunner <wikidesign@gmail.com>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');

class action_plugin_mediasyntax extends DokuWiki_Action_Plugin 
{

  /**
   * register the eventhandlers
   */
  function register(&$contr){
    $contr->register_hook('TOOLBAR_DEFINE',
                          'AFTER',
                          $this,
                          'define_toolbar',
                           array());
  }

  /**
   * modifiy the toolbar JS defines
   *
   * @author  Esther Brunner  <wikidesign@gmail.com>
   */
  function define_toolbar(&$event, $param){
    // return false;  
    if ($this->getConf('precedence') != 'mediasyntax') return false; // leave untouched
        
    $c = count($event->data);
    for ($i = 0; $i <= $c; $i++){
      if ($event->data[$i]['type'] == 'format'){
        
        // headers
        if (preg_match("/h(\d)\.png/", $event->data[$i]['icon'], $match)){
          $markup = substr('======', 0, $match[1]);
          $event->data[$i]['open']  = $markup." ";
          $event->data[$i]['close'] = " ".$markup."\\n";
          
        // ordered lists
        } elseif ($event->data[$i]['icon'] == 'ol.png'){
          $event->data[$i]['open']  = "# ";
          
        // unordered lists
        } elseif ($event->data[$i]['icon'] == 'ul.png'){
          $event->data[$i]['open']  = "* ";
        }
      }
    }
    
    return true;
  }
  
}

//Setup VIM: ex: et ts=4 enc=utf-8 :
