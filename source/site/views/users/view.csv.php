<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiussiteViewUsers extends XiusView
{
	// XITODO : break the function
	function export($tmpl='csv')
	{
		global $mainframe;
		$user =& JFactory::getUser();

		if(!XiusHelpersUtils::isAdmin($user->id)){
			$url = XiusRoute::_('index.php?option=com_xius&view=users',false);
			$mainframe->redirect($url,XiusText::_('NOT HAVE PERMISSIONS TO EXPORT'),false);
		}
		$params = XiusLibrariesUsersearch::getDataFromSession(XIUS_CONDITIONS,false);
		$sort = XiusLibrariesUsersearch::getDataFromSession(XIUS_SORT,false);
		$dir = XiusLibrariesUsersearch::getDataFromSession(XIUS_DIR,false);
		//$sortInfo = XiusLibrariesUsersearch::collectSortParams();
		$plgSortInstance = XiusFactory::getPluginInstanceFromId($sort);

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
		parent::display($tmpl);
	}
}

?>