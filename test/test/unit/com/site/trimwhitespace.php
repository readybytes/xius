<?php

class XiuscleanWhiteSpaceUnitTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	/**
	 * @dataProvider conditionProvider
	 */
	function testTrimWhiteSpace($conditions,$join,$totalResultUserCount)
	{
		$sqlPath = $this->getSqlPath().DS."whiteSpaceRemove.start.sql";
		$this->_DBO->loadSql($sqlPath);

		$this->resetCachedData();
		$post		= XiusLibrariesUsersearch::processSearchData($conditions);
		XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,$post,'XIUS');
		XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,$join,'XIUS');
		
		require_once(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'views'.DS.'users'.DS.'view.html.php');
		XiussiteHelperResults::_getInitialData(&$data);
		XiussiteHelperResults::_getTotalUsers(&$data);		
		
		$this->assertEquals($data['total'],$totalResultUserCount);
	}
	
	public static function conditionProvider()
	{
		$conditions1 = array('xiusinfo_121'	=> 12,'value' => '    shyam@joomlaxi.com' ,'xiusinfo_122'	=> 12);
		$join1		 = 'OR';
		$totalUser1	 = 1;
		
		$conditions2 = array('xiusinfo_131'	=> 13,'value' =>"\r    user" ,'xiusinfo_132'	=> 13);
		$join2		 = 'OR';
		$totalUser2	 = 58;

		$conditions3 = array('xiusinfo_141'	=> 14,'value'=>" \n   09-02-1992" ,'xiusinfo_142'=> 14);
		$join3		 = 'AND';
		$totalUser3	 = 1;

		$conditions4 = array('xiusinfo_121'	=> 12,'value' => " \t     shyam@joomlaxi.com" ,'xiusinfo_122'	=> 12,'xiusinfo_141'	=> 14,'value'=>'     09-02-1992' ,'xiusinfo_142'=> 14);
		$join4		 = 'AND';
		$totalUser4	 = 0;
		
		$conditions5 = array('xiusinfo_111'=>11, 'Proximityinformation_userForm_option'=>'addressbox', 'Proximityinformation_userForm_address'=> ' \n     bhilwara', 'Proximityinformation_userForm_lat' => 28.635308, 'Proximityinformation_userForm_long' => 77.22496, 'Proximityinformation_userForm_dis' =>      50, 'Proximityinformation_userForm_dis_unit' => 'kms', 'xiusinfo_112'=>11);
		$join5		 = 'AND';
		$totalUser5	 = 5;
		
		return array(
			array($conditions1,$join1,$totalUser1),
			array($conditions2,$join2,$totalUser2),
			array($conditions3,$join3,$totalUser3),
			array($conditions4,$join4,$totalUser4),
			array($conditions5,$join5,$totalUser5)
			);
	}
	
	/**
	 * @dataProvider trimconditionProvider
	 */
	function testTrimArray($conditions,$join,$totalResultUserCount)
	{
		$sqlPath = $this->getSqlPath().DS."trimArray.start.sql";
		$this->_DBO->loadSql($sqlPath);

		$this->resetCachedData();
		$post		= XiusLibrariesUsersearch::processSearchData($conditions);
		XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,$post,'XIUS');
		XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,$join,'XIUS');
		
		require_once(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'views'.DS.'users'.DS.'view.html.php');
		XiussiteHelperResults::_getInitialData(&$data);
		XiussiteHelperResults::_getTotalUsers(&$data);		
		
		$this->assertEquals($data['total'],$totalResultUserCount);
	}
	
	public static function trimconditionProvider()
	{
		$conditions1 = array('xiusinfo_121'	=> 12,'value' => " \t \n \r    shyam@joomlaxi.com" ,'xiusinfo_122'	=> 12);
		$join1		 = 'OR';
		$totalUser1	 = 1;
		
		$conditions2 = array('xiusinfo_191'	=> 19,'value' => array(" \n Swimming"," \r Running","  Reading",'Teaching'," \t programming",'Chating','Surfing') ,'xiusinfo_192'	=> 19);
		$join2		 = 'OR';
		$totalUser2	 = 0;

		$conditions3 = array('xiusinfo_181'	=> 18,'value'=>array('Home','Car'," \n \r \t Bike  ",'Wif','Job') ,'xiusinfo_182'=> 18);
		$join3		 = 'AND';
		$totalUser3	 = 0;

		$conditions4 = array(
							'xiusinfo_191'=> 19,'value' =>array(" \t Swimming  ","  Running","     Reading"," Teaching     ","   programming",'Chating','Surfing') ,'xiusinfo_192'=> 19,
							'xiusinfo_181'=> 18,'value' =>array("\n Home",'Car','Bike,','Job') ,'xiusinfo_182'=> 18,
							'xiusinfo_171'=> 17,'value' =>array('Airtel','BSNL',"\r MTS",'Relience'), 'xiusinfo_172'=> 17
							);
		$join4		 = 'AND';
		$totalUser4	 = 0;
		
				
		return array(
			array($conditions1,$join1,$totalUser1),
			array($conditions2,$join2,$totalUser2),
			array($conditions3,$join3,$totalUser3),
			array($conditions4,$join4,$totalUser4),
			);
	}	
}
?>
