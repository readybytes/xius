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
		 */
		$filter = array();
		$filter['published'] = true;
		$allInfo = XiusLibrariesInfo::getInfo($filter,'AND',true,0,5);
		
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
	
}