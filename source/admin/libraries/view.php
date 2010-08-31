<?php

/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @contact		shyam@joomlaxi.com
*/

defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );
/**
 */

abstract class XiusView extends JView
{
	/* Will be set by controller*/
	public $_model 			= null;
	public $_form 			= null;
	
	function __construct($config = array())
	{
		$template	= 'default';

		// override the template path, so that default
		// templates will be picked from here
		//XITODO : we can add here multiple templates, so from global params
		// we will define the directory here
		$prefix	=	$this->getPrefix();	
		$xiustemplateBase = XIUS_PATH_TEMPLATE;

		if(!isset($config['template_path']))
			$config['template_path']	=	array();

		//Always add base template path first and actual view path second
		//base _addPath function will automatically
		//give preference to last given path

		//VERY IMP : These order should be maintained
		$path1 = $xiustemplateBase.DS.JString::strtolower($template).DS.JString::strtolower($this->getName());
		array_unshift($config['template_path'],$path1);

		$path2	=	$xiustemplateBase.DS.JString::strtolower($template);
		array_unshift($config['template_path'],$path2);
		
		parent::__construct($config);
	}
	
	/*
	 * Collect prefix auto-magically
	 */
	public function getPrefix()
	{
		if(isset($this->_prefix) && empty($this->_prefix)===false)
			return $this->_prefix;

		$r = null;
		if (!preg_match('/(.*)View/i', get_class($this), $r)) {
			XiError::raiseError (500, "XiView::getPrefix() : Can't get or parse class name.");
		}

		$this->_prefix  =  JString::strtolower($r[1]);
		return $this->_prefix;
	}
	
	/*
	 * We need to override joomla behaviour as they differ in
	 * Model and Controller Naming	 
	 */
	function getName()
	{
		$name = $this->_name;

		if (empty( $name ))
		{
			$r = null;
			if (!preg_match('/View(.*)/i', get_class($this), $r)) {
				JError::raiseError (500, "Can't get or parse class name.");
			}
			$name = strtolower( $r[1] );
		}

		return $name;
	}
	
	function displayResult($from,$list='')
	{
		$data = array(array());
		XiusHelperResults::_getInitialData($data);
		XiusHelperResults::_getUsers($data);
		XiusHelperResults::_getTotalUsers($data);
		XiusHelperResults::_createUserProfile($data);
		XiusHelperResults::_getAppliedInfo($data);
		XiusHelperResults::_getAvailableInfo($data);

		$document = JFactory::getDocument();
        if(!empty($list) && !empty($list->name))
			$document->setTitle(JText::_($list->name));
		else
			$document->setTitle(JText::_('Search Result'));

		//collect user data from appropritae profile component
		$xiusSlideShow  = xiusHelpersUtils::getConfigurationParams('xiusSlideShow','none');
		$this->assignRef('xiusSlideShow', $xiusSlideShow);

		$this->assignRef('users', XiusHelperProfile::getUserProfileData($data['users']));
		
		// get the list id for save list
		$listid=0;
		if(!empty( $list )){
			if(isset($list->id))
				$listid = $list->id;
			}
		
		$toolbar =XiusHelperToolbar::getAdminToolbar($listid,$from);
		$this->assignRef('toolbar',$toolbar);
		//calculate data for these users

		// trigger event onBeforMiniProfileDisplae
		$dispatcher =& JDispatcher::getInstance();
		$dispatcher->trigger( 'onBeforeMiniProfileDisplay', array( &$data ) );
		
		$this->assignRef('userprofile', $data['userprofile']);
		$this->assignRef('sortableFields', $data['sortableFields']);
		$this->assignRef('pagination', $data['pagination']);
		$this->assign('total', $data['total']);
		$this->assign('appliedInfo', $data['appliedInfo']);
		$this->assign('availableInfo', $data['availableInfo']);

		$this->assign('sort', $data['sortId']);
		$this->assign('dir', $data['dir']);
		$this->assign('join', $data['join']);

		$this->assign('list', $list);

		$this->assign('task', $from);
		$this->assign('view', $this->getName());
		parent::display();
	}
	
}