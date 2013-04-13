<?php

class XiusFrontSelTemplateTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function testPluginTemplateOverride()
	{
		return;
		jimport('joomla.filesystem.file');
        $templateDir = XIUS_PATH_TEMPLATE.DS.'default'.DS.'xiusplugins';
		system("sudo chmod 777 $templateDir");
		system("mkdir ".$templateDir.DS.'joomla');
		system("mkdir ".$templateDir.DS.'joomla'.DS.'search.php');
	}
}