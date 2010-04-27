<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiusViewUsers extends JView 
{	
	function exportUser($fromTask)
	{
		global $mainframe;
		$user =& JFactory::getUser();
		
		if(!XiusHelpersUtils::isAdmin($user->id)){
			$url = JRoute::_('index.php?option=com_xius&view=users',false);
			$mainframe->redirect($url,JText::_('NOT HAVE PERMISSIONS TO EXPORT'),false);
		}
		$this->setLayout('userlist.csv');
		$params = XiusLibrariesUsersearch::getDataFromSession(XIUS_CONDITIONS,false);
		$sort = XiusLibrariesUsersearch::getDataFromSession(XIUS_SORT,false);
		$dir = XiusLibrariesUsersearch::getDataFromSession(XIUS_DIR,false);
		//$sortInfo = XiusLibrariesUsersearch::collectSortParams();
		$plgSortInstance = XiusFactory::getPluginInstanceFromId($sort);
		
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
		
		$join = XiusLibrariesUsersearch::getDataFromSession(XIUS_JOIN,'AND');
		$model =& XiusFactory::getModel('users','site');
		$users =& $model->getUsers($params,$join,$sort,$dir,false);      
      
        $userprofile = array();
        
        /*collect all info */
        $filter = array();
		$filter['published'] = true;
        $allInfo = XiusLibrariesInfo::getInfo($filter,'AND',false);
		$fields = array();
        if(!empty($allInfo)){
        	foreach($allInfo as $info){
        		
        		if(empty($users))
        			break;
        			
				$plgInstance = XiusFactory::getPluginInstanceFromId($info->id);
				if(!$plgInstance)
					continue;

				if(!$plgInstance->isAllRequirementSatisfy())
					continue;
					
				if(!$plgInstance->isExportable())
					continue;
				
				array_push($fields,$plgInstance->get('labelName'));
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
		$this->assignRef('fields', $fields);
		parent::display();
	}
}	

?>