<?php

// include files specific to our components
$comPath = JPATH_ROOT.DS.'components'.DS.'com_xius';
$comAdminPath = JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius';

if(JFolder::exists($comPath))
{
	require_once $comAdminPath.DS.'includes.php';
	require_once $comPath.DS.'includes.php';

	if(!defined('JPATH_COMPONENT'))
	{
		define( 'JPATH_COMPONENT',					JPATH_BASE.DS.'components'.DS.'com_xius');
		define( 'JPATH_COMPONENT_SITE',				JPATH_SITE.DS.'components'.DS.'com_xius');
		define( 'JPATH_COMPONENT_ADMINISTRATOR',	JPATH_ADMINISTRATOR.DS.'components'.DS.'com_xius');
	}
}


