<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');
require_once XIUS_COMPONENT_PATH_SITE.DS.'elements'.DS.'limit.php';
$this->submitUrl = XIUS_PATH_RESPONSIVE_TEMPLATE_SEARCH;
?>
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function($){
	$("#backtotop").click(function(){ 
		$(window).scrollTop(0);
	});

	$('#filters-sm').click(function(){
		if($('#filters').hasClass("hidden-phone")){
			$('#filters').removeClass("hidden-phone");
		}else{
			$('#filters').addClass("hidden-phone");
		}
	});
});
</script>
<?php 
// for jquery not load
XiusHelperUtils::loadJQuery();

//load bootstrap
XiusHelperUtils::loadBootstrap();

$this->loadAssets('css', 'result.css');
$this->loadAssets('js', 'menus.js');
$this->loadAssets('js', 'result.js');

?>

<?php JHTML::_('behavior.tooltip'); ?>

<div class="container-fluid jomsocial">
	<div id="xiusProfile" class="joms-page">
		<form action="<?php echo XiusRoute::_($this->submitUrl);?>" name="userForm" id="userForm" method="post">	
			<div class="row-fluid">
				<div id="xiusTotal" class="span9" id="total_<?php echo $this->total;?>">
					<h3><span class="text-info"><?php echo sprintf(XiusText::_('XIUS_ABOUT_RESULTS_FOUND'),$this->total);?></span></h3>
				</div>
				<div id="xius-pagination" class="span3 pull-right xius-margin">
					<?php 
					//set default limit for search result
					$mainframe  	= JFactory::getApplication();
					$limit 			= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	                $jlimit = new JElementLimit();
	                echo $jlimit->fetchElement('limit',$limit);
	                ?><span class="xius-margin pull-right xius-font-color"><small><?php echo XiusText::_("USERS_PER_PAGE")?>&nbsp;</small></span>
                </div>
			</div>
			<hr>
			<div class="row-fluid" id="xiusFilter">
				<?php echo $this->loadTemplate('filtered');?>
			</div>
			<div class="visible-phone xius-pointer xius-margin row-fluid">
					<span class="badge label-info " id="filters-sm">Filters <i class="icon-plus xius-icon-bg"></i></span>
				</div>
			<div class="row-fluid">			
				<div class="span4 hidden-phone" id="filters">
					<?php	echo $this->loadTemplate('filters');?>
				</div>
				
				<div class="span8" id="result">
					<div class="row-fluid">
						<?php echo $this->loadTemplate('toolbar'); ?>
					</div>
					<div class="row-fluid xius-margin" id="xiusMiniProfiles">
						<?php echo $this->loadTemplate('profile');?>
						
						<?php 
							if($this->total){
							?>
							<div class="pull-right pagination">
								<?php echo $this->pagination->getPagesLinks();?>
								<img id="backtotop" class="pull-right xius-pointer" src="<?php echo JURI::base().'components/com_xius/assets/images/top.png';?>" title="BackToTop"/>
							</div>
							<?php 
							}?>
					</div>
				</div>
			</div>
			<input type="hidden" name="view" value="users" />
			<input type="hidden" name="task" value="search" />
			<input type="hidden" name="fromPanel" value="true" />
		</form>
	</div>
</div>

