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
		
		// Get the document object
		$document	=& JFactory::getDocument();

		// Get the view type
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
	
	
}