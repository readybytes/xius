<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class XiusControllerSearch extends JController
{
	
	function display()
	{
		$this->showsearchpanel();
	}
	
	
	
	function showsearchpanel()
	{
		/*XITODO : Add icon for mailing , printing ,and pdf document
		 * for pdf :- &format=pdf&tmpl=component use it
		 * for print :- &print=1&tmpl=component
		 */
		/*XITODO : Collect all info here
		 * ask admin , how many no's of info
		 * he want's to display at a time , and add more links.
		 * never assume anything
		 * show only searchable information
		 * for admin non-published info should be visible
		 */
		$filter = array();
		$filter['published'] = true;
		
		$count = XiusHelpersUtils::getDisplayInformationCount();
		
		if($count === XIUS_ALL || $count === 0)
			$allInfo = XiusLibrariesInfo::getInfo($filter,'AND',false);
		else
			$allInfo = XiusLibrariesInfo::getInfo($filter,'AND',true,0,$count);
		
		$viewName	= JRequest::getCmd( 'view' , 'search' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		$layout		= JRequest::getCmd( 'layout' , 'searchpanel' );
		$view->setLayout( $layout );

		/*XITODO : pass only searchable information 
		 * Trigger event before displaying search 
		 */
		echo $view->showsearchpanel($allInfo);
		
	}
	
	function basicsearch()
	{
		/*XITODO : collect join parameter
		 * and set in session
		 */
		if(JRequest::getVar('xiusdelinfo', '', 'POST') != ''){
			$params = XiusLibrariesUsersearch::getDataFromSession('searchdata',false);
			$delInfoId = JRequest::getVar('xiusdelinfo', 0, 'POST');
			if($delInfoId){
				if(!empty($params)){
		        	foreach($params as $key => $p){
		        		if(!array_key_exists('infoid',$p))
		        			continue;
		        			
		        		if($p['infoid'] == $delInfoId)
		        			unset($params[$key]);
		        	}
		        }
			}
			XiusLibrariesUsersearch::setDataInSession('searchdata',$params,'XIUS');
		}
		
		if(JRequest::getVar('xiussort', '', 'POST') != ''){
			$sort = JRequest::getVar('xiussort', 'userid', 'POST');
			$dir = JRequest::getVar('xiussortdir', 'ASC', 'POST');
			
			XiusLibrariesUsersearch::setDataInSession('sort',$sort,'XIUS');
			XiusLibrariesUsersearch::setDataInSession('dir',$dir,'XIUS');
		}
		if(JRequest::getVar('xiussearch', '', 'POST') != ''){
			$searchdata = array();
			$infoid = 0;
			$count = 0;
			$post = JRequest::get('POST');
			foreach($post as $key => $value){
				if(JString::stristr($key,'xiusinfo_')){
					if($infoid && $infoid == $value)
						$infoid = 0;
					else
						$infoid = $value;
					
					continue;
				}
				
				if(empty($value))
					continue;
				
				if($infoid){
					$searchdata[$count]['infoid'] = $infoid;
					$searchdata[$count]['value'] = $value;
					$searchdata[$count]['operator'] = XIUS_EQUAL;
					$count++;
				}
	
			}	
	
			XiusLibrariesUsersearch::setDataInSession('searchdata',$searchdata,'XIUS');
		}
	
		$viewName	= JRequest::getCmd( 'view' , 'search' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		$layout		= JRequest::getCmd( 'layout' , 'basicsearch' );
		$view->setLayout( $layout );
		
        $view->basicsearch();
	}
	
	
	
	function showLists()
	{
		$listId = JRequest::getVar('listid', 0);
		
		$viewName	= JRequest::getCmd( 'view' , 'list' );
		$document	=& JFactory::getDocument();
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		
		if($listId){
			$layout		= JRequest::getCmd( 'layout' , 'basicsearch' );

			/*get list */
			$lModel =& XiusFactory::getModel('list','admin');
			$list = $lModel->getList($listId);
			
			$url = JRoute::_('index.php?option=com_xius&view=search&task=showLists',false);
			if(empty($list))
				$mainframe->redirect($url,JText::_('INVALID LIST ID'),false);
				
			/*set data in session*/
			$listInfo = array();
			$listInfo[$listId]['sort']			= $list->sortinfo;
			$listInfo[$listId]['dir']			= $list->sortdir;
			$listInfo[$listId]['join']			= $list->join;
			$listInfo[$listId]['searchdata']	= unserialize($list->conditions);
			
			XiusLibrariesUsersearch::setDataInSession('listid',$listId,'XIUS');
			XiusLibrariesUsersearch::setDataInSession('sort',$list->sortinfo,'XIUS');	
			XiusLibrariesUsersearch::setDataInSession('dir',$list->sortdir,'XIUS');
			XiusLibrariesUsersearch::setDataInSession('join',$list->join,'XIUS');
			XiusLibrariesUsersearch::setDataInSession('searchdata',unserialize($list->conditions),'XIUS');
			
			$params = $listInfo[$listId]['searchdata'];
			$join = $list->join;
			$sortInfo = array();
			$sortInfo['sort']	=	$list->sortinfo;
			$sortInfo['dir']	=	$list->sortdir;
			
			$view->setLayout( $layout );
			$view->showusers($params,$sortInfo,$join,$listId);
		}
		else{
			$layout		= JRequest::getCmd( 'layout' , 'lists' );
			$view->setLayout( $layout );
			$view->showLists($listId);
		}
		
	}
	
	
	
	function saveList()
	{
		global $mainframe;
		$user =& JFactory::getUser();
		
		/* Check for admin only admin can save list	 */
		if(!XiusHelpersUtils::isAdmin($user->id)){
			$url = JRoute::_("index.php?option=com_xius&view=search&task=basicsearch",false);
			$mainframe->redirect($url,JText::_('YOU CAN NOT SAVE LIST'),false);
		}
		
		$searchdata = XiusLibrariesUsersearch::getDataFromSession('searchdata',false);
		/*if(!$searchdata){
			$url = JRoute::_("index.php?option=com_xius&view=search&task=display",false);
			$mainframe->redirect($url,JText::_('PLEASE SELECT ANY CRITERIA'),false);
		}*/

		$listid		= XiusLibrariesUsersearch::getDataFromSession('listid',0);//JRequest::getCmd( 'listid' ,0 );
		/*XITODO : set visible info and published also */
		$data = array();
		
		$data['id'] = $listid;//0;
		$data['join'] = XiusLibrariesUsersearch::getDataFromSession('join','AND');
		$data['sortinfo'] = XiusLibrariesUsersearch::getDataFromSession('sort','userid');
		$data['sortdir'] = XiusLibrariesUsersearch::getDataFromSession('dir','ASC');
		$data['owner'] = $user->id;
		$data['conditions'] = serialize($searchdata);
		$data['searchdata'] = serialize($searchdata);
		
		if(!XiusLibrariesList::saveList($data))
			$msg = JText::_('ERROR IN SAVE LIST');
		else
			$msg = JText::_('LIST SAVED SUCCESSFULLY');

		$url = JRoute::_("index.php?option=com_xius&view=search&task=display",false);
		$mainframe->redirect($url,$msg,false);
	}
}
