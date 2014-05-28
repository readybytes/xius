<?php
/**
 * @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
 * @license		GNU/GPL, http://www.gnu.org/copyleft/gpl.html
 * @package		Team Joomlaxi
 * @subpackage	Frontend
 * @contact 		support+joomlaxi@readybytes.in
 */
if(!defined('_JEXEC')) die('Restricted access');

class Forcesearch extends XiusBase
{

	function __construct()
	{
		parent::__construct(__CLASS__);
	}
	
			
	/*@ return plugin different - 2 type which can exist
	 * Eq :- for JSFields ( Gender , city , state etc ) exist
	 * It will return key with display name 
	 */ 
	public function getAvailableInfo()
	{
		$allInfo = XiusLibInfo::getAllInfo();
		
		if(empty($allInfo)){
			return false;
		}

		$pluginsInfo = array();
			
		foreach($allInfo as $info){
			//XITODO: Implement force search for dependent informations
			//ignore dependent informations 
			if($info->pluginType !='Forcesearch' && $info->pluginType != 'Rangesearch' &&
			   $info->pluginType != 'Proximity'  && $info->pluginType != 'Xiusexport'  && 
			   $info->pluginType != 'Xiusemail'  && $info->pluginType != 'Onlineuser'  &&
			   $info->pluginType != 'Keyword'    && $info->pluginType != 'Groupmember'){
			      $pluginsInfo[$info->id] = $info->labelName;
			   }
		}
		
		return $pluginsInfo;
	}

	
	public function isSearchable($reset = false)
	{
		return true;
	}
	

	public function getPluginParamsHtml()
	{
		$plgInstance = XiusFactory::getPluginInstance('',$this->key);
        $operator    = $this->pluginParams->get('operatorType','LIKE');
		
		if(!$plgInstance){
			return false;
			}
			
		if(!$plgInstance->isAllRequirementSatisfy()){
			return false;
			}
			
		$inputHtml  = '<table class="paramlist admintable" width="100%">
	                   <tr><td class="paramlist_key">
	                   <label title="'.XiusText::_("TOOLTIP_VALUE").'" class ="hasTip">'
		               .XiusText::_('VALUE').'</label>
	                   </td> <td class="paramlist_value">';
		                    
	    $inputHtml .= $plgInstance->renderSearchableHtml
	                         (unserialize($this->pluginParams->get('value')));
        
		//html for operatorType select box
         $html = array('Equal'           => XIUS_EQUAL,
                      'GreaterThan' 	 => XIUS_GT,
                      'GreaterThanEqual' => XIUS_GTE,
                      'LessThan'         => XIUS_LT,
                      'LessThanEqual'    => XIUS_LTE,
                      'NotEqual'         => XIUS_NOTEQUAL,
                      'LIKE'             => XIUS_LIKE,
                      'NOTLIKE'          => XIUS_NOTLIKE,
                      'IN'               => XIUS_IN,
                      'NOT IN'           => XIUS_NOTIN);
        
        $inputHtml .= '</td></tr>
                       <tr><td class="paramlist_key" width = "40%">
                       <label title="'.XiusText::_("TOOLTIP_OPERATOR").'" class ="hasTip">'.
                       XiusText::_('OPERATOR_TYPE_LABEL').'</label>
                       </td><td class="paramlist_value">';
        $inputHtml .= '<select name="operatorType" id="operatorType">';
        
        foreach ($html as $key => $value){
			if($key != $operator)
        	  	$inputHtml .='<option value ="'.$key.'" >'.$value.'</option>'; 
        	else	  
               	$inputHtml .='<option value ="'.$key.'" selected="selected">'
               	.$value.'</option>';
        }
		$inputHtml  .= '</select></td></tr></table>';
        return $inputHtml;
	}
	
	
	function collectParamsFromPost(&$key,&$pluginParams,$postdata)
	{
		//XiTODO:: Apply assert
		if(count($postdata) == 0)
			return true;	
		
		$key = $postdata['key'];
			
		$searchArray	=	XiusLibUsersearch::processSearchData($postdata);
		
		if(count($searchArray) > 0){
			$pluginParamArray = $searchArray[0] ; //array('value' => $searchArray[0]->value);
			$parentInfo 			   = XiusModelInfo::getInfo($postdata['key']);
		    //for profiletype info
            if($parentInfo->pluginType == 'Jsfields'){
       	     $filter 	   = array();
		     $filter['id'] = $parentInfo->key;
		     require_once XIUS_PATH_LIBRARY.DS.'plugins'.DS.'jsfields'.DS.'jsfieldshelper.php';
		     $fieldInfo    = Jsfieldshelper::getJomsocialFields($filter);
           		 }
			if($parentInfo->key == 'usertype' || (isset($fieldInfo) && $fieldInfo[0]->type == 'profiletypes'))
				$pluginParamArray['value'] = serialize($pluginParamArray['value']['param']);
			else 
				$pluginParamArray['value'] = serialize($pluginParamArray['value']);
				
			$pluginParamArray['operatorType'] = $postdata['operatorType'];
			$registry	= new JRegistry;
			$registry->loadArray($pluginParamArray,'xius_pluginParams');
			$pluginParams =  $registry->toString('INI' , 'xius_pluginParams' );
		}
		//$key = $postdata['key'];
		return true;
	}
	
	
	/*this function should call after setting key */
	function getInfoName()
	{
		$filter = array();
		$filter['id'] = $this->key;
		$fieldInfo = XiusLibInfo::getInfo($filter);
		
		if(!empty($fieldInfo))
			return $fieldInfo[0]->labelName;
			
		return false;
	}
	
	

	public function isKeywordCompatible()
	{
		return false;
	}
	
	
	public function addSearchToQuery(XiusQuery &$query,$value,$operator=XIUS_LIKE,$join='AND')
	{
		// get all information available
		$filter = 	array('pluginType' => 'Forcesearch','published' => true);
		$forceSearchInfo	=	XiusLibInfo::getInfo($filter,'AND',false);
		
		if(count($forceSearchInfo) == 0)
			return false;
	
		$fsQuery = new XiusQuery();
	    
		//arrange information by keys 
        usort($forceSearchInfo, "sortByKey");
	        
	    $strQuery = null;

	    /*
	     * @since Xius-4.1
	     * now the grouping of information is not done because among the group query is executing in OR manner 
	     * but all force search infos should be attached with AND 
	     */
	    foreach ($forceSearchInfo as $forceSearch) {
	    	$fgQuery = new XiusQuery();
	    	$forceSearchInstance = XiusFactory::getPluginInstance('',$forceSearch->id);
          	if(!$forceSearchInstance->checkConfiguration('isSearchable'))
				continue;
		  	$pluginParams = $forceSearchInstance->getData('pluginParams');
		  	$this->_addSearchToQuery($fgQuery,$pluginParams,'AND');
		  	
		  	$fgQuery	= $fgQuery->convertWhereIntoString();
		  	if($strQuery!= null)
		  		$strQuery = $strQuery.' AND '.$fgQuery;
		  	else
		  		$strQuery = $fgQuery;
		  	
	    }
				
		if(!$strQuery){
			return false;
		}

		$prevQuery	=	$query->convertWhereIntoString();
		if(!$prevQuery){
			$query->where( ' ( '.$strQuery.' ) ', 'AND');
			return true;
		}
		
		$condition = '( '. $prevQuery.' ) AND ( ' .$strQuery .' ) ';
		$query->clear('where');
	 	$query->where($condition, $join);		   	 
	   	return true;
	}
	
	
	function _addSearchToQuery(XiusQuery &$query,$pluginParams,$join='AND')
	{		
		$plgInstance = XiusFactory::getPluginInstance('',$pluginParams->get('infoid'));
		if(!$plgInstance){
			return false;
		}
		
		if(!$plgInstance->isAllRequirementSatisfy()){
			return false;
			}
		
		$this->getqueryByoperator($query,$plgInstance,$pluginParams->get('operatorType'),
               unserialize($pluginParams->get('value')),$join);
		return true;			
   	}
   	
   	/*
   	 * make query according to the selected operator for negative searching
   	 */
   function getqueryByoperator(XiusQuery &$query , $instance , $operator ,$value ,$join )
   	{
   		$db      = JFactory::getDBO();
   		$columns = $instance->getTableMapping();
   		$value   =  $this->formatValues($instance,$operator, $value);
   		
   		switch($operator)
   		{
   			case 'Equal'           : 
   									 $operator = XIUS_EQUAL;
   									 break;
   			case 'GreaterThan'	   :
   				                     $operator = XIUS_GT;
   				                     break;
   			case 'GreaterThanEqual':
   				                     $operator = XIUS_GTE;
   				                     break;
   			case 'LessThan'        :
   				                     $operator = XIUS_LT;
   				                     break;
   			case 'LessThanEqual'   :
   				                     $operator = XIUS_LT;
   				                     break;
   			case 'NotEqual'        : 
   				                     $operator = XIUS_NOTEQUAL;
   				                     break;
   			case 'NOTLIKE'         :
   				                     $operator = XIUS_NOTLIKE;
   				                     $value = "'%$value%'";
   				                     break;
   			case 'IN'         :
   				                     $operator = XIUS_IN;
   				                     $value =   "(".implode(",",$value).")";
   				                     break;
   			case 'NOT IN'      :
   				                     $operator = XIUS_NOTIN;
   				                     $value =   "(".implode(",",$value).")";
   				                     break;
   			default                :
   				                     $operator = XIUS_LIKE; 
   				                     $value = "'%$value%'";

   		}
   		$conditions = $instance->formatColumn($columns[0],$db)
   					 .$operator
   					 .$value;
   	    $query->where($conditions,$join);
   		
   	}
   	
    //format values according to operator type
   	function formatValues($instance,$operator, $value)
   	{  	
        //For multiselect type info
   		if(is_array($value) && isset($value))  {   
   			  	$formatedValues = $value;
   			} 
   		if( "IN" == $operator || "NOT IN" == $operator){
   	    	if(!isset($formatedValues))	
   				$formatedValues = explode(',', $value);
   				
   			foreach ($formatedValues as $key=>$value){
   				$value = $instance->formatValue($value);
   				if(is_string($value))
   					$formatedValues[$key] = "'$value'";
   			}
   		}
   		else{
            //if operator is not IN and NOTIN and info type is not of 
            //multiselect type then assign '$value' otherwise assign the 
            //'formatedValues' first element only, bcoz other opr only needs 1 value
   			$formatedValues = $instance->formatValue(
   			                     isset($formatedValues)?$formatedValues[0]:$value);
   			if(is_string($formatedValues) && 
   			        ($operator == 'Equal' ||$operator == 'NotEqual')){
   				$formatedValues = "'$formatedValues'";
   			  }
   			}
   		return $formatedValues;
   	}
   	
	function isExportable()
	{
		return false;
	}
}
   //sort by key in descending order
    function sortByKey($a, $b) 
     {
          if ($a->key == $b->key)
            return 0;
         else
            return $a->key < $b->key ? 1 : -1; // reverse order
     }