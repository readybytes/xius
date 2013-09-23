<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
$this->loadAssets('css', 'lists.css');
require_once XIUS_COMPONENT_PATH_SITE.DS.'elements'.DS.'limit.php';
?>
<div id="xiusLists">
<form action="<?php echo XiusRoute::_($this->submitUrl);?>" name="listForm" id="listForm" method="post">
<?php
if(empty($this->lists))	:
	echo XiusText::_('NO_LISTS_AVAILABLE');
else	:
	foreach($this->lists as $l)	:
		$url = XiusRoute::_($this->submitUrl.'&listid='.$l->id,false);
		?>
		<div class="xiusListsBox">
			
			<div class="xiusListsHead">
				<div class="listtopleft">
				<h3>
				<?php
				$name = $l->name;
				if(empty($name)):
					$name = 'LIST';
				endif;
				
				echo '<a href="'.$url.'">'.$name.'</a>'
				?></h3>
				</div>
			
				<div class="listtopright">
				</div>
			</div>	
			<div class="xiusListDesc">
				<?php
				echo $l->description;
				?>
			</div>
				
		</div>
		<?php
	endforeach;
endif;
echo $this->pagination->getPagesLinks();
//set default limit that is already set from backend
$limit		    = XiusHelperUtils::getConfigurationParams('xiusLimit','20');
JRequest::setVar('limit', $limit);
$jlimit = new JElementLimit();
echo $jlimit->fetchElement('limit',$limit);
?>

<input type="hidden" name="option" value="com_xius" />
<input type="hidden" name="view" value="list" />
<input type="hidden" name="task" value="display" />
</form>
</div>