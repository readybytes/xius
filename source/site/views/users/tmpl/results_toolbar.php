<?php 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<div class = "xiusToolbar">
<?php 
$params	= array('size'=>array('x' => 500 , 'y' => 450));
JHTML::_('behavior.modal' , 'a.savelist' , $params);
$user =& JFactory::getUser();
$listid = 0;
if(!empty( $this->list )){
	if(isset($this->list->id))
		$listid = $this->list->id;
}
/*only admin will see this icon */
if(XiusHelpersUtils::isAdmin($user->id)){
	$url = "index.php?option=com_xius&view=users&task=displaySaveOption&tmpl=component&listid=".$listid;
?>
	<a class = 'savelist' href="<?php echo $url;?>" rel = "{handler: 'iframe', size: {x: 500 , y: 450}}" >
		<img src="<?php echo JURI::base().'components/com_xius/assets/images/save.png';?>" title=<?php echo JText::_("Save This List"); ?> />
	</a>
<?php 
	
	$csvurl = "index.php?option=com_xius&view=users&task=".$this->task."&subtask=xiusexport&format=csv";
?>	
<img src="<?php echo JURI::base().'components/com_xius/assets/images/excel.png';?>" onClick='location.href="<?php echo JRoute::_($csvurl,false);?>"' title="Export TO CSV" />
<?php 
}
?><div class="xiusTbRight">



	
				<?php 
				if(!empty($this->sortableFields))	:
					$html = '<select id="xiussort" name="xiussort" onchange="xiusApplySort(\'xiussort\');" >';
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
					if($this->dir == 'ASC')	:
						$ascselected = ' selected=true ';
					elseif($this->dir == 'DESC')	:
						$descselected = ' selected=true ';
					endif;
						
					$dirhtml = '<select id="xiussortdir" name="xiussortdir" onchange="xiusApplySort(\'xiussortdir\');" >';
					$dirhtml .= '<option value="ASC" '.$ascselected.'>ASC</option>';
					$dirhtml .= '<option value="DESC" '.$descselected.'>DESC</option>';
					$dirhtml .= '</select>';
					
					echo $dirhtml;
				endif;
				
				echo $this->pagination->getLimitBox();?> 
	</div>
</div>
