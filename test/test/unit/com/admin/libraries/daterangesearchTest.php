<?php
class XiusDateRangesearchUnitTest extends XiUnitTestCase
{
	public $post= array();
	
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	
	/**
	 * @dataProvider conditionResultProvider
	 */
	function testDateRangesearch($conditions,$join,$totalResultUserCount)
	{
		$url	= dirname(__FILE__).'/sql/'.__CLASS__.'/testDateRangesearch.start.sql';
		$this->_DBO->loadSql($url);
						
		$this->resetCachedData();

		$model = XiusFactory::getInstance('users','model');
		$strQuery= $model->getQuery($conditions,$join);

		$db = JFactory::getDBO();
		$db->setQuery((string)$strQuery);
		$users = $db->loadObjectList();		
		
		$this->assertEquals($totalResultUserCount,count($users),'Total users should be '.$totalResultUserCount.' but we get '.count($users));
	}
	

	public static function conditionResultProvider()
	{
				
		$conditions1[] = array('infoid'	=> 1,'value' => 'Male','operator' => '=');
		$conditions1[] = array('infoid'	=> 6,'value'=>array(0 => 11 , 1 => 25) ,'operator' => '=');
		$conditions1[] = array('infoid'	=> 8,'value'=>array(0 => 40 , 1 => 65) ,'operator' => '=');
			
		$join1	=	'OR';
		$totalUser1	=	55;
		
		$conditions2   = $conditions1;
		$conditions2[] = array('infoid'	=> 9,'value'=>array(0 => '01-08-2010', 1 => '01-08-2009' ) ,'operator' => '=');

		$join2		  =	'OR';
		$totalUser2	  =	 59;
		
		$conditions3[]=$conditions2[1];
		$conditions3[]=$conditions2[2];
		$conditions3[]=$conditions2[3];
		
		$join3		  =	'AND';
		$totalUser3	  =	 1;
		
		$conditions4[]=$conditions2[2];
		$conditions4[]=$conditions2[3];
		
		$join4		  =	'AND';
		$totalUser4	  =	 4;
		 
		
		return array(
			array($conditions1,$join1,$totalUser1),
			array($conditions2,$join2,$totalUser2),
			array($conditions2, 'AND', 0),
			array($conditions3,$join3,$totalUser3),
			array($conditions4,$join4,$totalUser4)
			);
	}
	
}
