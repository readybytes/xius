<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
if(!defined('_JEXEC')) die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class XiussiteViewUsers extends XiusView
{
	function panel($allInfo,$tmpl='panel')
	{
		$infohtml = array();
		if(!empty($allInfo)){
			$count = 0;
			foreach($allInfo as $info){
				$plgInstance = XiusFactory::getPluginInstanceFromId($info->id);

				if(!$plgInstance)
					continue;

				if(!$plgInstance->isAllRequirementSatisfy())
					continue;

				if(!$plgInstance->isSearchable())
					continue;

				$inputHtml = $plgInstance->renderSearchableHtml();

				if($inputHtml === false)
					continue;

				$infohtml[$count]['infoid'] = $info->id;
				$infohtml[$count]['info'] = $info;
				$infohtml[$count]['label'] = $info->labelName;
				$infohtml[$count]['tooltip'] = $plgInstance->getTooltip();
				/*
				 *replace name and id in input html
				 */

				$infohtml[$count]['html'] = $inputHtml;

				$count++;

			}
		}

		$document = JFactory::getDocument();
		$document->setTitle(XiusText::_('Search Panel'));
		$dispatcher =& JDispatcher::getInstance();
		$dispatcher->trigger( 'onBeforeDisplaySearchPanel',array( &$infohtml  ));
		
		$joinHtml['enable']  	= XiusHelperUtils::getConfigurationParams('xiusEnableMatch',true);
		$joinHtml['defultMatch']= XiusHelperUtils::getConfigurationParams('xiusDefaultMatch','AND');
		$this->assignRef('joinHtml', $joinHtml);
		$this->assignRef('join', $joinHtml['defultMatch']);
		
		$submitUrl	= $this->getXiUrl();
		$this->assign('submitUrl', $submitUrl);
		$this->assign( 'infohtml' , $infohtml );
		return parent::display($tmpl);
	}

//	function displayAdvanceSearch()
//	{
//		parent::display();
//	}
}