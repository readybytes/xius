<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
$this->loadAssets('css', 'nextgen_lists.css');
?>
<div id="xiusLists">
<form action="<?php echo XiusRoute::_($this->submitUrl);?>" name="listForm" id="listForm" method="post">
<?php
if(empty($this->lists))	:
	echo XiusText::_('NO LISTS AVAILABLE');
else	:
	foreach($this->lists as $l)	:
		$url = XiusRoute::_($this->submitUrl.'&listid='.$l->id,false);
		?>
		<div class="xiusListsBox">
			
			<div class="xiusListsHead">
				<div class="listtopleft">
				<h2>
				<?php
				$name = $l->name;
				if(empty($name)):
					$name = 'LIST';
				endif;
				
				echo '<a href="'.$url.'">'.XiusText::_($name).'</a>'
				?></h2>
				</div>
			
				<div class="listtopright">
				</div>
			</div>	
			<div class="xiusListDesc">
				<?php
				echo XiusText::_($l->description);
				?>
			</div>
				
		</div>
		<?php
	endforeach;
endif;
echo $this->pagination->getPagesLinks();
echo $this->pagination->getLimitBox();
?>

<input type="hidden" name="option" value="com_xius" />
<input type="hidden" name="view" value="list" />
<input type="hidden" name="task" value="display" />
</form>
</div>