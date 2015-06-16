<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

if(!empty($this->appliedInfo)){ ?>
	<div id="xiusFiltered">
		<div id="xiusFdHead" class="row-fluid xius-font-color xius-margin">
			<div class="span3">
				<div class="pull-left xius-margin">
					<lead><em>
					<?php
					echo XiusText::_('FILTERED_BY');
					?>
					</em></lead>
				</div>
				<?php echo $this->loadTemplate('joinhtml');?>
			</div>
			<div class="span9">
				<?php 
					$count = 0;
					foreach($this->appliedInfo as $a) :
					$count++; 
				?>			
				<div class="badge xius-margin pull-left">
					<input type="hidden" id="delinfovalue_<?php echo $a['infoid'].$count;?>" name="delinfovalue_<?php echo $a['infoid'].$count;?>" value='<?php echo XiusHelperUsers::getSerializedData($a['value']);?>' />
					<?php 
								if(is_array($a['formatvalue']))	:	
									foreach($a['formatvalue'] as $a_values) 
										echo JText::_($a_values);
								else	:
									echo '<span class="xius-pointer" onClick="xiusDeleteInfo(this,\'delinfovalue_'.$a['infoid'].$count.'\');">'.JText::_($a['formatvalue']).'</span>';
								endif;
								
					echo '<i class="icon-remove xius-icon xius-icon-bg xius_test_remove_'.$a['formatvalue'].'"  src="components/com_xius/assets/images/delete.png" id="'.$a['infoid'].'" name="'.$a['infoid'].'"  
												alt="X" onClick="xiusDeleteInfo(this,\'delinfovalue_'.$a['infoid'].$count.'\');"></i>';
					?>
				</div>
				<?php endforeach;?>
				<span class="xius-pointer xius-margin badge label-info" onclick="xiusAddSubTask('resetfilter')" >
						Reset All <i class="icon-remove xius-icon xius-icon-bg xius"></i>
				</span>
			</div>
		</div>
		
		<hr>
		<input type="hidden" name="xiusdelinfo" value="" />
		<input type="hidden" id="conditionvalue" name="conditionvalue" value='' />
	</div>
<?php 
}
?>