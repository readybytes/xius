<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');
$this->loadAssets('css', 'lists.css');
require_once XIUS_COMPONENT_PATH_SITE.DS.'elements'.DS.'limit.php';
?>
<div class="">
<form action="<?php echo XiusRoute::_($this->submitUrl);?>" name="listForm" id="listForm" method="post">
<?php
if(empty($this->lists))	:
	echo XiusText::_('NO_LISTS_AVAILABLE');
else	:
	foreach($this->lists as $l)	:
		$url = XiusRoute::_($this->submitUrl.'&listid='.$l->id,false);
		?>
		<div class="listmain">
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
		<div class="listdesc">
		<?php
		echo $l->description;
		?><hr />
		</div>
		</div>
		<?php
	endforeach;
endif;
echo $this->pagination->getPagesLinks();

//set default limit that is already set from backend
$endLimit = JRequest::getVar('limit',0);
$limit    = ( !$endLimit ) 
		      ? XiusHelperUtils::getConfigurationParams('xiusLimit') 
		      : $endLimit;
$listObject = new JElementLimit;
$listObject->fetchElement('limit',$limit);
?>

<input type="hidden" name="view" value="list" />
<input type="hidden" name="task" value="display" />
</form>
</div>
