<?php

class XiusCbuilderTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	function testGetAvailableInfoForCB()
	{
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . 'cbuilder' . DS . 'cbuilder.php';
		$cbinstance = new Cbuilder();
		
		$info = $cbinstance->getAvailableInfo();
		
		if(!XiusHelpersUtils::isComponentExist('com_comprofiler',true))
			$this->assertFalse($info);
		else {
		
			$requiredInfo = array();
			
			$requiredInfo[41] 	= 'name';
	    	$requiredInfo[26] 	= 'onlinestatus';
	    	$requiredInfo[27] 	= 'lastvisitDate';
		    $requiredInfo[28] 	= 'registerDate';
		    $requiredInfo[29] 	= 'avatar';
		    $requiredInfo[42] 	= 'username';
		    $requiredInfo[45] 	= 'formatname';
		    $requiredInfo[46]	= 'firstname';
		    $requiredInfo[47] 	= 'middlename';
		    $requiredInfo[48] 	= 'lastname';
		    $requiredInfo[49] 	= 'lastupdatedate';
		    $requiredInfo[50] 	= 'email';
		    $requiredInfo[25] 	= 'hits';
		    $requiredInfo[51] 	= 'password';
		    $requiredInfo[52] 	= 'params';
		    $requiredInfo[24] 	= 'connections';
		    $requiredInfo[23] 	= 'forumrank';
		    $requiredInfo[22] 	= 'forumposts';
		    $requiredInfo[21] 	= 'forumkarma';
		    $requiredInfo[54] 	= 'cb_trial';
		    $requiredInfo[55] 	= 'cb_trialdate';
	
			$this->assertEquals($requiredInfo,$info);
		}
	}
		
}
?>
