<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
if(!defined('_JEXEC')) die('Restricted access');

require_once(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'base'.DS.'route.php');
require_once(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'base'.DS.'text.php');
require_once  JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'includes.php';
require_once  JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php';

function com_install()
{
	/*if(installPlugin() == false){
		JError::raiseError('INSTERR', XiusText::_("NOT ABLE TO INSTALL PLUGINS"));
		return false;
	}*/
	// Set Warning for removing older XiUS Version
	$adminPath = JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius';
	$siteFolder= Array('helper','libraries','models','tabels','elements','assets');
	foreach($siteFolder as $folder){
		if(JFolder::exists($adminPath.DS.$folder)){
			JError::raiseWarning("","You are Upgrading Your XiUS Package (Older to XIUS 2.6). 
										So Please,Properly Remove XiUS 2.5.xxx or lower-version.
										'Any One' or 'All'(helper,libraries,models,tabels,elements,assets) folder exists
										in Back-end");
			
			break;
		}
	}
	
	if(installExtensions() == false){
		JError::raiseError('INSTERR', XiusText::_("NOT_ABLE_TO_INSTALL_EXTENSIONS"));
		return false;
	}
	
	
	changePluginState('xius_system',true);
	changePluginState('xius',true);
	changePluginState('js_privacy',true);
	//changePluginState('xipt_privacy',true);
	//check if migration is required
	if(xiusMigration::isMigrationRequired()){
		xiusMigration::doMigration();
	}
	return true;
}	

function installExtensions($extPath=null)
{
	//if no path defined, use default path
	if($extPath==null)
		$extPath = dirname(__FILE__).DS.'extensions';

	if(!JFolder::exists($extPath))
		return false;
	
	$extensions	= JFolder::folders($extPath);
	
	//no apps there to install
	if(empty($extensions))
		return true;

	//get instance of installer
	$installer =  new JInstaller();
	$installer->setOverwrite(true);

	//install all apps
	foreach ($extensions as $ext)
	{
		$msg = "Supportive Plugin/Module $ext Installed Successfully";

		// Install the packages
		if($installer->install($extPath.DS.$ext)==false)
			$msg = "Supportive Plugin/Module $ext Installation Failed";

		//enque the message
		JFactory::getApplication()->enqueueMessage($msg);
	}

	return true;
}	
		
	
function changePluginState($pluginname, $action=1)
{
	  	$version = new JVersion();
		$db		=& JFactory::getDBO();
		
		if ($version->RELEASE == '1.5'){
			$query	= 'UPDATE ' . $db->nameQuote( '#__plugins' )
					. ' SET '.$db->nameQuote('published').'='.$db->Quote($action)
			  		.' WHERE '. $db->nameQuote('element').'='.$db->Quote($pluginname);
		}
                else{
			$query	= 'UPDATE ' . $db->nameQuote( '#__extensions' )
					. ' SET '.$db->nameQuote('enabled').'='.$db->Quote($action)
					.' WHERE '. $db->nameQuote('element').'='.$db->Quote($pluginname) . "  AND `type`='plugin' ";
		}
	
	$db->setQuery($query);		
	
	if(!$db->query())
		return false;
		
	return true;
}

class xiusMigration
{
	function isMigrationRequired(){
		//if xius_config table is not present it means xius has never been installed
		//and migration is not required
		if(self::_isTableExist('xius_config')){
			$db = JFactory::getDBO();
			$query = 'SELECT * FROM `#__xius_config`';
			$db->setQuery($query);
			$results = $db->loadObjectList();
			//if version row is not present then migration is required.
			foreach ($results as $result){
				if($result->name == 'version')
					return false;
			}
			return true;
		}
		return false;
	}
	
	//check whether the given table exists or not
    function _isTableExist($tableName)
	{
        $database   = JFactory::getDBO();
	    $query 	= "SHOW TABLES LIKE '%".$tableName."%'";
        $database->setQuery($query);
        $result 	= $database->loadResultArray();
        if(!empty($result)) return true;
        return false;
	}
	
	function doMigration()
	{
		self::migrationInConfig();
		self::migrationInInfoParams();
		self::migrationInListParams();
		
	}
	
	function migrationInConfig()
	{
		//add a version in xius_config table
		$db 	  = JFactory::getDBO();
		$sqlquery = "INSERT INTO `#__xius_config`(`name`,`params`) 
			              	            VALUES ('version','3.1.483')";	
        $db->setQuery($sqlquery);
        $db->query();
        //change 'xiusListCreator' param from usergroup's name to usergroup's id
        $cModel			 = XiusFactory::getInstance ('configuration' , 'model');
        $params          = $cModel->getParams();
        $params          = $params->toArray();
        $xiusListCreator = unserialize($params['xiusListCreator']);
        require_once XIUS_PATH_SITE_HELPER.DS.'users.php';
        foreach ($xiusListCreator as $key=>$value){
        	 if($value == 'All')
        	 		continue;
        	 else
        			$xiusListCreator[$key] = self::convertInGroupId($value); 
            
         $params['xiusListCreator']	= $xiusListCreator;
         XiusModelConfiguration::save('config',$params);
        }
        return true;
      }
      
      function migrationInInfoParams()
      {
         $iModel	= XiusFactory::getInstance ( 'info','model' );
      	 $allInfo   = $iModel->getAllInfo();
      	 $instance  = new XiusFactory();
       	 foreach ($allInfo as $info){
      	 	$param  	= $instance->getPluginInstance('',$info->id)->get('params');
      	 	$paramArray = $param->toArray();
      	 	$isacc  	= unserialize($paramArray['isAccessible']);
        	foreach($isacc as $key=>$value){
            	if($value == 'All')
        	    	continue;
        	    else
      	 	    	$isacc[$key] = self::convertInGroupId($value);
        	}
            $paramArray['isAccessible'] = serialize($isacc);
            $param->bind($paramArray);
      	 	$info->params = $param->tostring('INI');
      	 	
      	 	//if plugintype is forcesearch then add a pluginparam 'operatorType' and
      	 	// update 'value' from usergroup's name to usergroup's id 
      	 	//in case of usertype and profiletype 
      	 	if($info->pluginType == 'Forcesearch'){
      	 		$_params      = $instance->getPluginInstance('',$info->id)->get('pluginParams');	
            	$pluginParams = $_params->toArray();
            	$parentInfo   = XiusModelInfo::getInfo($info->key);
            //for profiletype info
            	if($parentInfo->pluginType == 'Jsfields'){
       	        	$filter 	  = array();
		    		$filter['id'] = $parentInfo->key;
		    		$fieldInfo    = Jsfieldshelper::getJomsocialFields($filter);
           		 }
            	if($parentInfo->key == 'usertype' || (isset($fieldInfo) && $fieldInfo[0]->type == 'profiletypes')){
      	 				$temp    = array();
            			$temp[]  = self::convertInGroupId(
      	 			                         unserialize($pluginParams['value']));
      	 				$pluginParams['value']     = serialize($temp);
             	} 
             $pluginParams['operatorType'] = 'LIKE';
      	 	 $_params->bind($pluginParams);  
		     $info->pluginParams = $_params->toString('INI');
      	 	}
      	 	$iModel->save((array)$info);
      	 }
      	 return true;
      }
      
      //function to change groupname to groupid
      function convertInGroupId($value)
      {
      	$groups    = XiusHelperUsers::getJoomlaGroups();
      	foreach ($groups as $group){
      		if($value == $group->{XIUS_JOOMLA_GROUP_VALUE})
      		  return $value = $group->id;
      	}
      	return $value;
      }
      
      function migrationInListParams()
      {
      	$parameter  = new XiusParameter();
      	$lModel    	= XiusFactory::getInstance ('list', 'model');	
		$lists 	    = $lModel->getLists();
		//change param 'xiusListViewGroup' from groupname to groupid
		foreach ($lists as $list){
			$parameter->loadINI($list->params);
			$ListParams = $parameter->toArray();
			$listView 	= unserialize($ListParams['xiusListViewGroup']);
			foreach ($listView as $key=>$value)
			 	$listView[$key] = self::convertInGroupId($value);
			 	
			$ListParams['xiusListViewGroup'] = serialize($listView);
			$parameter->loadArray($ListParams);
			$list->params = $parameter->toString('INI');
			$lModel->save((array)$list);
		}
		return true;
      }
}


