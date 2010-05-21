<?php

class ScreenshotTest extends XiSelTestCase 
{ 
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function setUp()
  {    
	$filter['debug']=0;
    $filter['error_reporting']=6143;
    $this->updateJoomlaConfig($filter);
  }
  
 function captureScreen($fileName)
 {
 	$fileName = dirname(__FILE__).DS."screenshots".DS.$fileName . '.png';
 	$this->drivers[0]->captureEntirePageScreenshot($fileName);
 }
 

 function testScreenshot()
 {
 	$this->importDatabase();
 	$this->installTemplates();
 }
 
 function importDatabase()
 {
 	$url= dirname(__FILE__). '/com/site/_data';
  	$this->_DBO->loadSql($url.DS.'insert.sql');
  	$this->_DBO->loadSql($url.DS.'updateCache.sql');
 }
 
 function installTemplates()
 {
 	$templatePath= dirname(__FILE__).DS.__CLASS__.DS.'templates';
 	
 	// collect all files
 	
 	// install these one by one
 	
 	//return all installed templates
 }
 
 function selectTemplate()
 {}
 
 function takeScreenshots($template)
 {    
 	
    //go to page and take screenshot
    $this->open(JOOMLA_LOCATION."/index.php?option=com_xius");
    $this->waitPageLoad();
    $this->captureScreen("searchPanelFirefox");
    
    //go to page and take screenshot
    $this->open(JOOMLA_LOCATION."/index.php?option=com_xius&view=users&suplytask=displayresult");
    $this->waitPageLoad();
    $this->captureScreen("resultPanelFirefox");  
 }  
  
 function installTemplate($extPath=null)
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
   
}
