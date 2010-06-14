<?php

class ScreenshotTest extends XiSelTestCase 
{ 
  function getSqlPath()
  {
      return dirname(__FILE__).'/sql/'.__CLASS__;
  }
  
  function setUp()
  {    
  	parent::setUp();
	$filter['debug']=0;
    $filter['error_reporting']=6143;
    $filter['list_limit']=10;
    $this->updateJoomlaConfig($filter);
  }
  
 function captureScreen($fileName)
 {
 	$this->windowMaximize();
 	$this->windowFocus();
 	sleep(1);
 	$fileName = dirname(__FILE__).DS.__CLASS__.DS."screenshots".DS.$fileName . '.png';
 	$this->drivers[0]->captureEntirePageScreenshotAndWait($fileName);
 }
 

 function testScreenshot()
 {
 	$this->importDatabase();
 	$this->adminLogin();
 	$templates = $this->installTemplates();
 	$templates[]= 'ja_purity';
 	$templates[]= 'rhuk_milkyway';
 	
 	foreach($templates as $t)
 	{
 		$this->selectTemplate($t);
 		$this->takeScreenshots($t);
 	}
 }
 
 function importDatabase()
 {
 	$url= dirname(__FILE__). '/com/site/_data';
  	$this->_DBO->loadSql($url.DS.'insert.sql');
  	$this->_DBO->loadSql($url.DS.'updateCache.sql');
 }
 
 function installTemplates()
 {
 	$templatePath=$_ENV['HOME']."/Dropbox/Joomla/templates";
 	$retTemplates = array();
 
	if(!JFolder::exists($templatePath))
		return $retTemplates ;
	
	$templates = JFolder::files($templatePath);//array('rt_nexus_j15.tgz'); //
	
	foreach ($templates as $ext)
	{ 
		$this->open(JOOMLA_LOCATION."/administrator/index.php?option=com_installer");
		$this->type("install_package", $templatePath.DS.$ext);
  		$this->click("//input[@value='Upload File & Install']");
  		$this->waitPageLoad();
  		$retTemplates[]=JFile::stripExt($ext);
	}
	return $retTemplates;
 }
 
 function selectTemplate($template)
 {
 		$this->open(JOOMLA_LOCATION."administrator/index.php?option=com_templates");
 		$order= $this->getTemplateOrder($template);
		$this->click("cb$order");
		$this->click("link=Default");
  		$this->waitPageLoad();
 }
 
 function takeScreenshots($template)
 {    
    //go to page and take screenshot
    $this->open(JOOMLA_LOCATION."/index.php?option=com_xius");
    $this->waitPageLoad();
    $this->captureScreen(JString::strtolower($template)."_searchPanel");
    
    $this->select("field2", "label=Male");
  //	$this->select("field12", "label=Afghanistan");
  	$this->click("//input[@name='xius_join' and @value='OR']");
  	$this->click("xiussearch");
  	$this->waitPageLoad();
  	$this->captureScreen(JString::strtolower($template)."_result");
  	
  	$this->open(JOOMLA_LOCATION."/index.php?option=com_xius&view=users&layout=lists&task=displayList&Itemid=60");
  	$this->captureScreen(JString::strtolower($template)."_userList");

  	$this->frontLogin();
  	
  	$this->open(JOOMLA_LOCATION."/index.php?option=com_xius");
    $this->waitPageLoad();
   	$this->select("field2", "label=Male");
  //	$this->select("field12", "label=Afghanistan");
  	$this->click("//input[@name='xius_join' and @value='OR']");
  	$this->click("xiussearch");
  	$this->waitPageLoad();
  	$this->click("//img[@title='Save']");
  	$this->captureScreen(JString::strtolower($template)."_saveOption");
	$this->frontLogout();
 }  
 
function getTemplateOrder($template)
  {
  	// Import file dependencies
	require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_templates'.DS.'helpers'.DS.'template.php');

	$rows = array();
	$tBaseDir = JPATH_SITE.DS.'templates';
	$rows = TemplatesHelper::parseXMLTemplateFiles($tBaseDir);

  	for($i = 0; $i < count($rows); $i++)  {
  		//echo "Matching template given $template comapring to {$rows[$i]->directory} \n";
		if($rows[$i]->directory == $template)
			return $i;
  }
	return -1;
  }
}
