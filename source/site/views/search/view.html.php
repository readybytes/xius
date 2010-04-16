<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiusViewSearch extends JView 
{
	function showsearchpanel($allInfo)
	{
		$infohtml = array();
		if(!empty($allInfo)){
			$count = 0;
			foreach($allInfo as $info){
				$plgInstance = XiusFactory::getPluginInstanceFromId($info->id);
				//if($plgInstance->isSearchable())
				if($plgInstance->isAllRequirementSatisfy()){
					$inputHtml = $plgInstance->renderSearchableHtml();
					
					if($inputHtml === false)
						continue;
						
					$infohtml[$count]['infoid'] = $info->id;
					$infohtml[$count]['info'] = $info;
					$infohtml[$count]['label'] = $info->labelName;
					/*
					 *replace name and id in input html 
					 */
					
					
					$infohtml[$count]['html'] = $inputHtml;
					
					$count++;
				}
			}
		}
		
		$this->assign( 'infohtml' , $infohtml );
		parent::display();
	}
	
	function _replaceText($serachStr,$replaceStr,&$string)
	{
		
	}
}
?>