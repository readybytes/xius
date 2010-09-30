<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');
jimport( 'joomla.filesystem.folder' );
require_once( JPATH_ROOT . DS . 'components' . DS . 'com_xius'  . DS . 'includes.php');
require_once( dirname(__FILE__).DS.'helper.php' );

$url = 'index.php?option=com_xius&view=list&task=showList&listid=';
if(XiusHelpersUtils::getConfigurationParams('integrateJomSocial',0) == true){	
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

				echo '<li><a href="'.$link.'">'.XiusText::_($name).'</a></li>';
			endforeach;
			?>
	</ul>
<?php 	
	endif;
