<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
if(!defined('_JEXEC')) die('Restricted access');
//XITODO : add all backend views
JHTML::_('behavior.tooltip', '.hasTip');

// load jquery
XiusHelperUtils::loadJQuery();
?>
<style type="text/css">
       #toolbar-updateCache
       {
           background-image:  url(../components/com_xius/assets/images/icon_update_cache.png);
           background-repeat:no-repeat;
           background-position: top center;
        }     
</style>

<script type="text/javascript">
	jQuery(document).ready(function($){
			$("div#xiusAdvanceTemplate").css("display","none");
			$("input#advanceConfig").click(function(){
			$("div#xiusAdvanceTemplate").slideToggle();
		});	
	});
	
</script>

<div>
<form action="<?php echo JURI::base();?>index.php?" method="post" name="adminForm">

<?php  
/*jimport('joomla.html.pane');
		$pane = &JPane::getInstance('sliders', array('allowAllClose' => true));
		echo $pane->startPane('configuration-pane');*/
?>
<div class="col width-45" style="float:left;">
<fieldset class="adminform">
<legend><?php echo XiusText::_( 'BASIC CONFIGURATION' ); ?></legend>
	<div>
	<fieldset class="adminform" id="xiusBasicTemplate">
		<legend><?php echo XiusText::_( 'TEMPLATE CONFIGURATION' ); ?></legend>
		<?php echo $this->params->render('xiusparams','basicXiusTemplate');?>		
	</fieldset>
	</div>

	<div>
	<fieldset class="adminform">
		<legend><?php echo XiusText::_( 'SEARCH CONFIGURATION' ); ?></legend>
			<?php echo $this->params->render('xiusparams','basicXiusSearch');?>
	</fieldset>
	</div>
	
	<div>
	<fieldset class="adminform">
		<legend><?php echo XiusText::_( 'LIST CONFIGURATION' ); ?></legend>
		<?php echo $this->params->render('xiusparams','basicXiusList');?>
	</fieldset>	
	</div>
</fieldset>
</div>

<div class="col width-45" style="float:right;" >
<fieldset class="adminform">
<legend><input type="checkbox" id="advanceConfig"><?php echo XiusText::_( 'ADVANCE CONFIGURATION' ); ?></legend>
	<?php echo XiusText::_('ADVANCE CONFIGURATION DESCRIPTION');?>
	<div id="xiusAdvanceTemplate">
	<fieldset class="adminform">
		<legend><?php echo XiusText::_( 'TEMPLATE CONFIGURATION' ); ?></legend>
		<?php echo $this->params->render('xiusparams','advXiusTemplate');?>
	</fieldset>

	<fieldset class="adminform">
		<legend><?php echo XiusText::_( 'SEARCH CONFIGURATION' ); ?></legend>
			<?php echo $this->params->render('xiusparams','advXiusSearch');?>
	</fieldset>

	<fieldset class="adminform">
		<legend><?php echo XiusText::_( 'LIST CONFIGURATION' ); ?></legend>
		<?php echo $this->params->render('xiusparams','advXiusList');?>
	</fieldset>	
	</div>
</fieldset>
</div>

<div class="clr"></div>
<input type="hidden" name="view" value="configuration" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_xius" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>	
</div>