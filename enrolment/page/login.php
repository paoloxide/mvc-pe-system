<?php //-->
/*
 * This file is part a custom application package.
 */

/**
 * Default logic to output a page
 */
class Enrolment_Page_Login extends Enrolment_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'COPERS | Sign in';
	protected $_class = 'home';
	protected $_template = '/login.phtml';
	protected $_error = array();
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function render() {
		if(!empty($_POST)) {
			$arguments = 'user_email' . '~' . $_POST['email'];
			$item = enrolment()->Data()->secureCalling('search', $arguments, 'user');
			$this->_isError($item); //Error Trapping
			
			if($_POST['login-form'] == 'forgot') {
				if(!empty($this->_error)) {
					$_SESSION['errorMessage'] = $this->_error[0]['message'];
					header('Location: http://plmcopers.edu.ph/login');
					exit;
				}
			} else if($_POST['login-form'] == 'not-forgot') {
				if(!empty($this->_error)) {
					$_SESSION['errorMessage'] = $this->_error[0]['message'];
					header('Location: http://plmcopers.edu.ph/login');
					exit;
				} else if($item[0]['user_type'] == 'admin') {
					$_SESSION['clientEmail'] = $item[0]['user_email'];
					$_SESSION['clientType'] = 'superuser';
					header('Location: http://plmcopers.edu.ph/home');
					exit;
				} else if($item[0]['user_type'] == 'professor') {
					$_SESSION['clientEmail'] = $item[0]['user_email'];
					header('Location: http://plmcopers.edu.ph/professor');
					exit;
				} else if($item[0]['user_type'] == 'student') {
					$_SESSION['clientEmail'] = $item[0]['user_email'];
					header('Location: http://plmcopers.edu.ph/student');
					exit;
				}
			}
		}
		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	protected function _isError($item) {
		if(isset($_POST['email'])) {
			if(!empty($item)) {
				if($item[0]['user_active'] == 0) {
					$this->_error[] = array(
						'type'		=> 'error',
						'message'	=> 'Account no longer exists'
					);
				} else if($item[0]['user_password'] != md5($_POST['password'])) {
					$this->_error[] = array(
						'type'		=> 'error',
						'message'	=> 'Incorrect username or password'
					);
				}
			} else {
				$this->_error[] = array(
						'type'		=> 'error',
						'message'	=> 'Account is not existing'
				);
			}
		}
		
		return $this;
	}
	
	/* Private Methods
	-------------------------------*/
}
