<?php
/**
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_JEXEC' ) or die;

include_once (dirname(__FILE__).'/52n_templatetools_2.5.php');
//$mainframe =& JFactory::getApplication('site');
$app = JFactory::getApplication();

//$tmpTools = new JA_Tools($this, array(JA_TOOL_MENU, JA_TOOL_COLOR));	//For demo
$tmpTools = new JA_Tools($this);										//For release

# Auto Collapse Divs Functions ##########
$ja_left = $this->countModules('left');
$ja_right = $this->countModules('right');

if ( $ja_left && $ja_right )
{
	$divid = '';
}
elseif ( $ja_left )
{
	$divid = '-fr';
	
} 
elseif ( $ja_right )
{
	$divid = '-fl';
} 
else 
{
	$divid = '-f';
}

//Main navigation
$ja_menutype = $tmpTools->getParam(JA_TOOL_MENU);
include_once( dirname(__FILE__).'/52n_menus/Base.class.php' );
$japarams = JA_Base::createParameterObject('');
$japarams->set( 'menutype', $tmpTools->getParam('menutype', 'mainmenu') );
$japarams->set( 'menu_images_align', 'left' );
$japarams->set( 'menupath', $tmpTools->templateurl() .'/52n_menus');
$japarams->set('menu_title', 0);
switch ($ja_menutype) {
	case 'css':
		$menu = "CSSmenu";
		include_once( dirname(__FILE__).'/52n_menus/'.$menu.'.class.php' );
		break;
	case 'moo':
		$menu = "Moomenu";
		include_once( dirname(__FILE__).'/52n_menus/'.$menu.'.class.php' );
		break;
	case 'split':
	default:
    $japarams->set('menu_title', 0);
		$menu = "CSSmenu";
		include_once( dirname(__FILE__).'/52n_menus/'.$menu.'.class.php' );
		break;
}
$menuclass = "JA_$menu";
$jamenu = new $menuclass ($japarams);

$hasSubnav = false;
if ($jamenu->hasSubMenu(1) && $jamenu->showSeparatedSub )
{
	$hasSubnav = true;
}
//End for main navigation

?>
