<?php

class XiusCacheTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	
	function testCreateTable()
	{
		$this->resetCachedData();
		
		$cache = new XiusCache();
		$cache->createTable();
		
		//Test column exist or not
		$columns = array('userid' => true,'jsfields2_0' => true , 'jsfields11_0' => true ,'jsfields12_0' => true ,'joomlaregisterDate_0' => true ,'joomlaregisterDate_0' => true ,'joomlausername_0' => true ,'joomlaname_0' => true ,'jsfields17_0' => true , 'jsfields3_0' => true ,'jsfields4_0' => false , 'joomlaactivation_0' => false );
		
		foreach($columns as $columnName => $result)
			$this->assertEquals($result,self::checkColumnExistance($columnName));
		
	}

	function checkColumnExistance($columnName,$tableName = '#__xius_cache')
	{
		$db =& JFactory::getDBO();
		$results = $db->getTableFields($db->nameQuote($tableName));
		
		foreach($results as $t)
			if(array_key_exists($columnName,$t))
				return true;
			
		return false;
	}
	
	
	function testInsertIntoTableWithDataAccuracy()
	{
		$sqlPath = $this->getSqlPath().DS."insert.sql";
		$this->_DBO->loadSql($sqlPath);
		
		$cache = new XiusCache();
		
		$getDataQuery = XiusLibUsersearch::buildInsertUserdataQuery();
		
		//$limit = array('limitStart' => 0 , 'limit' => 23);
		
		$cache->insertIntoTable($getDataQuery);
		
		$datas = array();
		$datas[] =	array('userid' => 63 , 'data' => array('jsfields2_0' => 'Male' , 'jsfields11_0' => 'Noida') , 'userStatus' => 1);
		$datas[] =	array('userid' => 87 , 'data' => array('jsfields2_0' => '' , 'joomlausername_0' => 'Clint') , 'userStatus' => 1);
		$datas[] =	array('userid' => 80 , 'data' => array('jsfields2_0' => 'Female' , 'joomlausername_0' => 'meenal' , ) , 'userStatus' => 1);
		$datas[] =	array('userid' => 93 , 'data' => array('joomlaregisterDate_0' => '2009-04-10 20:10:05' , 'joomlausername_0' => 'raf13001' , ) , 'userStatus' => 1);
		$datas[] =	array('userid' => 10000 , 'data' => array() , 'userStatus' => 0);
		
		foreach($datas as $data)
			self::compareUserData($data['userid'],$data['data'],$data['userStatus']);
		
	}
	
	
	
	function testInsertIntoTableWithLimit()
	{
		$sqlPath = $this->getSqlPath().DS."insert.sql";
		$this->_DBO->loadSql($sqlPath);
		
		$cache = new XiusCache();
		
		$getDataQuery = XiusLibUsersearch::buildInsertUserdataQuery();
		
		$limit = array('limitStart' => 0 , 'limit' => 23);
		
		$cache->insertIntoTable($getDataQuery,true,$limit);
		
		$datas = array();
		$datas[] =	array('userid' => 62 , 'data' => array() , 'userStatus' => 1);
		$datas[] =	array('userid' => 63 , 'data' => array('jsfields2_0' => 'Male' , 'jsfields11_0' => 'Noida') , 'userStatus' => 1);
		$datas[] =	array('userid' => 87 , 'data' => array() , 'userStatus' => 0);
		$datas[] =	array('userid' => 80 , 'data' => array('jsfields2_0' => 'Female' , 'joomlausername_0' => 'meenal') , 'userStatus' => 1);
		$datas[] =	array('userid' => 93 , 'data' => array() , 'userStatus' => 0);
		$datas[] =	array('userid' => 10000 , 'data' => array() , 'userStatus' => 0);
		
		foreach($datas as $data)
			self::compareUserData($data['userid'],$data['data'],$data['userStatus']);
		
		self::getTotalUserCount(23);
		
		
		$cache = new XiusCache();
		
		$limit = array('limitStart' => 23 , 'limit' => 1600);
		
		$cache->insertIntoTable($getDataQuery,true,$limit);
		
		$datas = array();
		$datas[] =	array('userid' => 62 , 'data' => array() , 'userStatus' => 1);
		$datas[] =	array('userid' => 63 , 'data' => array('jsfields2_0' => 'Male' , 'jsfields11_0' => 'Noida') , 'userStatus' => 1);
		$datas[] =	array('userid' => 87 , 'data' => array('jsfields2_0' => '' , 'joomlausername_0' => 'Clint') , 'userStatus' => 1);
		$datas[] =	array('userid' => 80 , 'data' => array('jsfields2_0' => 'Female' , 'joomlausername_0' => 'meenal') , 'userStatus' => 1);
		$datas[] =	array('userid' => 1685 , 'data' => array('jsfields2_0' => '' , 'joomlausername_0' => 'Denverwinks') , 'userStatus' => 1);
		$datas[] =	array('userid' => 1693 , 'data' => array() , 'userStatus' => 0);
		$datas[] =	array('userid' => 10000 , 'data' => array() , 'userStatus' => 0);
		
		foreach($datas as $data)
			self::compareUserData($data['userid'],$data['data'],$data['userStatus']);
		
		self::getTotalUserCount(1623);
		
		
		$cache = new XiusCache();
		
		$limit = array('limitStart' => 1623 , 'limit' => 4000);
		
		$cache->insertIntoTable($getDataQuery,true,$limit);
		
		$datas = array();
		$datas[] =	array('userid' => 271 , 'data' => array('jsfields2_0' => 'Male' , 'jsfields11_0' => 'orldando' , 'jsfields12_0' => 'United States' , 'jsfields17_0' => 'JomSocial Redirector,') , 'userStatus' => 1);
		
		$datas[] =	array('userid' => 3937 , 'data' => array('jsfields2_0' => '' , 'joomlausername_0' => 'adminwww' , 'joomlaname_0' => 'admin') , 'userStatus' => 1);
		$datas[] =	array('userid' => 3938 , 'data' => array() , 'userStatus' => 0);
		$datas[] =	array('userid' => 10000 , 'data' => array() , 'userStatus' => 0);
		
		foreach($datas as $data)
			self::compareUserData($data['userid'],$data['data'],$data['userStatus']);
		
		self::getTotalUserCount(3860);
	}
	
	
	
	function compareUserData($userid,$data,$userStatus)
	{	
		$db = JFactory::getDBO();
		$query = 'SELECT * FROM '.$db->nameQuote('#__xius_cache')
				.' WHERE '.$db->nameQuote('userid').'='.$db->Quote($userid);
				
		$db->setQuery($query);
		$users = $db->loadObjectList();
		
		$this->assertEquals(count($users),$userStatus,'User count should be '.$userStatus.' but we get '.count($users).' for userid '.$userid);
		
		if($data)
		foreach($users as $u){
			foreach($data as $k => $v)
				$this->assertEquals($u->$k,$v,'We get '.$u->$k.' but result should be '.$v.' for '.$k.' for user '.$u->userid);
		}
				
	}
	
	
	function getTotalUserCount($result)
	{
		$db = JFactory::getDBO();
		$query = 'SELECT * FROM '.$db->nameQuote('#__xius_cache');
				
		$db->setQuery($query);
		$users = $db->loadObjectList();
		
		$this->assertEquals(count($users),$result,'User count should be '.$result.' but we get '.count($users));
	}
	
	
	/**
	 * @dataProvider userQueryProvider
	 */
	function testSearchUsers($conditions,$join,$sort,$dir,$usercount,$requsers)
	{
		/*XITODO : Update cache table also */
		$sqlPath = $this->getSqlPath().DS.__FUNCTION__.".start.sql";
		$this->_DBO->loadSql($sqlPath);
		$strQuery = XiusFactory::getInstance('users','model')
								->getQuery($conditions,$join,'true',$sort,$dir);

		$db = JFactory::getDBO();
		$db->setQuery((string)$strQuery);
		$users = $db->loadObjectList();
		
		$this->assertEquals($usercount,count($users),'Total users should be '.$usercount.' but we get '.count($users));
		
		foreach($requsers as $userid => $status){
			$result = false;
			foreach($users as $u){
				if($u->userid == $userid){
					$result = true;
					break;
				}
			}
			
			$this->assertEquals($status,$result,"Status of user ".$userid." should be ".$status);
		}
	}
	
	
	public static function userQueryProvider()
	{
		$conditions1 = array();
		
		$conditions1[] = array('infoid' => 1 ,'value' => 'Male' ,  'operator' => '=');
		$conditions1[] = array('infoid' => 3 ,'value' => 'United States' ,  'operator' => '=');
		
		$join1 = 'AND';
		$sort1 = 'userid';
		$dir1 = 'ASC';
		
		$reqUsersCount1 = 184;
		$reqUsers1 = array(389 => true,399 => true,319 => true,252 => true,1653 => false , 271 => true , 400 => true,535 => true , 68 => false);
					
		$conditions2 = array();
		
		$conditions2[] = array('infoid' => 1 ,'value' => 'Male' ,  'operator' => '=');
		$conditions2[] = array('infoid' => 2 ,'value' => 'Noida' ,  'operator' => '=');
		
		$join2 = 'AND';
		$sort2 = 'userid';
		$dir2 = 'ASC';
		
		$reqUsersCount2 = 1;
		$reqUsers2 = array(389 => false , 63 => true);
			

		/*test date fields from joomla and jsfields
		 * Also test Text box
		 */
		$conditions3 = array();
		
		$conditions3[] = array('infoid' => 2 ,'value' => 'Bhilwara' ,  'operator' => '=');
		$conditions3[] = array('infoid' => 4 ,'value' => '16-01-2010',  'operator' => '=');
		$conditions3[] = array('infoid' => 4 ,'value' => '05-03-2009',  'operator' => '=');
		$conditions3[] = array('infoid' => 8 ,'value' => '11-10-1985',  'operator' => '=');
		$conditions3[] = array('infoid' => 8 ,'value' => '16-7-1984',  'operator' => '=');
		
		$join3 = 'OR';
		$sort3 = 'joomlaregisterDate_0';
		$dir3 = 'DESC';
		
		$reqUsersCount3 = 3;
		$reqUsers3 = array(389 => false , 62 => true , 63 => true , 80 => true);
		
		return array(
			array($conditions1,$join1,$sort1,$dir1,$reqUsersCount1,$reqUsers1),
			array($conditions2,$join2,$sort2,$dir2,$reqUsersCount2,$reqUsers2),
			array($conditions3,$join3,$sort3,$dir3,$reqUsersCount3,$reqUsers3)
		);
	}
	
	
	function testCreateTableWithEmptyInfo()
	{
		$this->resetCachedData();
		
		$cache = new XiusCache();
		$result = $cache->createTable();
	
		$this->assertFalse($result);
		
	}
}
?>
