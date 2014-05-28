<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

// If file is already included
if(defined('XIUS_PROXIMITY_DEFINE'))
	return;

define('XIUS_PROXIMITY_DEFINE','XIUS_PROXIMITY_DEFINE');

// defime multipler for miles to miles and miles to kms
define('PROXIMITY_MILES_TO_MILES' , 1);
define('PROXIMITY_MILES_TO_KMS'   , 1.609344);
define('PROXIMITY_QUERY_CONSTANT' , 3959);

define('PROXIMITY_IFRAME_WIDTH'   , 750);
define('PROXIMITY_IFRAME_HEIGHT'  , 480);

define('PROXIMITY_APPLIED_IFRAME_WIDTH'   , 550);
define('PROXIMITY_APPLIED_IFRAME_HEIGHT'  , 450);

define('PROXIMITY_DEFAULT_LAT_LOC' , 20.29);
define('PROXIMITY_DEFAULT_LONG_LOC', 70.54);
define('PROXIMITY_DEFAULT_MAP_TYPE', 'map');
define('PROXIMITY_DEFAULT_MAP_ZOOM', 2);

define('PROXIMITY_MAP_WIDTH' 	   , 730);
define('PROXIMITY_MAP_HEIGHT'      , 400);
define('XIUS_GEOCODE_URL', 'http://maps.google.com/maps/api/geocode/json?');