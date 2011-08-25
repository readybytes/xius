<?php

class XiusInfoTest extends XiUnitTestCase
{
	
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	/**
	 * @dataProvider getInfoWithFilterProvider
	 */
	public function testGetInfoWithFilter($filter,$join,$reqPagination,$limitStart,$limit,$result)
	{
		$sqlPath = $this->getSqlPath().DS.__FUNCTION__.".start.sql";
		$this->_DBO->loadSql($sqlPath);
		$resultInfo = XiusLibInfo::getInfo($filter,$join,$reqPagination,$limitStart,$limit);
		
		foreach($resultInfo as $r){
			$rArray[0] = (array) $r;
			$diffArray = array_diff($rArray,$result);
			$this->assertTrue((count($diffArray) == 0));
		}
	}
	
	
	public static function getInfoWithFilterProvider()
	{
		/*result will be info id or false */
		$filter1 = array('published' => 1);
		$join1 = 'AND';
		$reqPagination1 = false;
		$limitStart1 = 0;
		$limit1 = 0;
		$result1[] = array('id' => '1','labelName' => 'Gender' , 'params' => '' , 'key' => '2' , 'pluginParams' => '','pluginType' => 'Jsfields' , 'ordering' => '1' , 'published' => '1');
		$result1[] = array('id' => '3','labelName' => 'Country' , 'params' => '' , 'key' => '12' , 'pluginParams' => '','pluginType' => 'Jsfields' , 'ordering' => '3' , 'published' => '1');
		
		$filter2 = array('id' => 2);
		$join2 = 'AND';
		$reqPagination2 = false;
		$limitStart2 = 0;
		$limit2 = 0;
		$result2[] = array('id' => '2','labelName' => 'City' , 'params' => '' , 'key' => '11' , 'pluginParams' => '','pluginType' => 'Jsfields' , 'ordering' => '2' , 'published' => '0');
		
		$filter3 = array('published' => 1);
		$join3 = 'AND';
		$reqPagination3 = true;
		$limitStart3 = 0;
		$limit3 = 1;
		$result3[] = array('id' => '1','labelName' => 'Gender' , 'params' => '' , 'key' => '2' , 'pluginParams' => '','pluginType' => 'Jsfields' , 'ordering' => '1' , 'published' => '1');
		
		return array(
			array($filter1,$join1,$reqPagination1,$limitStart1,$limit1,$result1),
			array($filter2,$join2,$reqPagination2,$limitStart2,$limit3,$result2),
			array($filter3,$join3,$reqPagination3,$limitStart3,$limit3,$result3)
		);
	}
	
	
	/**
	 * @dataProvider infoexistProvider
	 */
	public function testInfoExist($data,$result)
	{
		$sqlPath = $this->getSqlPath().DS.__FUNCTION__.".start.sql";
		$this->_DBO->loadSql($sqlPath);
		
		$infoResult = XiusModel::isIdExist('info',$data);
        $this->assertEquals(is_bool($result),$infoResult,"result should be $result but we get $infoResult");
	}
	
	
	public static function infoexistProvider()
	{
		/*result will be info id or false */
		$data1 = array('key' => 2 , 'pluginType' => 'Jsfields');
		$result1 = true;
		
		$data2 = array('key' => 'registerDate' , 'pluginType' => 'Joomla');
		$result2 = true;
		
		$data3 = array('key' => 'block' , 'pluginType' => 'Joomla');
		$result3 = false;
		
		$data4 = array('key' => 9 , 'pluginType' => 'Jsfields');
		$result4 = false;
		
		return array(
			array($data1,$result1),
			array($data2,$result2),
			array($data3,$result3),
			array($data4,$result4)
		);
	}
	
}
