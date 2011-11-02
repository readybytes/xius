<?php

class XiusJuserTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	

	function testGetAvailableInfoForJsuser()
	{
		/*IMP : Need joomla enviorenment to run test case
		 * it will not run individually ,
		 * b'coz joomla file system does not load
		 */
		require_once  XIUS_PLUGINS_PATH. DS . 'jsuser' . DS . 'jsuser.php';
		$instance = new Jsuser();
		
		$info = $instance->getAvailableInfo();
		
		if(!$instance->isAllRequirementSatisfy())
			$this->assertFalse($info);
		else {
		
			$requiredInfo = array();
			
			
			$requiredInfo['userid']			= 'userid';
    		$requiredInfo['status']			= 'status';
		    $requiredInfo['status_access']	= 'status_access';
		    $requiredInfo['points']			= 'points';
		    $requiredInfo['posted_on']		= 'posted_on';
		    $requiredInfo['avatar']			= 'avatar';
		    $requiredInfo['thumb']			= 'thumb';
		    $requiredInfo['invite']			= 'invite';
		    $requiredInfo['params']			= 'params';
		    $requiredInfo['view']			= 'view';
		    $requiredInfo['friends']		= 'friends';
		    $requiredInfo['groups']			= 'groups';
		    $requiredInfo['friendcount']	= 'friendcount';
		    $requiredInfo['alias']			= 'alias';
		    $requiredInfo['latitude']		= 'latitude';
		    $requiredInfo['longitude']		= 'longitude';
		    $requiredInfo['profile_id']		= 'profile_id';
		    $requiredInfo['storage']		= 'storage';
		    $requiredInfo['watermark_hash']	= 'watermark_hash';
		    $requiredInfo['search_email']	= 'search_email';

			$this->assertEquals($requiredInfo,$info);
		}
	}

	
	
	function testViewSearchHtml()
	{
		require_once  XIUS_PLUGINS_PATH. DS . 'jsuser' . DS . 'jsuser.php';
		$instance = new Jsuser();
		require_once  XIUS_PLUGINS_PATH. DS . 'jsuser' . DS . 'views' . DS . 'view.html.php';
		$instance->load(1);
		$viewClass = new JsuserView();
		$searchHtml5 =  $viewClass->searchHtml($instance);
		$result5 = '<inputclass="inputbox"type="text"name="Jsuser_1"id="Jsuser_1"value=""/>';
		$this->assertEquals($this->cleanWhiteSpaces($result5),$this->cleanWhiteSpaces($searchHtml5)); 
		
		$instance->load(2);
		$searchHtml4 =  $viewClass->searchHtml($instance);
		
		$result4 = '<inputclass="inputbox"type="text"name="Jsuser_2"id="Jsuser_2"value=""/>';
		$this->assertEquals($this->cleanWhiteSpaces($result4),$this->cleanWhiteSpaces($searchHtml4));
		
		$instance->load(9);
		$searchHtml6= $viewClass->searchHtml($instance);
		$result6='<select id="profileType" name="profileType">
		          <option>Select Profile-Type</option>
		          <option value="1">Male</option>
		          <option value="2">Female</option>
		          </select>';
		$this->assertEquals($this->cleanWhiteSpaces($result6),$this->cleanWhiteSpaces($searchHtml6));	
	
		$instance->load(10);
		$searchHtml7=$viewClass->searchHtml($instance);
		$result7='	<div><label><inputtype="radio"id="avatar"name="avatar"value="0"title="Userswithavatar"/>
				  	Userswithavatar</label><label>
					<inputtype="radio"id="avatar"name="avatar"value="1"title="Userswithdefaultavatar"/>
                    Userswithdefaultavatar</label><label>
                    <inputtype="radio"id="avatar"name="avatar"value="AllUsers"title="Allusers"checked/>
                    AllUsers</label></div>';
		$this->assertEquals($this->cleanWhiteSpaces($result7),$this->cleanWhiteSpaces($searchHtml7));
	}    
	
	function testGetFormatData()
	{
		$instance=new Jsuser();
		$instance->setData("key",'profile_id');
		$instance->load(9);
		
		$result=$instance->_getFormatData(0);
		$this->assertEquals($this->cleanWhiteSpaces($result),'Default');
		
		$result=$instance->_getFormatData(1);
		$this->assertEquals($this->cleanWhiteSpaces($result),'Male');
		
		$result=$instance->_getFormatData(2);
		$this->assertEquals($this->cleanWhiteSpaces($result),'Female');
		
		$result=$instance->validateValues(1);
		$this->assertEquals($result,true);
		
		$result=$instance->validateValues('select profile type');
		$this->assertEquals($result,false);
		
		$instance->setData("key", 'avatar');
		$instance->load(10);
		
		$result=$instance->_getFormatData(0);
		$this->assertEquals($this->cleanWhiteSpaces($result),'WithAvatar');
		
		$result=$instance->_getFormatData(1);
		$this->assertEquals($this->cleanWhiteSpaces($result),'WithDefaultAvatar');
		
		$result=$instance->_getFormatData('All Users');
		$this->assertEquals($this->cleanWhiteSpaces($result),'AllUsers');
		}
	
	
	
	function testGetTableMapping()
	{       
            $this->changePluginState('xipt_system',true);
	        $this->changePluginState('xipt_community',true);
		$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusJuserTest/testViewSearchHtml.start.sql');
		$instance = new Jsuser();
		$instance->load(2);
		$mapping = $instance->getTableMapping();
		
		$tableInfo					= array();
		$count = 0;
		 
		$object	= new stdClass();
		$object->tableName			= '`#__community_users`';
		$object->tableAliasName 	= "communityusersstatus_0";
		$object->originColumnName	= 'status';
		$object->cacheColumnName	= 'jsuserstatus_0';
		$object->cacheSqlSpec 		= 'varchar(250) NOT NULL';
		$object->cacheLabelName		= 'status';
		$object->createCacheColumn	= true;
		$tableInfo[]=$object;
		
		$this->assertEquals($mapping, $tableInfo);
		
		$instance->load(1);
		$mapping = $instance->getTableMapping();
		
		$tableInfo					= array();
		$count = 0;
		 
		$object	= new stdClass();
		$object->tableName			= '`#__community_users`';
		$object->tableAliasName 	= "communityusersuserid_0";
		$object->originColumnName	= 'userid';
		$object->cacheColumnName	= 'jsuseruserid_0';
		$object->cacheSqlSpec 		= 'int(21) NOT NULL';
		$object->cacheLabelName		= 'userid';
		$object->createCacheColumn	= true;
		$tableInfo[]=$object;
		
		$this->assertEquals($mapping, $tableInfo);
	
		$instance->load(10);
        Jsuser::$defaultAvatars = array();
		$mapping = $instance->getTableMapping();
		$tableInfo					= array();
		$count = 0;
		 
		$object	= new stdClass();
		$object->tableName			= "(
				  SELECT `userid`, CASE `avatar`  WHEN '' THEN 1  WHEN 'components/com_community/assets/default.jpg' THEN 1  WHEN 'images/profiletype/avatar_1.jpg' THEN 1  WHEN 'images/profiletype/avatar_2.jpg' THEN 1  ELSE  0  END as avatar
				   FROM `#__community_users`
				)";
		$object->tableAliasName 	= 'communityusersavatar_0';
		$object->originColumnName	= 'avatar';
		$object->cacheColumnName	= 'jsuseravatar_0';
		$object->cacheSqlSpec 		= 'TINYINT(1) NOT NULL DEFAULT 0';
		$object->cacheLabelName		= 'avatar';
		$object->createCacheColumn	= true;
		$tableInfo[]=$object;
		
		$this->assertEquals($mapping, $tableInfo);
		
	}
	
	/**
	 * @dataProvider conditionResultProvider
	 */
	
	function testAvatarUsers($post,$join,$totalResultUserCount)
	{ 
	   $sqlPath = $this->getSqlPath().DS.__FUNCTION__.".start.sql";
	    $this->_DBO->loadSql($sqlPath);
	     
	    //$this->resetCachedData();

		$model = XiusFactory::getInstance('users','model');
		$strQuery= $model->getQuery($post,$join);
		
        $db = JFactory::getDBO();
		$db->setQuery((string)$strQuery);
		$users = $db->loadObjectList();	
		
	   $this->assertEquals($totalResultUserCount,count($users),'Total users should be '.$totalResultUserCount.' but we get '.count($users));
	  
	}
	
	function conditionResultProvider() 
	{
		
		// search Avatar users
		$post1[]			= array('infoid'=>6,'value'=>'User','operator'=>'=');
		$post1[]            = array('infoid'=>10,'value'=>'0','operator'=>'=');
							
		$join1	=	'OR';						
		$result1		= 9;
		
		$post2[]			= array('infoid'=>6,'value'=>'User','operator'=>'=');
		$post2[]            = array('infoid'=>10,'value'=>'1','operator'=>'=');
		
		$join2	  =	 'OR';						
		$result2		= 7;
		
		$post3[]			= array('infoid'=>6,'value'=>'john','operator'=>'=');
		$post3[]            = array('infoid'=>10,'value'=>'0','operator'=>'=');
		$join3	  =	'AND';						
		$result3		= 1;
		
		$post4[]			= array('infoid'=>10,'value'=>'All Users','operator'=>'=');
		$result4		= 9;
		
		return array(
                   	 array($post1,$join1,$result1),
					 array($post2,$join2,$result2),
					 array($post3,$join3,$result3),
					 array($post4,'AND',$result4)
					);
		
	}
}
?>
