<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
$css = JURI::base().'components/com_xius/assets/css/save.css';
$js = JURI::base().'components/com_xius/assets/js/xius.js';
$document =& JFactory::getDocument();
//$document->addStyleSheet($css);
$document->addScript($js);
if(!empty($this->msg))
	echo '<div class="xius_error">'.$this->msg.'</div>';

?><div class="savemainbox">
<form action="<?php echo JRoute::_('index.php?option=com_xius&view=users&task=displaySaveOption'); ?>" name="saveListForm" id="saveListForm" method="post">

	<div class="leftbox">
		<!--  START HEADER -->
		<h3>
			<?php
				echo JText::_("Save As New"); 
			?>
		</h3>
		<!--  END HEADER -->
		
		<!--  START NAME -->
		<div class="lab">
			<label>
				<?php 
					echo JText::_('Name');
				?>
			</label>
		</div>		
		<div>
			<input type="text" name="xiusListName" value="<?php echo $this->data['listName']; ?>" />
		</div>
		<!--  END NAME -->
		
		<!--  START PUBLISH -->
		<div>
			<?php 
			echo JText::_('Published');?>:<input type="radio" name="xiusListPublish" value="0"><?php echo JText::_('NO');?>:<input type="radio" name="xiusListPublish" value="1" checked="checked"><?php echo JText::_('YES');
			?>
		</div>
		<!--  END PUBLISH -->
		
		<!--  START CONDITION -->		
		<div>
			<label>
				<?php 
					echo JText::_('SEARCH CONDITION');
				?>
			</label>
			<?php 
				foreach($this->data['conditions'] as $condition)
					if(array_key_exists($condition['infoid'],$this->data['infoName']))					
						echo @$this->data['infoName'][$condition['infoid']].'  '.$condition['operator'].'   '.$condition['value'].'<br/>';
			?>
		</div>
		<!--  END CONDITION -->
			
		<!--  START SORTABLE INFORMATION -->
		<div>
			<label>
				<?php 
					echo JText::_('SORT RESULT ACCORDING TO');
				?>
			</label>
			<?php 
				if(!empty($this->data['sortableFields']))	:
					$html = '<select id="xiussort" name="xiusListSortInfo">';
					foreach($this->data['sortableFields'] as $sfields)	:
						$selected = '';
						if($this->data['sortId'] === $sfields['key']):
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
		</div>
		<!--  END SORTABLE INFORMATION -->		
		
		<!--  START SORTING ORDER -->
		<div>		
			<label for="name">
				<?php echo JText::_( 'SORTING DIRECTION' ); ?>:
			</label>
			<?php
				if($this->data['dir']) : 
					$ascselected = '';
					$descselected = '';
					if($this->data['dir'] === 'ASC')	:
						$ascselected = ' selected=true ';
					elseif($this->data['dir'] === 'DESC')	:
						$descselected = ' selected=true ';
					endif;

					$dirhtml = '<select id="xiussortdir" name="xiusListSortDir" >';
					$dirhtml .= '<option value="ASC" '.$ascselected.'>ASC</option>';
					$dirhtml .= '<option value="DESC" '.$descselected.'>DESC</option>';
					$dirhtml .= '</select>';

					echo $dirhtml;	
				endif;			
			?>
		</div>
		<!--  END SORTING ORDER -->		
		
		<!--  START JOIN WITH -->
		<div>
			<label for="name">
				<?php echo JText::_( 'JOIN WITH' ); ?>:
			</label>
			<?php 
				$orSelected = '';
				$andSelected = '';
				if($this->data['join'] == 'AND'):
					$andSelected = ' selected=true ';
				elseif($this->data['join'] == 'OR') :
					$orSelected = ' selected=true ';
				endif;
			?>
			<select id="xiusjoin" name="xiusListJoinWith" >
			<option value="AND" <?php echo $andSelected; ?> ><?php echo JText::_('MATCH ALL'); ?></option>
			<option value="OR"  <?php echo $orSelected; ?> ><?php echo JText::_('MATCH ANY'); ?></option>
			</select>
		</div>
		<!--  END JOIN WITH -->	
		
		<!--  START DESCRIPTION -->
		<div class="lab">
			<label>
				<?php
					echo JText::_('Description');
				?>
			</label>
		</div>		
		<div>
			<?php		
				echo $this->data['editor']->display( 'xiusListDesc', $this->data['listDesc'], '480', '250', '50', '20' );
			?>			
		</div>
		<!--  END DESCRIPTION -->
		
		
		
		<div class="submit"><input type="submit" name = "xiussave" id = "xiussave" value=<?php echo JText::_('SAVE AS NEW')?> /></div>
	</div>
	
	</div>

<input type="hidden" name="subtask" value="<?php echo $this->saveas; ?>" />
<input type="hidden" name="listid" value="<?php echo $this->selectedListId; ?>" />
</form>
</div>
<?php 