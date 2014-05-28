<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Backend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiusViewInfo extends XiusView 
{
	protected $_name = 'info';
	
	function display($tpl = null)
	{
		$iModel	= XiusFactory::getInstance ( 'info','Model' );
		
		$allInfo	= $iModel->getAllInfo();
		$pagination	= $iModel->getPagination();

		$this->assignRef( 'allinfo' 		, $allInfo );
		$this->assignRef( 'pagination'	, $pagination );
		parent::display( $tpl );
    }
	

    function add($plugin,$tpl = null)
	{
		$plugins = XiusHelperUtils::getAvailablePlugins();
		
		if($plugin) {
		
			/*XITODO : render all plugins individual fields 
			 * Take care , what if f particular field ifo is already created
			 * Eq :- never create info for Gender Twice etc.*/
			
			$rawDataHtml = '';
			//XiTODO:: is it required??
			if($plugins){
					/*call plugin field render function */
					$pluginObject = XiusFactory::getPluginInstance($plugin);
					if($pluginObject)
						$rawDataHtml = $pluginObject->renderRawDataHtml();
			}
			
			$this->assign( 'rawDataHtml' , $rawDataHtml );
			$this->assign( 'plugin' , $plugin );
		}
		//XiTODO:: Why assign this.
		$this->assign( 'plugins' , $plugins );
		parent::display($tpl);
	}
	
	
	function renderinfo($pluginObject,$data,$tpl = null)
	{
		$paramsHtml = '';
		$pluginParamsHtml = '';
		
		$postData = JRequest::get('post');
		
		$pluginObject->formatPostForGeneratingInfo($postData);
		$pluginObject->getHtml($paramsHtml,$pluginParamsHtml);

		$privacy	= array();
		$dispatcher = JDispatcher::getInstance();
		$privacyHtml= $dispatcher->trigger('onBeforeRenderInfoDisplay', array(&$data));
		
		$this->assignRef('privacyHtml', $privacyHtml);
		$this->assignRef('paramsHtml',		$paramsHtml);
		$this->assignRef('pluginParamsHtml',		$pluginParamsHtml);
		
		$infoName = $pluginObject->getInfoName();
		$pluginArray = $pluginObject->toArray();
		
		if(empty($pluginArray['labelName']))
			$pluginArray['labelName'] = $infoName;
		
		$this->assign('pluginArray',		$pluginArray);
		$this->assign('info',$data);
		$this->assign('infoName',$infoName);
		parent::display($tpl);
	}
	
	
	function setToolBar()
	{

		$task   = JFactory::getApplication()->input->get('task');
		$plugin = JFactory::getApplication()->input->get('plugin', 0 ) ;
		
		if($task != ('add' || 'renderinfo' || 'apply') || $task == "cancel") {
			JToolBarHelper::addNew('add', XiusText::_( 'CREATE_INFO' ));
			JToolBarHelper::divider();
			JToolBarHelper::publishList('publish', XiusText::_( 'PUBLISH' ));
			JToolBarHelper::unpublishList('unpublish', XiusText::_( 'UNPUBLISH' ));
			JToolBarHelper::divider();
			JToolBarHelper::trash('remove', XiusText::_( 'DELETE' ));
		}
		if($task == 'renderinfo' || $task == 'apply' )
		{
			JToolBarHelper::apply('apply', XiusText::_('APPLY'));
			JToolBarHelper::save('save',XiusText::_('SAVE_AND_CLOSE'));
		}
		if($plugin && $task != 'cancel') {
			JToolbarHelper::back(XiusText::_('BACK'));
		}
		if($task != ('cancel') && isset($task) ) {
			JToolBarHelper::cancel( 'cancel', XiusText::_('CLOSE' ));
		}
		
	}
}

