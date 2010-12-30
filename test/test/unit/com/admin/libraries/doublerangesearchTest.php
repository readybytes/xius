<?php
class XiusDoubleRangesearchUnitTest extends XiUnitTestCase
{
	public $post= array();
	
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	
	/**
	 * @dataProvider conditionResultProvider
	 */
	function testDoubleRangesearch($conditions,$join,$totalResultUserCount)
	{
		$url	= dirname(__FILE__).'/sql/'.__CLASS__.'/testDoubleRangesearch.start.sql';
		$this->_DBO->loadSql($url);
						
		$this->resetCachedData();

		$query		= XiusLibUsersearch::buildQuery($conditions,$join);
		$strQuery	= $query->__toString();

		$db = JFactory::getDBO();
		$db->setQuery($strQuery);
		$users = $db->loadObjectList();		
		
		$this->assertEquals($totalResultUserCount,count($users),'Total users should be '.$totalResultUserCount.' but we get '.count($users));
	}
	

	public static function conditionResultProvider()
	{
				
		$conditions1[] = array('infoid'	=> 1,'value' => 'Male','operator' => '=');
		$conditions1[] = array('infoid'	=> 6,'value'=>array(0 => 11 , 1 => 25) ,'operator' => '=');
					
		$join1	=	'OR';
		$totalUser1	=	52;
		
		$conditions2   = $conditions1;
		$conditions2[] = array('infoid'	=> 8,'value'=>array(0 => 10, 1 => 12 ) ,'operator' => '=');

		$join2		  =	'OR';
		$totalUser2	  =	 53;
		
		$conditions3[]=$conditions2[1];
		$conditions3[]=$conditions2[2];
		
		$join3		  =	'AND';
		$totalUser3	  =	 20;
		
		$conditions4[]=$conditions2[2];

		
		$join4		  =	'AND';
		$totalUser4	  =	 21;
		 
		
		return array(
			array($conditions1,$join1,$totalUser1),
			array($conditions2,$join2,$totalUser2),
			array($conditions2, 'AND', 14),
			array($conditions3,$join3,$totalUser3),
			array($conditions4,$join4,$totalUser4)
			);
	}
	
}
