<?php
defined('_JEXEC') or die('Restricted access');
$css = JURI::base().'administrator/components/com_xius/assets/css/front/sp.css';
$document =& JFactory::getDocument();
$document->addStyleSheet($css);
JHTML::_('behavior.tooltip', '.hasTip');
jimport('joomla.html.pane');
		
?>

<form action="<?php echo JURI::base();?>index.php?option=com_xius&view=users&suplytask=displayresult" method="post" name="searchForm" id="searchForm">
<div class="xius_box"><div class="head"><p><b>Search : </b></p></div>
		<?php
		$count = 0;
		$i  = 0;
		
		if(!empty($this->infohtml))
		foreach($this->infohtml as $data):
			?> <div class="ul">
				<span><?php echo $data['html'];?>
				<?php echo $data['label'];?></span>
				</div>		
		<?php 
		endforeach;
		?>
				<br />
	</div>

<div class="clr"></div>
	<div id="searcha"><input type="submit" id="xiussearch" name="xiussearch" value="Search" /></div>
	<input type="hidden" name="option" value="com_xius" />
	<input type="hidden" name="view" value="users" />
	<input type="hidden" name="task" value="<?php echo JRequest::getCmd('task','displaySearch');?>" />
	<input type="hidden" name="subtask" value="xiussearch" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>