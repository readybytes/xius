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
				if($plgInstance->isSearchable()){
					if($plgInstance->isAllRequirementSatisfy()){
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
		/*XITODO : not include file here
		* Include community language file also
		 */
		require_once(JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'libraries'.DS.'core.php');
		$params = XiusLibrariesUserSearch::collectParamstoSearch();
		$model =& XiusFactory::getModel('search','site');
		$users =& $model->getData($params);      
        $pagination =& $model->getPagination($params);
        
        $userprofile = array();
        
        /*collect all info */
        $filter = array();
		$filter['published'] = true;
        $allInfo = XiusLibrariesInfo::getInfo($filter,'AND',false);
        if(!empty($allInfo)){
        	foreach($allInfo as $info){
				$plgInstance = XiusFactory::getPluginInstanceFromId($info->id);
				if($plgInstance->isVisible()){
					if($plgInstance->isAllRequirementSatisfy()){
						
						if(!empty($users)){
	        				foreach($users as $u){
	        					$userprofile[$u->userid][$info->id]['label'] = $info->labelName;
	        					$userprofile[$u->userid][$info->id]['value'] = $plgInstance->getMiniProfileDisplay($u->userid);
	        				}
	        			}
					}
        		}
			}
        }
        
		$this->assignRef('users', $users);
		$this->assignRef('userprofile', $userprofile);
		$this->assignRef('pagination', $pagination);
		
		parent::display();
	}
}	

?>