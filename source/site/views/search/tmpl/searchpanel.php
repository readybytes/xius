<?php
defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip', '.hasTip');
jimport('joomla.html.pane');
?>

<form action="<?php echo JURI::base();?>index.php" method="post" name="form" id="form">
<table>
	
		<?php
		$count = 0;
		$i  = 0;
		//XITODO : Add message if no fields to show
		if(!empty($this->infohtml))
		foreach($this->infohtml as $data)
		{
			?>
			<tr>
				<td><?php echo $data['label'];?></td>
				<td><?php echo $data['html'];?></td>
			</tr>
			<?php 
		}
		?>
</table>

<div class="clr"></div>
	<input type="submit" id="search" name="search" value="Search"/>
	<input type="hidden" name="option" value="com_xius" />
	<input type="hidden" name="view" value="search" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>

