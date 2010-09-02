<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');
$css = JURI::base().'components/com_xius/assets/css/sp.css';
$document =& JFactory::getDocument();
$document->addStyleSheet($css);
//$document->addStyleSheet('components/com_community/templates/default/css/style.css');
JHTML::_('behavior.tooltip', '.hasTip');
jimport('joomla.html.pane');
?>
<div class="xius_sp" id="xius_sp">
<form action="<?php echo JRoute::_('index.php?option=com_xius&view=users&task=search');?>" method="post" name="userForm" id="userForm">

<div class="xius_spHead">
<?php echo JText::_('Search');?>
</div>
		<?php
		$count = 0;
		$i  = 0;

		if(empty($this->infohtml)):
		?>
			<!-- <div class="xiusNoInfo"> -->
			<h3>
			<?php echo JText::_('All Searchable Information Has Been Disabled By Administrator');?>
			</h3>
			<!-- </div> -->
		<?php
		else:
		foreach($this->infohtml as $data):
			?>
			<div class="xius_spMain">
			<div class="xius_spLabel">
			<?php
			//echo JHTML::_('tooltip',JText::_($xiustool), JText::_($data['label']), null, JText::_($data['label']));
			$xiustooltip = $data['tooltip'];
			if(!empty($xiustooltip)) :
				echo '<span title="'.JText::_($xiustooltip).'">'.JText::_($data['label']).'</span>';			
			else :
				echo JText::_($data['label']); 
			endif; 
			?>
			</div>
			<div class="xius_spInput">
			<?php echo $data['html'];?>
			</div>
			</div>
			<?php
		endforeach;
		?>
		<div class="xius_spMain">
		<div class="xius_spLabel"><?php echo JText::_('XIUS JOIN WITH'); ?></div>
		<div class="xius_spInput">
		<input type="radio" name="xius_join" value="AND" /><?php echo JText::_('MATCH ALL'); ?>
		<input type="radio" name="xius_join" value="OR" /><?php echo JText::_('MATCH ANY'); ?>
		</div>
		</div>
		<div class="xius_spSubmit">
		<input type="submit" id="xiussearch" name="xiussearch" value="Search" />
		</div>
		<?php
		endif;
		?>

	<input type="hidden" name="fromPanel" value="true" />
	<input type="hidden" name="option" value="com_xius" />
	<input type="hidden" name="view" value="users" />
	<input type="hidden" name="task" value="search" />
	<input type="hidden" name="subtask" value="xiussearch" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>