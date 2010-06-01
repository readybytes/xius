<?php 
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
?>
<div class="xiusTotal">
<span id="total_<?php echo $this->total;?>">
<?php echo sprintf(JText::_('Total :  %s'),$this->total);?>
</span>
</div>
<div class="xiusPagination"><?php echo $this->pagination->getLimitBox();?>
</div>
