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
	protected $_error = array();
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function render() {
		$student = enrolment()->Data()->secureCalling('gather', NULL, 'student');
		$professor = enrolment()->Data()->secureCalling('gather', NULL, 'professor');
		$this->_body['student'] = $student;
		$this->_body['professor'] = $professor;
		
		if(!isset($_SESSION['clientEmail']) || !isset($_SESSION['clientType'])) {
			header('Location: http://plmcopers.edu.ph/welcome');
			exit;
		}
		if(!empty($_POST)) {
			if($_POST['post-flag'] == 'add') {
				$this->_isError();
				if(!empty($this->_error)) {
					return $this->_page();
				}
				if($_POST['user-type'] == 'professor') {
					$name = $_POST['last-name'].', '.$_POST['given-name'].' '.$_POST['mid-name'];
					$newRow = array('user_name' 	=> $name,
									'user_email'	=> $_POST['prof-email'],
									'user_password' => md5($_POST['prof-password']),
									'user_gender'	=> $_POST['prof-gender'],
									'user_phone'	=> $_POST['prof-phone'],
									'user_type'		=> $_POST['user-type'],
									'user_created'  => date('Y-m-d H:i:s'),
									'user_updated'	=> date('Y-m-d H:i:s'),
									'professor_number'=> $_POST['prof-number']);
					$arguments = array('type' => 'professor',
									   'row'  => $newRow);
					enrolment()->Data()->secureCalling('add', $arguments, 'user');
					$this->_error['type'] = 'success';
					$this->_error['message'] = 'Professor Successfully Added';
					$_SESSION['error'] = $this->_error;
				} else {

					$name = $_POST['last-name'].', '.$_POST['given-name'].' '.$_POST['mid-name'];
					$newRow = array('user_name' 	=> $name,
									'user_email'	=> $_POST['stud-email'],
									'user_password' => md5($_POST['stud-password']),
									'user_gender'	=> $_POST['stud-gender'],
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

					$this->_error['type'] = 'success';
					$this->_error['message'] = 'Student Successfully Added';
					$_SESSION['error'] = $this->_error;

				}
				unset($_POST);
			}
		}		
		return $this->_page();
	}
	/* Protected Methods
	-------------------------------*/
	protected function _isError() {
		if($_POST['user-type'] == 'professor') {
			$email = 'user_email' . '~' . $_POST['prof-email'];
			$number = 'professor_number' . '~' . $_POST['prof-number'];
			$dataEmail = enrolment()->Data()->secureCalling('search', $email, 'user');
			$dataNumber = enrolment()->Data()->secureCalling('search', $number, 'professor');
			if($_POST['prof-password'] != $_POST['prof-password2']) {
				$this->_error['type'] = 'error';
				$this->_error['message'] = 'Password Mismatch';
				$_SESSION['error'] = $this->_error;
			} else if(!empty($dataEmail[0]['user_email'])) {
				$this->_error['type'] = 'error';
				$this->_error['message'] = 'Account Already Taken';
				$_SESSION['error'] = $this->_error;
			} else if(!empty($dataNumber[0]['professor_number'])) {
				$this->_error['type'] = 'error';
				$this->_error['message'] = 'Employee Number Exists';
				$_SESSION['error'] = $this->_error;
			}
		} else {
			$email = 'user_email' . '~' . $_POST['stud-email'];
			$number = 'student_number' . '~' . $_POST['stud-number'];
			$dataEmail = enrolment()->Data()->secureCalling('search', $email, 'user');
			$dataNumber = enrolment()->Data()->secureCalling('search', $number, 'student');
			if($_POST['stud-password'] != $_POST['stud-password2']) {
				$this->_error['type'] = 'error';
				$this->_error['message'] = 'Password Mismatch';
				$_SESSION['error'] = $this->_error;
			} else if(!empty($dataEmail[0]['user_email'])) {
				$this->_error['type'] = 'error';
				$this->_error['message'] = 'Account Already Taken';
				$_SESSION['error'] = $this->_error;
			} else if(!empty($dataNumber[0]['student_number'])) {
				$this->_error['type'] = 'error';
				$this->_error['message'] = 'Student Number Exists';
				$_SESSION['error'] = $this->_error;
			}
		}
		
		return $this;
		
	}
	/* Private Methods
	-------------------------------*/
}
