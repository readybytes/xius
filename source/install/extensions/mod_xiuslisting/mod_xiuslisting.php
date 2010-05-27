<?php
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.filesystem.folder' );
require_once( JPATH_ROOT . DS . 'components' . DS . 'com_xius'  . DS . 'includes.php');
require_once( dirname(__FILE__).DS.'helper.php' );

$displayList= XiusListHelper::getListData();
	if(!empty($displayList)):?>
	
	<ul class="menu">
				<?php 
			foreach($displayList as $list):
				$link = 'index.php?option=com_xius&view=users&layout=lists&task=displayList';
				$menu = &JSite::getMenu(); 
				$itemid = $menu->getItems('link', $link);
				$link.='&listid='.$list->id;
				if(empty($itemid))
					$itemid = $menu->getItems('link', "index.php?option=com_xius&view=users");
				
				if(!empty($itemid))
					$link .= "&Itemid=".$itemid[0]->id;
		
				$link = JRoute::_($link, false);
					
				$name = $list->name;
				if(empty($name))
					$name = 'LIST';

				echo '<li><a href="'.$link.'">'.JText::_($name).'</a></li>';
			endforeach;
			?>
	</ul>
<?php 	
	endif;
?>
