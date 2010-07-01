<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
defined('_JEXEC') or die('Restricted access');
$document =& JFactory::getDocument();
if ($params->get('xius_layout','horizontal')=='vertical')
	$document->addStyleSheet('modules/mod_xiussearchpanel/css/mod_xiussearchpanel_ver.css');
else
	$document->addStyleSheet('modules/mod_xiussearchpanel/css/mod_xiussearchpanel_hz.css');
	
	//$document->addStyleSheet('components/com_community/templates/default/css/style.css')
?>

<?php
// set module form name in seesion
$mySess =& JFactory::getSession();
$mySess->set('xiusModuleForm',"xiusMod{$module->id}",'XIUS');


		
jimport( 'joomla.filesystem.folder' );
require_once( JPATH_ROOT . DS . 'components' . DS . 'com_xius'  . DS . 'includes.php');
require_once( dirname(__FILE__).DS.'helper.php' );
//XITODO : use proper name
$disp= UserSearchHelper::getSearchHtml();
	if(!empty($disp)):
//XITODO: fix the bug in pagignation of module
		$link = 'index.php?option=com_xius&view=users&task=displaySearch&subtask=xiussearch';
		$menu = &JSite::getMenu(); 
		$itemid = $menu->getItems('link', $link);
		if(empty($itemid))
			$itemid = $menu->getItems('link', "index.php?option=com_xius&view=users&layout=lists&task=displayList");
			
		if(!empty($itemid))
			$link .= "&Itemid=".$itemid[0]->id;
			
		ob_start();
	?>
	<div class="xiusMod_available">
		<form id="xiusMod<?php echo $module->id;?>" name="xiusMod<?php echo $module->id;?>" action="<?php echo JRoute::_($link,false);?>" method=post>
		<?php 	
			$infoRange = $params->get('xius_info_range','all');
			$range=array();
			if( 'all' != strtolower($infoRange) )
				$range = UserSearchHelper::getInfoRange($infoRange);
				
			$count=0;
			foreach($disp as $data):
				$count++;
				if(count($range)>0){
					 if( $range['start']!=0 && $count < $range['start'])
						continue;
					 if($range['end']!=0 && $count > $range['end']) 
						break;
				}
			?> 
				<div class="xiusMod_availablemain">
				<div class="xiMod_left"><?php echo JText::_($data['label']);?></div>
				<div class="xiMod_right"><?php echo $data['html'];?></div>
			   	</div>	
			<?php 
			endforeach;
			?>
			<div class ="xiusModSearch"><input type="submit" value="Search" /></div>
		</form>
	</div>
	<?php 
	$contents	= ob_get_clean();
	$mySess->clear('xiusModuleForm','XIUS');
	echo $contents;
	endif;
?>

