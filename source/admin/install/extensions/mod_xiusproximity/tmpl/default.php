<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

//Call XIUS Functions

// load jquery
XiusHelperUtils::loadJQuery();

require_once( JPATH_ROOT . DS . 'modules'. DS .'mod_xiusproximity'. DS .'css'. DS .'proximity_css.php');
$template = JPATH_ROOT . DS . 'modules'. DS .'mod_xiusproximity'. DS .'css'. DS .'proximity_js.php';

ob_start();
include $template;
$output = ob_get_contents();
ob_end_clean();

JFactory::getDocument()->addScriptDeclaration( $output);
?>


	<div id="xiusProximity">
	<?php 

	if(isset($displayKeyword['html'])
	 ||isset($displayProximity['html'])):  ?>
		<form id="xiusMod<?php echo $module->id;?>" name="xiusMod<?php echo $module->id;?>" action="<?php echo XiusRoute::_($link,false);?>"  method=post>
			<div id="xiusKeyword">
			<div id="keywordHtml"><?php if($displayKeyword['html']) echo $displayKeyword['html'];?></div>
			</div>
			
			<div id="proximityDiv">
				<div id="proximityHtml"><?php if($displayProximity['html']) echo $displayProximity['html'];?></div>
			</div>
			
			<input type="hidden" name="fromPanel" value="true" />
			
			<div id="searchButton">
			 <input id="xiusMod<?php echo $module->id;?>Search" type="submit" value="<?php echo XiusText::_('SEARCH'); ?>" />
			</div>

		</form>
		<?php else: ?>
			<div id="xiusProxiError">
				<?php echo XiusText::_("ALL_SEARCHABLE_INFORMATION_HAS_BEEN_DISABLED_BY_ADMINISTRATOR");?>
			</div>
		<?php endif; ?>
	</div>