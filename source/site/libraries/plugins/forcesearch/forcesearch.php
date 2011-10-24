<?php

// no direct access
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

	
	public function isSearchable()
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
			
		$inputHtml .= '<table class="paramlist admintable" width="100%">
	                   <tr><td class="paramlist_key">
	                   <label title="'.XiusText::_("TOOLTIP_VALUE").'" class ="hasTip">'
		               .XiusText::_('VALUE').'</label>
	                   </td> <td class="paramlist_value">';
		                    
	    $inputHtml .= $plgInstance->renderSearchableHtml
	                         (unserialize($this->pluginParams->get('value')));
        
		//html for operatorType select box
         $html = array('Equal'            => XIUS_EQUAL,
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
	    
	    //creating groups of informations with same key 
	    $forceGrp = array();
	    for($i=0,$j=0;$i<count($forceSearchInfo);$i++)
	    {

	    	if( ($i+1) < count($forceSearchInfo) && $forceSearchInfo[$i]->key == $forceSearchInfo[$i+1]->key){
	    		 $forceGrp[$j][$i] = $forceSearchInfo[$i]; 
	    		 $forceGrp[$j][$i+1] = $forceSearchInfo[$i+1];
	    	}
	    	else{
	    		 $forceGrp[$j][$i] = $forceSearchInfo[$i];
	    		 $j++;
	    	}
	    }
	   $strQuery = null;
        //make query according to force search groups
	    foreach ($forceGrp as $group)
	    {
	    	$fgQuery = new XiusQuery();
	        foreach($group as $fg)
	    	{
              $forceSearchInstance = XiusFactory::getPluginInstance('',$fg->id);
	          if(!$forceSearchInstance->checkConfiguration('isSearchable'))
				continue;
			  $pluginParams = $forceSearchInstance->getData('pluginParams');
			  $this->_addSearchToQuery($fgQuery,$pluginParams,'OR');
		    }
		    $fgQuery	=	'('.$fgQuery->convertWhereIntoString().')';
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
   		$value   =  $this->formatValue($instance,$operator, $value);
   		
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
   	function formatValue($instance,$operator, $value)
   	{  	
   		if( "IN" == $operator || "NOT IN" == $operator){
   			$formatedValues = explode(',', $value);
   			foreach ($formatedValues as $key=>$value){
   				$value = $instance->formatValue($value);
   				if(is_string($value))
   					$formatedValues[$key] = "'$value'";
   			}
   		}
   		else{
   			$formatedValues = $instance->formatValue($value);
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