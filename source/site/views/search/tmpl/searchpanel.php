<?php
defined('_JEXEC') or die('Restricted access');
$css = JURI::base().'administrator/components/com_xius/assets/css/front/sp.css';
$document =& JFactory::getDocument();
$document->addStyleSheet($css);
JHTML::_('behavior.tooltip', '.hasTip');
jimport('joomla.html.pane');
		
?>

<form action="<?php echo JURI::base();?>index.php?option=com_xius&view=search&task=basicsearch" method="post" name="form" id="form">
<div class="xius_box"><div class="head"><p><b>Search : </b></p></div>
		<?php
		$count = 0;
		$i  = 0;
		
		if(!empty($this->infohtml))
		foreach($this->infohtml as $data)
		{
			?> <div class="ul">
				<div class="tag"><?php echo $data['label'];?></div>
				<div class="input"><?php echo $data['html'];?></div>
				</div>		
		<?php 
		}
		?>
				<br />
	</div>

<div class="clr"></div>
	<div id="searcha"><input type="submit" id="search" name="search" value="Search" /></div>
	<input type="hidden" name="option" value="com_xius" />
	<input type="hidden" name="view" value="search" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="task" value="basicsearch" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
