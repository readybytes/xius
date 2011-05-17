<?php

class XiusGroupMemberTest extends XiUnitTestCase {

	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	//Test:: get All Available Groups
	function testGetGroups()
	{
		for($i=0; $i<8;$i++)
			$groups[$i]= new stdClass();

		$groups[0]->id = 16;
		$groups[0]->name ='Lufange-Parinde';
		$groups[1]->id = 13;
		$groups[1]->name ='XiPT';
		$groups[2]->id = 14;
		$groups[2]->name ='Joomlaxi';
		$groups[3]->id = 15;
		$groups[3]->name ='XiEC';
		$groups[4]->id = 12;
		$groups[4]->name ='XiUS';
		$groups[5]->id = 9;
		$groups[5]->name ='Joomla_lover';
		$groups[6]->id = 10;
		$groups[6]->name ='RBSL Customer';
		$groups[7]->id = 11;
		$groups[7]->name ='RBSL';
		
		$resultGroups =  XiusFactory::getInstance('model')
       					 ->getGroups();

       	$this->assertEquals($resultGroups,$groups);    	
	}
	
	
	/**
	 *@dataProvider searchCondition
	 */
	function testSearchQuery($post,$join, $resultQuery)
	{
		$this->_DBO->loadSql($this->getSqlPath().DS.__FUNCTION__.'.start.sql');
		// Search Query
		$queryObj = XiusFactory::getInstance('users','model')
					->getQuery($post,$join);
		
		$strQuery = (string)$queryObj;
		$this->assertEquals($this->cleanWhiteSpaces($resultQuery), $this->cleanWhiteSpaces($strQuery));
	
	}
	
	function searchCondition() {
		
		$post0[] = Array('infoid'=>8,'value'=>16,'operator' => '=');
		$join0	 = 'OR';
		
	 	$resultQuery0 = "SELECT * FROM `#__xius_cache`
	 				 	 WHERE  `userid` IN (
	 						SELECT `memberid` FROM `#__community_groups_members`WHERE `groupid`=16)
	 						ORDER BY `userid` ASC";
	 	
				
		$post1[] = Array('infoid'=>	1,'value'=>'Male','operator' => '=');
		$post1[] = Array('infoid'=>8,'value'=>16,'operator' => '=');
		$post1[] = Array('infoid'=>	7,'value'=>'all available','operator' => '=');
		
		$join1	 = 'OR';
		
	 	$resultQuery1 = "SELECT * FROM `#__xius_cache`
	 				 	 WHERE `jsfields2_0` = 'Male' OR  `userid` IN (
	 						SELECT `memberid` FROM `#__community_groups_members`WHERE `groupid`=16)
	 						ORDER BY `userid` ASC";
	 	
	 		 	
	 	$post2   = array();
	 	$post2	 = $post1;
		$post2[] = Array('infoid'=>4,
					'value'=>array('googlemap','',25.346251,74.636383,100,'miles'),
					'operator' => '='
						);
	  // 	$post2[] = Array('infoid'=>	5,'value'=>"05-08-2011",'operator' => '=');
		$post2[] = Array('infoid'=>	6,'value'=>array(0,25),'operator' => '=');
						
		$resultQuery2 = "SELECT*,ROUND((3959*acos(cos(0.442375532987)*cos(radians(`jsuserlatitude_0`))*cos(radians(`jsuserlongitude_0`)-(1.30265062513))+sin(0.442375532987)*sin(radians(`jsuserlatitude_0`))))*1,3)ASxius_proximity_distance
						 FROM`#__xius_cache`
						 WHERE`jsfields2_0`='Male'AND
							  `userid` IN ( SELECT `memberid`
										  FROM`#__community_groups_members`
										  WHERE`groupid`=16) AND
							   ROUND((3959*acos(cos(0.442375532987)*cos(radians(`jsuserlatitude_0`))*cos(radians(`jsuserlongitude_0`)-(1.30265062513))+sin(0.442375532987)*sin(radians(`jsuserlatitude_0`) ) ) ) * 1,3)  <= 100  AND
							   `rangesearch5_0` BETWEEN '0' AND '25'
					   ORDER BY `userid` ASC";
		

		$join2	 = 'AND';
						
		return Array(
					Array($post1, $join1, $resultQuery1),
					Array($post1, $join1, $resultQuery1),
					Array($post2, $join2, $resultQuery2)
					);
	
	}
}