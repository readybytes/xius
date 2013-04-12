<?php
class XiusjuserTest extends XiSelTestCase
{

	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.'XiusjuserTest';
	}
	
	function testGetTableMapping()
	{       
		$this->changePluginState('xipt_system',true);
		$this->changePluginState('xipt_community',true);
		//$this->_DBO->loadSql(dirname(__FILE__).'/sql/XiusJuserTest/testViewSearchHtml.start.sql');
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
		$object->tableName			= $this->cleanWhiteSpaces("(   
			               SELECT `userid`, CASE `avatar`  WHEN '' THEN 1  WHEN 'components/com_community/assets/default.jpg' THEN 1  WHEN 'components/com_community/assets/user_thumb.png' THEN 1  WHEN 'images/profiletype/avatar_1.jpg' THEN 1  WHEN 'images/profiletype/avatar_2.jpg' THEN 1  ELSE  0  END as avatar
			               FROM `#__community_users`
				)");
		$object->tableAliasName 	= 'communityusersavatar_0';
		$object->originColumnName	= 'avatar';
		$object->cacheColumnName	= 'jsuseravatar_0';
		$object->cacheSqlSpec 		= 'TINYINT(1) NOT NULL DEFAULT 0';
		$object->cacheLabelName		= 'avatar';
		$object->createCacheColumn	= true;
		$tableInfo[]=$object;
		
		$this->assertEquals($this->cleanWhiteSpaces($mapping[0]->tableName), $this->cleanWhiteSpaces($tableInfo[0]->tableName));
		
	}
}