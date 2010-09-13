<?php 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

if($this->joinHtml['enable']):
?>
	<div class="xijoin">
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
	echo '<b>'.XiusText::_('XIUS JOIN WITH').'</b>&nbsp;&nbsp;&nbsp;&nbsp;';
	echo $joinhtml;	
	?>
	</div>
	<?php 
else:
	?>
	<input type='hidden' id="xiusjoin" name="xiusjoin" value="<?php echo $this->joinHtml['defultMatch']; ?>" />
	<?php 
endif;	
?>
<?php 