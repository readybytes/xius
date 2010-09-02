<?php

function _GetXiusMenus()
{
	static $menus = null;

	if($menus !==null)
		return $menus;

	$dbo = JFactory::getDBO();
	$dbo->setQuery(  " SELECT `id` "
					." FROM `#__components` "
					." WHERE `option`='com_xius' AND `parent`=0"
				);
	$xiusCmpId 	= $dbo->loadResult();
	$menu 		= &JSite::getMenu();
	$menus 		= $menu->getItems('componentid',$xiusCmpId);

	return $menus;
}

function _getXiusUrlVars()
{
	return array('view','task','layout','supplytask','subtask','listid');
}

function _findXiusMatchCount($menu, $query)
{
	$vars = _getXiusUrlVars();
	$count = 0;
	foreach($vars as $var)
	{
		//variable not requested
		if(!isset($query[$var]))
			continue;

		//variable not exist in menu
		if(!isset($menu[$var]))
			continue;

		//exist but do not match
		if($menu[$var] !== $query[$var])
			continue;

		$count++;
	}
	return $count++;
}

//XITODO : handle list id

function XiusBuildRoute( &$query )
{
	$segments = array();
	$menus = _GetXiusMenus();

	//If item id is not set then we need to extract those
	$selMenu = null;
	if (!isset($query['Itemid']) && $menus)
	{
		$count 		= 0;
		$selMenu 	= $menus[0];

		foreach($menus as $menu){
			//count matching
			$matching = _findXiusMatchCount($menu->query,$query);

			if($count >= $matching)
				continue;

			//current menu matches more
			$count		= $matching;
			$selMenu 	= $menu;
		}

		//assig ItemID of selected menu
		$query['Itemid'] = $selMenu->id;
	}

	if (!isset($query['Itemid']))
		return $segments;
	//finally selected menu is
	$selMenu = JSite::getMenu()->getItem($query['Itemid']);

	//remove not-required variables, which can be calculated from URL itself
	$vars = _getXiusUrlVars();
	foreach($vars as $var)
	{
		//variable not requested
		if(!isset($query[$var]))
			continue;

		//variable not exist in menu
		if(!isset($selMenu->query[$var]))
			continue;

		//exist but do not match
		if($selMenu->query[$var] === $query[$var])
			unset($query[$var]);
	}

	return $segments;
}

/**
 * @param	array	A named array
 * @param	array
 *
 * Formats:
 */
function XiusParseRoute( $segments )
{
	$myVars = _getXiusUrlVars();
	$vars = array();

	foreach($myVars as $v)
	{
		$reqVar = JRequest::getVar($v, null);
		if($reqVar===null)
			continue;

		$vars[$v] = $reqVar;
	}

	return $vars;
}