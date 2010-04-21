<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

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
		JToolBarHelper::title( JText::_( 'CONTROL PANEL' ), 'Xius' );
		JToolBarHelper::back('Home' , 'index.php?option=com_xius');
		//JToolBarHelper::custom('aboutus','aboutus','',JText::_('ABOUT US'),0,0);
	}
	
	function addIcon( $image , $url , $text , $newWindow = false )
	{
		$lang		=& JFactory::getLanguage();
		
		$newWindow	= ( $newWindow ) ? ' target="_blank"' : '';
		?>
		<div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
			<div class="icon">
				<a href="<?php echo $url; ?>"<?php echo $newWindow; ?>>
					<?php echo JHTML::_('image', 'administrator/components/com_xius/assets/images/' . $image , NULL, NULL, $text ); ?>
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