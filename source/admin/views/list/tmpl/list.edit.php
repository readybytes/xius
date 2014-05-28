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
<form action="<?php echo JURI::base();?>index.php?option=com_xius&view=list" method="post" name="adminForm" id="adminForm">
<div>
<div class="col width-40" style="width:40%; float:left;">
	<fieldset class="adminform">
	<legend><?php echo XiusText::_( 'DETAILS' ); ?></legend>
			<div class="elementParams">
					<div class="paramTitle">
						<label for="name">
							<?php echo XiusText::_( 'NAME' ); ?>:
						</label>
					</div>
					<div class="paramValue"><input type="text" name="xiusListName" value ="<?php echo $this->list->name; ?>" /></div>
			</div>
		
			<div class="elementParams">
					<div class="paramTitle">
						<label for="name">
							<?php echo XiusText::_( 'OWNER_ID' ); ?>:
						</label>
					</div>
					<div class="paramValue"><?php echo $this->list->owner; ?></div>
			</div>
		
			<div class="elementParams">
					<div class="paramTitle">
						<label for="name">
							<?php echo XiusText::_( 'OWNER_NAME' ); ?>:
						</label>
					</div>
					<div class="paramValue"><?php echo $this->user->name; ?></div>
			</div>
			
			<div class="elementParams">
					<div class="paramTitle">
						<label for="name">
							<?php echo XiusText::_( 'OWNER_TYPE' ); ?>:
						</label>
					</div>
					<div class="paramValue">
					<?php 
						foreach ($this->user->groups as $g)	
							echo $g."  ";
					?>
					</div>
			</div><!--
			
			<div class="elementParams">
					<div class="paramTitle">
						<label for="name">
							<?php // echo XiusText::_( 'VISIBLE_INFO' ); ?>:
						</label>
					</div>
					<div class="paramValue"><input type="text" name="xiusListVisibleInfo" value ="<?php echo $this->list->visibleinfo; ?>" /></div>
			</div>
			
			--><div class="elementParams">
					<div class="paramTitle">
						<label for="name">
							<?php echo XiusText::_( 'INFORMATION_FOR_SORTING' ); ?>:
						</label>
					</div>	
					<div class="paramValue"><?php 
							if(!empty($this->sortableFields))	:
							$html = '<select id="xiussort" name="xiusListSortInfo">';
							foreach($this->sortableFields as $sfields)	:
							$selected = '';
							if($this->list->sortinfo === $sfields['key']):
							$selected = ' selected=true ';
						endif;

							$html .= '<option value='.$sfields['key'].$selected.'>'.$sfields['value'];
							$html .= '</option>';
					endforeach;
							$html .= '</select>';
					echo $html;
					else : 
						XiusText::_('NO_INFORMATION_AVAILABLE_FOR_SORTING');
					endif;?></div>				
			</div>
		
			<div class="elementParams">
					<div class="paramTitle">
						<label for="name">
							<?php echo XiusText::_( 'SORTING_DIRECTION' ); ?>:
						</label>
					</div>
					<div class="paramValue">
						<?php
							if($this->list->sortdir) : 
							$ascselected = '';
							$descselected = '';
							if($this->list->sortdir === 'ASC')	:
							$ascselected = ' selected=true ';
							elseif($this->list->sortdir === 'DESC')	:
							$descselected = ' selected=true ';
							endif;
							
							$dirhtml = '<select id="xiussortdir" name="xiusListSortDir" >';
							$dirhtml .= '<option value="ASC" '.$ascselected.'>ASC</option>';
							$dirhtml .= '<option value="DESC" '.$descselected.'>DESC</option>';
							$dirhtml .= '</select>';

							echo $dirhtml; 
						else :
							XiusText::_('SORTING_DIRECTION_IS_NOT_AVAILABLE');
						endif;?></div>
				</div>
			
			<div class="elementParams">
					<div class="paramTitle">
						<label for="name">
							<?php echo XiusText::_( 'JOIN_WITH' ); ?>:
						</label>
					</div>
					<div class="paramValue"><?php 
							$orSelected = '';
							$andSelected = '';
							if($this->list->join == 'AND'):
								$andSelected = ' selected=true ';
							elseif($this->list->join == 'OR') :
								$orSelected = ' selected=true ';
							endif;
							?>
					</div>
					<div class="paramValue"><select id="xiusjoin" name="xiusListJoinWith" >
											<option value="AND" <?php echo $andSelected; ?> ><?php echo XiusText::_('MATCH_ALL'); ?></option>
											<option value="OR"  <?php echo $orSelected; ?> ><?php echo XiusText::_('MATCH_ANY'); ?></option>
											</select>
					</div>
			</div>
		
			<div class="elementParams">
					<div class="paramTitle">
						<label for="name">
							<?php echo XiusText::_( 'CONDITION' ); ?>:
						</label>
					</div>
					
					<div class="paramValue"><?php 
											if($this->conditionHtml)
											foreach($this->conditionHtml as $condition)							
											echo $condition['label'].'  '.$condition['operator'].'   '.$condition['value'].'<br/>';						
										?></div>
		</div>			
		
			<div class="elementParams">
					<div class="paramTitle">
						<?php echo XiusText::_( 'PUBLISHED' ); ?>:
					</div>
					<div class="paramValue"><?php echo JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $this->list->published ); ?></div>
			</div>
	</fieldset>
	<br />
	<br />
	
	<fieldset class="adminform">
	<legend><?php echo XiusText::_( 'DESCRIPTION' ); ?></legend>
	<?php		
		echo $this->editor->display( 'xiusListDescription', $this->list->description, '480', '250', '50', '20' );
	?>
	</fieldset>

</div>
</div>
<div>
<div class="col width-60" style="width:60%; float:right;">
	

<fieldset class="adminform">
	<legend><?php echo XiusText::_( 'GENERAL_PARAMETERS' ); ?></legend>
	<?php
		echo $this->config->render('params');
	?>
	</fieldset>

<fieldset class="adminform">
	<legend><?php echo XiusText::_( 'PLUGINS_PARAMETERS' ); ?></legend>

	<table class="admintable">

		<?php 
			foreach($this->xiusListPrivacy as $html)
				 echo $html;
		?>
	</table>
</fieldset>

</div>
</div>
<div class="clr"></div>

	<input type="hidden" name="option" value="com_xius" />
	<input type="hidden" name="id" value="<?php echo $this->list->id;?>" />	
	<input type="hidden" name="cid[]" value="" />
	<input type="hidden" name="view" value="<?php echo JRequest::getCmd( 'view' , 'list' );?>" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
</div>
