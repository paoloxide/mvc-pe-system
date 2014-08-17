<?php //-->
/*
 * This file is part a custom application package.
 */

/**
 * Default logic to output a page
 */
class Enrolment_Page_Admin_Schedule extends Enrolment_Page {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_title = 'COPERS | Schedule';
	protected $_class = 'home';
	protected $_template = '/admin/schedule.phtml';
	
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
				$faculty = 'professor_id' . '~' . $_POST['add-schedule-faculty'];
				$data = enrolment()->Data()->secureCalling('search', $faculty, 'professor');
				$newRow = array('subject_code'		=> $_POST['add-schedule-code'],
								'subject_name'		=> $_POST['add-schedule-name'],
								'subject_day'		=> $_POST['add-schedule-day'],
								'subject_time'		=> $_POST['add-schedule-time'],
								'subject_professor'	=> $data[0]['professor_id'],
								'subject_active'  	=> 1,
								'subject_enrolees'	=> 0);
				$arguments = array('type' => 'subject', 'row'  => $newRow);
				enrolment()->Data()->secureCalling('add', $arguments, 'user');
			} else if($_POST['post-flag'] == 'edit') {
				$faculty = 'user_name' . '~' . $_POST['schedule-faculty'];
				$data = enrolment()->Data()->secureCalling('search', $faculty, 'user');
				$newRow = array('subject_code'		=> $_POST['schedule-code'],
								'subject_name'		=> $_POST['schedule-name'],
								'subject_day'		=> $_POST['schedule-day'],
								'subject_time'		=> $_POST['schedule-time'],
								'subject_professor'	=> $data[0]['user_id'],
								'subject_active'  	=> 1,
								'subject_enrolees'	=> 0);
				$arguments = array('colName' => 'subject_code', 'filter' => $newRow['subject_code'], 'list' => $newRow);
				enrolment()->Data()->secureCalling('update', $arguments, 'subject');
			}
			unset($_POST);
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
