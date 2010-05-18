<?php
/**
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

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

		//$resetImage = JUri::root().'administrator/components/com_xijc/assets/images/icon-reset.png';
		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'Configuration' ), 'configuration' );

		// Add the necessary buttons
		JToolBarHelper::back('HOME' , 'index.php?option=com_xijc');
		JToolBarHelper::divider();
		JToolBarHelper::save('save','SAVE');
		//JToolBarHelper::custom('reset','reset','','RESET',0,0); 
	}
}