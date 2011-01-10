<?php

class XiusTemplatePath extends XiUnitTestCase
{

	// For this test-case must b default template selected
	//Clean this test-case
	function testDefaultViewPath()
	{
		$setPathArray = Array(
						    0 => '/templates/rhuk_milkyway/html/com_xius/xiusplugins/customtable/',
           					1 => '/components/com_xius/templates/default/xiusplugins/customtable/',
            				2 => '/components/com_xius/templates/default/xiusplugins/',
            				3 => '/components/com_xius/libraries/plugins/customtable/views/tmpl/',
            				4 => '/templates/rhuk_milkyway/html//customtable/',
            				5 => '/templates/rhuk_milkyway/html/com_xius/xiusplugins/customtable/',
            				6 => '/components/com_xius/templates/default/xiusplugins/customtable/',
            				7 => '/components/com_xius/templates/default/xiusplugins/',
            				8 => '/components/com_xius/libraries/plugins/customtable/views/tmpl/',
            				9 => '/components/com_xius/templates/default/',
            				10 =>'/components/com_xius/templates/default/customtable/',
            				11 => '/templates/rhuk_milkyway/html/com_xius/'
            				);
		
		require_once JPATH_ROOT.DS."components/com_xius/libraries/plugins/customtable/views/view.html.php";
		$obj = new CustomtableView();
		$getPathArray = $obj->get('_path');
		
		$i=0;
		foreach($getPathArray['template'] as $path)
		$this->assertEquals($getPathArray['template'][$i], JPATH_ROOT.$setPathArray[$i]);

	}
}
