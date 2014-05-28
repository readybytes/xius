<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

$this->loadAssets('css', 'lists.css');
$this->loadAssets('js', 'result.js');
if(!empty($this->msg))
	echo '<div class="xius_error">'.$this->msg.'</div>';

?><div id="xiusSave">
	<form action="<?php echo XiusRoute::_($this->submitUrl.'&isnew='.$this->isNew,false); ?>" name="saveListForm" id="saveListForm" method="post" onsubmit="return xiusListValidation();" >
	
	<!--  START HEADER -->
		<div id = "xiusSaveHeader">
			<?php
				echo XiusText::_("SAVE_AS_NEW"); 
			?>
		</div>
	<!--  END HEADER -->
		
	<!--  START NAME -->
		<div id="xiusNewName" class="xiusSaveInfo">
			<div class="xiusSavelabel">
			<label><?php echo XiusText::_('NAME'); ?></label>
			</div>
			<div class="xiusfl"><input type="text" name="xiusListName" id="xiusListName" value="<?php echo $this->data['listName']; ?>" /></div>
			</div>
	<!--  END NAME -->
		
		<!--  START PUBLISH -->
		<div class="xiusSaveInfo">
			<div class="xiusSavelabel">		
			<label><?php echo XiusText::_('PUBLISHED'); ?></label>
			</div>
			<div class="xiusSavehtml">			
			<input type="radio" name="xiusListPublish" value="0"><?php echo XiusText::_('NO');?>
			<input type="radio" name="xiusListPublish" value="1" checked="checked"><?php echo XiusText::_('YES');?>
			</div>
		</div>
		<!--  END PUBLISH -->
		
		<!--  START CONDITION -->		
		<div class="xiusSaveInfo">
			<div class="xiusSavelabel">
			<label>
				<?php 
					echo XiusText::_('SEARCH_CONDITION');
				?>
			</label>
			</div>
			<div class="xiusSavehtml">
			<?php 
			if(is_array($this->conditionHtml) && !empty($this->conditionHtml))
 				foreach($this->conditionHtml as $condition)							
					echo $condition['label'].'  '.$condition['operator'].'   '.$condition['value'].'<br/>';
			else
				echo XiusText::_('NO_SEARCH_CONDITION_FOUND');
			?>
			</div>
		</div>
		<!--  END CONDITION -->
			
		<!--  START SORTABLE INFORMATION -->
		<div class="xiusSaveInfo">
			<div class="xiusSavelabel">
			<label>
				<?php 
					echo XiusText::_('SORT_RESULT_ACCORDING_TO');
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
					XiusText::_('NO_INFORMATION_AVAILABLE_FOR_SORTING');
				endif;
			?>
			</div>
		</div>
		<!--  END SORTABLE INFORMATION -->		
		
		<!--  START SORTING ORDER -->
		<div id="xiusSorting" class="xiusSaveInfo">
		<div class="xiusSavelabel">		
			<label for="name">
				<?php echo XiusText::_( 'SORTING_DIRECTION' ); ?>
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
					$dirhtml .= '<option value="ASC" '.$ascselected.'>'.XiusText::_('ASC').'</option>';
					$dirhtml .= '<option value="DESC" '.$descselected.'>'.XiusText::_('DESC').'</option>';
					$dirhtml .= '</select>';

					echo $dirhtml;	
				endif;			
			?>
			</div>
		</div>
		<!--  END SORTING ORDER -->		
		
		<!--  START JOIN WITH -->
		<div class="xiusSaveInfo">
		<div class="xiusSavelabel">
			<label for="name">
				<?php echo XiusText::_( 'JOIN_WITH' ); ?>
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
			<option value="AND" <?php echo $andSelected; ?> ><?php echo XiusText::_('MATCH_ALL'); ?></option>
			<option value="OR"  <?php echo $orSelected; ?> ><?php echo XiusText::_('MATCH_ANY'); ?></option>
			</select>
			</div>
		</div>
		<!--  END JOIN WITH -->	
		
		<div style="clear:both;"></div>
		<!-- START PLUGIN PRIVACY -->
		<div id="xiusPlugin" class="xiusSaveInfo">
				<div style="width:100%;" >
				<?php 
					foreach($this->data['xiusListPrivacy'] as $html)
						if($html)
							echo $html;
				?>
				</div>
		</div>
		<!-- END PLUGIN PRIVACY -->		
		<div style="clear:both;"></div>
		
		<!--  START DESCRIPTION -->
		<div class="xiusSaveInfo">
		<div class="xiusSavelabel">
			<label>
				<?php
					echo XiusText::_('DESCRIPTION');
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
<div style="clear:both;"><br/></div>	
<div id="xiussubmit">				
<input type="submit" name = "xiussave" id = "xiussave" value=<?php echo XiusText::_('SAVE_AS_NEW')?> />	
</div>
<input type="hidden" name="listid" value="<?php echo $this->selectedListId; ?>" />
</form>
</div>

<div class="clr"></div>
<?php 