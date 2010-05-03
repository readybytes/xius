<script language="javascript" type="text/javascript">
	function applySort(subtask) {
		var form = document.userForm;
		form.subtask.value = subtask;
		form.submit();
	}	
</script>
<div class = "xius_sorting">
<?php 
		if(!empty($this->sortableFields))	:
			$html = '<select id="xiussort" name="xiussort" onchange="applySort(\'xiussort\');" >';
			foreach($this->sortableFields as $sfields)	:
				$selected = '';
				if($this->sort == $sfields['key'])
					$selected = ' selected=true ';
				
				$html .= '<option value='.$sfields['key'].$selected.'>'.$sfields['value'];
				$html .= '</option>';
			endforeach;
			$html .= '</select>';
			echo $html;
			
			$ascselected = '';
			$descselected = '';
			if($this->dir == 'ASC')
				$ascselected = ' selected=true ';
			else if($this->dir == 'DESC')
				$descselected = ' selected=true ';
				
			$dirhtml = '<select id="xiussortdir" name="xiussortdir" onchange="applySort(\'xiussortdir\');" >';
			$dirhtml .= '<option value="ASC" '.$ascselected.'>ASC</option>';
			$dirhtml .= '<option value="DESC" '.$descselected.'>DESC</option>';
			$dirhtml .= '</select>';
			
			echo $dirhtml;
		endif;
		
		
	?>
</div>