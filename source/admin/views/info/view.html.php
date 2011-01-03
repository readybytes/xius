<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiusViewInfo extends JView 
{
	function display($tpl = null)
	{
		$iModel	= XiusFactory::getModel( 'info' );
		
		$allInfo		=& $iModel->getAllInfo();
		$pagination	=& $iModel->getPagination();
		
		$this->setToolbar();
		// Load tooltips
		JHTML::_('behavior.tooltip', '.hasTip');

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
			if($plugins){
					/*call plugin field render function */
					$pluginObject = XiusFactory::getPluginInstance($plugin);
					if($pluginObject)
						$rawDataHtml = $pluginObject->renderRawDataHtml();
			}
			
			$this->assign( 'rawDataHtml' , $rawDataHtml );
			$this->assign( 'plugin' , $plugin );
		}
		
		$this->assign( 'plugins' , $plugins );
		JToolBarHelper::title( XiusText::_( 'GENERATE INFO' ), 'info' );
		parent::display($tpl);
	}
	
	
	function renderinfo($pluginObject,$data,$tpl = null)
	{
		$paramsHtml = '';
		$pluginParamsHtml = '';
		
		$postData = JRequest::get('post');
		
		$pluginObject->formatPostForGeneratingInfo($postData);
		$pluginObject->getHtml($paramsHtml,$pluginParamsHtml);
		//XITODO:: import plugin in xius.php
		$privacy	=array();
		JPluginHelper::importPlugin('xius');
		$dispatcher = & JDispatcher::getInstance();
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
		JToolBarHelper::title( XiusText::_( 'GENERATE INFO' ), 'info' );
		parent::display($tpl);
	}
	
	
	function setToolBar()
	{

		// Set the titlebar text
		JToolBarHelper::title( XiusText::_( 'GENERATE INFO' ), 'info' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xius');
		JToolBarHelper::divider();
		JToolBarHelper::publishList('publish', XiusText::_( 'PUBLISH' ));
		JToolBarHelper::unpublishList('unpublish', XiusText::_( 'UNPUBLISH' ));
		JToolBarHelper::divider();
		JToolBarHelper::trash('remove', XiusText::_( 'DELETE' ));
		JToolBarHelper::addNew('add', XiusText::_( 'CREATE INFO' ));
	}
}
