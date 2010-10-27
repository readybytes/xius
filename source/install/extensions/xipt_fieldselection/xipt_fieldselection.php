<?php
// no direct access
if(!defined('_JEXEC')) die('Restricted access');
jimport( 'joomla.plugin.plugin' );
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

if(!JFolder::exists(JPATH_ROOT.DS.'components'.DS.'com_xipt'))
	return;

require_once JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_xipt'.DS.'helpers'.DS.'profilefields.php';

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
		$includePath = JPATH_ROOT.DS.'components'.DS.'com_xipt'.DS.'includes.xipt.php';
		
		if(!JFile::exists($includePath))
			return false;

		require_once $includePath;
		
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
	
	
	function _addScript($hiddenInfoId, $profileTypeInfoId)
	{
		ob_start();
			?>			
			<script language="javascript">
					var hiddenFields= new Array();
					var profileTypeInfoId = "<?php echo $profileTypeInfoId;?>"; 
					<?php
						foreach ($hiddenInfoId as $profileType => $fields){	?>
						  hiddenFields[<?php echo $profileType;?>] = new Array(<?php echo  implode("," , $fields); ?>);
							<?php
						}
						?>
			</script>
	<?php
		
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
			
		$profileTypes = XiPTLibraryProfiletypes::getProfiletypeArray();
		$jsfields = XiPTHelperProfileFields::get_jomsocial_profile_fields();
		
		//check Profile Type info create or not
		foreach ($jsfields as $field){
			
			if ($field->type !=='profiletypes')
				continue ;
			
			$profileTypeInfoId = 'field'.$field->id;
			$visibleFields=array();
			foreach($profileTypes as $profileType){
				$visibleFields[$profileType->id] = $jsfields;
				if(!(XiPTLibraryProfiletypes::_getFieldsForProfiletype($visibleFields[$profileType->id], $profileType->id,'getViewableProfile')))
						continue ;	
				}		
			$hiddenInfoId = $this->_setDisplayInfo($allInfo, $visibleFields, $profileTypes);
		
			if(JRequest::getVar('profileType') === null)
				JRequest::setVar('profileType',0,'POST');
			
			// XITODO: get variable by JRequest
			if(!empty($_POST[$profileTypeInfoId]))
			   JRequest::setVar('profileType',$_POST[$profileTypeInfoId],'POST');	
			
		// Script Variable Set	
		$this->_addScript($hiddenInfoId, $profileTypeInfoId);
		
		require_once JPATH_ROOT.DS.'plugins'.DS.'xius'.DS.'xipt_fieldselection'.DS.'addJS.php';

		return true;
		}
		return false;
	}
}