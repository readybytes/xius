<?php
class InsertUserTest extends XiUnitTestCase
{
	function getSqlPath()
	{
		return dirname(__FILE__).'/sql/'.__CLASS__;
	}
	
	function insertUser($userLimit)
	{		
		$db = & JFactory::getDBO();
		$query 	='SELECT MAX(id) FROM `#__users`';
		$db->setQuery( $query );
		$userid = $db->loadResult();
		$userid = (int)$userid + 1;

		$config		=& JFactory::getConfig();
		$authorize	=& JFactory::getACL();
		$usersConfig = &JComponentHelper::getParams( 'com_users' );
		$newUsertype = 'Registered';
		$date =& JFactory::getDate();
		$registerDate = $date->toMySQL();
		
		
		for($i=1 ; ($userid+$i)<$userLimit ; $i++)
		{
			$user 		= new JUser();

			$user->set('id', 0);
			$user->set('usertype', $newUsertype);
			$user->set('gid', $authorize->get_group_id( '', $newUsertype, 'ARO' ));
			$user->set('registerDate', $registerDate);
			
			$this->bind($user, $userid+$i);
			$user->save();
			$this->communityUsers($user->id);
			$this->communityUserFields($user->id);
			//echo $user->id . "\n";
			//if($user->id == 100000)
			// break;
		}
	}
	
	function bind($user, $userid)
	{
		$user->name 		= "name$userid";
		$user->username 	= "username$userid";
		$user->email		= "username$userid@email.com";
		$user->password		= "password";	
	}
	
	function communityUsers($userid)
	{
		static $status		= "";
		static $points		= 0;
		static $posted_on	= '';
		static $avatar		= 'components/com_community/assets/default.jpg';
		static $thumb 		= 'components/com_community/assets/default_thumb.jpg';
		static $invite		= 0;
		static $params		= "notifyEmailSystem=1\nprivacyProfileView=30\nprivacyPhotoView=20\nprivacyFriendsView=20\nprivacyVideoView=1\nnotifyEmailMessage=1\nnotifyEmailApps=1\n\n";
		static $view		= 0;
		static $friendcount= 0;
		
		$db = & JFactory::getDBO();
		$query 	= 'INSERT INTO `#__community_users` (`userid`, `status`, `points`, `posted_on`, `avatar`, `thumb`, `invite`, `params`, `view`, `friendcount`)'
				. ' VALUES ('.$db->Quote($userid).','.$db->Quote($status).','.$db->Quote($points).','.$db->Quote($posted_on).','.$db->Quote($avatar).','.$db->Quote($thumb).','.$db->Quote($invite).','.$db->Quote($params).','.$db->Quote($view).','.$db->Quote($friendcount).')';
		$db->setQuery( $query );
		$db->query();				
	}	
	
	function communityUserFields($userid)
	{
		$data		= $this->getData();
		$day	  	= rand(1,28);
		$month		= rand(1,12);
		$year		= rand(1990,2000);
		$dob		= $year.'-'.$month.'-'.$day.' 23:59:59';

		$country_no	= rand(0,11);
		$country	=$data['country'][$country_no];
		
		$mobile 	= rand(0000000000,9999999999);
		$land		= rand(1111111111,9999999999);
		
		$gen_no		= rand(0,1);
		$gender 	= $data['gender'][$gen_no];
		
		$state_no	= rand(0,11);
		$state  	= $data['state'][$state_no];
		
		$city_no	= rand(0,26);
		$city		= $data['city'][$city_no];
		
		$fieldValues= array(2=>$gender, 3=>$dob, 4=>$city, 7=>$mobile, 8=>$land, 9=>$city, 10=>$state, 11=>$city, 12=>$country);
						
		$db = & JFactory::getDBO();

		foreach($fieldValues as $fieldId => $value)
		{
			$query 	= 'INSERT INTO `#__community_fields_values` (`user_id`, `field_id`, `value`) VALUES'
					  .' ('.$db->Quote($userid).','.$db->Quote($fieldId).','.$db->Quote($value).')';

			$db->setQuery( $query );
			$db->query();		
		}		
	}
	
	function getData()
	{
		static $data =null;
		
		if($data)
			return $data;
			
		$data['country'] =  array('Afghanistan','Albania','Algeria','American Samoa','Andorra','Angola','Anguilla','Antarctica','Antigua and Barbuda','Argentina','Armenia','Aruba');
		$data['gender']	 =  array('Male','Female');
		$data['state']	 =  array('Rajasthan','Orissa','Bihar','Delhi','Maharashtra','Uttar Pradesh','Andhra Pradesh','Assam','Goa','Gujrat','Haryana','Karnataka');
		$data['city']	 =  array('Bhilwara','Jaipur','Udaipur','Jodhapur','Mumbai','Delhi','Banglore','chennai','Indore','Bhopal','Kanpur','Noida','Kolkata','Hyderabad','Ahmedabad','Pune','Surat',
						'Nagpur','Chandigarh','Jalandhar','Shimla','Ludhiana','Alwar','Ajmer','Bikaner','Vadodara','Coimbatore');
		
		return $data;
	}
	
	function testPerformanceOn25000()
	{
		$this->resetCachedData();
		$this->insertUser(122);
		$this->updateCache();
		$data	= $this->xiusPerformance();
		$cusers = $this->jsPerformance();
		$this->assertEquals(count($cusers), $data['total']);		
	}
	
	function xxxtestPerformanceOn50000()
	{
		$url = dirname(__FILE__).DS.'sql'.DS.'InsertUserTest'.DS.'testPerformanceOn25000.start.sql';
  		$this->_DBO->loadSql($url);
  	
  		$this->resetCachedData();
		$this->insertUser(50000);
		echo "inserted";
		$this->updateCache();
		$data	= $this->xiusPerformance();
		$cusers = $this->jsPerformance();
		$this->assertEquals(count($cusers), $data['total']);
		
	}
	
	function updateCache()
	{	
		$db 			= & JFactory::getDBO();
		$startTicker	= $db->getTicker();
		$profiler 		= new JProfiler();
		$startMemory	= $profiler->getMemory();
				
		$startTime = $profiler->getmicrotime();
		
		require_once(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'controllers'.DS.'users.php');
		$insertedRows = XiusLibrariesUsersearch::updateCache();
		
		$endTime = $profiler->getmicrotime();
				
		$endTicker = $db->getTicker();
		$endMemory = $profiler->getMemory();
		echo "\n\n".'XIUS DB Ticker for Updating Cache '.($endTicker-$startTicker);
		echo "\n".'XIUS Memory for Updating Cache '.($endMemory-$startMemory);
		echo "\n".'XIUS '.$profiler->mark('Time in updating cache');
		
		//echo "\n".
		$time = $endTime - $startTime;
		echo "\n".'Time in updating cache '.$time;
	}
	
	function xiusPerformance()
	{		
		$compareCondition[0]["infoid"]	= 1;
		$compareCondition[0]["value"]	= 'Male';
		$compareCondition[0]["operator"]= '=';
		$compareCondition[1]["infoid"]	= 2;
		$compareCondition[1]["value"]	= 'Bhilwara';
		$compareCondition[1]["operator"]= '=';
		
		// data post
		$post			= array('xiusinfo_11'=>1,'field2'=>'Male','xiusinfo_12'=>1,'xiusinfo_21'=>2,'field11'=>'Bhilwara','xiusinfo_22'=>2);
		
		$profiler		= new JProfiler;	
		
		// get object of DBO for identifying number of queries
		$db 			= & JFactory::getDBO();
		$startTicker	= $db->getTicker();
		$startMemory	= $profiler->getMemory();
		
		// build the condition and  compare
		//$startTime 		= $profiler->getmicrotime();
		$conditions		= XiusLibrariesUsersearch::processSearchData($post);
		XiusLibrariesUsersearch::setDataInSession(XIUS_CONDITIONS,$conditions,'XIUS');
		XiusLibrariesUsersearch::setDataInSession(XIUS_JOIN,'AND','XIUS');
		
		// get the user data according to search condition
		require_once(JPATH_ROOT.DS.'components'.DS.'com_xius'.DS.'views'.DS.'users'.DS.'view.html.php');
		$startTime 		= $profiler->getmicrotime();
		$data = array(array());
		XiusViewUsers::_getInitialData(&$data);
		XiusViewUsers::_getUsers(&$data);		
		$endTime 		= $profiler->getmicrotime();
			
		// perrmace measurement in getting results
		$endTicker 		= $db->getTicker();
		$endMemory		= $profiler->getMemory();
		
		$this->assertEquals($compareCondition,$conditions);		
		$time = $endTime - $startTime;
		
		echo "\n\n".'XIUS DB Ticker for Searching Users '.($endTicker - $startTicker);
		echo "\n".'XIUS Memory for Searching Users '.($endMemory - $startMemory);
		echo "\n".'XIUS '.$profiler->mark('Time in Searching Users');
		echo "\n".'XIUS Time in Searching Users '.$time;
		echo "\n".'Start Time in Searching Users '.$startTime;
		echo "\n".'End Time in Searching Users '.$endTime;
		//print_r(var_export($db->getLog()));
		$noOfqueries	= 5; 	
		$this->assertFalse( $noOfqueries < ($endTicker - $startTicker) );
		XiusViewUsers::_getTotalUsers(&$data);	
		return $data;	
	}
	
	
	function jsPerformance()
	{		
		// performance measurement for jom Social
		$filter[0] = new StdClass();
		$filter[0]->field		= 'FIELD_CITY';
		$filter[0]->condition   = 'contain';
		$filter[0]->fieldType   = 'text';
		$filter[0]->value		= 'Bhilwara';
		
		$filter[1] = new StdClass();
		$filter[1]->field		= 'FIELD_GENDER';
		$filter[1]->condition   = 'equal';
		$filter[1]->fieldType   = 'select';
		$filter[1]->value		= 'Male';
		
		$profiler	= new JProfiler;	
		
		// get object of DBO for identifying number of queries
		$db = & JFactory::getDBO();
		$startTicker = $db->getTicker();
		$startMemory = $profiler->getMemory();		
					
		$join='and';
		require_once(JPATH_ROOT.DS.'components'.DS.'com_community'.DS.'models'.DS.'search.php');
		$model 	=new  CommunityModelSearch();
		$model->setState('limit',100000);
		$model->setState('limitstart',0);
		
		$startTime =$profiler->getmicrotime();
		
		$cusers = $model->getAdvanceSearch($filter,$join);
		
		$endTime =$profiler->getmicrotime();
		$time = $endTime - $startTime;
		// perrmace measurement in getting results
		$endTicker = $db->getTicker();
		$endMemory = $profiler->getMemory();
		echo "\n\n".'JS DB Ticker for Searching Users '.($endTicker - $startTicker);
		echo "\n".'JS Memory for Searching Users '.($endMemory - $startMemory);
		echo "\n".'JS '.$profiler->mark('Time in Searching Users');
		echo "\n".'JS Time in Searching Users '.$time;
		return $cusers;			
	}
	
}
