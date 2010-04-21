<div class="sort">
	
	<?php 
		if(empty($this->sortableFields))
			echo "I m in sorting";
		else{
			$html = '<select id="sort" name="sort"/>';
			foreach($this->sortableFields as $sfields){
				$selected = '';
				if($this->sort == $sfields['key'])
					$selected = ' selected=true ';
				
				$html .= '<option value='.$sfields['key'].$selected.'>'.$sfields['value'];
				$html .= '</option>';
			}
			$html .= '</select>';
			echo $html;
			
			$ascselected = '';
			$descselected = '';
			if($this->dir == 'ASC')
				$ascselected = ' selected=true ';
			else if($this->dir == 'DESC')
				$descselected = ' selected=true ';
				
			$dirhtml = '<select id="dir" name="dir"/>';
			$dirhtml .= '<option value="ASC" '.$ascselected.'>ASC</option>';
			$dirhtml .= '<option value="DESC" '.$descselected.'>DESC</option>';
			$dirhtml .= '</select>';
			
			echo $dirhtml;
		}
		
		
	?>
</div>