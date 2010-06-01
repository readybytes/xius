<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

class UserSearchHelper
{				
	function getSearchHtml()
	{
		$filter = array();
		$filter['published'] = true;
		
		$count = XiusHelpersUtils::getDisplayInformationCount();
		
		if($count === XIUS_ALL || $count === 0)
			$allInfo = XiusLibrariesInfo::getInfo($filter,'AND',false);
		else
			$allInfo = XiusLibrariesInfo::getInfo($filter,'AND',true,0,$count);
			
			$infohtml = array();
			if(!empty($allInfo)){
				foreach($allInfo as $info){
					$plgInstance = XiusFactory::getPluginInstanceFromId($info->id);

					if(!$plgInstance)
						continue;

					if(!$plgInstance->isAllRequirementSatisfy())
						continue;

					if(!$plgInstance->isSearchable())
						continue;

					$inputHtml = $plgInstance->renderSearchableHtml();
						
					if($inputHtml === false)
						continue;
							
					$infohtml[]		= 	array('infoid' => $info->id , 'info' => $info , 'label' => $info->labelName , 'html' => $inputHtml);
					}
			}
		return $infohtml;		
	}
	
	function getInfoRange($infoRange)
	{
		$infoRange=explode('-',$infoRange);
		if( array_key_exists(0,$infoRange) && !empty($infoRange[0]))
			$range['start'] = $infoRange[0];
		else
			$range['start'] = 0;
		
		if( array_key_exists(1,$infoRange) && !empty($infoRange[1]))
				$range['end'] = $infoRange[1];
		else
				$range['end'] = 0;
				
		return $range;
	}
}
