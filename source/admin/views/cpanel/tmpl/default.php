<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<form action="<?php echo JURI::base();?>index.php?option=com_xius" method="post" name="adminForm">
<table width="100%" border="0">
	<tr>
		<td width="100%" valign="top">
			<div id="cpanel">
				<?php echo $this->addIcon('download.png','index.php?option=com_xius&view=info', JText::_('INFO'));?>
				<?php echo $this->addIcon('download.png','index.php?option=com_xius&view=list', JText::_('list'));?>
				<?php echo $this->addIcon('icon-updates.gif','index.php?option=com_xius&view=cpanel&task=updates', JText::_('UPDATES'));?>
				<?php echo $this->addIcon('download.png','http://www.joomlaxi.com/downloads/jomsocial-multi-profile-types.html', JText::_('DOWNLOAD'));?>
				<?php echo $this->addIcon('documentation.png','http://www.joomlaxi.com/support/documentation/59-multiple-profile-type.html', JText::_('DOCUMENTATION'));?>
				<?php echo $this->addIcon('support.png','http://www.joomlaxi.com/support/forum.html', JText::_('SUPPORT'));?>
				<?php echo $this->addIcon('gnugpl.png','http://www.gnu.org/licenses/old-licenses/gpl-2.0.html', JText::_('LICENSE'));?>				
				<?php echo $this->addIcon('twitter.jpg','http://twitter.com/joomlaXi', JText::_('FOLLOW TWITTER'));?>
			</div>
		</td>
	</tr>
</table>

<input type="hidden" name="view" value="cpanel" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_xius" />
<input type="hidden" name="boxchecked" value="0" />
</form>	