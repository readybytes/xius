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
		$mySess =& JFactory::getSession();
	
        /*XITODO : get sort params to set in session */
		$mySess->set('sort',1,'XIUS');
		$mySess->set('dir','DESC','XIUS');
		
		/*XITODO : not include file here
		* Include community language file also
		 */
		require_once(JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');
		$params = XiusLibrariesUserSearch::collectParamstoSearch();
		
		$sortInfo = XiusLibrariesUserSearch::collectSortParams();
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
		$users =& $model->getData($params,'AND',$sort,$sortInfo['dir']);      
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
		
		$this->assignRef('users', $users);
		$this->assignRef('userprofile', $userprofile);
		$this->assignRef('sortableFields', $sortableFields);
		$this->assignRef('pagination', $pagination);
		$this->assign('total', $total);

		/*XITODO : get select sort and direction form session
		 * pass this to template
		 */
		$sortInfo = XiusLibrariesUserSearch::collectSortParams();
		$this->assign('sort', $sortInfo['sort']);
		$this->assign('dir', $sortInfo['dir']);
		parent::display();
	}
}	

?>