<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
jimport( 'joomla.plugin.plugin' );
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_xipt'))
	return;

require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xius'.DS.'helpers'.DS.'xiptwrapper.php';

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
		
		if(!(XiusHelpersUtils::isPluginInstalledAndEnabled('xipt_community','community')))
			return false;
			
		if(!(XiusHelpersUtils::isPluginInstalledAndEnabled('xipt_system','system')))
			return false;	

		return true;	
	}
	
	/**
	 * Find-out Several fields which are invisible according to Profile-Types.
	 * @param $allInfo, Array have all created information.
	 * @param $visibleFields, Array have visible fields according to Profile Type Id's.
	 * @param $profileTypes array have all Profile Types id.
	 */
	function _setDisplayInfo($allInfo, $visibleFields, $profileTypes) {

		$allInfo=array_values($allInfo);

		$hiddenInfoId=array();
				
		foreach ($profileTypes as $profileType)
		{
			$fieldId=array();
			foreach($visibleFields[$profileType->id] as $visibleField)
				$fieldId[] = $visibleField->id;

			foreach ($allInfo as $info)
			{	
				if($info->pluginType === 'Jsfields' && false === in_array($info->key, $fieldId))
					$hiddenInfoId[$profileType->id][]=$info->key;
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
	
	/**
	 * Filtered all available ifo accoding to XiPT Profile field Privacy
	 * @param $allInfo
	 * @param $loginuser
	 */
	function xiusOnAfterLoadAllInfo($allInfo, $loginuser=null)
	{
		$app = JFactory::getApplication();
		//Don't run in admin
		if($app->isAdmin())
			return true;
		
		if(!$this->_loadXipt())
			return false;
			
		$profileTypes = XiptWrapper::getProfileTypeIds();
		$jsfields = XiptWrapper::getJSProfileFields();
		$jsfields = array_values($jsfields);
		
		//check Profile Type info create or not
		foreach ($jsfields as $field){
			
			if ($field->type !=='profiletypes')
				continue ;
			
			$profileTypeInfoId = 'field'.$field->id;
			$visibleFields=array();
			foreach($profileTypes as $profileType){
				$visibleFields[$profileType->id] = $jsfields;
				if(!(XiptWrapper::filterProfileTypeFields($visibleFields[$profileType->id], $profileType->id,'getViewableProfile')))
						continue ;	
				}		
			$hiddenInfoId = $this->_setDisplayInfo($allInfo, $visibleFields, $profileTypes);
		
			if(JRequest::getVar('profileType') === null)
				JRequest::setVar('profileType',0,'POST');
			
			// XITODO: get variable by JRequest
			if(!empty($_POST[$profileTypeInfoId]))
			   JRequest::setVar('profileType',$_POST[$profileTypeInfoId],'POST');	
			
			// Script Variable Set	
			$this->_addScriptParam($hiddenInfoId, $profileTypeInfoId);
			
			// load jquery
			$js='plugins/xius/xipt_fieldselection/default.js';
			CAssets::attach($js, 'js' , JURI::base());
					
			return true;
		}
		return false;
	}
}