<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiusViewConfiguration extends JView 
{
    
	function display($tpl = null)
	{
		self::setToolBar();
		$cModel = XiusFactory::getInstance ('configuration','model');
		$params	= $cModel->getParams();
    	jimport('joomla.html.pane');
		$pane	=& JPane::getInstance('sliders');
		
		$this->assignRef( 'pane', $pane );
		$this->assign( 'params' , $params );

		$document   = JFactory::getDocument();
		$document->addStyleSheet(JURI::root() . 'components/com_xius/assets/css/admin.css');
		
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

		// Set the titlebar text
		JToolBarHelper::title( XiusText::_( 'CONFIGURATION' ), 'configuration' );

		// Add the necessary buttons
		JToolBarHelper::back('HOME' , 'index.php?option=com_xius');
		JToolBarHelper::divider();
		JToolBarHelper::save('save','COM_XIUS_SAVE');
		 
		JToolBarHelper::custom("runCron",'updateCache','','COM_XIUS_UPDATE_CACHE',0,0); 
			
		//JToolBarHelper::custom('reset','reset','','RESET',0,0); 
	}
}
