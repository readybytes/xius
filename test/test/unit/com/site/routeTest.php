<?php

class RouterUnitTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	function setUp()
	{
		$filter['sef'] = 1;
    	$filter['sef_suffix'] = 1;
    	$this->updateJoomlaConfig($filter);
		parent::setUp();
	}

	function getURLs()
	{
		static $url = null;

		if($url !== null)
			return $url;

		$url =
		array(
		/*with item id*/
		"index.php?option=com_xius&view=users&layout=lists&task=displayList&listid=2&Itemid=57"
			=> "/usr/bin/index.php/xiuslist-reg.html",
		"index.php?option=com_xius&view=users&layout=lists&task=displayList&listid=1&Itemid=56"
			=> "/usr/bin/index.php/xiuslist-males.html",
		"index.php?option=com_xius&view=users&layout=results&Itemid=55"
			=> "/usr/bin/index.php/xiusresults.html",
		"index.php?option=com_xius&view=users&Itemid=54"
			=> "/usr/bin/index.php/xiussearch.html",

		/*without item id*/
		"index.php?option=com_xius&view=users&layout=lists&task=displayList&listid=2"
			=> "/usr/bin/index.php/xiuslist-reg.html",
		"index.php?option=com_xius&view=users&layout=lists&task=displayList&listid=1"
			=> "/usr/bin/index.php/xiuslist-males.html",
		"index.php?option=com_xius&view=users&layout=results"
			=> "/usr/bin/index.php/xiusresults.html",
		"index.php?option=com_xius&view=users"
			=> "/usr/bin/index.php/xiussearch.html",

		/* preserve extra vars*/
		"index.php?option=com_xius&view=users&layout=lists&task=displayList&listid=2&shyam=1"
			=> "/usr/bin/index.php/xiuslist-reg.html?shyam=1",
			
		"index.php?option=com_xius&view=users&layout=lists&task=displayList"
			=>"/usr/bin/index.php/xiuslist-males.html",
		"index.php?option=com_xius&task=displayList"
			=>"/usr/bin/index.php/xiuslist-males.html",
		"index.php?option=com_xius&view=users&task=displayList&listid=2"
			=>"/usr/bin/index.php/xiuslist-reg.html",
		"index.php?option=com_xius"
			=>"/usr/bin/index.php/xiussearch.html",
		"index.php?option=com_xius&view=users&layout=lists&task=displayList"
			=>"/usr/bin/index.php/xiuslist-reg.html",
		);

		return $url;
	}
	
	function testRoute()
	{
		$urls = $this->getURLs();
		foreach($urls as $url => $seoUrl)
			$this->assertEquals(JRoute::_($url,false),$seoUrl);
			
		$filter['sef'] = 0;
    	$filter['sef_suffix'] = 0;
    	$this->updateJoomlaConfig($filter);
	}

	function getSEOURLs()
	{
		static $url = null;

		if($url !== null)
			return $url;

		$url =
		array(
		/*with item id*/
		"/usr/bin/index.php/xiuslist-reg.html"
			=> array(
				"Itemid" => 57,
				"option" => "com_xius",
				"view" 	 => "users",
				"layout" => "lists",
				"task" 	 => "displayList",
				"listid" => 2
				),
		"/usr/bin/index.php/xiuslist-males.html"
			=> array(
				"Itemid" => 56,
				"option" => "com_xius",
				"view" 	 => "users",
				"layout" => "lists",
				"task" 	 => "displayList",
				"listid" => 1
				),
		"/usr/bin/index.php/xiusresults.html"
			=> array(
				"Itemid" => 55,
				"option" => "com_xius",
				"view" 	 => "users",
				"layout" => "results"
				),
		"/usr/bin/index.php/xiussearch.html"
			=> array(
				"Itemid" => 54,
				"option" => "com_xius",
				"view" 	 => "users"
				)
		);

		return $url;
	}

	function testParse()
	{
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/RouterUnitTest/testRoute.start.sql');
		$urls = $this->getSEOURLs();
		foreach($urls as $url => $data)
		{
			$uri = new JURI($url);
			$output = JFactory::getApplication()->getRouter()->parse($uri);
			foreach($data as $key=> $value)
				$this->assertEquals($value, @$output[$key], " Parsing this $url => Output is ". var_export($output,true). " Expected was :".var_export($data, true));
		}
		
		$filter['sef'] = 0;
    	$filter['sef_suffix'] = 0;
    	$this->updateJoomlaConfig($filter);
	}


	function xtestRouteWithoutMenu()
	{
		$urls = $this->getURLsWithoutMenu();
		foreach($urls as $url => $seoUrl)
			$this->assertEquals(JRoute::_($url,false),$seoUrl);
			
		$filter['sef'] = 0;
    	$filter['sef_suffix'] = 0;
    	$this->updateJoomlaConfig($filter);
	}
	
	function getURLsWithoutMenu()
	{
		static $url = null;

		if($url !== null)
			return $url;

		$url =
		array(
		/*with item id*/
		"index.php?option=com_xius&view=users&layout=lists&task=displayList&listid=2&Itemid=57"
			=> "/usr/bin/index.php/component/xius/?view=users&layout=lists&task=displayList&listid=2",
		"index.php?option=com_xius&view=users&layout=lists&task=displayList&listid=1&Itemid=56"
			=> "/usr/bin/index.php/component/xius/?view=users&layout=lists&task=displayList&listid=1",
		"index.php?option=com_xius&view=users&layout=results&Itemid=55"
			=> "/usr/bin/index.php/component/xius/?view=users&layout=results",
		"index.php?option=com_xius&view=users&Itemid=54"
			=> "/usr/bin/index.php/component/xius/?view=users",

		/*without item id*/
		"index.php?option=com_xius&view=users&layout=lists&task=displayList&listid=2"
			=> "/usr/bin/index.php/component/xius/?view=users&layout=lists&task=displayList&listid=2",
		"index.php?option=com_xius&view=users&layout=lists&task=displayList&listid=1"
			=> "/usr/bin/index.php/component/xius/?view=users&layout=lists&task=displayList&listid=1",
		"index.php?option=com_xius&view=users&layout=results"
			=> "/usr/bin/index.php/component/xius/?view=users&layout=results",
		"index.php?option=com_xius&view=users"
			=> "/usr/bin/index.php/component/xius/?view=users",

		/* preserve extra vars*/
		"index.php?option=com_xius&view=users&layout=lists&task=displayList&listid=2&shyam=1"
			=> "/usr/bin/index.php/component/xius/?view=users&layout=lists&task=displayList&listid=2&shyam=1"
		);

		return $url;
	}

}