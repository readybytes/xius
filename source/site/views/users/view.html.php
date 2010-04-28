<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiusViewUsers extends JView 
{
	function displaySearch($allInfo)
	{
		$infohtml = array();
		if(!empty($allInfo)){
			$count = 0;
			foreach($allInfo as $info){
				$plgInstance = XiusFactory::getPluginInstanceFromId($info->id);

				if(!$plgInstance)
					continue;

				if(!$plgInstance->isAllRequirementSatisfy())
					continue;

				if(!$plgInstance->isSearchable())
					continue;

				$inputHtml = $plgInstance->renderSearchableHtml();
						
				if($inputHtml === false)
					continue;
							
				$infohtml[$count]['infoid'] = $info->id;
				$infohtml[$count]['info'] = $info;
				$infohtml[$count]['label'] = $info->labelName;
				/*
				 *replace name and id in input html 
				 */
	
				$infohtml[$count]['html'] = $inputHtml;
				
				$count++;

			}
		}
		
		$this->assign( 'infohtml' , $infohtml );
		return parent::display();
	}
	

	function displayResult($from,$subtask,$list='')
	{
		$conditions = XiusLibrariesUsersearch::getDataFromSession(XIUS_CONDITIONS,false);
		$sortId = XiusLibrariesUsersearch::getDataFromSession(XIUS_SORT,false);
		$dir = XiusLibrariesUsersearch::getDataFromSession(XIUS_DIR,'ASC');
		//$sortInfo = XiusLibrariesUsersearch::collectSortParams();
		$join = XiusLibrariesUsersearch::getDataFromSession(XIUS_JOIN,'AND');
		$plgSortInstance = XiusFactory::getPluginInstanceFromId($sortId);
		
		if(!$plgSortInstance)
			$sort = 'userid';
		else{
			$cacheColumns = $plgSortInstance->getCacheColumns();
			if(empty($cacheColumns))
				$sort = 'userid';
			else {
				foreach($cacheColumns as $c){
					$sort = $c['columnname'];
				}
			}
		}
		
		$model =& XiusFactory::getModel('users','site');
		$users =& $model->getUsers($conditions,$join,$sort,$dir);      
        $pagination =& $model->getPagination($conditions);
        $total =& $model->getTotal($conditions);
        
        $userprofile = array();
        
        /*collect all info */
        $filter = array();
		$filter['published'] = true;
        $allInfo = XiusLibrariesInfo::getInfo($filter,'AND',false);
        $sortableFields = XiusLibrariesUsersearch::getSortableFields($allInfo);

        if(!empty($allInfo)){
        	foreach($allInfo as $info){
        		
        		if(empty($users))
        			break;
        			
				$plgInstance = XiusFactory::getPluginInstanceFromId($info->id);
				if(!$plgInstance)
					continue;

				if(!$plgInstance->isAllRequirementSatisfy())
					continue;
					
				if(!$plgInstance->isVisible())
					continue;
				
        		foreach($users as $u){
        			$userprofile[$u->userid][$info->id]['label'] = $info->labelName;
        			
				    $columns = $plgInstance->getCacheColumns();
					if(empty($columns))
						break;
				
					foreach($columns as $c){
						if(isset($c['columnname']) && !empty($c['columnname']))
							$cname = $c['columnname'];
					}
        			
					if(isset($u->$cname))
        				$userprofile[$u->userid][$info->id]['value'] = $plgInstance->_getFormatData($u->$cname);
        			else
        				$userprofile[$u->userid][$info->id]['value'] = $plgInstance->getMiniProfileDisplay($u->userid);
        		}
	        		
			}
        }
		
        //$availableInfo = $allInfo;
        $appliedInfo = array();
        /*convert search param into display data
         * creating applied info ( search parameter )
         */
        if(!empty($conditions)){
        	foreach($conditions as $c){
        		if(!array_key_exists('infoid',$c))
        			continue;
        			
        		$plgInstance = XiusFactory::getPluginInstanceFromId($c['infoid']);
				if(!$plgInstance)
					continue;
			
				$appliedData = array();
				$appliedData['label'] = $plgInstance->get('labelName');
				$appliedData['value'] = $c['value'];
				$appliedData['infoid'] = $c['infoid'];
				
				$appliedInfo[] = $appliedData;
        	}
        }
        
        
        /*XITODO : arrange available info
         * representation array
         */
        $availableInfo = array();
	 	if(!empty($allInfo)){
        	foreach($allInfo as $ai){	
        		$plgInstance = XiusFactory::getPluginInstanceFromId($ai->id);
				if(!$plgInstance)
					continue;
					
				if(!$plgInstance->isAllRequirementSatisfy())
					continue;

				if(!$plgInstance->isSearchable())
					continue;

				if(!empty($appliedInfo)){
					$exist = false;
					foreach($appliedInfo as $api){
						if($api['infoid'] == $ai->id)
							$exist = true;
					}
					if($exist == true)
						continue;
				}
				$inputHtml = $plgInstance->renderSearchableHtml();
						
				if($inputHtml === false)
					continue;
							
				$infohtml['infoid'] = $ai->id;
				$infohtml['info'] = $ai;
				$infohtml['label'] = $ai->labelName;
				$infohtml['html'] = $inputHtml;
				
				array_push($availableInfo,$infohtml);
        	}
        }
        
        
		$this->assignRef('users', $users);
		$this->assignRef('userprofile', $userprofile);
		$this->assignRef('sortableFields', $sortableFields);
		$this->assignRef('pagination', $pagination);
		$this->assign('total', $total);
		$this->assign('appliedInfo', $appliedInfo);
		$this->assign('availableInfo', $availableInfo);

		$this->assign('sort', $sortId);
		$this->assign('dir', $dir);
		
		$this->assign('list', $list);
		
		$this->assign('task', $from);
		$this->assign('subtask', $subtask);
		parent::display();
	}
	
	
	function _showLists($fromTask,$owner)
	{
		/*XITODO : get list according to owner*/
		$lModel =& XiusFactory::getModel('list','admin');
		
		$filter = array();
					
		$user = JFactory::getUser();
		
		if(XiusHelpersUtils::isAdmin($user->id))
			$filter['published'] = 1;

		$lists = $lModel->getLists($filter);
		
		$this->assign('lists',$lists);
		
		return parent::display();
	}
}	

?>