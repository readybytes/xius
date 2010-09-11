<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php 
JToolBarHelper::back('Home' , 'index.php?option=com_xius&view=info');
JToolBarHelper::divider();
JToolBarHelper::apply('apply', XiusText::_('APPLY'));
JToolBarHelper::save('save',XiusText::_('SAVE'));
JToolBarHelper::cancel( 'cancel', XiusText::_('CLOSE' ));
?>


<div style="background-color: #F9F9F9; border: 1px solid #D5D5D5; margin-bottom: 10px; padding: 5px;font-weight: bold;">
	<?php echo XiusText::_($this->infoName);?>
</div>

<form action="<?php echo JURI::base();?>index.php?option=com_xius&view=info" method="post" name="adminForm">
<div>
<div class="col width-40" style="width:40%; float:left;">
	<fieldset class="adminform">
	<legend><?php echo XiusText::_( 'Details' ); ?></legend>
	<table class="admintable">
		<tr>
			<td width="100" class="key">
				<label for="name">
					<?php echo XiusText::_( 'NAME' ); ?>:
				</label>
			</td>
			<td>
				<input type="text" name="labelName" value ="<?php echo XiusText::_($this->pluginArray['labelName']); ?>" />
			</td>
		</tr>
		<tr>
			<td valign="top" class="key">
				<?php echo XiusText::_( 'PUBLISHED' ); ?>:
			</td>
			<td>
				<?php echo JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $this->pluginArray['published'] ); ?>
			</td>
		</tr>
		</table>
	</fieldset>
	<br />
	<br />
	
	<fieldset class="adminform">
	<legend><?php echo XiusText::_( 'General Parameters' ); ?></legend>
	<?php
		jimport('joomla.html.pane');
		$pane = &JPane::getInstance('sliders', array('allowAllClose' => true));
		echo $pane->startPane('core-pane');
		//echo $pane->startPanel(XiusText:: _('Core Fields Parameters'), 'coreparam-page');
		echo $this->paramsHtml;
		//echo $pane->endPanel();
		?>
	</fieldset>


</div>
</div>
<div>
<div class="col width-60" style="width:60%; float:right;">
	

<fieldset class="adminform">
	<legend><?php echo XiusText::_( 'Plugin Parameters' ); ?></legend>
	<?php
		jimport('joomla.html.pane');
		$pane = &JPane::getInstance('sliders', array('allowAllClose' => true));
		echo $pane->startPane('plugin-pane');
		echo $this->pluginParamsHtml;
	?>
	</fieldset>


</div>
</div>

<div>
<div class="col width-60" style="width:60%; float:right;">
<fieldset class="adminform">
	<legend><?php echo JText::_( 'Profile Types Parameters' ); ?></legend>
	<?php
		jimport('joomla.html.pane');
		$pane = &JPane::getInstance('sliders', array('allowAllClose' => true));
		echo $pane->startPane('core-pane');
		foreach ( $this->privacyHtml as $html)
			echo $html;
		echo $pane->endPanel();
		?>
		
	</fieldset>
</div>
</div>

<div class="clr"></div>

	<input type="hidden" name="option" value="com_xius" />
	<input type="hidden" name="id" value="<?php echo $this->pluginArray['id'];?>" />
	<input type="hidden" name="key" value="<?php echo $this->pluginArray['key'];?>" />
	<input type="hidden" name="pluginType" value="<?php echo $this->pluginArray['pluginType'];?>" />
	<input type="hidden" name="cid[]" value="" />
	<input type="hidden" name="view" value="<?php echo JRequest::getCmd( 'view' , 'info' );?>" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
