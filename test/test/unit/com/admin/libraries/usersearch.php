<?php

class XiusUserSearchTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	/**
	 * @dataProvider searchParamProvider
	 */
	function testBuildQuery($params)
	{
		/*XITODO : Test case is not complete , apply some assertion */
		$query = XiusLibrariesUserSearch::buildQuery($params);
		echo $query;
	}
	
	
	public static function searchParamProvider()
	{
		$params1 = array();
		$params1[1] = 'Male';
		$params1[2] = 'Bhilwara';//city
		return array(
			array($params1)
		);
	}
	
	
	function testCreateTableQuery()
	{
		/*XITODO : Test case is not complete , apply some assertion */
		$query = XiusLibrariesUserSearch::createTableQuery();
		echo $query;
	}
	
	function testBuildInsertUserdataQuery()
	{
		/*XITODO : Test case is not complete , apply some assertion */
		$query = XiusLibrariesUserSearch::buildInsertUserdataQuery();
		echo $query;
	}
	
}
?>
