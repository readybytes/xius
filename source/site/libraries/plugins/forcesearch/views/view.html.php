<?php

// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class ForcesearchView extends XiusBaseView 
{
	
	function __construct()
	{
		parent::__construct(__FILE__);
	}
	
	function searchHtml($calleObject,$value='')
	{
		return false;
	}
	
	function rawDataHtml(XiusBase $calleObject)
	{
		if(!$calleObject->isAllRequirementSatisfy())
			return false;
			
		$this->setLayout('rawdata');
		
		/*In $this->key , I will store field id for my understanding
		 * so i can easily get properties of info
		 */
		
		$info = $calleObject->getAvailableInfo();
		/*unset already exist info */
		$availableInfo = XiusLibrariesInfo::getInfo();
		//$calleObject->removeExistingInfo($info,$availableInfo);
		
		$this->assign('info',$info);
		ob_start();
		$this->display();
		$contents = ob_get_clean();
		return $contents;
	}
}