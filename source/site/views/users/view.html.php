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
		
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('Search Panel'));
		
		$this->assign( 'infohtml' , $infohtml );
		return parent::display();
	}
	

	function displayResult($from,$list='')
	{
		$data	  = $this->_displayResult($from,$list='');
		$document = JFactory::getDocument();
        if(!empty($data['list']) && !empty($data['list']->name))
			$document->setTitle(JText::_($data['list']->name));
		else
			$document->setTitle(JText::_('Search Result'));
        
		$this->assignRef('users', $data['users']);
		$this->assignRef('userprofile', $data['userprofile']);
		$this->assignRef('sortableFields', $data['sortableFields']);
		$this->assignRef('pagination', $data['pagination']);
		$this->assign('total', $data['total']);
		$this->assign('appliedInfo', $data['appliedInfo']);
		$this->assign('availableInfo', $data['availableInfo']);

		$this->assign('sort', $data['sortId']);
		$this->assign('dir', $data['dir']);
		$this->assign('join', $data['join']);
		
		$this->assign('list', $data['list']);
		
		$this->assign('task', $data['from']);
		//$this->assign('subtask', $subtask);
		parent::display();
	}
	
	function _displayResult($from,$list='')
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
        $pagination =& $model->getPagination($conditions,$join,$sort,$dir);
        $total =& $model->getTotal($conditions,$join,$sort,$dir);
        
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
        			
				//$plgInstance = XiusFactory::getPluginInstance($info->id);
				$plgInstance = XiusFactory::getPluginInstance($info->pluginType);
				if(!$plgInstance)
					continue;
					
				$plgInstance->bind($info);

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
        			
        		//$plgInstance = XiusFactory::getPluginInstanceFromId($c['infoid']);
        		$plgInstance = false;
        		if(!empty($allInfo)){
        			foreach($allInfo as $info){
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
			
				$appliedData = array();
				$appliedData['label'] = $plgInstance->get('labelName');
				$appliedData['formatvalue'] = $plgInstance->_getFormatData($c['value']);
				$appliedData['infoid'] = $c['infoid'];
				$appliedData['value'] = $c['value'];
				
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
				
				array_push($availableInfo,$infohtml);
        	}
        }
                
		$data['users']= $users;
		$data['userprofile']=$userprofile;
		$data['sortableFields']= $sortableFields;
		$data['pagination']=$pagination;
		$data['total']=$total;
		$data['appliedInfo']=$appliedInfo;
		$data['availableInfo']=$availableInfo;

		$data['sortId']=$sortId;
		$data['dir']=$dir;
		$data['join']=$join;
		
		$data['list']=$list;
		
		$data['from']=$from;
		//$this->assign('subtask', $subtask);
		return $data;
	}
	
	
	function displaySaveOption($msg = '')
	{
		$lModel =& XiusFactory::getModel('list','admin');
		
		$filter = array();
					
		$user = JFactory::getUser();
		
		if(!XiusHelpersUtils::isAdmin($user->id))
			$filter['published'] = 1;

		$lists = $lModel->getLists($filter,'AND',false);
		
		$selectedListId = JRequest::getVar('listid', 0);
		
		$this->assign('lists',$lists);
		$this->assign('selectedListId',$selectedListId);
		$this->assign('msg',$msg);
		parent::display();
	}
	
	
	function success($data)
	{		
		$this->assign('data',$data);
		
		/*$document->addScriptDeclaration("
		window.addEvent('domready', function() {
			document.preview = SqueezeBox;
		});");*/
 		/*$resizeJs = "SqueezeBox.resize({size:{x: 200, y: 100}});";
 		$document->addScriptDeclaration($resizeJs); */

		$document = JFactory::getDocument();
		$js = "window.setTimeout(\"window.parent.location.href = '".$data['url']."';parent.SqueezeBox.close()\", 1000);";
 		$document->addScriptDeclaration($js); 

		parent::display();
	}
	
	
	function _showLists($fromTask,$owner)
	{
		/*XITODO : get list according to owner*/
		$lModel =& XiusFactory::getModel('list','admin');
		
		$filter = array();
					
		$user = JFactory::getUser();
		
		if(!XiusHelpersUtils::isAdmin($user->id))
			$filter['published'] = 1;

		$lists = $lModel->getLists($filter,'AND',true);
		$pagination =& $lModel->getPagination($filter,'AND');
		
		$this->assign('lists',$lists);
		$this->assign('pagination', $pagination);
		
		return parent::display();
	}
}	

?>