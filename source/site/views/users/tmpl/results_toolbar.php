<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<div class = "xiusToolbar">
<?php
foreach($this->toolbar as $tool)
	echo $tool->value;

?><div class="xiusTbRight">
				<?php
				if(!empty($this->sortableFields))	:
					$html = '<select id="xiussort" name="xiussort" onchange="xiusApplySort(\'xiussort\');" >';
					foreach($this->sortableFields as $sfields)	:
						$selected = '';
						if($this->sort == $sfields['key']):
							$selected = ' selected=true ';
						endif;

						$html .= '<option value='.$sfields['key'].$selected.'>'.$sfields['value'];
						$html .= '</option>';
					endforeach;
					$html .= '</select>';
					echo $html;

					$ascselected = '';
					$descselected = '';
					if($this->dir == 'ASC')	:
						$ascselected = ' selected=true ';
					elseif($this->dir == 'DESC')	:
						$descselected = ' selected=true ';
					endif;

					$dirhtml = '<select id="xiussortdir" name="xiussortdir" onchange="xiusApplySort(\'xiussortdir\');" >';
					$dirhtml .= '<option value="ASC" '.$ascselected.'>'.JText::_('ASC').'</option>';
					$dirhtml .= '<option value="DESC" '.$descselected.'>'.JText::_('DESC').'</option>';
					$dirhtml .= '</select>';

					echo $dirhtml;
				endif;

				echo $this->pagination->getLimitBox();?>
	</div>
</div>
