<?php

class xiusIntegrate extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	/**
	 * @dataProvider conditionResultProvider
	 */
	function testonSearch($searchWord ,$result )
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.DS.__FUNCTION__.'.start.sql');
		require_once JPATH_ROOT.DS.'plugins' . DS . 'search' . DS . 'xius.php';
		$dispatcher =  JDispatcher::getInstance();
		$plugin 	=  JPluginHelper::getPlugin('search','xius');
        // create the plugin
		$instance = new plgSearchxius($dispatcher, (array)($plugin));
		
        $users = $instance->onSearch($searchWord, $phrase = '', $ordering = '', $areas['xius'] = 'User' );
		$this->assertEquals( $result ,count($users),"Total result should be".$result." but we get".count($users));
	}
	
	function conditionResultProvider() 
	{
		$searchWord1 = 'user';
		$result1 = 5;
		
		$searchWord2 = 'Hello';
		$result2 = 2;
		
		$searchWord3 = 'Things';
		$result3 = 1;
		
		return array(
                   	 array($searchWord1,$result1),
					 array($searchWord2,$result2),
					 array($searchWord3,$result3)
					 );
	}
	
}