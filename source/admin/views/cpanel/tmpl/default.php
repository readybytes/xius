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
<form action="<?php echo JURI::base();?>index.php?option=com_xius" method="post" name="adminForm">

<div id="cpanel">
	<?php echo $this->addIcon('xius-config.png','index.php?option=com_xius&view=configuration', XiusText::_('CONFIGURATION'));?>
	<?php echo $this->addIcon('info.png','index.php?option=com_xius&view=info', XiusText::_('INFO'));?>
	<?php echo $this->addIcon('userlist.png','index.php?option=com_xius&view=list', XiusText::_('LIST'));?>
</div>
<?php 
        $version = new JVersion();
	        $suffix = 'jom=J'.$version->RELEASE.'&utm_campaign=broadcast&pay=XIUS'.XIUS_VERSION.'&dom='.JURI::getInstance()->toString(array('scheme', 'host', 'port'));
        ob_start();?>
        <div class ="xiusboardcast">    
            <iframe src='http://www.readybytes.net/broadcast/xius.html?<?php echo urlencode($suffix); ?>' frameborder="0" scrolling="auto" width="100%" height="250px"></iframe>
         </div>
        <?php
   		$return .= ob_get_contents();
        ob_end_clean();
        echo $return;
?>            


<input type="hidden" name="view" value="cpanel" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_xius" />
<input type="hidden" name="boxchecked" value="0" />
</form>	
