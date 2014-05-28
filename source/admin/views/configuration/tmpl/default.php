<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Backend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

//XITODO : add all backend views
//JHTML::_('behavior.tooltip', '.hasTip');

// load jquery
XiusHelperUtils::loadJQuery();
?>

<div id="XIUS">
<form action="<?php echo JURI::base();?>index.php?" method="post" name="adminForm" id="adminForm">

<div class="col width-50" style="float:left;width:50%">
	<fieldset class="adminform">
	<legend><?php echo XiusText::_( 'BASIC_CONFIGURATION' ); ?></legend>
		<div>
			<?php echo $this->params->render('xiusparams','basicXiusTemplate');?>		
			<?php echo $this->params->render('xiusparams','basicXiusSearch');?>
			<?php echo $this->params->render('xiusparams','basicXiusList');?>
		</div>
	</fieldset>
</div>

<div class="col width-50" style="float:right;width:50%" >
	<fieldset class="adminform">
		<legend><?php echo XiusText::_( 'ADVANCE_CONFIGURATION' ); ?></legend>
		<div id="xiusAdvanceTemplate">
			<?php echo $this->params->render('xiusparams','advXiusTemplate');?>
			<?php echo $this->params->render('xiusparams','advXiusSort');?>    
			<?php echo $this->params->render('xiusparams','advXiusSearch');?>
			<?php echo $this->params->render('xiusparams','advXiusLimit');?>
			<?php echo $this->params->render('xiusparams','autoCacheUpdate');?>
			<?php echo $this->params->render('xiusparams','advXiusList');?>
			<?php echo $this->params->render('xiusparams','expertSetting');?>
		</div>
	</fieldset>
</div>

<div class="clr"></div>
<input type="hidden" name="view" value="configuration" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_xius" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHtml::_( 'form.token' ); ?>
</form>	
</div>
