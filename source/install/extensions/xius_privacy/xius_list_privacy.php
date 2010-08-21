<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
jimport( 'joomla.plugin.plugin' );
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_xius'))
	return;

class plgSystemxius_list_privacy extends JPlugin
{
	var $_debugMode = 0;
		
	function plgSystemxius_list_privacy( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}
	
	function _loadXius()
	{				
		$includePath = JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'includes.php';
		if(!JFile::exists($includePath))
			return false;
		
		require_once $includePath;
		return true;
	}
	
	/*
	 * @trigger will return the privacy html to be shown on page
	 * @where list data will be filled
	 */
	function xiusOnBeforeDisplayListDetails($params)
	{
		if(!$this->_loadXius())
			return false;
				
		return $this->_xiusGetListPrivacyHtml($params);
	}
	
	/*
	 * @will generate the html for list privacy to be shown
	 */
	function _xiusGetListPrivacyHtml($params)
	{
		$name = $this->_name;
		$htmlOption['public'] 	= JText::_("XIUS LIST PRIVACY PUBLIC");
		$htmlOption['member'] 	= JText::_("XIUS LIST PRIVACY MEMBER");
		$htmlOption['friend'] 	= JText::_("XIUS LIST PRIVACY FRIEND");
		$htmlOption['self'] 	= JText::_("XIUS LIST PRIVACY SELF");
		$html = '';
		
		$selectedOption			= ''; 
		if(array_key_exists($name,$params))
			$selectedOption			= $params[$name];
		
		foreach($htmlOption as $key => $value){
			$select = '';
			if($selectedOption !=='' && $selectedOption === $key)
				$select = " checked ";
 			$html .= '<input type="radio" name="'.$name.'" value="'.$key.'" '.$select.'/>'.$value;
		}
 		return $html;
	}
	
	function xiusOnBeforeSaveList($postData, $params)
	{	
		if(!$this->_loadXius())
			return false;

		// is postdata of this plugin is set then, set it into postData[params]
		if(array_key_exists($this->_name,$postData)){
			$params[$this->_name] = $postData[$this->_name];
			return true;
		}

		return true;
	} 
	
	function xiusOnBeforeAllListDisplay($lists,$loggedinUser)
	{
		if(!$this->_loadXius())
			return false;

		$count = count($lists);
		for($i =0 ; $i < $count ; $i++ ){
			$params = new JParameter('','');
			$params->bind($lists[$i]->params);
			$privacy = $params->get($this->_name,'public');
			$isViewable = $this->_isListViewable($privacy,$loggedinUser,$lists[$i]->owner);
			if($isViewable === true)
				continue;
			
			unset($lists[$i]);
		}
		$lists = array_values($lists);
		return true;
	}
	
	function _isListViewable($privacy,$loggedinUser,$ownerId)
	{
		if(XiusHelpersUtils::isAdmin($loggedinUser->id))
			return true;
			
		switch($privacy){
			case 'public' : 
							return true;
							break;
							
			case 'member' : 
							if(!$loggedinUser->usertype)
								return false;
								
							return true;
							break;
							
			case 'friend' : 
							if($this->_isFriend($loggedinUser->id,$ownerId))
								return true;
								
							return false;
							break;
							
			case 'self'	  : 
							if($loggedinUser->id === $ownerId)
								return true;
								
							return false;
							break;
							
			default       :
							return true;				
		}
	}
	
	function _isFriend($userId, $otherUserId)
    {
    	$db      = & JFactory::getDBO();
        $query   = 'SELECT '. $db->nameQuote('connection_id').'  FROM ' . $db->nameQuote( '#__community_connection')
        			.' WHERE '. $db->nameQuote('connect_from').'='.$db->Quote($userId)
                    .' AND '. $db->nameQuote('connect_to').'='.$db->Quote($otherUserId)
                    .' AND '. $db->nameQuote('status').'='.$db->Quote('1');
                                       
        $db->setQuery( $query );
        return $db->loadResult();                
    }	
}