<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Backend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');
?>

<div id="XIUS">
<div class="xippElements">	
<div style="background-color: #F9F9F9; border: 1px solid #D5D5D5; margin-bottom: 10px; padding: 5px;font-weight: bold;">
	<?php echo XiusText::_('SELECT_DATA_TO_USE');?>
</div>
<div id="error-notice" style="color: red; font-weight:700;"></div>
<div style="clear: both;"></div>
<form action="<?php echo JURI::base();?>index.php?option=com_xius&view=info" method="post" name="adminForm" id="adminForm" >
<?php 
if(empty($this->rawDataHtml))
	echo XiusText::_('NO_INFO_TO_DISPLAY');
else 
{?>
				<div class="elementParams">
					<div class="paramTitle">
							<label for="information">
								<?php echo XiusText::_('INFO');?>
							</label>
					</div>
					
					<div class="paramValue"><?php echo $this->rawDataHtml;?></div>
					<div class="paramValue"><input type="submit" name="infonext" value="<?php echo XiusText::_('NEXT');?>"/></div>
				</div>

<div class="clr"></div>


	

<?php }?>	
	<input type="hidden" name="plugin" value="<?php echo $this->plugin;?>" />
	
	<input type="hidden" name="option" value="com_xius" />
	<input type="hidden" name="view" value="<?php echo JRequest::getCmd( 'view' , 'info' );?>" />
	<input type="hidden" name="id" value="" />
	<input type="hidden" name="task" value="renderinfo" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
</div>
