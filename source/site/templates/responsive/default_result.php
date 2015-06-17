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
?>
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function($){
	$("#backtotop").click(function(){ 
		$(window).scrollTop(0);
	});
		
	$('button[data-info="filters-sm"]').click(function(){
		if($('div[data-info="filters"]').hasClass("hidden-phone"))
		{
			$('div[data-info="filters"]').removeClass("hidden-phone");
			$('button[data-info="applyFilter"]').hide();

			//hide the user profile info and add an icon to view that info
			$('div[data-info="xius-user-info"]').hide();
			$('i[data-info="view-user-info"]').show();
		}
		else{
			$('div[data-info="filters"]').addClass("hidden-phone");
		}
	});

	//function to view user info in mobile view
	$('label[data-info="view-user-info"]').click(function(){
		$(this).parent().find('label[data-info="view-user-info"]').addClass("hidden-phone");
		$(this).parent().find('div[data-info="xius-user-info"]').removeClass("hidden-phone");
		$(this).parent().find('label[data-info="hide-user-info"]').removeClass("hidden-phone");
	});

	//function to hide user info in mobile view
	$('label[data-info="hide-user-info"]').click(function(){
		$(this).parent().find('label[data-info="hide-user-info"]').addClass("hidden-phone");
		$(this).parent().addClass("hidden-phone");
		$(this).parent().parent().find('label[data-info="view-user-info"]').removeClass("hidden-phone");
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

<div id="xius" class="xius">
	<div class="joms-page xi-search-result-inner">
		<form action="<?php echo XiusRoute::_($this->submitUrl);?>" name="userForm" id="userForm" method="post">	
			<div class="row-fluid">
				<div id="xiusTotal" class="span9" id="total_<?php echo $this->total;?>">
					<h3><span class="text-info"><?php echo sprintf(XiusText::_('XIUS_ABOUT_RESULTS_FOUND'),$this->total);?></span></h3>
				</div>
				<div id="xius-pagination" class="span3 pull-right xius-margin xius-pagination">
					<?php 
					//set default limit for search result
					$mainframe  	= JFactory::getApplication();
					$limit 			= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
	                $jlimit = new JElementLimit();
	                echo $jlimit->fetchElement('limit',$limit);
	                ?><span class="xius-margin pull-right"><small><?php echo XiusText::_("USERS_PER_PAGE")?>&nbsp;</small></span>
                </div>
			</div>
			<hr>
			<div class="row-fluid" id="xiusFilter">
				<?php echo $this->loadTemplate('filtered');?>
			</div>
			<div class="visible-phone xius-pointer xius-margin row-fluid">
					<button class="btn btn-info" data-info="filters-sm">Filters <i class="icon-filter xius-icon-bg"></i></button>
				</div>
			<div class="row-fluid">			
				<div class="span4 hidden-phone" id="filters" data-info="filters">
					<?php	echo $this->loadTemplate('filters');?>
				</div>
				
				<div class="span8" id="result">
					<div class="row-fluid">
						<?php echo $this->loadTemplate('toolbar'); ?>
					</div>
					<div class="row-fluid xius-margin xius-mini-profiles" id="xiusMiniProfiles">
						<?php echo $this->loadTemplate('profile');?>
						
						<?php 
							if($this->total){
							?>
							<div class="pull-right pagination">
								<?php echo $this->pagination->getPagesLinks();?>
								<span id="backtotop" class="pull-right label xius-pointer xius-margin xi-top">TOP&nbsp;<i class="icon-chevron-up"></i></span>
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

