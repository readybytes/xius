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
<div id="XIUS">
<div class="xippElements">
<form action="<?php echo JURI::base();?>index.php?option=com_xius&view=info" method="post" name="adminForm" id="adminForm">
<table class="table table-striped adminlist" cellspacing="1">
	<thead>
		<tr class="title">
			<th width="1%">
				<?php echo XiusText::_( 'NUM' ); ?>
			</th>
			<th width="1%">
				<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
			</th>
			<th width="20%">
				<?php echo XiusText::_( 'LABEL_NAME' ); ?>
			</th>
			<th width="5%">
				<?php echo XiusText::_( 'PLUGIN' ); ?>
			</th>
			<th width="5%">
				<?php echo XiusText::_( 'PUBLISHED' ); ?>
			</th>
			<th width="5%">
				<?php echo XiusText::_( 'SEARCHABLE' ); ?>
			</th>
			<th width="5%">
				<?php echo XiusText::_( 'VISIBLE' ); ?>
			</th>
			<th width="5%">
				<?php echo XiusText::_( 'SORTABLE' ); ?>
			</th>
			<th width="5%">
				<?php echo XiusText::_( 'EXPORTABLE' ); ?>
			</th>
			<th width="5%" align="center">
				<?php echo XiusText::_( 'ORDERING' ); ?>
			</th>
		</tr>		
	</thead>
<?php
	$count	= 0;
	$i		= $this->pagination->get('limitstart',0);

	if(!empty($this->allinfo))
	foreach($this->allinfo as $info)
	{
		/*XITODO : direct using param here without any help of plugin instance
		 * use plugin instance after dissucssion
		 */
		$params	= new XiusParameter('','');
		$params->bind($info->params);
		
		$input	= JHTML::_('grid.id', $count, $info->id);
		
		// Process publish / unpublish images
		++$i;
?>
		<tr class="row<?php echo $i%2;?>" id="rowid<?php echo $info->id;?>">
			<td><?php echo $i;?></td>
			<td>
				<?php echo $input; ?>
			</td>
			<td align="center" >
				<span class="editlinktip" title="<?php echo $info->labelName; ?>" id="labelname<?php echo $info->id;?>">
					<?php $link = XiusRoute::_('index.php?option=com_xius&view=info&task=renderinfo&editId='.$info->id, false); ?>
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
			<td align="center" id="searchable<?php echo $info->id;?>">
				<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i-1;?>','<?php echo $params->get('isSearchable',0) ? 'unsearchable' : 'searchable' ?>')">
							<?php if($params->get('isSearchable',0))
							{ ?>
								<img src="../components/com_xius/assets/images/tick.png" width="16" height="16" border="0" alt=<?php echo XiusText::_('SEARCHABLE');?> />
							<?php 
							}
							else 
							{ ?>
								<img src="../components/com_xius/assets/images/publish_x.png" width="16" height="16" border="0" alt=<?php echo XiusText::_('NOT_SEARCHABLE');?> />
						<?php 
							} //echo $published;
						?>
				</a>
			</td>
			<td align="center" id="visible<?php echo $info->id;?>">
				<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i-1;?>','<?php echo $params->get('isVisible',0) ? 'invisible' : 'visible' ?>')">
							<?php if($params->get('isVisible',0))
							{ ?>
								<img src="../components/com_xius/assets/images/tick.png" width="16" height="16" border="0" alt=<?php echo XiusText::_('VISIBLE');?> />
							<?php 
							}
							else 
							{ ?>
								<img src="../components/com_xius/assets/images/publish_x.png" width="16" height="16" border="0" alt=<?php echo XiusText::_('NOT_VISIBLE');?> />
						<?php 
							} //echo $published;
						?>
				</a>
			</td>
			<td align="center" id="sortable<?php echo $info->id;?>">
				<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i-1;?>','<?php echo $params->get('isSortable',0) ? 'unsortable' : 'sortable' ?>')">
							<?php if($params->get('isSortable',0))
							{ ?>
								<img src="../components/com_xius/assets/images/tick.png" width="16" height="16" border="0" alt=<?php echo XiusText::_('SORTABLE');?> />
							<?php 
							}
							else 
							{ ?>
								<img src="../components/com_xius/assets/images/publish_x.png" width="16" height="16" border="0" alt=<?php echo XiusText::_('NOT_SORTABLE');?> />
						<?php 
							} //echo $published;
						?>
				</a>
			</td>
			<td align="center" id="exportable<?php echo $info->id;?>">
				<a href="javascript:void(0);" onclick="return listItemTask('cb<?php echo $i-1;?>','<?php echo $params->get('isExportable',0) ? 'unexportable' : 'exportable' ?>')">
							<?php if($params->get('isExportable',0))
							{ ?>
								<img src="../components/com_xius/assets/images/tick.png" width="16" height="16" border="0" alt=<?php echo XiusText::_('EXPORTABLE');?> />
							<?php 
							}
							else 
							{ ?>
								<img src="../components/com_xius/assets/images/publish_x.png" width="16" height="16" border="0" alt=<?php echo XiusText::_('NOT_EXPORTABLE');?> />
						<?php 
							} //echo $published;
						?>
				</a>
			</td>
			<td align="center">
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
</div>
</div>
