<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Plugin
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

jimport( 'joomla.plugin.plugin' );
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');


// If Xius System Plugin disabled then do nothing
$state = JPluginHelper::isEnabled('system', 'xius_system');
if(!$state){
    return true;
} else {

if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_xipt'))
	return;


class plgXiusxipt_fieldselection extends JPlugin
{		
	function plgXiusxipt_fieldselection( &$subject, $params )
	{
		parent::__construct( $subject, $params );
	}

	/**
	 * load XiPT component
	 */
	function _loadXipt()
	{		
		if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_xipt'))
			return false;

		if(!$this->_pluginStatus())
			return false;
		
		return true;
	}
		
	/**
	 * check XiPT plugin status.
	 */
	function _pluginStatus(){
		
		if(!(XiusHelperUtils::isPluginInstalledAndEnabled('xipt_community','community')))
			return false;
			
		if(!(XiusHelperUtils::isPluginInstalledAndEnabled('xipt_system','system')))
			return false;	

		return true;	
	}
	
	/**
	 * Find-out Several fields which are invisible according to Profile-Types.
	 * @param $allInfo, Array have all created information.
	 * @param $visibleFields, Array have visible fields according to Profile Type Id's.
	 * @param $profileTypes array have all Profile Types id.
	 */
	function _setDisplayInfo( $visibleFields, $profileTypes) {
        $filter 			 = array();
		$filter['published'] = true;
		$allInfo	 	     = XiusLibInfo::getInfo($filter,'AND',false);
		$hiddenInfoId=array();
				
		foreach ($profileTypes as $profileType)
		{
			$fieldId=array();
			foreach($visibleFields[$profileType->id] as $visibleField)
				$fieldId[] = $visibleField->id;
            //check if base/depentdent or both infos are needed to be hidden
            //$parentOrChild is '0' for Base
            //'1' for dependent
            //'2' for Both
			foreach ($allInfo as $info)
			{	
				if($info->pluginType === 'Jsfields' && false === in_array($info->key, $fieldId)){
				 	$parentOrChild = $this->params->get('xiusSetInfo');
					if($parentOrChild != 0){
						$dependentInfos = XiusHelperUsersearch::getChildren($info->id);
						foreach ($dependentInfos as $key=>$childid) 
							$hiddenInfoId[$profileType->id][] = $childid;
					 }
					if($parentOrChild != 1)
					 	$hiddenInfoId[$profileType->id][] = $info->id;
						
				}
			}
			unset($fieldId);
		}
		return $hiddenInfoId;
	}
	/**
	 * declare hidden fields array for Jquery
	 * @param unknown_type $hiddenInfoId
	 * @param unknown_type $profileTypeInfoId
	 */
	
	function _addScriptParam($hiddenInfoId, $profileTypeInfoId)
	{
		ob_start();
			?>
			var hiddenFields= new Array();
			var profileTypeInfoId = "<?php echo $profileTypeInfoId;?>"; 
			<?php
				foreach ($hiddenInfoId as $profileType => $fields): ?>
					hiddenFields[<?php echo $profileType;?>] = [<?php echo  implode("," , $fields); ?>];
				<?php endforeach; ?>
	
		<?php
		$content = ob_get_contents();
		ob_clean();
        JFactory::getDocument()->addScriptDeclaration($content);
	}
	
	function onBeforeDisplaySearchPanel($allInfo )
	{
		return self::_filterInfo();
	}
	
	function onBeforeMiniProfileDisplay($allInfo )
	{
		return self::_filterInfo();
	}
	
	/**
	 * Filtered all available ifo accoding to XiPT Profile field Privacy
	 * @param $allInfo
	 * @param $loginuser
	 */
	function _filterInfo()
	{
		//Don't run when user is  admin or cache upadate time.
		if(JFactory::getApplication()->isAdmin() ||
		   JFactory::getSession()->get('updateCache', false) )
		   return true;

        if(XiusHelperUtils::isAdmin())
           return true;		

		if(!$this->_loadXipt())
			return false;
			
		$profileTypes = XiusHelperXiptwrapper::getProfileTypeIds();
		$jsfields 	  = XiusHelperXiptwrapper::getJSProfileFields();
		$jsfields 	  = array_values($jsfields);
		
		//check Profile Type info create or not
		foreach ($jsfields as $field){
			
			if ($field->type !=='profiletypes')
				continue ;
			
			$profileTypeInfoId = 'field'.$field->id;
			$visibleFields=array();
			foreach($profileTypes as $profileType){
				$visibleFields[$profileType->id] = $jsfields;
				if(!(XiusHelperXiptwrapper::filterProfileTypeFields($visibleFields[$profileType->id], $profileType->id,'getViewableProfile')))
						continue ;	
				}
				//Restrict to hide profileType info in dynamic filtering
				foreach ($visibleFields as $key=>$value){
					$visibleFields[$key][] = $field; 
				}		
			$hiddenInfoId = $this->_setDisplayInfo( $visibleFields, $profileTypes);
		
			if(JRequest::getVar('profileType') === null)
				JRequest::setVar('profileType',0,'POST');
			
			// XITODO: get variable by JRequest
			if(!empty($_POST[$profileTypeInfoId]))
			   JRequest::setVar('profileType',$_POST[$profileTypeInfoId],'POST');	
			
			// Script Variable Set	
			$this->_addScriptParam($hiddenInfoId, $profileTypeInfoId);
			
			// load jquery
			$strPath="";
			if (!XIUS_JOOMLA_15)
				$strPath = "/xipt_fieldselection";
			$js='plugins/xius/xipt_fieldselection'.$strPath.'/default.js';
			$jsVersion = XiusHelperUtils::getJSVersion();
			if(version_compare($jsVersion,'3.2.0.6') >= 0) {
				CFactory::attach($js, 'js' , JURI::base());
			}
			else {
				CAssets::attach($js, 'js' , JURI::base());
			}
					
			return true;
		}
		return false;
	}
}

}
