<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Backend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

jimport( 'joomla.filesystem.folder' );


// If Xius System Plugin disabled then do nothing
$state = JPluginHelper::isEnabled('system', 'xius_system');
if(!$state){
    return true;
}

require_once( JPATH_ROOT . DS . 'components' . DS . 'com_xius'  . DS . 'includes.php');
require_once( dirname(__FILE__).DS.'helper.php' );

$url = 'index.php?option=com_xius&view=list&task=showList&listid=';
if(XiusHelperUtils::getConfigurationParams('integrateJomSocial',0) == true){	
	$url = 'index.php?option=com_community&view=list&task=showList&usexius=1&listid=';
}

$displayList= XiusListHelper::getListData();
	if(!empty($displayList)):?>
	
	<ul class="menu">
				<?php 
			foreach($displayList as $list):
				$link = $url.$list->id;				
				$link = XiusRoute::_($link, false);

				$name = $list->name;
				if(empty($name)){
					$name = 'LIST';
				}

				echo '<li><a href="'.$link.'">'.$name.'</a></li>';
			endforeach;
			?>
	</ul>
<?php 	
	endif;
