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
		$cModel = XiusFactory::getModel('configuration');
		$params	= $cModel->getParams();
    	jimport('joomla.html.pane');
		$pane	=& JPane::getInstance('sliders');
		
		$this->assignRef( 'pane', $pane );
		$this->assign( 'params' , $params );
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
		JToolBarHelper::title( XiusText::_( 'Configuration' ), 'configuration' );

		// Add the necessary buttons
		JToolBarHelper::back('HOME' , 'index.php?option=com_xius');
		JToolBarHelper::divider();
		JToolBarHelper::save('save','SAVE');
		 
		JToolBarHelper::custom("runCron",'updateCache','','UPDATE CACHE',0,0); 
			
		//JToolBarHelper::custom('reset','reset','','RESET',0,0); 
	}
}
