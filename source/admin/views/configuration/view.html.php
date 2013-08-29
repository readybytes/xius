<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class XiusViewConfiguration extends XiusView 
{
	protected $_name = 'configuration';

	function display($tpl = null)
	{
		$cModel = XiusFactory::getInstance ('configuration','model');
		$params	= $cModel->getParams();
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
		// Add the necessary buttons
		JToolBarHelper::save('save','COM_XIUS_SAVE');		 
		JToolBarHelper::custom("runCron",'refresh','','COM_XIUS_UPDATE_CACHE',0,0); 			
		//JToolBarHelper::custom('reset','reset','','RESET',0,0); 
	}
}
