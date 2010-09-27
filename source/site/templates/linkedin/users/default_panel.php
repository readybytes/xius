<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');
$this->loadAssets('css', 'panel.css');
$document =& JFactory::getDocument();
JHTML::_('behavior.tooltip', '.hasTip');
jimport('joomla.html.pane');
?>
<div class="xius_sp" id="xiusSp">
<form action="<?php echo XiusRoute::_($this->submitUrl);?>" method="post" name="userForm" id="userForm">

<div id="spHead">
<?php echo XiusText::_('Search');?>
</div>
		<?php
		$count = 0;
		$i  = 0;

		if(empty($this->infohtml)):
		?>
			<!-- <div class="xiusNoInfo"> -->
			<h3>
			<?php echo XiusText::_('All Searchable Information Has Been Disabled By Administrator');?>
			</h3>
			<!-- </div> -->
		<?php
		else:
		foreach($this->infohtml as $data):
			?>
			<div class="xiusSpMain">
			<div class="xiusSpLabel">
			<?php
			//echo JHTML::_('tooltip',XiusText::_($xiustool), XiusText::_($data['label']), null, XiusText::_($data['label']));
			$xiustooltip = $data['tooltip'];
			if(!empty($xiustooltip)) :
				echo '<span title="'.XiusText::_($xiustooltip).'">'.XiusText::_($data['label']).'</span>';			
			else :
				echo XiusText::_($data['label']); 
			endif; 
			?>
			</div>
			<div class="xiusSpInput">
			<?php echo $data['html'];?>
			</div>
			</div>
			<?php
		endforeach;
?>		
		<div class="clr"></div>
		<?php 	
		echo $this->loadTemplate('joinhtml');
		?>
		<div id="xiusSpSubmit">
		<input type="submit" id="xiussearch" name="xiussearch" value="Search" />
		</div>
		<?php
		endif;
		?>

	<input type="hidden" name="fromPanel" value="true" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>
<?php 
