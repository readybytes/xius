<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

function isComponentExist($comName,$bothReq=false)
{
	$frontcompath = JPATH_ROOT.DS.'components'.DS.$comName;
	$admincompath = JPATH_ADMINISTRATOR.DS.'components'.DS.$comName;
	
	if($bothReq) {
		if(JFolder::exists($frontcompath) && JFolder::exists($admincompath))
			return true;
		
		return false;
	}
	
	if(JFolder::exists($frontcompath) || JFolder::exists($admincompath))
		return true;
		
	return false;
}

