<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
$css = JURI::base().'components/com_xius/assets/css/save.css';
$js = JURI::base().'components/com_xius/assets/js/xius.js';
$document =& JFactory::getDocument();
$document->addStyleSheet($css);
$document->addScript($js);
if(!empty($this->msg))
	echo '<div class="xius_error">'.$this->msg.'</div>';

?><div id="xiusSave">
	<form action="<?php echo JRoute::_($this->submitUrl.'&isnew='.$this->isNew,false); ?>" name="saveListForm" id="saveListForm" method="post" onsubmit="return xiusListValidation();" >
	
	<!--  START HEADER -->
		<h3>
			<?php
				echo JText::_("Save As New"); 
			?>
		</h3>
	<!--  END HEADER -->
		
	<!--  START NAME -->
		<div id="xiusNewName">
			<div class="xiusSavelabel">
			<label><?php echo JText::_('Name'); ?></label>
			</div>
			<div class="xiusfl"><input type="text" name="xiusListName" id="xiusListName" value="<?php echo $this->data['listName']; ?>" /></div>
			</div>
	<!--  END NAME -->
		
		<!--  START PUBLISH -->
		<div>
			<div class="xiusSavelabel">		
			<label><?php echo JText::_('Published'); ?></label>
			</div>
			<div class="xiusSavehtml">			
			<input type="radio" name="xiusListPublish" value="0"><?php echo JText::_('NO');?>:
			<input type="radio" name="xiusListPublish" value="1" checked="checked"><?php echo JText::_('YES');?>
			</div>
		</div>
		<!--  END PUBLISH -->
		
		<!--  START CONDITION -->		
		<div>
			<div class="xiusSavelabel">
			<label>
				<?php 
					echo JText::_('SEARCH CONDITION');
				?>
			</label>
			</div>
			<div class="xiusSavehtml">
			<?php 
			if(is_array($this->conditionHtml) && !empty($this->conditionHtml))
 				foreach($this->conditionHtml as $condition)							
					echo $condition['label'].'  '.$condition['operator'].'   '.$condition['value'].'<br/>';
			else
				echo JText::_('NO SEARCH CONDITION FOUND');
			?>
			</div>
		</div>
		<!--  END CONDITION -->
			
		<!--  START SORTABLE INFORMATION -->
		<div>
			<div class="xiusSavelabel">
			<label>
				<?php 
					echo JText::_('SORT RESULT ACCORDING TO');
				?>
			</label>
			</div>
			<div class="xiusSavehtml">
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
		</div>
		<!--  END SORTABLE INFORMATION -->		
		
		<!--  START SORTING ORDER -->
		<div id="xiusSorting">
		<div class="xiusSavelabel">		
			<label for="name">
				<?php echo JText::_( 'SORTING DIRECTION' ); ?>:
			</label>
			</div>
			<div class="xiusSavehtml">
			<?php
				if(array_key_exists('dir',$this->data) && $this->data['dir']) : 
					$ascselected = '';
					$descselected = '';
					if($this->data['dir'] === 'ASC')	:
						$ascselected = ' selected=true ';
					elseif($this->data['dir'] === 'DESC')	:
						$descselected = ' selected=true ';
					endif;

					$dirhtml = '<select id="xiussortdir" name="xiusListSortDir" >';
					$dirhtml .= '<option value="ASC" '.$ascselected.'>'.JText::_('ASC').'</option>';
					$dirhtml .= '<option value="DESC" '.$descselected.'>'.JText::_('DESC').'</option>';
					$dirhtml .= '</select>';

					echo $dirhtml;	
				endif;			
			?>
			</div>
		</div>
		<!--  END SORTING ORDER -->		
		
		<!--  START JOIN WITH -->
		<div>
		<div class="xiusSavelabel">
			<label for="name">
				<?php echo JText::_( 'JOIN WITH' ); ?>:
			</label>
			</div>
			<div class="xiusSavehtml">
			<?php 
				$orSelected = '';
				$andSelected = '';
				if(array_key_exists('join',$this->data)):
					if($this->data['join'] == 'AND'):
						$andSelected = ' selected=true ';
					elseif($this->data['join'] == 'OR') :
						$orSelected = ' selected=true ';
					endif;
				endif;
			?>
			<select id="xiusjoin" name="xiusListJoinWith" >
			<option value="AND" <?php echo $andSelected; ?> ><?php echo JText::_('MATCH ALL'); ?></option>
			<option value="OR"  <?php echo $orSelected; ?> ><?php echo JText::_('MATCH ANY'); ?></option>
			</select>
			</div>
		</div>
		<!--  END JOIN WITH -->	
		
		<!-- START PLUGIN PRIVACY -->
		<div id="xiusPlugin">
						
			<?php 
				foreach($this->data['xiusListPrivacy'] as $html){
					?>						
					<div class="xiusSavelabel">
						<label><?php 				
							echo $html['label'];?> 
						</label>
					</div>
					<div class="xiusSavehtml">
						<?php 
						echo $html['html'];
						?>
					</div>
					<?php 
				}					
			?>
		</div>
		<!-- END PLUGIN PRIVACY -->		
		
		<!--  START DESCRIPTION -->
		<div>
		<div class="xiusSavelabel">
			<label>
				<?php
					echo JText::_('Description');
				?>
			</label>
		</div>
		<div class="xiusSavehtml">
			<?php
			$val = '';	
				if(array_key_exists('listDesc',$this->data))
					$val = $this->data['listDesc'];
				echo $this->data['editor']->display( 'xiusListDesc',$val , '480', '250', '50', '20' );
			?>			
		</div>
		</div>
		<!--  END DESCRIPTION -->
	
<div id="xiussubmit">				
<input type="submit" name = "xiussave" id = "xiussave" value=<?php echo JText::_('SAVE AS NEW')?> />	
</div>
<input type="hidden" name="listid" value="<?php echo $this->selectedListId; ?>" />
</form>
</div>

<div class="clr"></div>
<?php 