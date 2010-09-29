<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class UserSearchHelper
{				
	function getSearchHtml($range )
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
				$counter=1;
				foreach($allInfo as $info){
					
					if (is_array($range))
						if(!($counter >= $range['start'] 
								&& $counter <= $range['end'])){
							$counter++;
							continue;
						}
						
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
						
					$counter++;		
					$infohtml[]		= 	array('infoid' => $info->id , 'info' => $info , 'label' => $info->labelName , 'html' => $inputHtml, 'tooltip' => $plgInstance->getTooltip());
					}
			}
		return $infohtml;		
	}
	
	function getInfoRange( $infoRange)
	{
		if( 'all' === strtolower($infoRange) )
			$range = $infoRange;
		else {		
			$range = array();
			$infoRange=explode('-',$infoRange);
			if( array_key_exists(0,$infoRange) && !empty($infoRange[0]))
				$range['start'] = $infoRange[0];
			else
				$range['start'] = 0;
		
			if( array_key_exists(1,$infoRange) && !empty($infoRange[1]))
				$range['end'] = $infoRange[1];
			else
				$range['end'] = 0;
		}	
		return $range;
	}
}
