<?php
/**
* @Copyright Ready Bytes Software Labs Pvt. Ltd. (C) 2010- author-Team Joomlaxi
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/
// no direct access
defined('_JEXEC') or die('Restricted access');

// Include library dependencies
jimport('joomla.filter.input');

/**
* Table class
*
* @package          Joomla
* @subpackage		profilestatus
*/

class XiusTableConditions extends JTable 
{
	var $id 				= null;
	var $listid 			= null;
  	var $infoid				= null;
  	var $operator			= null;
  	var $value				= null;
  	var $combinecondition	= null;

    /**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('#__xius_conditions', 'id', $db);
	}
	
	function load( $id)
	{
		if($id)
			return parent::load( $id );
			
		$this->id					= 0;
		$this->listid				= 0;
		$this->infoid				= 0;
		$this->operator				= 0;
		$this->value				= '0';
		$this->combinecondition		= '0';
		
		return true;
	}

	function delete()
	{		
		return parent::delete();
	}
	
	/**
	 * Overrides Joomla's JTable store method so that we can define proper values
	 * upon saving a new entry
	 * 
	 * @return boolean true on success
	 **/
	function store( )
	{
		//$db		=& $this->getDBO();
 		return parent::store();
	}


	/**
	 * Bind AJAX data into object's property
	 * @param	array	data	The data for this field
	 **/
	function bind($data)
	{
		/*	if(is_object($data))
				$data = (array)$data;
				
			foreach($data as $k => $v){
				if(in_array($k,$this->getProperties()))
					$this->$k = $v;
			}*/
			
			return parent::bind($data);
	}
	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 */
	/*function check() {
		if (trim($this->name) == '') {
			$this->setError(JText::_('YOUR CONDITIONS MUST CONTAIN A NAME'));
			return false;
		}
		return true;
	}*/

}
?>