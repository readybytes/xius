<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
if(!defined('_JEXEC')) die('Restricted access');

class Groupmember extends XiusBase
{
	function __construct()
	{
		parent::__construct(__CLASS__);
	}

	/**
	 * return available information for create XiUS_Information
	 */
	function getAvailableInfo()
	{
		$pluginsInfo['groupmember'] = "Group Members";
		return $pluginsInfo;
	}
	/**
	 * Default information Name 
	 */
	function getInfoName()
	{
		return "Group Members";
	}
	
	/**
	 * Add to query for search
	 * @see components/com_xius/libraries/plugins/XiusBase#addSearchToQuery($query, $value, $operator, $join)
	 */	
	function addSearchToQuery(XiusQuery &$query,$value,$operator=XIUS_LIKE,$join='AND')
	{
			
		// if input values are are not valid then discard this		
		if($this->validateValues($value) == false){
			return false;
		}

		// Build Sub-Query for getting group member 
		$groupQuery = new XiusQuery();
		$groupQuery->select("`memberid`")
				   ->from("`#__community_groups_members`")
				   ->where("`groupid`=$value");
							

		// Add with Searched Query
		$condition = " `userid` IN ($groupQuery)"; 
		$query->where($condition,$join);
	
		return true;
	}

	/**
	 * $value must be numeric
	 * @param unknown_type $value
	 */
	function validateValues($value)
	{
		return is_numeric($value) ? true : false;
	}
	
	/** Restict For keyword Compitable
	 * (non-PHPdoc)
	 * @see components/com_xius/libraries/plugins/XiusBase#isKeywordCompatible()
	 */
	function isKeywordCompatible()
	{
		return false;
	}
	
	/**
	 * Give the name of Group, on applied Value 
	 * @param unknown_type $postData
	 */
	function _getFormatData($value)
	{
		$resultGroups =  XiusFactory::getInstance('model')
       					 ->getGroups();

       	foreach($resultGroups as $group){
       		if($group->id == $value)
       			return $group->name;
       	} 	
	}
}
