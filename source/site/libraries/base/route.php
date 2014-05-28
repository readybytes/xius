<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

require_once JPATH_ROOT.DS.'components'.DS.'com_xius' .DS. 'router.php';

class XiusRoute
{
	public static function _addItemId($url)
	{
		
		$Jurl     = new JURI($url);
		$query     = $Jurl->getQuery(true);
		
		//already itemid is there
		if(isset($query['Itemid']))
			return $url;
		
		XiusBuildRoute($query);
		
		// no menu there, so we can't add item id
		if(!isset($query['Itemid']))
			return $url;
		
		//we have menu so add it's item id
		return $url."&Itemid=".$query['Itemid'];		
	}
	
	public static function _($url, $xhtml = true, $ssl = null)
	{
		
	   $config = JFactory::getConfig();
	   
	   if(JFactory::getApplication()->isAdmin())
			return $url;
	   if($config->get('sef') === '0'){           
          if(strpos($url, 'com_xius')){
              $url = self::_addItemId($url);
        	    return $url;
          }
      }
	
		if(strpos($url, 'com_community'))
			return CRoute::_($url,$xhtml, $ssl);
			
	
		return JRoute::_($url, $xhtml, $ssl);
	}
	
}
