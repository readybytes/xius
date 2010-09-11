<?php

class XiussiteHelperUsersTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	
	function testSerializeUnserialize()
	{
		$data[]="'";
		$data[]='"';
		$data[]="<";
		$data[]=">";
		$data[]="&";
		$data[]='\\';
		$data[]="\\";
		
		$compare = "a:7:{i:0;s:1:&quot;&#039;&quot;;i:1;s:1:&quot;&quot;&quot;;i:2;s:1:&quot;&lt;&quot;;i:3;s:1:&quot;&gt;&quot;;i:4;s:1:&quot;&amp;&quot;;i:5;s:1:&quot;\&quot;;i:6;s:1:&quot;\&quot;;}";		
		$res= XiussiteHelperUsers::getSerializedData($data);
		$this->assertEquals($compare,$res);
		
		$res= XiussiteHelperUsers::getUnserializedData($res);
		$this->assertEquals($data,$res);
	}
	
}