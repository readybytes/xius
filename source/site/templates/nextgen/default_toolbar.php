<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?><!--[if IE]>
    <style type="text/css">
        #profileToolbar { zoom: 1; }
    </style>
<![endif]-->
<div id="profileToolbar">
<?php if($this->xiusToolbar):?>
	<div id="xiusActions" class="xiusfl">
		<?php echo XiusText::_('OPTION'); ?>
		<span class="xiusOptionsImg">&nbsp;</span>
		<div id="xiusTbButton">
		<?php
		foreach($this->xiusToolbar as $tool)
			echo $tool->value;
		?>
		</div>
	</div>
<?php endif;?>
<div class="xiusfr">
				<?php
				if(!empty($this->sortableFields))	:
					$html = '<select id="xiussort" name="xiussort" onchange="xiusApplySort(\'sort\');" >';
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

					$dirhtml = '<select id="xiussortdir" name="xiussortdir" onchange="xiusApplySort(\'sortdir\');" >';
					$dirhtml .= '<option value="ASC" '.$ascselected.'>'.XiusText::_('ASC').'</option>';
					$dirhtml .= '<option value="DESC" '.$descselected.'>'.XiusText::_('DESC').'</option>';
					$dirhtml .= '</select>';

					echo $dirhtml;
				endif;

				echo $this->pagination->getLimitBox();?>
	</div>
</div><?php 
