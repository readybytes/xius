<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>

<?php 
JToolBarHelper::back('Home' , 'index.php?option=com_xius&view=info');
JToolBarHelper::divider();
JToolBarHelper::apply('apply', JText::_('APPLY'));
JToolBarHelper::save('save',JText::_('SAVE'));
JToolBarHelper::cancel( 'cancel', JText::_('CLOSE' ));
?>


<div style="background-color: #F9F9F9; border: 1px solid #D5D5D5; margin-bottom: 10px; padding: 5px;font-weight: bold;">
	<?php echo JText::_($this->list->name);?>
</div>

<form action="<?php echo JURI::base();?>index.php?option=com_xius&view=list" method="post" name="adminForm">
<div>
<div class="col width-40" style="width:40%; float:left;">
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'Details' ); ?></legend>
	<table class="admintable">
		<tr>
			<td width="100" class="key">
				<label for="name">
					<?php echo JText::_( 'NAME' ); ?>:
				</label>
			</td>
			<td>
				<input type="text" name="xiusListName" value ="<?php echo JText::_($this->list->name); ?>" />
			</td>
		</tr>
		
		<tr>
			<td width="100" class="key">
				<label for="name">
					<?php echo JText::_( 'OWNER ID' ); ?>:
				</label>
			</td>
			<td>
				<?php echo JText::_($this->list->owner); ?>
			</td>
		</tr>
		
		<tr>
			<td width="100" class="key">
				<label for="name">
					<?php echo JText::_( 'OWNER NAME' ); ?>:
				</label>
			</td>
			<td>
				<?php echo JText::_($this->user->name); ?>
			</td>
		</tr>
		
		<tr>
			<td width="100" class="key">
				<label for="name">
					<?php echo JText::_( 'OWNER TYPE' ); ?>:
				</label>
			</td>
			<td>
				<?php echo JText::_($this->user->usertype); ?>
			</td>
		</tr>
		<tr>
			<td width="100" class="key">
				<label for="name">
					<?php echo JText::_( 'VISIBLE INFO' ); ?>:
				</label>
			</td>
			<td>
				<input type="text" name="xiusListVisibleInfo" value ="<?php echo JText::_($this->list->visibleinfo); ?>" />
			</td>
		</tr>
		
		<tr>
			<td width="100" class="key">
				<label for="name">
					<?php echo JText::_( 'INFORMATION FOR SORTING' ); ?>:
				</label>
			</td>
			<td>
			<?php 
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
					JText::_('NO INFORMATION AVAILABLE FOR SORTING');
				endif;
			?>				
			</td>
		</tr>
		
		<tr>
			<td width="100" class="key">
				<label for="name">
					<?php echo JText::_( 'SORTING DIRECTION' ); ?>:
				</label>
			</td>
			<td>
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
					JText::_('SORTING DIRECTION IS NOT AVAILABLE');
				endif;
			?>			
			</td>
		</tr>
		
		<tr>
			<td width="100" class="key">
				<label for="name">
					<?php echo JText::_( 'JOIN WITH' ); ?>:
				</label>
			</td>
			<td>
				<?php 
					$orSelected = '';
					$andSelected = '';
					if($this->list->join == 'AND'):
						$andSelected = ' selected=true ';
					elseif($this->list->join == 'OR') :
						$orSelected = ' selected=true ';
					endif;
				?>
				<select id="xiusjoin" name="xiusListJoinWith" >
				<option value="AND" <?php echo $andSelected; ?> ><?php echo JText::_('MATCH ALL'); ?></option>
				<option value="OR"  <?php echo $orSelected; ?> ><?php echo JText::_('MATCH ANY'); ?></option>
				</select>
			</td>
		</tr>
		
		<tr>
			<td width="100" class="key">
				<label for="name">
					<?php echo JText::_( 'CONDITION' ); ?>:
				</label>
			</td>
			<td>
				<?php 
				if($this->conditionHtml)
					foreach($this->conditionHtml as $condition)							
						echo $condition['label'].'  '.$condition['operator'].'   '.$condition['value'].'<br/>';						
				?>
			</td>
		</tr>
		
		<tr>
			<td valign="top" class="key">
				<?php echo JText::_( 'PUBLISHED' ); ?>:
			</td>
			<td>
				<?php echo JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $this->list->published ); ?>
			</td>
		</tr>
		</table>
	</fieldset>
	<br />
	<br />
	
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'DESCRIPTION' ); ?></legend>
	<?php		
		echo $this->editor->display( 'xiusListDescription', $this->list->description, '480', '250', '50', '20' );
	?>
	</fieldset>

</div>
</div>
<div>
<div class="col width-60" style="width:60%; float:right;">
	

<fieldset class="adminform">
	<legend><?php echo JText::_( 'General Parameters' ); ?></legend>
	<?php
		echo $this->config->render('params');
	?>
	</fieldset>

<fieldset class="adminform">
	<legend><?php echo JText::_( 'Plugins Parameters' ); ?></legend>

	<table class="admintable">

		<?php 
			foreach($this->xiusListPrivacy as $html){
				?><tr>
				<td class="key"><label for="name"><?php echo $html['label']; ?></label></td> 
				<td><?php echo $html['html'];?></td>
				</tr>
				<?php 
			}					
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
