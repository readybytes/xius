<?php
defined('_JEXEC') or die('Restricted access');

JToolBarHelper::back('Home' , 'index.php?option=com_xius&view=info');
JToolBarHelper::cancel( 'cancel', JText::_('CLOSE' ));
?>
	
<div style="background-color: #F9F9F9; border: 1px solid #D5D5D5; margin-bottom: 10px; padding: 5px;font-weight: bold;">
	<?php echo JText::_('SELECT DATA TO USE');?>
</div>
<div id="error-notice" style="color: red; font-weight:700;"></div>
<div style="clear: both;"></div>
<form action="<?php echo JURI::base();?>index.php?option=com_xius&view=info" method="post" name="adminForm" id="adminForm" >
<table cellspacing="0" class="admintable" border="0" width="100%">
	<tbody>
		<tr>
			<td class="key"><?php echo JText::_('INFO');?></td>
			<td>:</td>
			<td>
				<div>
				<?php
					if(!empty($this->rawDataHtml))
						echo $this->rawDataHtml;
				?>
				</div>
			</td>
		</tr>
	</tbody>
</table>

<div class="clr"></div>

<div style="float:left; margin-left: 320px">
	<input type="submit" name="infonext" value="<?php echo JText::_('NEXT');?>"/>
</div>	
	<input type="hidden" name="plugin" value="<?php echo $this->plugin;?>" />
	
	<input type="hidden" name="option" value="com_xius" />
	<input type="hidden" name="view" value="<?php echo JRequest::getCmd( 'view' , 'info' );?>" />
	<input type="hidden" name="id" value="" />
	<input type="hidden" name="task" value="renderinfo" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
