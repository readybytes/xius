<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
jimport( 'joomla.plugin.plugin' );
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'))
	return;
	
class plgSearchxius extends JPlugin
{
    function plgSearchxius(&$subject, $params)
	{
		parent::__construct( $subject, $params );
	}
	
   //function to return an array of search areas.
   function onSearchAreas() 
   {
	 static $areas = array();
	 if (empty($areas)) {
		$areas['xius'] = "User";
	 }
	 return $areas;
   }
	
	function onSearch($text, $phrase = '', $ordering = '', $areas = null)
	{
		//if xius area is not selected then return 
	    if (is_array ( $areas )) {
		  if (! array_intersect ( $areas, array_keys ( plgSearchxius::onSearchAreas() ) )) {
			return array ();
		 }
	    }
	    // XiTODO:: Try to Auto load
		require_once JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php';
		require_once JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'keyword'.DS.'keyword.php';
		require_once JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'models'.DS.'users.php';
		
		$filter['pluginType']="'Keyword'";
        $model = XiusFactory::getInstance('info','model');
        $info  = $model->getallinfo($filter,'AND',false);
        
        //if keyword info is not exist then return 
        if(empty($info))
        {
        	return array();
        }
        
        //set search condition in session
		$conditions = array(array());
		$conditions[0]['infoid']   = $info[0]->id;
		$conditions[0]['value']    = $text;
		$conditions[0]['operator'] = '=';
		XiusLibUsersearch::setDataInSession(XIUS_CONDITIONS,$conditions,'XIUS');

		//get search results
		$data = array(array());
		XiusHelperResults::_getInitialData($data);
		XiusHelperResults::_getUsers($data);
		XiusHelperResults::_createUserProfile($data);
		$users = XiusHelperProfile::getUserProfileData($data['users']);
		
		//Ignore Css and Js that may affect the result
		$doc = JFactory::getDocument();
		$css = $doc->get('_styleSheets');
		$js = $doc->get('_scripts');
		$path = JFactory::getURI()->base();
		$config	= CFactory::getConfig();
		$newCss = array();
		$newJs = array();
	    foreach ($js as $key=>$value)
		{  
			if( !JString::stristr( $key ,"$path"."components/com_community/assets/friends-1.0.js") &&
			    !JString::stristr( $key , "$path"."components/com_community/assets/window-1.0.js"))
				 $newJs[$key] = $value;
		}
		
		foreach ($css as $key=>$value)
		{   
			if( !JString::stristr($key , "$path"."components/com_community/assets/window.css") && 
			    !JString::stristr($key , "$path"."components/com_community/templates/".$config->get('template')."/css/style.css"))
				 $newCss[$key] = $value ;
		}
		//set new Css and Js
		$doc->set("_styleSheets", $newCss);
		$doc->set("_scripts" , $newJs);
		
		//set parameters that are essential for joomla search result 
		$i = 0;
		$results = array();
		foreach ($users as $user)
		{
			$results[$i]->href    	 = $user->profileLink;
			$results[$i]->section	 = "";
			$results[$i]->title    	 = $user->name;
			$results[$i]->browsernav = 1;
			$results[$i]->created    = "";
			$results[$i]->text 		 = self::setText($user,$text,$data['userprofile']);
			$i++;
		}
		return $results;
	}

	//set text that will be shown in the final result
	function setText($user,$searchWord,$userprofile)
	{
		 if(!empty($userprofile))
		   {  $value = null;
		     //checking for each user that in which information the searchWord is found
		      foreach($userprofile[$user->id] as $up)	
			 	 for($i =0 ; $i< count($up['value']); $i++ ){ 
				  	if(JString::stristr((string)$up['value'][$i],$searchWord))
				  	   $value.= $up['label'][$i].":".$up['value'][$i]."\n\n";
				  }
				return $value;
		    }
	} 
 }
