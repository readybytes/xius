<?php

class XiusListTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	
	function testSaveList()
	{
		$this->_DBO->addTable('#__xius_list');
		$this->_DBO->filterColumn('#__xius_list','params');
		$this->_DBO->filterColumn('#__xius_list','ordering');
		
		/*$sqlPath = $this->getSqlPath().DS.__FUNCTION__.".start.sql";
		$this->_DBO->loadSql($sqlPath);*/
		
		$url = dirname(__FILE__).'/_data/insert.sql';
		$this->_DBO->loadSql($url);

		$this->frontLogin('admin','ssv445');
		
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius&view=users&task=displayList&listid=1');
    	
		$this->select("field2", "label=Female");
   		$this->click("//img[@alt='Add']");
    	$this->waitPageLoad();
    	$this->click("1");
    	$this->waitPageLoad();
    
		$this->click("//img[@title='Save']");
		for ($second = 0; ; $second++) {
	        if ($second >= 60) 
	        	$this->fail("timeout");
	        	
            if ($this->isElementPresent("//form[@id='saveListForm']/div/div[1]/h3")) 
            	break;
        	
       		sleep(1);
    	}

	    for ($second = 0; ; $second++) {
	       if ($second >= 60) 
	        	$this->fail("timeout");
	        	
            if ($this->isElementPresent("//form[@id='saveListForm']/div/div[2]/h3")) 
            	break;
        	
       		sleep(1);
	    }
	    
	
        $this->assertEquals("1", $this->getValue("listid"));
    
        $this->assertEquals("1", $this->getValue("//input[@name='listid' and @value='1']"));
        $this->assertEquals("off", $this->getValue("//input[@name='listid' and @value='2']"));
        
	    $this->type("xius_list_name", "Female From Afghanistan");
    	$this->type("xius_list_desc", "All Female from afghanistan");
    	$this->click("xiussavenew");
    	
    	
		for ($second = 0; $second <= 60 ; $second++)
       		sleep(1);
    	
    	
    	//$this->waitPageLoad();
    	
	  	//$this->click("//input[@value='close']");
  
	  	//$this->selectWindow($this->getCurrentWindow());
	  	
	  	
    	/*for ($second = 0; ; $second++) {
        	if ($second >= 120)
        		$this->fail("timeout");
       
            if ($this->isTextPresent("Female From Afghanistan")) 
            	break;
       
       		sleep(1);
    	}
    	
        $this->assertTrue($this->isTextPresent("Female From Afghanistan"));*/
        	
	}
	
	
}