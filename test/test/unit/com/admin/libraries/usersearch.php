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
		
		$this->resetCachedData();
		
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
					." WHERE `jsfields2_0`='Male' AND"
					." ( `jsfields17_0` LIKE '%Checkbox1%' AND `jsfields17_0` LIKE '%Checkbox11%' )" 
					." ORDER BY `userid` ASC";
					
		$conditions2 = array();
		
		/*test text box from joomla */
		$conditions2[] = array('infoid' => 1 ,'value' => 'Male' ,  'operator' => '=');
		$conditions2[] = array('infoid' => 3 ,'value' => 'Afhganistan',  'operator' => '=');
		$conditions2[] = array('infoid' => 5 ,'value' => 'admin',  'operator' => '=');
		
		$join2 = 'AND';
		$sort2 = 'jsfields2_0';
		$dir2 = 'DESC';
		
		$reqQuery2 = "SELECT * FROM `#__xius_cache`"
					." WHERE `jsfields2_0`='Male' AND `jsfields12_0`='Afhganistan' AND `joomlausername_0` LIKE '%admin%'"
					." ORDER BY `jsfields2_0` DESC";

		/*test date fields from joomla and jsfields
		 * Also test Text box
		 */
		$conditions3 = array();
		
		$conditions3[] = array('infoid' => 2 ,'value' => 'Bhilwara' ,  'operator' => '=');
		$conditions3[] = array('infoid' => 4 ,'value' => '11-1-2010',  'operator' => '=');
		$conditions3[] = array('infoid' => 8 ,'value' => '11-10-1985',  'operator' => '=');
		
		$join3 = 'OR';
		$sort3 = 'joomlaregisterDate_0';
		$dir3 = 'DESC';
		
		$reqQuery3 = "SELECT * FROM `#__xius_cache`"
					." WHERE `jsfields11_0` LIKE '%Bhilwara%' OR DATE_FORMAT(`joomlaregisterDate_0`, '%d-%m-%Y')='11-1-2010' OR `jsfields3_0`='1985-10-11 23:59:59'"
					." ORDER BY `joomlaregisterDate_0` DESC";
		
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
					."`jsfields2_0` varchar(250) NOT NULL,"
					."`jsfields11_0` varchar(250) NOT NULL,"
					."`jsfields12_0` varchar(250) NOT NULL,"
					."`joomlaregisterDate_0` datetime NOT NULL,"
					."`joomlausername_0` varchar(250) NOT NULL,"
					."`joomlaname_0` varchar(250) NOT NULL,"
					."`jsfields17_0` varchar(250) NOT NULL,"
					."`jsfields3_0` datetime NOT NULL )";
		
		$this->assertEquals($this->cleanWhiteSpaces($reqQuery),$this->cleanWhiteSpaces($query));
	}
	
	function testBuildInsertUserdataQuery()
	{
		$query = XiusLibrariesUsersearch::buildInsertUserdataQuery();
		$reqQuery = "SELECT juser.`id` as userid,jsfields2_0.value as jsfields2_0,"
					."jsfields11_0.value as jsfields11_0,jsfields12_0.value as jsfields12_0,"
					."joomlauserregisterDate_0.registerDate as joomlaregisterDate_0,"
					."joomlauserusername_0.username as joomlausername_0,"
					."joomlausername_0.name as joomlaname_0,jsfields17_0.value as jsfields17_0"
					.",jsfields3_0.value as jsfields3_0"
					." FROM `#__users` as juser "
					." LEFT JOIN `#__community_fields_values` as jsfields2_0 ON ( jsfields2_0.`user_id` = juser.`id` AND jsfields2_0.`field_id` = 2)"
					." LEFT JOIN `#__community_fields_values` as jsfields11_0 ON ( jsfields11_0.`user_id` = juser.`id` AND jsfields11_0.`field_id` = 11)"
					." LEFT JOIN `#__community_fields_values` as jsfields12_0 ON ( jsfields12_0.`user_id` = juser.`id` AND jsfields12_0.`field_id` = 12)"
					." LEFT JOIN `#__users` as joomlauserregisterDate_0 ON ( joomlauserregisterDate_0.`id` = juser.`id` )"
					." LEFT JOIN `#__users` as joomlauserusername_0 ON ( joomlauserusername_0.`id` = juser.`id` )"
					." LEFT JOIN `#__users` as joomlausername_0 ON ( joomlausername_0.`id` = juser.`id` )"
					." LEFT JOIN `#__community_fields_values` as jsfields17_0 ON ( jsfields17_0.`user_id` = juser.`id` AND jsfields17_0.`field_id` = 17)"
					." LEFT JOIN `#__community_fields_values` as jsfields3_0 ON ( jsfields3_0.`user_id` = juser.`id` AND jsfields3_0.`field_id` = 3)";
		
		$this->assertEquals($this->cleanWhiteSpaces($reqQuery),$this->cleanWhiteSpaces($query));
	}
	
	
	
	function testGetSortableFields()
	{
		$this->resetCachedData();
		
		$filter = array();
		$filter['published'] = true;
		$allInfo = XiusLibrariesInfo::getInfo($filter,'AND',false);
		
		$sortableFields = XiusLibrariesUsersearch::getSortableFields($allInfo);
		
		$result = array(1,2,3,5,6,8);
		
		foreach($sortableFields as $s){
			$this->assertTrue(in_array($s['key'],$result)," key ".$s['key']." does not exist in result array");
		}
		
		$resultSortableFields[] = array('key' => 1 , 'value' => JText::_('Gender'));
		$resultSortableFields[] = array('key' => 2 , 'value' => JText::_('City'));
		$resultSortableFields[] = array('key' => 3 , 'value' => JText::_('Country'));
		$resultSortableFields[] = array('key' => 5 , 'value' => JText::_('Username'));
		$resultSortableFields[] = array('key' => 6 , 'value' => JText::_('Name'));
		$resultSortableFields[] = array('key' => 8 , 'value' => JText::_('Birthday'));
		
		$this->assertEquals($resultSortableFields,$sortableFields);
	}
	
	
	
	/**
	 * @dataProvider searchDataProvider
	 */
	function testProcessSearchData($data,$resultConditions)
	{
		$sqlPath = $this->getSqlPath().DS.__FUNCTION__.".start.sql";
		$this->_DBO->loadSql($sqlPath);
		
		$conditions		= XiusLibrariesUsersearch::processSearchData($data);
		
		//echo "result should be ".print_r(var_export($resultConditions))." but we get ".print_r(var_export($conditions));
		$this->assertEquals($resultConditions,$conditions);
	}
	
	
	public static function searchDataProvider()
	{
		$data1	= array('xiusinfo_241'=>24,'keyword'=>'admin','xiusinfo_242'=>24,'xiusinfo_141'=>14,'lastVisitDate'=>'10-1-2010','xiusinfo_142'=>14,'xiusinfo_31'=>3,'jsfields3'=>'Afghanistan','xiusinfo_32'=>3,);
		
		$resultCondition1[]  =	array('infoid' => 24 , 'value'	=> 'admin' , 'operator' => '=');
		$resultCondition1[]  =	array('infoid' => 14 , 'value'	=> '10-1-2010' , 'operator' => '=');
		$resultCondition1[]  =	array('infoid' => 3 , 'value'	=> 'Afghanistan' , 'operator' => '=');
		
		//empty posted value test
		$data2	= array('xiusinfo_21'=>2,'xiusinfo_22'=>2,'xiusinfo_51'=>5,'username'=>'admin','xiusinfo_52'=>5,'xiusinfo_31'=>3,'jsfields3'=>'','xiusinfo_32'=>3);
		
		$resultCondition2[]  =	array('infoid' => 5 , 'value'	=> 'admin' , 'operator' => '=');
		
		return array(
			array($data1,$resultCondition1),
			array($data2,$resultCondition2)
		);
	}
	
	
	/**
	 * @dataProvider searchDataExistProvider
	 */
	function testCheckSearchDataExistance($fromArray , $toArray , $resultPosition)
	{
		$sqlPath = $this->getSqlPath().DS."testDeleteSearchData.start.sql";
		$this->_DBO->loadSql($sqlPath);
		
		XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,$toArray,'XIUS');
		
		$position = XiusLibrariesUsersearch::checkSearchDataExistance($fromArray,$toArray);
		
		$this->assertEquals($resultPosition,$position,"postion should be $resultPosition but we get $position");
	}
	
	
	public static function searchDataExistProvider()
	{
		//set 1 with empty datas
		$fromArray1	= array();
		$toArray1 = array();
		$resultPosition1 = false;
		
		$fromArray2 = array('infoid' => 1 , 'value' => 'Female' , 'operator' => '=');
		
		$toArray2[]  =	array('infoid' => 24 , 'value'	=> 'admin' , 'operator' => '=');
		$toArray2[]  =	array('infoid' => 14 , 'value'	=> '10-1-2010' , 'operator' => '=');
		$toArray2[]  =	array('infoid' => 3 , 'value'	=> 'Afghanistan' , 'operator' => '=');
		$toArray2[]  =	array('infoid' => 24 , 'value'	=> 'ad' , 'operator' => '=');
		$toArray2[]  =	array('infoid' => 1 , 'value'	=> 'Male' , 'operator' => '=');
		$toArray2[]  =	array('infoid' => 1 , 'value'	=> 'Female' , 'operator' => '=');
		
		$resultPosition2	= 6;
		
		//set 3 with empty datas
		$fromArray3 = array('infoid' => 1 , 'value' => 'Female' , 'operator' => '=');
		$toArray3 = array();
		$resultPosition3 = false;
		
		$fromArray4 = array('infoid' => 7 , 'value' => array('checkbox1','checkobx') , 'operator' => '=');
		
		$toArray4[]  =	array('infoid' => 7 , 'value' => array('checkbox1','checkobx') , 'operator' => '=');
		$toArray4[]  =	array('infoid' => 7 , 'value' => array('checkbox1','checkobx','checkbox2') , 'operator' => '=');
		$toArray4[]  =	array('infoid' => 24 , 'value'	=> 'admin' , 'operator' => '=');
		$toArray4[]  =	array('infoid' => 14 , 'value'	=> '10-1-2010' , 'operator' => '=');
		$toArray4[]  =	array('infoid' => 3 , 'value'	=> 'Afghanistan' , 'operator' => '=');
		$toArray4[]  =	array('infoid' => 24 , 'value'	=> 'ad' , 'operator' => '=');
		$toArray4[]  =	array('infoid' => 1 , 'value'	=> 'Female' , 'operator' => '=');
		
		$resultPosition4	= 1;
		
		
		$fromArray5 = array('infoid' => 7 , 'value' => array('checkbox1','checkobx') , 'operator' => '=');
		
		$toArray5[]  =	array('infoid' => 7 , 'value' => 'xy', 'operator' => '=');
		$toArray5[]  =	array('infoid' => 24 , 'value'	=> 'admin' , 'operator' => '=');
		$toArray5[]  =	array('infoid' => 14 , 'value'	=> '10-1-2010' , 'operator' => '=');
		$toArray5[]  =	array('infoid' => 3 , 'value'	=> 'Afghanistan' , 'operator' => '=');
		$toArray5[]  =	array('infoid' => 24 , 'value'	=> 'ad' , 'operator' => '=');
		$toArray5[]  =	array('infoid' => 1 , 'value'	=> 'Female' , 'operator' => '=');
		
		$resultPosition5	= false;
		
		return array(
			array($fromArray1,$toArray1,$resultPosition1),
			array($fromArray2,$toArray2,$resultPosition2),
			array($fromArray3,$toArray3,$resultPosition3),
			array($fromArray4,$toArray4,$resultPosition4),
			array($fromArray5,$toArray5,$resultPosition5)
		);
	}
	
	
	/**
	 * @dataProvider deleteSearchDataProvider
	 */
	function testDeleteSearchData($delInfoId,$existConditions,$conditionValue,$resultConditions,$result)
	{
		$sqlPath = $this->getSqlPath().DS.__FUNCTION__.".start.sql";
		$this->_DBO->loadSql($sqlPath);
		
		XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,$existConditions,'XIUS');
		
		$success = XiusLibrariesUsersearch::deleteSearchData($existConditions,$delInfoId,$conditionValue);
		
		$this->assertEquals($result,$success,"result should be $result but we get $success");
		
		$conditions = XiusLibrariesUsersearch::getDataFromSession(XIUS_CONDITIONS,false);
		
		//echo "result should be ".print_r(var_export($resultConditions))." but we get ".print_r(var_export($conditions));
		$this->assertEquals($resultConditions,$conditions);
	}
	
	
	public static function deleteSearchDataProvider()
	{
		//set 1
		$delInfoId1 = 1;
		
		$conditionValue1 = serialize('Female');
		
		$result1 = true;
		
		$existConditions1[]  =	array('infoid' => 24 , 'value'	=> 'admin' , 'operator' => '=');
		$existConditions1[]  =	array('infoid' => 14 , 'value'	=> '10-1-2010' , 'operator' => '=');
		$existConditions1[]  =	array('infoid' => 3 , 'value'	=> 'Afghanistan' , 'operator' => '=');
		$existConditions1[]  =	array('infoid' => 24 , 'value'	=> 'ad' , 'operator' => '=');
		$existConditions1[]  =	array('infoid' => 1 , 'value'	=> 'Male' , 'operator' => '=');
		$existConditions1[]  =	array('infoid' => 1 , 'value'	=> 'Female' , 'operator' => '=');
		
		$resultCondition1[]  =	array('infoid' => 24 , 'value'	=> 'admin' , 'operator' => '=');
		$resultCondition1[]  =	array('infoid' => 14 , 'value'	=> '10-1-2010' , 'operator' => '=');
		$resultCondition1[]  =	array('infoid' => 3 , 'value'	=> 'Afghanistan' , 'operator' => '=');
		$resultCondition1[]  =	array('infoid' => 24 , 'value'	=> 'ad' , 'operator' => '=');
		$resultCondition1[]  =	array('infoid' => 1 , 'value'	=> 'Male' , 'operator' => '=');
		
		//set 2
		$delInfoId2 = 0;
		
		$conditionValue2 = serialize('Female');
		
		$result2 = false;
		
		$existConditions2[]  =	array('infoid' => 24 , 'value'	=> 'admin' , 'operator' => '=');
		$existConditions2[]  =	array('infoid' => 14 , 'value'	=> '10-1-2010' , 'operator' => '=');
		$existConditions2[]  =	array('infoid' => 3 , 'value'	=> 'Afghanistan' , 'operator' => '=');
		
		$resultCondition2[]  =	array('infoid' => 24 , 'value'	=> 'admin' , 'operator' => '=');
		$resultCondition2[]  =	array('infoid' => 14 , 'value'	=> '10-1-2010' , 'operator' => '=');
		$resultCondition2[]  =	array('infoid' => 3 , 'value'	=> 'Afghanistan' , 'operator' => '=');
		
		
		//set 3
		$delInfoId3 = 1;
		
		$conditionValue3 = serialize('Female');
		
		$result3 = false;
		
		$existConditions3	= '';
		
		$resultCondition3	=	'';
		
		
		//set 4
		$delInfoId4 = 14;
		
		$conditionValue4 = serialize('15-3-2009');
		$result4 = true;
		
		$existConditions4[]  =	array('infoid' => 24 , 'value'	=> 'admin' , 'operator' => '=');
		$existConditions4[]  =	array('infoid' => 14 , 'value'	=> '10-1-2010' , 'operator' => '=');
		$existConditions4[]  =	array('infoid' => 3 , 'value'	=> 'Afghanistan' , 'operator' => '=');
		$existConditions4[]  =	array('infoid' => 24 , 'value'	=> 'ad' , 'operator' => '=');
		$existConditions4[]  =	array('infoid' => 1 , 'value'	=> 'Male' , 'operator' => '=');
		$existConditions4[]  =	array('infoid' => 14 , 'value'	=> '15-3-2009' , 'operator' => '=');
		
		$resultCondition4[]  =	array('infoid' => 24 , 'value'	=> 'admin' , 'operator' => '=');
		$resultCondition4[]  =	array('infoid' => 14 , 'value'	=> '10-1-2010' , 'operator' => '=');
		$resultCondition4[]  =	array('infoid' => 3 , 'value'	=> 'Afghanistan' , 'operator' => '=');
		$resultCondition4[]  =	array('infoid' => 24 , 'value'	=> 'ad' , 'operator' => '=');
		$resultCondition4[]  =	array('infoid' => 1 , 'value'	=> 'Male' , 'operator' => '=');
		
		
		//set 5 with wrong del info id
		$delInfoId5 = 4;
		
		$conditionValue5 = serialize('15-3-2009');
		
		$result5 = true;
		
		$existConditions5[]  =	array('infoid' => 24 , 'value'	=> 'admin' , 'operator' => '=');
		$existConditions5[]  =	array('infoid' => 14 , 'value'	=> '10-1-2010' , 'operator' => '=');
		$existConditions5[]  =	array('infoid' => 3 , 'value'	=> 'Afghanistan' , 'operator' => '=');
		$existConditions5[]  =	array('infoid' => 24 , 'value'	=> 'ad' , 'operator' => '=');
		$existConditions5[]  =	array('infoid' => 1 , 'value'	=> 'Male' , 'operator' => '=');
		$existConditions5[]  =	array('infoid' => 14 , 'value'	=> '15-3-2009' , 'operator' => '=');
		
		$resultCondition5[]  =	array('infoid' => 24 , 'value'	=> 'admin' , 'operator' => '=');
		$resultCondition5[]  =	array('infoid' => 14 , 'value'	=> '10-1-2010' , 'operator' => '=');
		$resultCondition5[]  =	array('infoid' => 3 , 'value'	=> 'Afghanistan' , 'operator' => '=');
		$resultCondition5[]  =	array('infoid' => 24 , 'value'	=> 'ad' , 'operator' => '=');
		$resultCondition5[]  =	array('infoid' => 1 , 'value'	=> 'Male' , 'operator' => '=');
		$resultCondition5[]  =	array('infoid' => 14 , 'value'	=> '15-3-2009' , 'operator' => '=');
		
		
		$delInfoId6 = 7;
		
		$conditionValue6 = serialize(array('checkbox1','checkobx'));
		
		$result6 = true;
		
		$existConditions6[]  =	array('infoid' => 7 , 'value' => array('checkbox1','checkobx') , 'operator' => '=');
		$existConditions6[]  =	array('infoid' => 7 , 'value' => array('checkbox1','checkobx','checkbox2') , 'operator' => '=');
		$existConditions6[]  =	array('infoid' => 24 , 'value'	=> 'admin' , 'operator' => '=');
		$existConditions6[]  =	array('infoid' => 14 , 'value'	=> '10-1-2010' , 'operator' => '=');
		$existConditions6[]  =	array('infoid' => 3 , 'value'	=> 'Afghanistan' , 'operator' => '=');
		$existConditions6[]  =	array('infoid' => 24 , 'value'	=> 'ad' , 'operator' => '=');
		$existConditions6[]  =	array('infoid' => 1 , 'value'	=> 'Female' , 'operator' => '=');
		
		$resultCondition6[]  =	array('infoid' => 7 , 'value' => array('checkbox1','checkobx','checkbox2') , 'operator' => '=');
		$resultCondition6[]  =	array('infoid' => 24 , 'value'	=> 'admin' , 'operator' => '=');
		$resultCondition6[]  =	array('infoid' => 14 , 'value'	=> '10-1-2010' , 'operator' => '=');
		$resultCondition6[]  =	array('infoid' => 3 , 'value'	=> 'Afghanistan' , 'operator' => '=');
		$resultCondition6[]  =	array('infoid' => 24 , 'value'	=> 'ad' , 'operator' => '=');
		$resultCondition6[]  =	array('infoid' => 1 , 'value'	=> 'Female' , 'operator' => '=');
		
		
		return array(
			array($delInfoId1,$existConditions1,$conditionValue1,$resultCondition1,$result1),
			array($delInfoId2,$existConditions2,$conditionValue2,$resultCondition2,$result2),
			array($delInfoId3,$existConditions3,$conditionValue3,$resultCondition3,$result3),
			array($delInfoId4,$existConditions4,$conditionValue4,$resultCondition4,$result4),
			array($delInfoId5,$existConditions5,$conditionValue5,$resultCondition5,$result5),
			array($delInfoId6,$existConditions6,$conditionValue6,$resultCondition6,$result6)
		);
	}
	
	
	/**
	 * @dataProvider addSearchDataProvider
	 */
	function testAddSearchData($addInfoId,$post,$existconditions,$resultConditions)
	{
		$sqlPath = $this->getSqlPath().DS."testDeleteSearchData.start.sql";
		$this->_DBO->loadSql($sqlPath);
		
		XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,$existconditions,'XIUS');
		
		$success = XiusLibrariesUsersearch::addSearchData($addInfoId,$post);
		
		$conditions = XiusLibrariesUsersearch::getDataFromSession(XIUS_CONDITIONS,false);
		
		//echo "result should be ".print_r(var_export($resultConditions))." but we get ".print_r(var_export($conditions));
		$this->assertEquals($resultConditions,$conditions);
	}
	
	
	public static function addSearchDataProvider()
	{
		//set 1 : Adding existing value
		$addInfoId1 = 1;
		
		$post1 = array('xiusinfo_11'=>1,'jsfields2'=>'Male','xiusinfo_12'=>1);
		
		$existConditions1[]  =	array('infoid' => 24 , 'value'	=> 'admin' , 'operator' => '=');
		$existConditions1[]  =	array('infoid' => 14 , 'value'	=> '10-1-2010' , 'operator' => '=');
		$existConditions1[]  =	array('infoid' => 3 , 'value'	=> 'Afghanistan' , 'operator' => '=');
		$existConditions1[]  =	array('infoid' => 24 , 'value'	=> 'ad' , 'operator' => '=');
		$existConditions1[]  =	array('infoid' => 1 , 'value'	=> 'Male' , 'operator' => '=');
		$existConditions1[]  =	array('infoid' => 1 , 'value'	=> 'Female' , 'operator' => '=');
		
		$resultCondition1[]  =	array('infoid' => 24 , 'value'	=> 'admin' , 'operator' => '=');
		$resultCondition1[]  =	array('infoid' => 14 , 'value'	=> '10-1-2010' , 'operator' => '=');
		$resultCondition1[]  =	array('infoid' => 3 , 'value'	=> 'Afghanistan' , 'operator' => '=');
		$resultCondition1[]  =	array('infoid' => 24 , 'value'	=> 'ad' , 'operator' => '=');
		$resultCondition1[]  =	array('infoid' => 1 , 'value'	=> 'Male' , 'operator' => '=');
		$resultCondition1[]  =	array('infoid' => 1 , 'value'	=> 'Female' , 'operator' => '=');
		
		//set 2
		$addInfoId2 = 7;
		
		$post2 = array('xiusinfo_241'=>24,'keyword'=>'xyz','xiusinfo_242'=>24,'xiusinfo_71'=>7,'jsfields17'=> array('checkbox1','checkbox'),'xiusinfo_72'=> 7 );
		
		$existConditions2[]  =	array('infoid' => 24 , 'value'	=> 'admin' , 'operator' => '=');
		$existConditions2[]  =	array('infoid' => 14 , 'value'	=> '10-1-2010' , 'operator' => '=');
		$existConditions2[]  =	array('infoid' => 3 , 'value'	=> 'Afghanistan' , 'operator' => '=');
		
		$resultCondition2[]  =	array('infoid' => 24 , 'value'	=> 'admin' , 'operator' => '=');
		$resultCondition2[]  =	array('infoid' => 14 , 'value'	=> '10-1-2010' , 'operator' => '=');
		$resultCondition2[]  =	array('infoid' => 3 , 'value'	=> 'Afghanistan' , 'operator' => '=');
		$resultCondition2[]  =	array('infoid' => 7 , 'value'	=>  array('checkbox1','checkbox'), 'operator' => '=');
		
		
		return array(
			array($addInfoId1,$post1,$existConditions1,$resultCondition1),
			array($addInfoId2,$post2,$existConditions2,$resultCondition2)
		);
	}
	
	function testGetSortedInfo()
    {
		$info = XiusLibrariesUsersearch::getAllInfo();
        $info = XiusHelpersUsersearch::getSortedInfo($info);
       	foreach($info as $in)
       		$sequence[]=$in->id;
        
       $result = array(2,3,4,1);
       $this->assertEquals($sequence, $result);
    }
}
?>
