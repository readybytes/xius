<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

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
				$infohtml[$count]['tooltip'] = $plgInstance->getTooltip();
				/*
				 *replace name and id in input html
				 */

				$infohtml[$count]['html'] = $inputHtml;

				$count++;

			}
		}

		$document = JFactory::getDocument();
		$document->setTitle(JText::_('Search Panel'));
		$dispatcher =& JDispatcher::getInstance();
		$dispatcher->trigger( 'onBeforeDisplaySearchPanel',array( &$infohtml  ));
		
		$this->assign( 'infohtml' , $infohtml );
		return parent::display();
	}


	function displayResult($from,$list='')
	{
		$data = array(array());
		$this->_getInitialData($data);
		$this->_getUsers($data);
		$this->_getTotalUsers($data);
		$this->_createUserProfile($data);
		$this->_getAppliedInfo($data);
		$this->_getAvailableInfo($data);

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
		parent::display();
	}

	function _getInitialData(&$data)
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
			$cacheColumns = $plgSortInstance->getSortableTableMapping();
			if(empty($cacheColumns))
				$sort = 'userid';
			else {
				foreach($cacheColumns as $c){
					$sort = $c->cacheColumnName;
				}
			}
		}
		/*collect all info */
        $filter = array();
		$filter['published'] = true;
		$allInfo = XiusLibrariesInfo::getInfo($filter,'AND',false);

		$data['allInfo']=$allInfo;
		$data['conditions']=$conditions;
		$data['sortId']=$sortId;
		$data['sort']=$sort;
		$data['dir']=$dir;
		$data['join']=$join;
	}

	function _getUsers(&$data)
	{
		$model =& XiusFactory::getModel('users','site');
		$users =& $model->getUsers($data['conditions'],$data['join'],$data['sort'],$data['dir']);
        $pagination =& $model->getPagination($data['conditions'],$data['join'],$data['sort'],$data['dir']);

        $data['users']= $users;
        $data['pagination']=$pagination;
	}

	function _getTotalUsers(&$data)
	{
		$model =& XiusFactory::getModel('users','site');
		$total =& $model->getTotal($data['conditions'],$data['join'],$data['sort'],$data['dir']);

		$data['total']=$total;
	}

	function _createUserProfile(&$data)
	{
        $userprofile = array();
        $sortableFields = XiusLibrariesUsersearch::getSortableFields($data['allInfo']);

        if(!empty($data['allInfo'])){
        	foreach($data['allInfo'] as $info){

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
        $data['userprofile']=$userprofile;
		$data['sortableFields']= $sortableFields;
	}

	function _getAppliedInfo(&$data)
	{
	//$availableInfo = $allInfo;
        $appliedInfo = array();
        /*convert search param into display data
         * creating applied info ( search parameter )
         */
        if(!empty($data['conditions'])){
        	foreach($data['conditions'] as $c){
        		if(!array_key_exists('infoid',$c))
        			continue;

        		//$plgInstance = XiusFactory::getPluginInstanceFromId($c['infoid']);
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
				$appliedData['label'] = $plgInstance->get('labelName');
				$appliedData['formatvalue'] = $plgInstance->_getFormatAppliedData($c['value']);
				$appliedData['infoid'] = $c['infoid'];
				$appliedData['value'] = $c['value'];

				$appliedInfo[] = $appliedData;
        	}
        }
        $data['appliedInfo']=$appliedInfo;
	}

	function _getAvailableInfo(&$data)
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
				$infohtml['info'] = $ai;
				$infohtml['label'] = $ai->labelName;
				$infohtml['html'] = $inputHtml;
				$infohtml['tooltip'] = $plgInstance->getTooltip();

				array_push($availableInfo,$infohtml);
        	}
        }
        $dispatcher =& JDispatcher::getInstance();
		$dispatcher->trigger( 'onBeforeDisplayAvailableInfo',array( &$availableInfo ));
		
        $data['availableInfo']=$availableInfo;
	}


	function displaySaveOption($msg = '')
	{
		$lModel =& XiusFactory::getModel('list','admin');

		$filter = array();

		$user = JFactory::getUser();

		if(!XiusHelpersUtils::isAdmin($user->id)){
			$filter['published'] = 1;
			$filter['owner'] = $user->id;
		}
		
		$lists = XiusLibrariesList::getLists($filter,'AND',false);

		$selectedListId = JRequest::getVar('listid', 0);

		$this->assign('lists',$lists);
		$this->assign('selectedListId',$selectedListId);
		$this->assign('msg',$msg);
		parent::display();
	}

	function saveListData($selectedListId,$saveas)
	{
		$filter = array();

		$user = JFactory::getUser();

		if(!XiusHelpersUtils::isAdmin($user->id))
			$filter['published'] = 1;

		$lists = XiusLibrariesList::getLists($filter,'AND',false);
				
		//get editor for description of list
		$data['editor']		= & JFactory::getEditor();
		// get required data from session
		$data['conditions'] = XiusLibrariesUsersearch::getDataFromSession(XIUS_CONDITIONS,false);
		$data['sortId'] 	= XiusLibrariesUsersearch::getDataFromSession(XIUS_SORT,false);
		$data['dir'] 		= XiusLibrariesUsersearch::getDataFromSession(XIUS_DIR,'ASC');
		$data['join'] 		= XiusLibrariesUsersearch::getDataFromSession(XIUS_JOIN,'AND');

		// get related data of conditions 
		$conditionHtml = XiusHelperList::formatConditions($data['conditions']);
		
		// if saveas is xiussaveexisting
		$data['listName'] 	= '';
		$data['listDesc'] 	= '';
		$tempParams=array();
		if($saveas === 'xiussaveexisting'){
			$list = XiusLibrariesList::getList($selectedListId);
			$data['listName'] = $list->name;
			$data['listDesc'] = $list->description;
			$tempConfig = new JRegistry('xiuslist');
			$tempConfig->loadINI($list->params);
			$tempParams = $tempConfig->toArray('xiuslist');
		}
		
		// XITODO : if user is admin then ??
		$filter = array();
		$filter['published'] = true;
		$allInfo = XiusLibrariesInfo::getInfo($filter,'AND',false);
		$data['sortableFields'] 	= XiusLibrariesUsersearch::getSortableFields($allInfo);
		$data['sortableFields'][] 	= array('key' => 'userid','value' => 'userid');
		
		
		// triger event for displaying xius privacy html
		$dispatcher =& JDispatcher::getInstance();
		$data['xiusListPrivacy'] = $dispatcher->trigger( 'xiusOnBeforeDisplayListDetails',array($tempParams));
				 
		$this->assign( 'conditionHtml',$conditionHtml);
		$this->assign( 'saveas' , $saveas );
		$this->assign( 'data' , $data );		
		$this->assign('lists',$lists);
		$this->assign('selectedListId',$selectedListId);
		parent::display();
	}

	function _showLists($owner = null)
	{
		/*XITODO : get list according to owner*/
		$lModel =& XiusFactory::getModel('list','admin');

		$filter = array();

		if($owner == null)
			$user = JFactory::getUser();
		else
			$user = JFactory::getUser($owner);

		if(!XiusHelpersUtils::isAdmin($user->id))
			$filter['published'] = 1;

		$lists = $lModel->getLists($filter,'AND',true);
		
		// filter list according to privacy set by joomla
		XiusHelperList::filterListPrivacy(&$lists,$user);
		$pagination =& $lModel->getPagination($filter,'AND');

		$this->assign('lists',$lists);
		$this->assign('pagination', $pagination);

		return parent::display();
	}

	function displayAdvanceSearch()
	{
		parent::display();
	}
}