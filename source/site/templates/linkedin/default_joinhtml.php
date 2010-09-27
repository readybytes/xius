<?php 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

if($this->joinHtml['enable']):
?>
	<div class="xiusSpMain">
	<?php
	$orSelected = '';
	$andSelected = '';
	if($this->join == 'AND'):
		$andSelected = ' selected=true ';
	elseif($this->join == 'OR') :
		$orSelected = ' selected=true ';
	endif;
		
	$joinhtml = '<select id="xiusjoin" name="xiusjoin" onchange="xiusApplyJoin(\'join\');" >';
	$joinhtml .= '<option value="AND" '.$andSelected.'>'.XiusText::_('MATCH ALL').'</option>';
	$joinhtml .= '<option value="OR" '.$orSelected.'>'.XiusText::_('MATCH ANY').'</option>';
	$joinhtml .= '</select>';
	?>

	<div class="xiusSpLabel">
	<?php echo XiusText::_('XIUS JOIN WITH'); ?>
	</div>
	<div class="xiusSpInput">
	<?php echo $joinhtml; ?>	
	</div>
	</div>
	<?php 
else:
	?>
	<input type="hidden" id="xiusjoin" name="xiusjoin" value="<?php echo $this->joinHtml['defultMatch']; ?>" />
	<?php 
endif;	
?>
<?php 
