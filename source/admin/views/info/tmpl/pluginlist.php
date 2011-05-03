<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

JToolBarHelper::back('Home' , 'index.php?option=com_xius&view=info');
JToolBarHelper::cancel( 'cancel', XiusText::_('CLOSE' ));

// load jquery
XiusHelperUtils::loadJQuery();
?>

<script type="text/javascript">
jQuery(document).ready(function($){
	$("select#plugin").change(function(){
			var optionvalue = $("select option:selected").val();

			$('div#xiusOptionHelper').children('div').css("display", "none");
			$('div#'+optionvalue).css("display", "block");
	});
});
	
</script>

<div style="background-color: #F9F9F9; border: 1px solid #D5D5D5; margin-bottom: 10px; padding: 5px;font-weight: bold;">
	<?php echo XiusText::_('SELECT_DATA_TO_USE');?>
</div>
<div id="error-notice" style="color: red; font-weight:700;"></div>
<div style="clear: both;"></div>
<form action="<?php echo JURI::base();?>index.php?option=com_xius&view=info" method="post" name="adminForm" id="adminForm" >
<table cellspacing="0" class="admintable" border="0" width="100%">
	<tbody>
		<tr>
			<td class="key"><?php echo XiusText::_('INFO');?></td>
			<td>:</td>
			<td>
				<div>
				<?php
					if(!empty($this->plugins)){?>
						<select id="plugin" name="plugin">
						<?php 
						foreach($this->plugins as $p){?>
					    	<option value = "<?php echo $p['name'];?>"><?php echo XiusText::_($p['title']);?></option>
					    <?php 
						}
					    ?>
					    </select>
						<?php 
					}
				?>
				</div>
			</td>
			
			<td>
			<div id="xiusOptionHelper" style= "margin-right: 15%; background-color:#F9F9F9; border:1px solid #efefef; width:500px; float:right;">
				<?php 
						foreach($this->plugins as $p){ ?>
							<div  id= <?php echo $p['name']; ?>  style= "display:<?php echo ($p['name']==='customtable')?"block":"none";?>">
							<h3 > <?php echo $p['title']; ?> </h3>
							<?php echo $p['desc']; ?>
							</div> <?php
				}	
				?>
			</div>
			</td>
			
		</tr>
	</tbody>
</table>

<div class="clr"></div>

<div style="float:left; margin-left: 320px">
	<input type="submit" name="infonext" value="<?php echo XiusText::_('NEXT');?>"/>
</div>	
	<input type="hidden" name="option" value="com_xius" />
	<input type="hidden" name="view" value="<?php echo JRequest::getCmd( 'view' , 'info' );?>" />
	<input type="hidden" name="id" value="" />
	<input type="hidden" name="task" value="add" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
<?php 
