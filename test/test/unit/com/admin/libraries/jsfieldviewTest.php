<?php

class XiusJsfieldViewTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}

	function testJsfViewObject()
	{
		require_once  XIUS_PLUGINS_PATH . DS . 'jsfields' . DS . 'views' . DS . 'view.html.php';
		$viewClass = new JsfieldsView();
		$this->assertEquals($viewClass->getLayout(),'default',"layout is not search , we get ".$viewClass->getLayout());
		$requiredTemplatePath[0] = XIUS_PLUGINS_PATH.DS.'jsfields'.DS.'views'.DS.'tmpl' . DS;
	    $view=$viewClass->get('_path');
		$diffArray = array_diff($requiredTemplatePath,$view['template']);
		$this->assertTrue((count($diffArray) == 0));
	}
	
	function testJsfSearchHtml()
	{
		require_once  XIUS_PLUGINS_PATH . DS . 'jsfields' . DS . 'jsfields.php';
		$instance = new Jsfields();
		$instance->load(2);
		require_once  XIUS_PLUGINS_PATH . DS . 'jsfields' . DS . 'views' . DS . 'view.html.php';
		$viewClass = new JsfieldsView();
		$searchHtml =  $viewClass->searchHtml($instance);
		
		$result = '<inputtitle="City/Town"type="text"value=""id="field11"name="field11"maxlength="100"size="40"class="jomNameTipstipRightinputboxrequiredjomNameTipstipRight"style=""/>
		           <spanid="errfield11msg"style="display:none;">&nbsp;</span>';
				
		$this->assertEquals($this->cleanWhiteSpaces($result),$this->cleanWhiteSpaces($searchHtml));
	}
	
}
?>
