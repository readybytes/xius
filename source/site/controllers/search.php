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
		
		if(JRequest::getVar('search', '', 'POST') != ''){
			$searchdata = array();
			$infoid = 0;
			$count = 0;
			$post = JRequest::get('POST');
			foreach($post as $key => $value){
				if(JString::stristr($key,'info_')){
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
	
			$mySess =& JFactory::getSession();
			$mySess->set('searchdata',$searchdata,'XIUS');
		}
	
		$viewName	= JRequest::getCmd( 'view' , 'search' );
		// Get the document object
		$document	=& JFactory::getDocument();

		// Get the view type
		$viewType	= $document->getType();
		$view		=& $this->getView( $viewName , $viewType );
		$layout		= JRequest::getCmd( 'layout' , 'basicsearch' );
		$view->setLayout( $layout );
		
        $view->basicsearch();
	}
	
	
}