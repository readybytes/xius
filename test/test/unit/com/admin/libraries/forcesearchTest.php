<?php

class XiusForcesearchUnitTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testGetAvailableInfoForForcesearch()
	{
		$this->resetCachedData();
		require_once  XIUS_PLUGINS_PATH. DS . 'forcesearch' . DS . 'forcesearch.php';
		$instance = new Forcesearch();
		
		$info = $instance->getAvailableInfo();
		
		if(!$instance->isAllRequirementSatisfy())
			$this->assertFalse($info);
		else {			
			$requiredInfo = array( 1 => 'Gender',
								   2 => 'City' , 3 => 'Country' , 4 => 'Register Date',
								   5 => 'Username' , 6 => 'Name' , 7 => 'Checkbox1',
								   8 => 'Birthday' , 9 => 'ID' , 10 => 'E-mail', 11 => 'usertype',
			  					  14 => 'lastvisitDate');
			
			$this->assertEquals($requiredInfo,$info);
		}
	}
	
	/**
	 * @dataProvider conditionResultProvider
	 */
	function testBlock0WithExistCondition($conditions,$join,$totalResultUserCount)
	{
		$url	= JPATH_ROOT.'/test/test/_data/';
	    $this->_DBO->loadSql($url.'/insert.sql');	
		$this->_DBO->loadSql($url.'/16/updateCache.sql');
		
		if(TEST_XIUS_JOOMLA_15)
		{
		   $sqlPath = $this->getSqlPath().DS.__FUNCTION__.".start.sql";
		   $this->_DBO->loadSql($sqlPath);	
		}
		else
		{
		    $url	= JPATH_ROOT.'/test/test/unit/com/admin/libraries/sql/XiusForcesearchUnitTest/16';
			$this->_DBO->loadSql($url.'/testBlock0WithExistCondition.start.sql');
		}
		
		//$this->resetCachedData();
		
		$model = XiusFactory::getInstance('users','model');
		$strQuery= $model->getQuery($conditions,$join);

		$db = JFactory::getDBO();
		$db->setQuery((string)$strQuery);
		
		$users = $db->loadObjectList();
		
		$this->assertEquals(count($users),$totalResultUserCount,'Total users should be '.$totalResultUserCount.' but we get '.count($users));
	}
	

	public static function conditionResultProvider()
	{
	
		$conditions1[] = array('infoid'	=> 1,'value' => 'Female' , 'operator' => '=');
		$conditions1[] = array('infoid'	=> 3,'value' => 'Angola' , 'operator' => '=');
		
		$join1	=	'AND';
		$totalUser1	=	0;
		
		$conditions2[] = array('infoid'	=> 1,'value' => 'Female' , 'operator' => '=');
		$conditions2[] = array('infoid'	=> 3,'value' => 'Angola' , 'operator' => '=');
		
		$join2	=	'OR';
		$totalUser2	=	28;
		
		$conditions3[] = array('infoid'	=> 1,'value' => 'Female' , 'operator' => '=');
		$conditions3[] = array('infoid'	=> 12,'value' => '1' , 'operator' => '=');
		
		$join3	=	'AND';
		$totalUser3	=	0;
		return array(
			array($conditions1,$join1,$totalUser1),
			array($conditions2,$join2,$totalUser2),
			array($conditions3,$join3,$totalUser3)
		);
	}
	
	
	/**
	 * @dataProvider superadminResultProvider
	 */
	function testSuperAdminNotVisible($conditions,$join,$totalResultUserCount)
	{
		$url	= JPATH_ROOT.'/test/test/_data';
	    $this->_DBO->loadSql($url.'/insert.sql');	
		$this->_DBO->loadSql($url.'/updateCache.sql');
		
		$sqlPath = $this->getSqlPath().DS.__FUNCTION__.".start.sql";
		$this->_DBO->loadSql($sqlPath);

		$this->resetCachedData();
		
		$model = XiusFactory::getInstance('users','model');
		$strQuery= $model->getQuery($conditions,$join);
		
		$db = JFactory::getDBO();
		$db->setQuery((string)$strQuery);
		$users = $db->loadObjectList();
		
		$this->assertEquals($totalResultUserCount,count($users),'Total users should be '.$totalResultUserCount.' but we get '.count($users));
	}
	

	public static function superadminResultProvider()
	{
		$conditions1[] = array('infoid'	=> 11,'value' => 'Registered' , 'operator' => '=');
		
		$join1	=	'AND';
		$totalUser1	=	0;
		
		$conditions2[] = array('infoid'	=> 11,'value' => 'Super Administrator' , 'operator' => '=');
		$join2	=	'OR';
		$totalUser2	=	2;
		
		return array(
			array($conditions1,$join1,$totalUser1),
			array($conditions2,$join2,$totalUser2)
		);
	}
	

	/**
	 * @dataProvider multiForcedataProvider
	 */
	function testMultiValue($conditions,$join,$totalResultUserCount)
	{
		$url	= JPATH_ROOT.'/test/test/_data';
	    $this->_DBO->loadSql($url.'/insert.sql');	
		$this->_DBO->loadSql($url.'/updateCache.sql');
		
		$sqlPath = $this->getSqlPath().DS.__FUNCTION__.".start.sql";
		$this->_DBO->loadSql($sqlPath);

		$this->resetCachedData();
		
		$model = XiusFactory::getInstance('users','model');
		$strQuery= $model->getQuery($conditions,$join);
		
		$db = JFactory::getDBO();
		$db->setQuery((string)$strQuery);
		$users = $db->loadObjectList();
		
		$this->assertEquals($totalResultUserCount,count($users),'Total users should be '.$totalResultUserCount.' but we get '.count($users));
	}
	

	public static function multiForcedataProvider()
	{
		$conditions1[] = array('infoid'	=> 1,'value' => 'Female' , 'operator' => '=');
		$conditions1[] = array('infoid'	=> 3,'value' => 'Angola' , 'operator' => '=');
		
		$join1	=	'AND';
		$totalUser1	=	1;
		
		$conditions2[] = array('infoid'	=> 1,'value' => 'Female' , 'operator' => '=');
		$conditions2[] = array('infoid'	=> 3,'value' => 'Angola' , 'operator' => '=');
		
		$join2	=	'OR';
		$totalUser2	=	28;
		
		$conditions3[] = array('infoid'	=> 3,'value' => 'Angola' , 'operator' => '=');
		
		$join3	=	'OR';
		$totalUser3	=	1;
		
		$conditions4[] = array('infoid'	=> 1,'value' => 'Male' , 'operator' => '=');
		$conditions4[] = array('infoid'	=> 3,'value' => 'Angola' , 'operator' => '=');
		
		$join4	=	'OR';
		$totalUser4	=	1;
		
		$conditions5[] = array('infoid'	=> 1,'value' => 'Male' , 'operator' => '=');
		$conditions5[] = array('infoid'	=> 3,'value' => 'Angola' , 'operator' => '=');
		
		$join5	=	'AND';
		$totalUser5	=	0;
		
		$conditions6	=	'';
		
		$join6	=	'AND';
		$totalUser6	=	28;
		
		$conditions7[] = array('infoid'	=> 12,'value' => '1' , 'operator' => '=');
		
		$join7	=	'AND';
		$totalUser7	=	0;
		
		$conditions8[] = array('infoid'	=> 12,'value' => '0' , 'operator' => '=');
		
		$join8	=	'AND';
		$totalUser8	=	28;
		
		$conditions9[] = array('infoid'	=> 1,'value' => 'Male' , 'operator' => '=');
		$conditions9[] = array('infoid'	=> 3,'value' => 'Angola' , 'operator' => '=');
		$conditions9[] = array('infoid'	=> 1,'value' => 'Female' , 'operator' => '=');
		
		$join9	=	'AND';
		$totalUser9	=	0;
		
		return array(
			array($conditions1,$join1,$totalUser1),
			array($conditions2,$join2,$totalUser2),
			array($conditions3,$join3,$totalUser3),
			array($conditions4,$join4,$totalUser4),
			array($conditions5,$join5,$totalUser5),
			array($conditions6,$join6,$totalUser6),
			array($conditions7,$join7,$totalUser7),
			array($conditions8,$join8,$totalUser8),
			array($conditions9,$join9,$totalUser9),
		);
	}
}
