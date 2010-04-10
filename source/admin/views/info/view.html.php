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
	

    function add($tpl = null)
	{
		$plugins = XiusFactory::getAvailablePlugins();
		/*XITODO : render all plugins individual fields 
		 * Take care , what if f particular field ifo is already created
		 * Eq :- never create info for Gender Twice etc.*/
		
		$rawDataHtml = array();
		if($plugins){
			foreach($plugins as $p){
				/*call plugin field render function */
				$pluginObject = XiusFactory::getPluginInstance($p);
				if($pluginObject){
					$html = $pluginObject->renderRawData();
					
					if($html)
						$rawDataHtml[$p] = $html; 
				}
			}
		}
		
		$this->assign( 'plugins' , $plugins );
		$this->assign( 'rawDataHtml' , $rawDataHtml );
		parent::display($tpl);
	}
	
	
	function renderinfo($data,$tpl = null)
	{
		$coreParamsHtml = '';
		$aclParamsHtml = '';
		
		//call htmlrender fn
		$aclObject = aclFactory::getAclObject($data['aclname']);
		
		$aclObject->bind($data);
		$aclObject->getHtml($coreParamsHtml,$aclParamsHtml);
		
		$this->assignRef('coreParamsHtml',		$coreParamsHtml);
		$this->assignRef('aclParamsHtml',		$aclParamsHtml);
		$this->assign('aclruleInfo',$data);
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
