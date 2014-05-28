<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

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
	$joinhtml .= '<option value="AND" '.$andSelected.'>'.XiusText::_('MATCH_ALL').'</option>';
	$joinhtml .= '<option value="OR" '.$orSelected.'>'.XiusText::_('MATCH_ANY').'</option>';
	$joinhtml .= '</select>';
	?>
	<div class="xius_spMain">
	<div class="xius_spLabel">
	<?php echo XiusText::_('XIUS_JOIN_WITH'); ?>
	</div>
	<div class="xius_spInput">
	<?php echo $joinhtml; ?>	
	</div>
	</div>
	</div>
	<?php
else:
	?>
	<input type='hidden' id="xiusjoin" name="xiusjoin" value="<?php echo $this->joinHtml['defultMatch']; ?>" />
	<?php 
endif;	