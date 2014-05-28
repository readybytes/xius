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
<form action="<?php echo JURI::base();?>index.php?option=com_xius&view=info" method="post" name="adminForm" id="adminForm">
<div>
<div class="col width-50" style="width:50%; float:left;">
	<fieldset class="adminform">
	<legend><?php echo XiusText::_( 'DETAILS' ); ?></legend>
		<div class="elementParams">
					<div class="paramTitle">
						<label for="name">
							<?php echo XiusText::_( 'NAME' ); ?>:
						</label>
					</div>
					<div class="paramValue"><input type="text" name="labelName" value ="<?php echo $this->pluginArray['labelName']; ?>" />
					</div>
					<a style = "float:right;" href="<?php echo XiusText::_(JString::strtoupper($this->info['pluginType']).'_LINK');?>" target="_blank">
						<img style = "width:25px; height:20px;"src="../components/com_xius/assets/images/icon-doc.png"/ 
						     title="Click here to see documentation"></a>
		</div>	
		<div class="elementParams">
					<div class="paramTitle">
						<label for="plugin type">
							<?php echo XiusText::_( 'PLUGIN_TYPE' ); ?>:
						</label>
					</div>
					<div class="paramValue">
					  <label for="plugin type" style="font-weight: bold;">
							<?php echo $this->info['pluginType']; ?>
						</label>
					</div>
		</div>
		
		<div class="elementParams">
			<div class="paramTitle">
				<label for="plugin type">
					<?php echo XiusText::_( 'INFORMATION_KEY' ); ?>:
				</label>
			</div>
			<div class="paramValue">
			  <label for="plugin type">
					<?php echo $this->info['key']; ?>
				</label>
			</div>
		</div>
				
		<div class="elementParams">
					<div class="paramTitle">
						<?php echo XiusText::_( 'PUBLISHED' ); ?>:
					</div>
					<div class="paramValue"><?php echo JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $this->pluginArray['published'] ); ?></div>
		</div>
	</fieldset>
	<br />
	<br />
	
	<fieldset class="adminform">
	<legend><?php echo XiusText::_( 'GENERAL_PARAMETERS' ); ?></legend>
	<?php
		echo $this->paramsHtml;
	?>
	</fieldset>


</div>
</div>
<div>
<div class="col width-50" style="width:50%; float:right;">
	

<fieldset class="adminform">
	<legend><?php echo XiusText::_( 'PLUGIN_PARAMETERS' ); ?></legend>
	<?php
		echo $this->pluginParamsHtml;
	?>
	</fieldset>


</div>
</div>

<div>
<div class="col width-50" style="width:50%; float:right;">
<fieldset class="adminform">
	<legend><?php echo XiusText::_( 'PRIVACY_PARAMETER' ); ?></legend>
	<?php
		foreach ( $this->privacyHtml as $html)
			echo $html;
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
</div>
</div>
<?php 
