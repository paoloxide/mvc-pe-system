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
			if($_POST['post-flag'] == 'add') {
				if($_POST['user-type'] == 'professor') {
					echo 'hi';
				} else {
					$newDate = explode('-',$_POST['user-bday']);
					$date = new DateTime();
					$date->setDate($newDate[0],$newDate[1],$newDate[2]);
					$name = $_POST['given-name'].' '.$_POST['mid-name'].', '.$_POST['last-name'];
					$newRow = array('user_name' 	=> $name,
									'user_email'	=> $_POST['stud-email'],
									'user_password' => md5($_POST['stud-password']),
									'user_gender'	=> $_POST['stud-gender'],
									'user_birthday' => $date->format('Y-m-d'),
									'user_phone'	=> $_POST['stud-phone'],
									'user_type'		=> $_POST['user-type'],
									'user_created'  => date('Y-m-d H:i:s'),
									'user_updated'	=> date('Y-m-d H:i:s'),
									'student_number'=> $_POST['stud-number'],
									'student_year'	=> $_POST['stud-year'],
									'student_college' => $_POST['stud-college'],
									'student_course'  => $_POST['stud-course'],
									'student_FPA'	  => 0,
									'student_enrol'	  => 0);
					$arguments = array('type' => 'student',
									   'row'  => $newRow);
					enrolment()->Data()->secureCalling('add', $arguments, 'user');
					unset($_POST);
				}
			}
		}
		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
