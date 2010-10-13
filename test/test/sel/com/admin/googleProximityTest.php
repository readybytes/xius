<?php

class XiusProximityAdminSelTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testGoogleProximityBeforeCacheUpdate()
	{
		//Enable xipt_privacy plugin
 		$this->changePluginState('xipt_privacy',true);
		
		$this->_DBO->loadSql(dirname(__FILE__).'/../site/_proximityData/insert.sql');
		$db= & JFactory::getDBO();
		$sql = "DROP TABLE IF EXISTS `#__xius_proximity_geocode` ";
		$db->setQuery($sql);
		$db->query();
		
		$this->adminLogin();
		$this->open(JOOMLA_LOCATION.'/administrator/index.php?option=com_xius&view=info');
		$this->waitPageLoad();
        $this->click("link=Create Information");
    	$this->waitPageLoad();
    	$this->select("plugin", "label=Proximity Search");
    	$this->click("infonext");
    	$this->waitPageLoad();
    	$this->select("rawdata", "label=By Google API");
    	$this->click("infonext");
    	$this->waitPageLoad();
    	$this->select("pluginParams[xius_proximity_country]", "label=Country");
    	$this->select("pluginParams[xius_proximity_city]", "label=City / Town");
    	$this->select("pluginParams[xius_proximity_state]", "label=State");
    	$this->click("link=Save");
    	$this->waitPageLoad();

    	$this->_DBO->addTable('#__xius_info');
    	$this->_DBO->addTable('#__xius_proximity_geocode');  
    	$this->_DBO->filterOrder('#__xius_info','id');  	
    	
    	//Disable xipt_privacy plugin
 		$this->changePluginState('xipt_privacy',false);
	}
	
	
	
}
