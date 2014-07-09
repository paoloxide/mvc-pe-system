<?php //-->
/*
 * This file is part a custom application package.
 */

/**
 * Default logic to output a page
 */
class Enrolment_Page_Accounts_Account extends Enrolment_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'COPERS | Account Settings';
	protected $_class = 'home';
	protected $_template = '/accounts/account.phtml';
	
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
		
		if(!empty($_POST)) {
			if($_POST['function-flag'] == 'home-student') {
				setcookie('pageUser', 'student');
				$this->_body['pageUser'] = 'student';
			} else {
				setcookie('pageUser', 'professor');
				$this->_body['pageUser'] = 'professor';
			}
		}
		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
