<?php
defined('_JEXEC') or die('Restricted access');
$css = JURI::base().'components/com_xius/assets/css/sp.css';
$document =& JFactory::getDocument();
$document->addStyleSheet($css);
//$document->addStyleSheet('components/com_community/templates/default/css/style.css');
JHTML::_('behavior.tooltip', '.hasTip');
jimport('joomla.html.pane');		
?>
<div class="xius_box">
<form action="<?php echo JURI::base();?>index.php?option=com_xius&view=users&suplytask=displayresult" method="post" name="searchForm" id="searchForm">

<div class="xius_head"><p><b>Search : </b></p><hr /></div>
<div class="mainbox">
		<?php
		$count = 0;
		$i  = 0;
		
		if(!empty($this->infohtml))
		foreach($this->infohtml as $data):
			?> <div class="xius_inputs">
				<div class="xius_label"><?php echo JText::_($data['label']);?></div>
				<div><?php echo $data['html'];?></div>
			   </div>		
		<?php 
		endforeach;
		?>
		<div class="xius_inputs">
		<div class="xius_label">Join With</div>
		<div>
		<input type="radio" name="xius_join" value="AND" />And 
		<input type="radio" name="xius_join" value="OR" />Or
		</div>
		</div>
		<p class="submit"><input type="submit" id="xiussearch" name="xiussearch" value="Search" /></p>	
</div>

<div class="clr"></div>
	<input type="hidden" name="option" value="com_xius" />
	<input type="hidden" name="view" value="users" />
	<input type="hidden" name="task" value="<?php echo JRequest::getCmd('task','displaySearch');?>" />
	<input type="hidden" name="subtask" value="xiussearch" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form></div>