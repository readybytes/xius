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
<div id="xiusLists" class="jomsocial xiusLists">
	<form action="<?php echo XiusRoute::_($this->submitUrl);?>" name="listForm" id="listForm" method="post">
		<?php
		if(empty($this->lists))	:
			echo XiusText::_('NO_LISTS_AVAILABLE');
		else	:
			foreach($this->lists as $l)	:
				$url = XiusRoute::_($this->submitUrl.'&listid='.$l->id,false);
				?>
				<div class="xius-margin joms-page">
					<div class="row-fluid xiusListsPadding">
						<h3>
						<?php
						$name = $l->name;
						if(empty($name)):
							$name = 'LIST';
						endif;
						
						echo '<a href="'.$url.'">'.$name.'</a>'
						?></h3>
					</div>
					<div class="row-fluid xiusListsPadding">
						<?php
						echo $l->description;
						?>
					</div>
				</div>
		<?php
			endforeach;
		endif;?>
		<div class="row-fluid text-right">
			<?php 
			echo $this->pagination->getPagesLinks();
			//set default limit that is already set from backend
			$limit		    = XiusHelperUtils::getConfigurationParams('xiusLimit','20');
			JRequest::setVar('limit', $limit);
			$jlimit = new JElementLimit();
			echo $jlimit->fetchElement('limit',$limit);
			?>
		</div>
	<input type="hidden" name="option" value="com_xius" />
	<input type="hidden" name="view" value="list" />
	<input type="hidden" name="task" value="display" />
	</form>
</div>