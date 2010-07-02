<?php
require_once dirname(__FILE__). '/joomlaFramework.php';

// which selenium server to pick
$whichSelRC = getenv('useSelRC'); // can be local / network
if($whichSelRC == FALSE)
{
	echo "\n Environment variable not set picking up localhost as useSelRC";
	$whichSelRC = 'local';
}

require_once dirname(__FILE__). "/selRC_$whichSelRC.php";

define('JOOMLA_LOCATION',	'http://'.JOOMLA_HOST.'/@joomla.folder@/');
define('JOOMLA_FTP_LOCATION', 	JPATH_BASE);

$_SERVER['HTTP_HOST'] = JOOMLA_LOCATION;

define('TIMEOUT_SEC',300000);
define('JOOMLA_ADMIN_USERNAME', 'admin');
define('JOOMLA_ADMIN_PASSWORD',	'ssv445');

//these files should have been copied by phing during setup of joomla 
define('XIUS_PKG',		JOOMLA_LOCATION.'/xius.zip');

$name = 'com_xius';
define( 'JPATH_COMPONENT',					JPATH_BASE.DS.'components'.DS.$name);
define( 'JPATH_COMPONENT_SITE',				JPATH_SITE.DS.'components'.DS.$name);
define( 'JPATH_COMPONENT_ADMINISTRATOR',	JPATH_ADMINISTRATOR.DS.'components'.DS.$name);

define('JOMSOCIAL_ZEND_PLUGIN', JOOMLA_LOCATION);
define('JOMSOCIAL18_PKG', JOOMLA_LOCATION.'/com_community1.8.zip');
