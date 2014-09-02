<?php //-->
/*
 * This file is part a custom application package.
 */

/**
 * Default logic to output a page
 */
class Enrolment_Page_Admin_List extends Enrolment_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'COPERS | Class List';
	protected $_class = 'home';
	protected $_template = '/admin/list.phtml';
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function render() {
		if(!isset($_SESSION['clientEmail']) || !isset($_SESSION['clientType'])) {
			header('Location: http://plmcopers.edu.ph/welcome');
			exit;
		}
		
		$subject = enrolment()->Data()->secureCalling('gather', NULL, 'subject');
		$professor = enrolment()->Data()->secureCalling('gather', NULL, 'professor');
		$this->_body['schedule'] = $subject;
		$this->_body['instructor'] = $professor;
		
		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
