<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiusViewSearch extends JView 
{
	function showsearchpanel($allInfo)
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
		parent::display();
	}
	
	function _replaceText($serachStr,$replaceStr,&$string)
	{
		
	}
		
	
	function basicsearch()
	{
		$params = XiusLibrariesUsersearch::getDataFromSession('searchdata',false);
		$sortInfo = XiusLibrariesUsersearch::collectSortParams();
		$join = XiusLibrariesUsersearch::getDataFromSession('join','AND');
		$plgSortInstance = XiusFactory::getPluginInstanceFromId($sortInfo['sort']);
		
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
		
		$model =& XiusFactory::getModel('search','site');
		$users =& $model->getUsers($params,$join,$sort,$sortInfo['dir']);      
        $pagination =& $model->getPagination($params);
        $total =& $model->getTotal($params);
        
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
		
        $availableInfo = $allInfo;
        $appliedInfo = array();
        /*convert search param into display data
         * creating applied info ( search parameter )
         */
        if(!empty($params)){
        	foreach($params as $p){
        		if(!array_key_exists('infoid',$p))
        			continue;
        			
        		$plgInstance = XiusFactory::getPluginInstanceFromId($p['infoid']);
				if(!$plgInstance)
					continue;
				
					/*unset applied info */
				foreach($availableInfo as $k => $info){
					if($info->id == $p['infoid'])
						unset($availableInfo[$k]);
				}
				$appliedData = array();
				$appliedData['label'] = $plgInstance->get('labelName');
				$appliedData['value'] = $p['value'];
				$appliedData['infoid'] = $p['infoid'];
				
				$appliedInfo[] = $appliedData;
        	}
        }
        
        
        /*XITODO : arrange available info
         * representation array
         */
	 	if(!empty($availableInfo)){
        	foreach($availableInfo as $ai){	
        		$plgInstance = XiusFactory::getPluginInstanceFromId($ai->id);
				if(!$plgInstance)
					continue;
        	}
        }
        
		$this->assignRef('users', $users);
		$this->assignRef('userprofile', $userprofile);
		$this->assignRef('sortableFields', $sortableFields);
		$this->assignRef('pagination', $pagination);
		$this->assign('total', $total);
		$this->assign('appliedInfo', $appliedInfo);
		$this->assign('availableInfo', $availableInfo);

		$this->assign('sort', $sortInfo['sort']);
		$this->assign('dir', $sortInfo['dir']);
		parent::display();
	}
	
	
	function showLists()
	{
		$lModel =& XiusFactory::getModel('list','admin');
		
		$filter = array();
					
		$user = JFactory::getUser();
		
		if(XiusHelpersUtils::isAdmin($user->id))
			$filter['published'] = 1;

		$lists = $lModel->getLists($filter);
		
		$this->assign('lists',$lists);
		
		parent::display();
	}
}	

?>
