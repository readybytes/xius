<?php

class XiusJuserTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	

	function testGetAvailableInfoForJsuser()
	{
		/*IMP : Need joomla enviorenment to run test case
		 * it will not run individually ,
		 * b'coz joomla file system does not load
		 */
		require_once  XIUS_PLUGINS_PATH. DS . 'jsuser' . DS . 'jsuser.php';
		$instance = new Jsuser();
		
		$info = $instance->getAvailableInfo();
		
		if(!$instance->isAllRequirementSatisfy())
			$this->assertFalse($info);
		else {
		
			$requiredInfo = array();
			
			
			$requiredInfo['userid']			= JText::_('Userid');
    		$requiredInfo['status']			= JText::_('status');
		    $requiredInfo['status_access']	= JText::_('status_access');
		    $requiredInfo['points']			= JText::_('points');
		    $requiredInfo['posted_on']		= JText::_('posted_on');
		    $requiredInfo['avatar']			= JText::_('avatar');
		    $requiredInfo['thumb']			= JText::_('thumb');
		    $requiredInfo['invite']			= JText::_('invite');
		    $requiredInfo['params']			= JText::_('params');
		    $requiredInfo['view']			= JText::_('view');
		    $requiredInfo['friends']		= JText::_('Friends');
		    $requiredInfo['groups']			= JText::_('groups');
		    $requiredInfo['friendcount']	= JText::_('friendcount');
		    $requiredInfo['alias']			= JText::_('alias');
		    $requiredInfo['latitude']		= JText::_('Latitude');
		    $requiredInfo['longitude']		= JText::_('Longitude');
		    $requiredInfo['profile_id']		= JText::_('profile_id');
		    $requiredInfo['storage']		= JText::_('storage');
		    $requiredInfo['watermark_hash']	= JText::_('watermark_hash');
		    $requiredInfo['search_email']	= JText::_('search_email');

			$this->assertEquals($requiredInfo,$info);
		}
	}

	
	
	function testViewSearchHtml()
	{
		require_once  XIUS_PLUGINS_PATH. DS . 'jsuser' . DS . 'jsuser.php';
		$instance = new Jsuser();
		require_once  XIUS_PLUGINS_PATH. DS . 'jsuser' . DS . 'views' . DS . 'view.html.php';
		$instance->load(1);
		$viewClass = new JsuserView();
		$searchHtml5 =  $viewClass->searchHtml($instance);
		$result5 = '<inputclass="inputbox"type="text"name="Jsuser_1"id="Jsuser_1"value=""/>';
		$this->assertEquals($this->cleanWhiteSpaces($result5),$this->cleanWhiteSpaces($searchHtml5)); 
		
		$instance->load(2);
		$searchHtml4 =  $viewClass->searchHtml($instance);
		
		$result4 = '<inputclass="inputbox"type="text"name="Jsuser_2"id="Jsuser_2"value=""/>';
		$this->assertEquals($this->cleanWhiteSpaces($result4),$this->cleanWhiteSpaces($searchHtml4));
	}
	
	
	function testGetTableMapping()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusJuserTest/testViewSearchHtml.start.sql');
		$instance = new Jsuser();
		$instance->load(2);
		$mapping = $instance->getTableMapping();
		
		$tableInfo					= array();
		$count = 0;
		 
		$object	= new stdClass();
		$object->tableName			= '`#__community_users`';
		$object->tableAliasName 	= "communityusersstatus_0";
		$object->originColumnName	= 'status';
		$object->cacheColumnName	= 'jsuserstatus_0';
		$object->cacheSqlSpec 		= 'varchar(250) NOT NULL';
		$object->cacheLabelName		= 'status';
		$object->createCacheColumn	= true;
		$tableInfo[]=$object;
		
		$this->assertEquals($mapping, $tableInfo);
		
		$instance->load(1);
		$mapping = $instance->getTableMapping();
		
		$tableInfo					= array();
		$count = 0;
		 
		$object	= new stdClass();
		$object->tableName			= '`#__community_users`';
		$object->tableAliasName 	= "communityusersuserid_0";
		$object->originColumnName	= 'userid';
		$object->cacheColumnName	= 'jsuseruserid_0';
		$object->cacheSqlSpec 		= 'int(21) NOT NULL';
		$object->cacheLabelName		= 'userid';
		$object->createCacheColumn	= true;
		$tableInfo[]=$object;
		
		$this->assertEquals($mapping, $tableInfo);
	}
}
?>
