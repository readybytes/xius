<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// Disallow direct access to this file
if(!defined('_JEXEC')) die('Restricted access');
?>
<form action="<?php echo JURI::base();?>index.php?option=com_xius" method="post" name="adminForm">
<table width="100%" border="0">
	<tr>
		<td width="100%" valign="top">
			<div id="cpanel">
				<?php echo $this->addIcon('xius-config.png','index.php?option=com_xius&view=configuration', XiusText::_('CONFIGURATION'));?>
				<?php echo $this->addIcon('info.png','index.php?option=com_xius&view=info', XiusText::_('INFO'));?>
				<?php echo $this->addIcon('userlist.png','index.php?option=com_xius&view=list', XiusText::_('list'));?>
				<?php echo $this->addIcon('icon-updates.gif','index.php?option=com_xius&view=cpanel&task=updates', XiusText::_('UPDATES'));?>
				<?php echo $this->addIcon('download.png','http://www.joomlaxi.com/downloads/joomlaxi-user-search-xius.html', XiusText::_('DOWNLOAD'));?>
				<?php echo $this->addIcon('documentation.png','http://www.joomlaxi.com/support/documentation/category/joomlaxi-user-search.html', XiusText::_('DOCUMENTATION'));?>
				<?php echo $this->addIcon('support.png','http://www.joomlaxi.com/support/forum/40-joomlaxi-user-search-xius.html', XiusText::_('SUPPORT'));?>
				<?php echo $this->addIcon('gnugpl.png','http://www.gnu.org/licenses/old-licenses/gpl-2.0.html', XiusText::_('LICENSE'));?>				
				<?php echo $this->addIcon('twitter.jpg','http://twitter.com/joomlaXi', XiusText::_('FOLLOW TWITTER'));?>
			</div>
		</td>
	</tr>
</table>

<input type="hidden" name="view" value="cpanel" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_xius" />
<input type="hidden" name="boxchecked" value="0" />
</form>	
