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


<form action="<?php echo JURI::base();?>index.php" method="post" name="adminForm" id="adminForm">
<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="1%">
				<?php echo JText::_( 'Num' ); ?>
			</th>
			<th width="1%">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->lists ); ?>);" />
			</th>
			<th width="25%" class="title">
					<?php echo JText::_( 'List Name' ); ?>
			</th>
			<th width="5%">
				<?php echo JText::_( 'Published' ); ?>
			</th>
			<th width="5%" align="center">
				<?php echo JText::_( 'ORDERING' ); ?>
			</th>
		</tr>
	</thead>
		<?php
		$count = 0;
		$i  = 0;
		
		if(!empty($this->lists))
		foreach($this->lists as $list)
		{
				$published		= JHTML::_('grid.published', $list, $i );
				$checked		= JHTML::_('grid.id',   $i, $list->id );
				++$i;
				?>
				<tr>
				<tr class="row<?php echo $i%2;?>" id="listid<?php echo $list->id;?>">
				<td><?php echo $i;?></td>
				<td align="center">
						<?php echo $checked; ?>
				</td>
				<td>
				<?php 
				
					$lname = $list->name;
				if(!$lname)
					$lname = 'LIST'.$list->id;
					 ?>
					<span class="editlinktip" title="<?php echo $lname; ?>" id="name<?php echo $list->id;?>">
					<?php $link = JRoute::_('index.php?option=com_xius&view=list&task=editList&editId='.$list->id, false); ?>
						<A HREF="<?php echo $link; ?>"><?php echo $lname; ?></A>
					</span>
				</td>
				<td align="center">
							<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i-1;?>','<?php echo $list->published ? 'unpublish' : 'publish' ?>')">
							<?php if($list->published)
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
					<span><?php echo $this->pagination->orderDownIcon( $count , count($this->lists), true , 'orderdown', 'Move Down', true ); ?></span>
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

<div class="clr"></div>

	<input type="hidden" name="option" value="com_xius" />
	<input type="hidden" name="view" value="list" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>

