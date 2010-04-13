<?php
/**
 *
 */

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

class UserlistTableConditions extends JTable {

	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;
	var $name = null;
	var $listid = null;
	var $fieldid = null;
	var $operator = null;
	var $value = null;
	var $combinecondition = null;
	var $published = null;

    /**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('#__userlist_conditions', 'id', $db);
	}
	
	function load( $id)
	{
		if( $id == 0 )
		{
			$this->id			= 0;
			$this->name			= '0';
			$this->listid		= 0;
			$this->fieldid		= 0;
			$this->operator		= 0;
			$this->value		= '0';
			$this->combinecondition		= '0';
			$this->published	= true;
		}
		else
		{
			return parent::load( $id );
		}
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
			///*
			$this->id					= $data['id'];
			$this->name					= $data['name'];
			$this->listid				= $data['listid'];
			$this->fieldid				= $data['fieldid'];
			$this->operator				= $data['operator'];
			$this->value				= $data['value'];
			$this->combinecondition		= $data['combinecondition'];
			$this->published			= $data['published'];
			//*/
			/*
			$this->name			= $data->name;
			$this->total		= $data->total;
			$this->value		= $data->value;
			*/
			//print_r($this);
			return parent::bind($data);
	}
	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 */
	function check() {
		if (trim($this->name) == '') {
			$this->setError(JText::_('YOUR CONDITIONS MUST CONTAIN A NAME'));
			return false;
		}
		return true;
	}

}
?>