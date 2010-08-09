<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
if(!defined('_JEXEC')) die('Restricted access');
?>
<style type="text/css">
       #toolbar-updateCache
       {
           background-image:  url(../administrator/components/com_xius/assets/images/icon_update_cache.png);
           background-repeat:no-repeat;
           background-position: top center;
        }
</style>

<form action="<?php echo JURI::base();?>index.php?" method="post" name="adminForm">
<div>
<?php 
jimport('joomla.html.pane');
		$pane = &JPane::getInstance('sliders', array('allowAllClose' => true));
		echo $pane->startPane('configuration-pane');
		echo $this->params->render('xiusparams');?>
</div>
<div class="clr"></div>
<input type="hidden" name="view" value="configuration" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_xius" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>	
