<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

if(!empty($this->appliedInfo)) : ?>
<div class="xiusAppliedinfo">
<div class="xius_apiHead">
	<?php
	echo XiusText::_('APPLIED_INFORMATION');
	?>
	<img src="components/com_xius/assets/images/clear_all.png" title="<?php echo XiusText::_('XIUS_CLEAR_ALL_APPLIED_INFO');?>" onclick="xiusAddSubTask('resetfilter')" />
</div>
<?php 
	$count = 0;
	foreach($this->appliedInfo as $a) :
		$count++; ?>
		<input type="hidden" id="delinfovalue_<?php echo $a['infoid'].$count;?>" name="delinfovalue_<?php echo $a['infoid'].$count;?>" value='<?php echo XiusHelperUsers::getSerializedData($a['value']);?>' />
		<?php 
		echo '<div class="applied"><div class="xiusleft"><div><b>'.JText::_($a['label']).'</b>';
		if(is_array($a['formatvalue']))	:	
			foreach($a['formatvalue'] as $a_values) 
				echo '<div>'.JText::_($a_values).'</div>';
		else	:
			echo '<div>'.JText::_($a['formatvalue']).'</div>';
		endif;
		
		echo '</div></div><div class="right"><img class=\'xius_test_remove_'.$a['formatvalue'].'\'  src="components/com_xius/assets/images/delete.png" id="'.$a['infoid'].'" name="'.$a['infoid'].'"  
								alt="Remove" onClick="xiusDeleteInfo(this,\'delinfovalue_'.$a['infoid'].$count.'\');"/></div></div>';				
	endforeach;

echo $this->loadTemplate('joinhtml');

?>
<input type="hidden" name="xiusdelinfo" value="" />
<input type="hidden" id="conditionvalue" name="conditionvalue" value='' />
</div>
<?php 
endif;
?>
