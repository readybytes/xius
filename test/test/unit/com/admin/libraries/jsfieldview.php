<?php

class XiusJsfieldViewTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	function testViewObject()
	{
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . 'jsfields' . DS . 'views' . DS . 'view.html.php';
		$viewClass = new JsFieldsView();
		
		//echo "layout = ".$viewClass->getLayout()." template = ".$viewClass->_template;
		$this->assertEquals('search',$viewClass->getLayout(),"layout is not search , we get ".$viewClass->getLayout());
		
		$requiredTemplatePath = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries'.DS.'plugins'.DS.'jsfields'.DS.'views'.DS.'tmpl'.DS;
		//$this->assertContains($requiredTemplatePath,$viewClass->_path['template'],"template is not equal , we get ".var_export($viewClass->_path['template']));
	}
	
	function testSearchHtml()
	{
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . 'jsfields' . DS . 'jsfields.php';
		$instance = new JsFields();
		$instance->load(2);
		require_once JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius'.DS.'libraries' . DS . 'plugins' . DS . 'jsfields' . DS . 'views' . DS . 'view.html.php';
		$viewClass = new JsFieldsView();
		echo $viewClass->searchHtml($instance);
	}
	
}
?>
