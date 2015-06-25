<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Backend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

//Call XIUS Functions

// load jquery
XiusHelperUtils::loadJQuery();

//load bootstrap
XiusHelperUtils::loadBootstrap();

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
			<div id="xiusKeyword" class="row-fluid xius-margin">
				<div class="span3"><strong><?php echo XiusText::_('FIND');?></strong></div>
				<div id="keywordHtml span9 xius-margin"><?php if($displayKeyword['html']) echo $displayKeyword['html'];?></div>
			</div>
			
			<div id="proximityDiv" class="row-fluid">
				<div id="proximityHtml"><?php if($displayProximity['html']) echo $displayProximity['html'];?></div>
			</div>
			
			<div id="searchButton" class="row-fluid xius-margin text-center">
			 <input zid="xiusMod<?php echo $module->id;?>Search" type="submit" value="<?php echo XiusText::_('SEARCH'); ?>" />
			</div>

			<input type="hidden" name="fromPanel" value="true" />
		</form>
		<?php else: ?>
			<div id="xiusProxiError" class="row-fluid">
				<?php echo XiusText::_("ALL_SEARCHABLE_INFORMATION_HAS_BEEN_DISABLED_BY_ADMINISTRATOR");?>
			</div>
		<?php endif; ?>
	</div>