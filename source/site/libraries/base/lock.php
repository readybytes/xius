<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		xius
* @contact 		team@readybytes.in
*/
if(defined('_JEXEC')===false) die("Xius lock");

/**
 * lock class :
 * This class can be used when we need to handle simulataneous requests
 * by getting lock from database
 * 
 * @author Rimjhim Jain
 *
 */

class XiusLock
{
	public $_result   = null;
	public $_lockname = "";

	protected function __construct(){}
	
	static function getInstance($lockName="", $timeout=0)
	{
		static $instance = array();

		//if already there is an object and check for static cache clean up
		if(isset($instance[$lockName]))
			return $instance[$lockName];
		
		// create new instance if not cached
		$lock = new XiusLock();
		$lock->_lockname = $lockName;
		$lock->_result   = $lock->getLock($timeout);
		return $instance[$lockName] = $lock;
	}
	
	public function getLockResult()
	{
		return $this->_result;
	}
	
	public function getLockName()
	{
		return $this->_lockname;
	}
	
	/**
	 * returns :
	 * 1 for success, 
	 * 0 if a timeout occurs and the lock cannot be acquired, or 
	 * NULL if an error occurs...
	 * 
	 * @param string $lockName : name of requested lock 
	 * @param integer $timeout : timeout for simultaneous requests
	 */
	function getLock($timeout=0)
	{
		//get a lock only if it is free
		if(!$this->isFreeLock()){
			return false;
		}
		
		$query = new XiusQuery();
		return ($query->select("GET_LOCK('$this->_lockname','$timeout')")
							   ->dbLoadQuery()
							   ->loadResult())?true:false;
	}
	
	/**
	 * returns :
	 * 1 if the lock was released successfully, 
	 * 0 if the name was locked but not by the client requesting the release, and 
	 * NULL if the name was not locked...
	 * 
	 * @param string $lockName : name of lock to be released 
	 */
	function releaseLock()
	{
		$query = new XiusQuery();
		return ($query->select("RELEASE_LOCK('$this->_lockname')")
							     ->dbLoadQuery()
							     ->loadResult())?true:false;
	}
	
	/**
	 * returns :
	 * 1 if the name is not locked, 
	 * 0 if it is locked, and 
	 * NULL if an error occurs...
	 * 
	 * @param string $lockName : name of lock to be checked 
	 */
	function isFreeLock()
	{
		$query = new XiusQuery();
		return ($query->select("IS_FREE_LOCK('$this->_lockname')")
							     ->dbLoadQuery()
							     ->loadResult())?true:false;
	}
	
	/**
	 * returns :
	 * connection ID of the client that holds the lock on the name, or 
	 * NULL if the name is not locked...
	 * 
	 * @param string $lockName : name of lock to be checked 
	 */
	function isUsedLock()
	{
		$query = new XiusQuery();
		return $query->select("IS_USED_LOCK('$this->_lockname')")
							     ->dbLoadQuery()
							     ->loadResult();
	}
}