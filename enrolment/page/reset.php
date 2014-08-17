<?php //-->
/*
 * This file is part a custom application package.
 */

/**
 * Default logic to output a page
 */
class Enrolment_Page_Reset extends Enrolment_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'COPERS | Reset Password';
	protected $_class = 'home';
	protected $_template = '/reset.phtml';
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	/* Public Methods
	-------------------------------*/
	public function render() {
		
		if(!isset($_GET['token'], $_GET['email'])){
			header('Location: http://plmcopers.edu.ph');
			exit;
		}
		
		if(isset($_GET['token'], $_GET['email'])) {
			$arguments = 'user_email' . '~' . $_GET['email'];
			$item = enrolment()->Data()->secureCalling('search', $arguments, 'user');
			$user=$item[0];
			if(empty($user)) {// if email is invalid
				header('Location: http://karrera.ph');
				exit;
			}
			
			$token = md5($user['user_id'].$user['user_email'].$user['user_password']);
			if($_GET['token'] != $token) { // if token is invalid
				$this->_body['message'] = 'error';
				return $this->_page();
			}
			
			$this->_body['user'] = $user;
			$this->_body['message'] = 'reset';
			if(!empty($_POST)) {
				if($_POST['new-password'] != $_POST['confirm-password']) {
					$_SESSION['error'] = array('type' => 'alert', 'message' => 'Password Mismatch');
					header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
					exit;
				} else {
					$this->_body['message'] = 'success';
					//update database
					$row = array('user_password' => md5($_POST['new-password']));
					$arguments = array('colName' => 'user_password',
									   'filter'  => $user['user_password'],
									   'list'	 => $row);
					enrolment()->Data()->secureCalling('update', $arguments, 'user');
				}
			}
			
		} else if(isset($_GET['token'])) {
			header('Location: /');
			exit;
		} else if(isset($_GET['email'])) {
			header('Location: /');
			exit;
		}
		
		return $this->_page();
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}
