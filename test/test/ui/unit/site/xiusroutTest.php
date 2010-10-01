<?php
class XiusRouteTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function setUp()
	{
	
	parent::setUp();
  	$filter['sef'] = 0;
    $filter['sef_suffix'] = 0;
    $this->updateJoomlaConfig($filter);
  	}
  	
  	function getPanelUrl() {
  		$urls=Array('index.php?option=com_xius' => '/index.php?option=com_xius',
  					'index.php?option=com_xius&Itemid=54' => '/usr/bin/index.php?option=com_xius&view=users&Itemid=54',
  					'index.php?option=com_xius&Itemid=54&task=search' => '/usr/bin/index.php?option=com_xius&Itemid=54&task=search'
  					);
  		return $urls;
  	}
  	
  	function getListUrl(){
  		$urls=Array('index.php?option=com_xius&view=list&task=showList' => '/usr/bin/index.php?option=com_xius&view=list&task=showList',
  					'index.php?option=com_xius&view=list&task=showList&Itemid=54' => '/usr/bin/index.php?option=com_xius&view=list&task=showList&Itemid=54',
  					'index.php?option=com_xius&view=list&task=showList&Itemid=54&listid=7' =>'/usr/bin/index.php?option=com_xius&view=list&task=showList&Itemid=54&listid=7'
  					);
  		return $urls;
  		
  	}
  	
  	
  	function xtestPanelRoute()
  	{
  		$urls=$this->getPanelUrl();
  		foreach($urls as $url => $seoUrl)
			$this->assertEquals($seoUrl,XiusRoute::_($url,false));
  	}
  	
  	
	function testListRoute()
  	{
  		$urls=$this->getListUrl();
  		foreach($urls as $url => $seoUrl)
  				$this->assertEquals($seoUrl,XiusRoute::_($url,false));
  	}
  	
}