<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiusViewCpanel extends JView 
{

	function display( $tpl = null )
	{
		// Load tooltips
		JHTML::_('behavior.tooltip', '.hasTip');
		jimport('joomla.html.pane');
		$pane	=& JPane::getInstance('sliders');
		
		$this->setToolbar();
		
		$this->assignRef( 'pane'		, $pane );
		parent::display( $tpl );
	}

	/**
	 * Private method to set the toolbar for this view
	 * 
	 * @access private
	 * 
	 * @return null
	 **/
	function setToolBar()
	{
		?>
		<style type="text/css">
		#toolbar-aboutus
		{
	 		background-image:  url(../administrator/components/com_xius/assets/images/icon-aboutus.png);
	 		background-repeat:no-repeat;
	 		background-position: top center;
	 	}
		</style>
		<?php 
		// Set the titlebar text
		JToolBarHelper::title( XiusText::_( 'CONTROL_PANEL' ), 'Xius' );
		JToolBarHelper::back('Home' , 'index.php?option=com_xius');
		//JToolBarHelper::custom('aboutus','aboutus','',XiusText::_('ABOUT US'),0,0);
	}
	
	function addIcon( $image , $url , $text , $newWindow = false )
	{
		$lang		=& JFactory::getLanguage();
		
		$newWindow	= ( $newWindow ) ? ' target="_blank"' : '';
		?>
		<div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
			<div class="icon">
				<a href="<?php echo $url; ?>"<?php echo $newWindow; ?>>
					<?php echo JHTML::_('image', 'components/com_xius/assets/images/' . $image , $text ); ?>
					<span><?php echo $text; ?></span></a>
			</div>
		</div>
		<?php
	}
	
	
	function updates($tpl = null)
	{
		$this->setToolbar();
		parent::display( $tpl);
	}

}
?>