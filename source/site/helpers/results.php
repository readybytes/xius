<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class XiusHelperResults
{
	public static function _getInitialData(&$data)
	{
		$conditions 	 = XiusLibUsersearch::getDataFromSession(XIUS_CONDITIONS,false);
		$sortId 		 = XiusLibUsersearch::getDataFromSession(XIUS_SORT,false);
		$dir 			 = XiusLibUsersearch::getDataFromSession(XIUS_DIR,'ASC');
		$join 			 = XiusLibUsersearch::getDataFromSession(XIUS_JOIN,'AND');
		$plgSortInstance = XiusFactory::getPluginInstance('',$sortId);

		if(!$plgSortInstance)
			$sort = 'userid';
		else{
			$cacheColumns = $plgSortInstance->getSortableTableMapping();
			if(empty($cacheColumns))
				$sort = 'userid';
			else {
			// XiTODO:: Clean this
				foreach($cacheColumns as $c)
					$sort = $c->cacheColumnName;
			}
		}
		/*collect all info */
        $filter = array();
		$filter['published']= true;
		$allInfo 			= XiusLibInfo::getInfo($filter,'AND',false);

		$data['allInfo']	= $allInfo;
		$data['conditions']	= $conditions;
		$data['sortId']		= $sortId;
		$data['sort']		= $sort;
		$data['dir']		= $dir;
		$data['join']		= $join;
	}

	public static function _getUsers(&$data)
	{
		$model 		=  XiusFactory::getInstance ('users', 'model');
		$users 		= $model->getUsers($data['conditions'],$data['join'],$data['sort'],$data['dir']);
        $pagination = $model->getPagination($data['conditions'],$data['join'],$data['sort'],$data['dir']);

        $data['users']		= $users;
        $data['pagination'] = $pagination;
	}

	public static function _getTotalUsers(&$data)
	{
		$model 		   = XiusFactory::getInstance('users', 'model','');
		$data['total'] = $model->getTotal($data['conditions'],$data['join'],$data['sort'],$data['dir']);

	}

	public static function _createUserProfile(&$data)
	{
		$allInfo		= XiusLibInfo::getAllInfo();
        $userprofile 	= array();
        $sortableFields = XiusLibUsersearch::getSortableFields($data['allInfo']);

        JDispatcher::getInstance()->trigger("xiusOnBeforeCreateUserProfile",Array(&$data)); 
        if(!empty($allInfo)){
        	foreach($allInfo as $info){

        		//XiTODO:: why check it every time. I hate it. 
        		if(empty($data['users']))
        			break;

				//$plgInstance = XiusFactory::getPluginInstance($info->id);
				$plgInstance = XiusFactory::getPluginInstance($info->pluginType);
				if(!$plgInstance)
					continue;

				$plgInstance->bind($info);

				if(!$plgInstance->isAllRequirementSatisfy())
					continue;

				if(!$plgInstance->isVisible())
					continue;
				 
				$plgInstance->getDisplayData($userprofile,$data, $info);
			}
        }
        $data['userprofile']	= $userprofile;
		$data['sortableFields'] = $sortableFields;
	}

	public static function _getAppliedInfo(&$data)
	{
	//$availableInfo = $allInfo;
        $appliedInfo = array();
        /*convert search param into display data
         * creating applied info ( search parameter )
         */
        JDispatcher::getInstance()->trigger("xiusOnBeforeGetAppliedInfo", Array(&$data));
        if(!empty($data['conditions'])){
        	foreach($data['conditions'] as $c){
        		if(!array_key_exists('infoid',$c))
        			continue;

        		//$plgInstance = XiusFactory::getPluginInstance('',$c['infoid']);
        		$plgInstance = false;
        		if(!empty($data['allInfo'])){
        			foreach($data['allInfo'] as $info){
        				if($info->id == $c['infoid']){
        					$plgInstance = XiusFactory::getPluginInstance($info->pluginType);
        					if($plgInstance)
								$plgInstance->bind($info);

							break;
        				}

        			}
        		}

				if(!$plgInstance)
					continue;

				// if input values are are not valid then discard this
				if($plgInstance->validateValues($c['value']) == false)
					continue;

				$appliedData = array();
				
				$appliedData['label'] 		= $plgInstance->get('labelName');
				$appliedData['formatvalue'] = $plgInstance->_getFormatAppliedData($c['value']);
				$appliedData['infoid'] 		= $c['infoid'];
				$appliedData['value'] 		= $c['value'];

				$appliedInfo[] = $appliedData;
        	}
        }
        $data['appliedInfo']=$appliedInfo;
	}

	public static function _getAvailableInfo(&$data)
	{
        /*XITODO : arrange available info
         * representation array
         */
        $availableInfo = array();
	 	if(!empty($data['allInfo'])){
        	foreach($data['allInfo'] as $ai){
        		$plgInstance = XiusFactory::getPluginInstance($ai->pluginType);
        		if($plgInstance)
					$plgInstance->bind($ai);

				if(!$plgInstance)
					continue;

				if(!$plgInstance->isAllRequirementSatisfy())
					continue;

				if(!$plgInstance->isSearchable())
					continue;

				/*if(!empty($appliedInfo)){
					$exist = false;
					foreach($appliedInfo as $api){
						if($api['infoid'] == $ai->id)
							$exist = true;
					}
					if($exist == true)
						continue;
				}*/
				$inputHtml = $plgInstance->renderSearchableHtml();

				if($inputHtml === false)
					continue;

				$infohtml['infoid'] = $ai->id;
				$infohtml['info'] 	= $ai;
				$infohtml['label'] 	= $ai->labelName;
				$infohtml['html'] 	= $inputHtml;
				$infohtml['tooltip']= $plgInstance->getTooltip();

				array_push($availableInfo,$infohtml);
        	}
        }

		// XITODO : trigger it in view
        $dispatcher = JDispatcher::getInstance();
		$dispatcher->trigger( 'onBeforeDisplayAvailableInfo',array( &$availableInfo ));
		
        $data['availableInfo']=$availableInfo;
	}

	
}