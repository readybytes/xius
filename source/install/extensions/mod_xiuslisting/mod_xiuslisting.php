<?php
defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.filesystem.folder' );
//require_once( JPATH_ROOT . DS . 'components' . DS . 'com_xius'  . DS . 'includes.php');
require_once( dirname(__FILE__).DS.'helper.php' );
//XITODO : use proper name for disp , apply itemid also
$disp= ListHelper::getListData();
	if(!empty($disp)):?>
	
	<ul class="menu">
				<?php 
			foreach($disp as $l):
			$url = JRoute::_('index.php?option=com_xius&view=users&task=displayList&listid='.$l->id,false);
				$name = $l->name;
				if(empty($name))
					{
						$name = 'LIST';
					}
				echo '<li><a href="'.$url.'">'.JText::_($name).'</a></li>';
			endforeach;
			?>
	</ul>
<?php 	
	endif;
?>
