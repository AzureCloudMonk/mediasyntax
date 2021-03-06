<?php
/**
 * Mediasyntax Plugin, header component: Mediawiki style headers
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Esther Brunner <wikidesign@gmail.com>
 */
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
 
/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_mediasyntax_header extends DokuWiki_Syntax_Plugin 
{

    function getType()  { return 'container'; }
    function getPType() { return 'block'; }
    function getSort()  { return 49; }
  
    function getAllowedTypes()
    {
        return array('formatting', 'substition', 'disabled', 'protected');
    }
  
    function preConnect()
    {
        $this->Lexer->addSpecialPattern(
            '(?m)^[ \t]*=+[^\n]+=+[ \t]*$',
            'base',
            'plugin_mediasyntax_header'
        );
    }
  
    function handle($match, $state, $pos, Doku_Handler $handler)
    {
        global $conf;

        // get level and title
        $title = trim($match);
        $level = strspn($title, '=');
        if ($level < 1) $level = 1;
        elseif ($level > 5) $level = 5;
        $title = trim($title, '=');
        $title = trim($title);

        if ($handler->status['section']) $handler->_addCall('section_close', array(), $pos);

        if ($level <= $conf['maxseclevel'])
        {
            $handler->status['section_edit_start'] = $pos;
            $handler->status['section_edit_level'] = $level;
            $handler->status['section_edit_title'] = $title;
        }

        $handler->_addCall('header', array($title, $level, $pos), $pos);

        $handler->_addCall('section_open', array($level), $pos);
        $handler->status['section'] = true;
        return true;
    }
  
    function render($mode, Doku_Renderer $renderer, $data)
    {
        return true;
    }
}
 
//Setup VIM: ex: et ts=4 enc=utf-8 :
