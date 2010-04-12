<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

?>
<script type="text/javascript" language="javascript">
/**
 * This function needs to be here because, Joomla toolbar calls it
 **/ 
function submitbutton( action )
{
	switch( action )
	{
		case 'remove':
			if( !confirm( '<?php echo JText::_('ARE YOU SURE YOU WANT TO REMOVE THIS INFORMATION?'); ?>' ) )
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

<form action="<?php echo JURI::base();?>index.php" method="post" name="adminForm">
<table class="adminlist" cellspacing="1">
	<thead>
		<tr class="title">
			<th width="1%">
				<?php echo JText::_( 'NUM' ); ?>
			</th>
			<th width="1%">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->allinfo ); ?>);" />
			</th>
			<th>
				<?php echo JText::_( 'LABEL NAME' ); ?>
			</th>
			<th width="5%">
				<?php echo JText::_( 'PLUGIN' ); ?>
			</th>
			<th width="5%">
				<?php echo JText::_( 'PUBLISHED' ); ?>
			</th>
			<th width="5%" align="center">
				<?php echo JText::_( 'ORDERING' ); ?>
			</th>
		</tr>		
	</thead>
<?php
	$count	= 0;
	$i		= 0;

	if(!empty($this->allinfo))
	foreach($this->allinfo as $info)
	{
		$input	= JHTML::_('grid.id', $count, $info->id);
		
		// Process publish / unpublish images
		++$i;
?>
		<tr class="row<?php echo $i%2;?>" id="rowid<?php echo $info->id;?>">
			<td><?php echo $i;?></td>
			<td>
				<?php echo $input; ?>
			</td>
			<td>
				<span class="editlinktip" title="<?php echo $info->labelName; ?>" id="labelname<?php echo $info->id;?>">
					<?php $link = JRoute::_('index.php?option=com_xius&view=info&task=renderinfo&editId='.$info->id, false); ?>
						<A HREF="<?php echo $link; ?>"><?php echo $info->labelName; ?></A>
				</span>
			</td>
			<td align="center" id=plugin"<?php echo $info->id;?>">
				<?php echo $info->pluginType; ?>
			</td>
			<td align="center" id="published<?php echo $info->id;?>">
				<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i-1;?>','<?php echo $info->published ? 'unpublish' : 'publish' ?>')">
							<?php if($info->published)
							{ ?>
								<img src="images/tick.png" width="16" height="16" border="0" alt="Published" />
							<?php 
							}
							else 
							{ ?>
								<img src="images/publish_x.png" width="16" height="16" border="0" alt="Unpublished" />
						<?php 
							} //echo $published;
						?>
				</a>
			</td>
			<td align="right">
				<span><?php echo $this->pagination->orderUpIcon( $count , true, 'orderup', 'Move Up'); ?></span>
				<span><?php echo $this->pagination->orderDownIcon( $count , count($this->allinfo), true , 'orderdown', 'Move Down', true ); ?></span>
			</td>			
		</tr>
<?php
		
		$count++;
	}
?>
	<tfoot>
	<tr>
		<td colspan="15">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
	</tr>
	</tfoot>
</table>
<input type="hidden" name="view" value="info" />
<input type="hidden" name="task" value="<?php echo JRequest::getCmd( 'task' );?>" />
<input type="hidden" name="option" value="com_xius" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>	