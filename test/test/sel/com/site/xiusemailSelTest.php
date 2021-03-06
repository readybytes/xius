<?php 

class XiusemailSelTest extends XiSelTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function setEmailSettings()
	{
		$filter['mailer'] 	= 'smtp';
		$filter['mailfrom'] = 'teamjoomlaxi@gmail.com';
		$filter['smtpauth'] = '1';
		$filter['smtpsecure'] = 'tls';
		$filter['smtpport'] = '465';
		$filter['smtpuser'] = 'teamjoomlaxi@gmail.com';
		$filter['smtppass'] = 'joomlaxireadybytes';
		$filter['smtphost'] = 'smtp.gmail.com';		
		$this->updateJoomlaConfig($filter);	
	}
	
	function testSendEmailToSingleUser()
	{		
		$this->setEmailSettings();
		$this->frontLogin();
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();
		// search without condition
		$this->click('xiussearch');
		$this->waitPageLoad();
		
		$this->assertTrue($this->isElementPresent("//a[@id='xius_email_button62']"));
		$this->assertTrue($this->isElementPresent("//a[@id='xius_emailselected_button']"));
		$this->assertTrue($this->isElementPresent("//a[@id='xius_emailall_button']"));
		$this->assertTrue($this->isElementPresent("//input[@id='xiusCheckUser0']"));
		
		$this->click("//a[@id='xius_email_button62']");
		sleep(2);
		$this->click("send");
    	$this->assertEquals("Subject can not be empty.", $this->getAlert());

    	$this->type("xiusEmailSubjectEl","Test Mail From Xius Email System");
    	$this->click("link=Toggle editor");    	
    	$this->type("xiusEmailMessageEl", "<p>Test Email</p>");
    	$this->click("link=Toggle editor");
    	//$this->getEval("document.getElementById('xiusEmailMessageEl').value='fsdfsdfsf'");
    	$this->click('send');
		$this->waitPageLoad();
    	    	
    	$this->assertTrue($this->isElementPresent("//span[@id='Email has been sent to following Users.']"));
    	$this->assertTrue($this->isElementPresent("//li[@id='Administrator']"));
	}
	
	function testSendEmailToSelectedUser()
	{
		$this->setEmailSettings();
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testSendEmailToSingleUser.start.sql');
		$this->frontLogin();
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();

		// search without condition
		$this->click('xiussearch');
		$this->waitPageLoad();
		
		$this->assertTrue($this->isElementPresent("//a[@id='xius_email_button62']"));
		$this->assertTrue($this->isElementPresent("//a[@id='xius_emailselected_button']"));
		$this->assertTrue($this->isElementPresent("//a[@id='xius_emailall_button']"));
		$this->assertTrue($this->isElementPresent("//input[@id='xiusCheckUser0']"));
		
		$this->click("//a[@id='xius_emailselected_button']");
		sleep(2);
		$this->assertTrue($this->isElementPresent("//span[@id='xiusErrorUserNotSelected']"));
    	$this->click('sbox-btn-close');
    	sleep(2);
    	$this->click("//input[@id='xiusCheckUser0']");
    	$this->click("//input[@id='xiusCheckUser1']");
    	$this->click("//a[@id='xius_emailselected_button']");
		sleep(2);
		
		$this->type("xiusEmailSubjectEl","Test Mail From Xius Email System");
    	$this->click("link=Toggle editor");
    	$this->type("xiusEmailMessageEl", "<p>Test Email</p>");
    	$this->click("link=Toggle editor");$this->click('send');
    	$this->waitPageLoad();
    	    	
    	$this->assertTrue($this->isElementPresent("//span[@id='Email has been sent to following Users.']"));
    	$this->assertTrue($this->isElementPresent("//li[@id='Administrator']"));
    	$this->assertTrue($this->isElementPresent("//li[@id='name64']"));
    	
    	
    	// make diffrence b/t two selection
    	$this->click('sbox-btn-close');
    	sleep(2);
    	$this->click("//input[@id='xiusCheckUser7']");
    	$this->click("//input[@id='xiusCheckUser19']");
    	$this->click("//a[@id='xius_emailselected_button']");
		sleep(2);
		
		$this->type("xiusEmailSubjectEl","Test Mail From Xius Email System");
    	$this->click("link=Toggle editor");
    	$this->type("xiusEmailMessageEl", "<p>Test Email</p>");
    	$this->click("link=Toggle editor");$this->click('send');
    	$this->waitPageLoad();
    	    	
    	$this->assertTrue($this->isElementPresent("//span[@id='Email has been sent to following Users.']"));
    	$this->assertTrue($this->isElementPresent("//li[@id='name70']"));
    	$this->assertTrue($this->isElementPresent("//li[@id='name82']"));
	}
	
	function testXiusEmailToAll()
	{		
		$this->setEmailSettings();
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/'.__CLASS__.'/testSendEmailToSingleUser.start.sql');
		$this->frontLogin();
		
		// email = manish@readybytes.in and city = bhilwara 
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();

		// search without condition
		$this->type("//input[@id='Joomla_21']", "manish@readybytes.in");
		$this->type("//input[@id='field11']", "Bhilwara");
		$this->select("xiusjoin", "label=All");
		$this->click('xiussearch');
		$this->waitPageLoad();
		
		$this->assertTrue($this->isElementPresent("//a[@id='xius_email_button62']"));
		$this->assertTrue($this->isElementPresent("//a[@id='xius_emailselected_button']"));
		$this->assertTrue($this->isElementPresent("//a[@id='xius_emailall_button']"));
		$this->assertTrue($this->isElementPresent("//input[@id='xiusCheckUser0']"));
		
		$this->click("//a[@id='xius_emailall_button']");
		sleep(2);
		
		$this->type("xiusEmailSubjectEl","Test Mail From Xius Email System");
    	$this->click("link=Toggle editor");
    	sleep(2);
    	$this->type("xiusEmailMessageEl", "<p>Test Email</p>");
    	$this->click("link=Toggle editor");$this->click('send');
    	$this->waitPageLoad();
    	    	
    	$this->assertTrue($this->isElementPresent("//span[@id='Email has been sent to following Users.']"));
    	$this->assertTrue($this->isElementPresent("//li[@id='Administrator']"));
    	
    	// email = manish@readybytes.in OR gaurav@readybytes.in 
		$this->open(JOOMLA_LOCATION.'/index.php?option=com_xius');
		$this->waitPageLoad();

		// search without condition
		$this->type("//input[@id='Joomla_21']", "manish@readybytes.in");
		$this->select("xiusjoin", "label=Any");
		$this->click('xiussearch');
		$this->waitPageLoad();
		$this->type("//input[@id='Joomla_21']", "gaurav@readybytes.in");
		$this->click("//img[@class='xius_test_addinfo_21']");
		$this->waitPageLoad();
		
		$this->assertTrue($this->isElementPresent("//a[@id='xius_email_button62']"));
		$this->assertTrue($this->isElementPresent("//a[@id='xius_email_button63']"));
		$this->assertTrue($this->isElementPresent("//a[@id='xius_emailselected_button']"));
		$this->assertTrue($this->isElementPresent("//a[@id='xius_emailall_button']"));
		$this->assertTrue($this->isElementPresent("//input[@id='xiusCheckUser0']"));
		$this->assertTrue($this->isElementPresent("//input[@id='xiusCheckUser1']"));
		
		$this->click("//a[@id='xius_emailall_button']");
		sleep(2);
		
		$this->type("xiusEmailSubjectEl","Test Mail From Xius Email System");
    	$this->click("link=Toggle editor");
    	sleep(2);
    	$this->type("xiusEmailMessageEl", "<p>Test Email</p>");
    	$this->click("link=Toggle editor");$this->click('send');
		$this->waitPageLoad();
    	    	
    	$this->assertTrue($this->isElementPresent("//span[@id='Email has been sent to following Users.']"));
    	$this->assertTrue($this->isElementPresent("//li[@id='Administrator']"));
       	$this->assertTrue($this->isElementPresent("//li[@id='name64']"));
	}
}
