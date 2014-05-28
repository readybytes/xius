<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Backend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');
?>

<script type="text/javascript" language="javascript">
/**
 * This function needs to be here because, Joomla toolbar calls it
 **/ 
Joomla.submitbutton = function(action){

	if(action == 'remove' && !confirm( '<?php echo XiusText::_('ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_LIST'); ?>' ) )
	 	return true; 

	submitform( action );
 	
}
</script>


<form action="<?php echo JURI::base();?>index.php" method="post" name="adminForm" id="adminForm">
<table class="table table-striped adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="1%">
				<?php echo XiusText::_( 'NUM' ); ?>
			</th>
			<th width="1%">
				<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
			</th>
			<th width="25%" class="title">
					<?php echo XiusText::_( 'LIST_NAME' ); ?>
			</th>
			<th width="5%">
				<?php echo XiusText::_( 'PUBLISHED' ); ?>
			</th>
			<th width="5%" align="center">
				<?php echo XiusText::_( 'ORDERING' ); ?>
			</th>
		</tr>
	</thead>
		<?php
		$count = 0;
		$i		= $this->pagination->get('limitstart',0);
		
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
				<td align="center">
				<?php 
				
					$lname = $list->name;
				if(!$lname)
					$lname = 'LIST'.$list->id;
					 ?>
					<span class="editlinktip" title="<?php echo $lname; ?>" id="name<?php echo $list->id;?>">
					<?php $link = XiusRoute::_('index.php?option=com_xius&view=list&task=editList&editId='.$list->id, false); ?>
						<a HREF="<?php echo $link; ?>"><?php echo $lname; ?></a>
					</span>
				</td>
				<td align="center">
							<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i-1;?>','<?php echo $list->published ? 'unpublish' : 'publish' ?>')">
							<?php if($list->published)
							{ ?>
								<img src="../components/com_xius/assets/images/tick.png" width="16" height="16" border="0" alt="Published" />
							<?php 
							}
							else 
							{ ?>
								<img src="../components/com_xius/assets/images/publish_x.png" width="16" height="16" border="0" alt="Unpublished" />
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
	<?php echo JHtml::_( 'form.token' ); ?>
</form>

