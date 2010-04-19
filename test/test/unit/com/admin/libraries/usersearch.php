<?php

class XiusUserSearchTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	function testGetMiniProfileDisplayFields()
	{
		$value = XiusLibrariesUserSearch::getMiniProfileDisplayFields(64,'#__xius_cache');
		print_r(var_export($value));
	}
	
	function testBuildQuery()
	{
		/*XITODO : Test case is not complete , apply some assertion */
		$params1 = array();
		$params1[1] = 'Male';
		//$params1[3] = 'India';//city
		$params1[7] = array('Checkbox1','Checkbox11');//city
		$query = XiusLibrariesUserSearch::buildQuery($params1);
		echo $query;
	}
	
	
	public static function searchParamProvider()
	{
		$params1 = array();
		$params1[1] = 'Male';
		//$params1[3] = 'India';//city
		$params1[7] = array('Checkbox1','Checkbox11');//city
		return array(
			array($params1)
		);
	}
	
	
	function testCreateTableQuery()
	{
		$db = JFactory::getDBO();
		
		/*XITODO : Test case is not complete , apply some assertion */
		$query = XiusLibrariesUserSearch::createTableQuery();
		$db->setQuery($query);
		$db->query();
		echo $query;
	}
	
	function testBuildInsertUserdataQuery()
	{
		/*XITODO : Test case is not complete , apply some assertion */
		
		$query = XiusLibrariesUserSearch::buildInsertUserdataQuery();
		echo $query;
	}
	
	
	function testInsertUserData()
	{
		/*XITODO : Test case is not complete , apply some assertion */
		$db = JFactory::getDBO();
		
		$query = XiusLibrariesUserSearch::createTableQuery();
		$db->setQuery($query);
		//echo $query;
		if(!$db->query())
			echo $db->getErrorMsg();
		
		$collectUserDataQuery = XiusLibrariesUserSearch::buildInsertUserdataQuery();
		
		$isSuccess = XiusLibrariesUserSearch::insertUserData($collectUserDataQuery);
		
		
	}
	
}
?>
