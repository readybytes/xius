<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiusViewInfo extends JView 
{
	function display($tpl = null)
	{
		$iModel	= XiusFactory::getModel( 'info' );
		
		$allInfo		=& $iModel->getInfo();
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
		$plugins = XiusHelpersUtils::getAvailablePlugins();
		
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
		parent::display($tpl);
	}
	
	
	function renderinfo($pluginObject,$data,$tpl = null)
	{
		$paramsHtml = '';
		$pluginParamsHtml = '';
		
		$postData = JRequest::get('post');
		
		$pluginObject->formatPostForGeneratingInfo($postData);
		
		$pluginObject->getHtml($paramsHtml,$pluginParamsHtml);
		
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

		// Set the titlebar text
		JToolBarHelper::title( JText::_( 'GENERATE INFO' ), 'info' );

		// Add the necessary buttons
		JToolBarHelper::back('Home' , 'index.php?option=com_xius');
		JToolBarHelper::divider();
		JToolBarHelper::publishList('publish', JText::_( 'PUBLISH' ));
		JToolBarHelper::unpublishList('unpublish', JText::_( 'UNPUBLISH' ));
		JToolBarHelper::divider();
		JToolBarHelper::trash('remove', JText::_( 'DELETE' ));
		JToolBarHelper::addNew('add', JText::_( 'CREATE INFO' ));
	}
}
