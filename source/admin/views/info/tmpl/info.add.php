<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

JToolBarHelper::back('Home' , 'index.php?option=com_xius&view=info');
JToolBarHelper::cancel( 'cancel', XiusText::_('CLOSE' ));
?>
	
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
<table cellspacing="0" class="admintable" border="0" width="100%">
	<tbody>
		<tr>
			<td class="key"><?php echo XiusText::_('INFO');?></td>
			<td>:</td>
			<td>
				<div>
				<?php
					echo $this->rawDataHtml;
				?>
				</div>
			</td>
		</tr>
	</tbody>
</table>

<div class="clr"></div>

<div style="float:left; margin-left: 320px">
	<input type="submit" name="infonext" value="<?php echo XiusText::_('NEXT');?>"/>
</div>
<?php }?>	
	<input type="hidden" name="plugin" value="<?php echo $this->plugin;?>" />
	
	<input type="hidden" name="option" value="com_xius" />
	<input type="hidden" name="view" value="<?php echo JRequest::getCmd( 'view' , 'info' );?>" />
	<input type="hidden" name="id" value="" />
	<input type="hidden" name="task" value="renderinfo" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
