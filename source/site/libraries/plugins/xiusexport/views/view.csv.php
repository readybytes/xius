<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusexportView extends XiusBaseView
{
	function __construct()
	{
		parent::__construct(__FILE__);
	}
	
	function searchHtml($calleObject,$value='')
	{
		return false;
	}

	// XITODO : break the function
	function export($tmpl='csv')
	{
		$mainframe = JFactory::getApplication();
	
		$params = XiusLibUsersearch::getDataFromSession(XIUS_CONDITIONS,false);
		$sort = XiusLibUsersearch::getDataFromSession(XIUS_SORT,false);
		$dir = XiusLibUsersearch::getDataFromSession(XIUS_DIR,false);
		//$sortInfo = XiusLibUsersearch::collectSortParams();
		$plgSortInstance = XiusFactory::getPluginInstance('',$sort);

		if(!$plgSortInstance)
			$sort = 'userid';
		else{
			$cacheColumns = $plgSortInstance->getTableMapping();
			if(empty($cacheColumns))
				$sort = 'userid';
			else {
				foreach($cacheColumns as $c){
					/*	XITODO : Sort according to multiple columns name */
					$sort = $c->cacheColumnName;
				}
			}
		}

		$join  = XiusLibUsersearch::getDataFromSession(XIUS_JOIN,'AND');
		$model = XiusFactory::getInstance ('users','model');
		$users = $model->getUsers($params,$join,$sort,$dir,false);

        $userprofile = array();

        /*collect all info */
        $filter = array();
		$filter['published'] = true;
        $allInfo = XiusLibInfo::getInfo($filter,'AND',false);
		$fields = array();
        if(!empty($allInfo)){
        	foreach($allInfo as $info){

        		if(empty($users))
        			break;

				$plgInstance = XiusFactory::getPluginInstance($info->pluginType);

				if(!$plgInstance)
					continue;

				$plgInstance->bind($info);

				if(!$plgInstance->isAllRequirementSatisfy())
					continue;

				if(!$plgInstance->isExportable())
					continue;

				array_push($fields,$plgInstance->get('labelName'));
        		foreach($users as $u){
        			$userprofile[$u->userid][$info->id]['label'] = $info->labelName;

				    $columns = $plgInstance->getTableMapping();
					if(empty($columns))
						break;

					foreach($columns as $c){
						/* XITODO : multiple column support at all places */
						if(!empty($c->cacheColumnName))
							$cname = $c->cacheColumnName;
					}

					if(isset($u->$cname))
        				$userprofile[$u->userid][$info->id]['value'] = $plgInstance->_getFormatData($u->$cname);
        			else
        				$userprofile[$u->userid][$info->id]['value'] = $plgInstance->getMiniProfileDisplay($u->userid);
        		}

			}
        }
		$this->assignRef('users', $users);
		$this->assignRef('userprofile', $userprofile);
		$this->assignRef('fields', $fields);
		$this->display($tmpl);
	}
}

?>