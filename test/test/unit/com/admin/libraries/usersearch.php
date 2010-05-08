<?php

class XiusUserSearchTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	/**
	 * @dataProvider miniDisplayProvider
	 */
	function testGetMiniProfileDisplayFields($userid,$result)
	{
		$sqlPath = $this->getSqlPath().DS.__FUNCTION__.".start.sql";
		$this->_DBO->loadSql($sqlPath);
		
		$value = XiusLibrariesUsersearch::getMiniProfileDisplayFields($userid);
		$this->assertEquals($value,$result);
		$diffArrayAcToV = array_diff($value,$result);
		$this->assertTrue((count($diffArrayAcToV) == 0));
		$diffArrayAcToR = array_diff($result,$value);
		$this->assertTrue((count($diffArrayAcToR) == 0));
	}
	
	
	public static function miniDisplayProvider()
	{
		
		$result63 = array('Gender' => 'Male','Register Date' => '5-3-2009', 'Name' => 'Moderator', 'Birthday' => '');
		$result64 = array('Gender' => '','Register Date' => '15-3-2009','Name' => 'Shannon', 'Birthday' => '');
		
		return array(
			array(63,$result63),
			array(64,$result64)
		);
	}
	
	/**
	 * @dataProvider conditionsProvider
	 */
	function testBuildQuery($conditions,$join,$sort,$dir,$result)
	{	
		$sqlPath = $this->getSqlPath().DS.__FUNCTION__.".start.sql";
		$this->_DBO->loadSql($sqlPath);
		$query = XiusLibrariesUsersearch::buildQuery($conditions,$join,$sort,$dir);
		$strQuery = $query->__toString();
		$this->assertEquals($this->cleanWhiteSpaces($result),$this->cleanWhiteSpaces($strQuery));
	}
	
	
	public static function conditionsProvider()
	{
		$conditions1 = array();
		
		$conditions1[] = array('infoid' => 1 ,'value' => 'Male' ,  'operator' => '=');
		$conditions1[] = array('infoid' => 7 ,'value' => array('Checkbox1','Checkbox11') ,  'operator' => '=');
		
		$join1 = 'AND';
		$sort1 = 'userid';
		$dir1 = 'ASC';
		
		$reqQuery1 = "SELECT * FROM `#__xius_cache`"
					." WHERE `jsfields2`='Male' AND"
					." ( `jsfields17` LIKE '%Checkbox1%' AND `jsfields17` LIKE '%Checkbox11%' )" 
					." ORDER BY `userid` ASC";
					
		$conditions2 = array();
		
		/*test text box from joomla */
		$conditions2[] = array('infoid' => 1 ,'value' => 'Male' ,  'operator' => '=');
		$conditions2[] = array('infoid' => 3 ,'value' => 'Afhganistan',  'operator' => '=');
		$conditions2[] = array('infoid' => 5 ,'value' => 'admin',  'operator' => '=');
		
		$join2 = 'AND';
		$sort2 = 'jsfields2';
		$dir2 = 'DESC';
		
		$reqQuery2 = "SELECT * FROM `#__xius_cache`"
					." WHERE `jsfields2`='Male' AND `jsfields12`='Afhganistan' AND `joomlausername` LIKE '%admin%'"
					." ORDER BY `jsfields2` DESC";

		/*test date fields from joomla and jsfields
		 * Also test Text box
		 */
		$conditions3 = array();
		
		$conditions3[] = array('infoid' => 2 ,'value' => 'Bhilwara' ,  'operator' => '=');
		$conditions3[] = array('infoid' => 4 ,'value' => '11-1-2010',  'operator' => '=');
		$conditions3[] = array('infoid' => 8 ,'value' => '11-10-1985',  'operator' => '=');
		
		$join3 = 'OR';
		$sort3 = 'joomlaregisterDate';
		$dir3 = 'DESC';
		
		$reqQuery3 = "SELECT * FROM `#__xius_cache`"
					." WHERE `jsfields11` LIKE '%Bhilwara%' OR DATE_FORMAT(`joomlaregisterDate`, '%d-%m-%Y')='11-1-2010' OR `jsfields3`='1985-10-11 23:59:59'"
					." ORDER BY `joomlaregisterDate` DESC";
		
		return array(
			array($conditions1,$join1,$sort1,$dir1,$reqQuery1),
			array($conditions2,$join2,$sort2,$dir2,$reqQuery2),
			array($conditions3,$join3,$sort3,$dir3,$reqQuery3)
		);
	}
	
	
	function testCreateTableQuery()
	{
		$db = JFactory::getDBO();
		$query = XiusLibrariesUsersearch::createTableQuery();
		$reqQuery = "CREATE TABLE IF NOT EXISTS `#__xius_cache`"
					." ( `userid` int(21) NOT NULL,"
					."`jsfields2` varchar(250) NOT NULL,"
					."`jsfields11` varchar(250) NOT NULL,"
					."`jsfields12` varchar(250) NOT NULL,"
					."`joomlaregisterDate` datetime NOT NULL,"
					."`joomlausername` varchar(250) NOT NULL,"
					."`joomlaname` varchar(250) NOT NULL,"
					."`jsfields17` varchar(250) NOT NULL,"
					."`jsfields3` varchar(250) NOT NULL )";
		
		$this->assertEquals($this->cleanWhiteSpaces($reqQuery),$this->cleanWhiteSpaces($query));
	}
	
	function testBuildInsertUserdataQuery()
	{
		$query = XiusLibrariesUsersearch::buildInsertUserdataQuery();
		$reqQuery = "SELECT juser.`id` as userid,jsfields2.value as jsfields2,"
					."jsfields11.value as jsfields11,jsfields12.value as jsfields12,"
					."joomlauserregisterDate.registerDate as joomlaregisterDate,"
					."joomlauserusername.username as joomlausername,"
					."joomlausername.name as joomlaname,jsfields17.value as jsfields17"
					.",jsfields3.value as jsfields3"
					." FROM `#__users` as juser "
					." LEFT JOIN `#__community_fields_values` as jsfields2 ON ( jsfields2.`user_id` = juser.`id` AND jsfields2.`field_id` = 2)"
					." LEFT JOIN `#__community_fields_values` as jsfields11 ON ( jsfields11.`user_id` = juser.`id` AND jsfields11.`field_id` = 11)"
					." LEFT JOIN `#__community_fields_values` as jsfields12 ON ( jsfields12.`user_id` = juser.`id` AND jsfields12.`field_id` = 12)"
					." LEFT JOIN `#__users` as joomlauserregisterDate ON ( joomlauserregisterDate.`id` = juser.`id` )"
					." LEFT JOIN `#__users` as joomlauserusername ON ( joomlauserusername.`id` = juser.`id` )"
					." LEFT JOIN `#__users` as joomlausername ON ( joomlausername.`id` = juser.`id` )"
					." LEFT JOIN `#__community_fields_values` as jsfields17 ON ( jsfields17.`user_id` = juser.`id` AND jsfields17.`field_id` = 17)"
					." LEFT JOIN `#__community_fields_values` as jsfields3 ON ( jsfields3.`user_id` = juser.`id` AND jsfields3.`field_id` = 3)";
		
		$this->assertEquals($this->cleanWhiteSpaces($reqQuery),$this->cleanWhiteSpaces($query));
	}
	
}
?>
