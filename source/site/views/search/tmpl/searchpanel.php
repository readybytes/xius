<?php
defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip', '.hasTip');
jimport('joomla.html.pane');
		
?>

<script type="text/javascript" language="javascript">
/**
 * This function needs to be here because, Joomla toolbar calls it
 **/ 
function submitbutton( action )
{
	switch( action )
	{
		case 'removeList':
			if( !confirm( '<?php echo JText::_('Are you sure you want to delete this List?'); ?>' ) )
			{
				break;
			}
		case 'publish':
		case 'unpublish':
		default:
			submitform( action );
	}
}
</script>


<form action="<?php echo JURI::base();?>index.php" method="post" name="form" id="form">
<table>
	
		<?php
		$count = 0;
		$i  = 0;
		
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

