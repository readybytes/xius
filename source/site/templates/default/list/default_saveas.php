<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

$this->loadAssets('css', 'xiuspopup.css');
$this->loadAssets('js', 'result.js');
if(!empty($this->msg))
	echo '<div class="xius_error">'.$this->msg.'</div>';

$submitUrl = XiusRoute::_($this->submitUrl,false);
?>
<div id="xiusPopup">
 <form action="<?php echo $submitUrl; ?>" name="saveListForm" id="saveListForm" method="post" onsubmit="return xiusSaveListAs('<?php echo $submitUrl;?>');">
  
  	<div class="xiusPopupHeader">
  		<span><?php echo XiusText::_("SAVE_LIST"); ?></span>
	</div>
	<div id="xiusPopupData">
		<input type="radio" id="xiusListSaveAsNew" name="xiusListSaveAs" value="xiussavenew" checked><span><?php echo XiusText::_('SAVE_AS_NEW_LIST');?></span><br />
		<input type="radio" id="xiusListSaveAsExisting" name="xiusListSaveAs" value="xiussaveexisting"><span><?php echo XiusText::_('SAVE_AS_EXISTING');?></span>
			<div id="xiusSelect" class="xiusPopupControl">
				<select name="listid" id="listid">		
					<option value="-1" Selected="selected" ><?php echo XiusText::_('XIUS_SELECT_BELOW');?></option>
					<?php
						if(!empty($this->lists))	: 	
							foreach($this->lists as $l)	:
								$checked = '';
								$url = XiusRoute::_('index.php?option=com_xius&view=users&task=displayList&listid='.$l->id,false);
					
								if(empty($l->name)):
									$name = 'LIST<br />';
								else :
									$name = $l->name;
								endif;
						
								if($l->id == $this->selectedListId):
									$checked = ' selected=true';
								endif;
			
								echo '<option value="'.$l->id.'" '.$checked.'>'.JString::ucwords($name).'<br />';	
							endforeach;
						 endif;	
					?>
				</select>
			</div>
	
<div id="xiusPopupSubmit" style="float:right;">
	<input type="submit" name = "xiusListSaveAs" id = "xiusListSaveAs" value="<?php echo XiusText::_('NEXT')?>"/></div>
</div>
</form>
</div>
