<?php

class Data extends Eden_Class {
	
	protected $_database = NULL;
	
	public function __construct() {
		$this->_app = Eden::i()->getActiveApp();
		$this->_database = $this->_app->database();
	}
	
	public function secureCalling($methodCall = NULL, $arguments = NULL, $tableName = NULL) {
		if($methodCall == 'search') {
			$parameter = explode('~', $arguments);
			return $this->getItem($parameter[0], $parameter[1], $tableName);
		} else if($methodCall == 'gather') {
			if($tableName == 'subject') {
				return $this->getSubject();
			} else if($tableName == 'professor') {
				return $this->getProfessor();
			} else if($tableName == 'student') {
				return $this->getStudent();
			}
			return $this->getData($tableName); 
		} else if($methodCall == 'update') {
			return $this->updateTable($tableName, $arguments['colName'], $arguments['filter'], $arguments['list']);	
		} else if($methodCall == 'add') {
			if($arguments['type'] == 'subject') {
				$this->addSubject($arguments['row']);
			} else {
				$this->addUser($arguments['type'], $arguments['row']);
			}
		}
	}
	
	protected function getItem($haystack = NULL, $needle = NULL, $tableName = NULL) {
		return $rows = $this->_database
					->search($tableName)
					->addFilter($haystack.'=%s',$needle)
					->getRows();	
	}
	
	protected function getData($tableName = NULL) {
		return $rows = $this->_database
					->search($tableName)
					->getRows();
	}
	
	protected function getStudent() {
		return $rows = $this->_database
					->search('student')
					->innerJoinOn('user', 'user_id = student_user')
					->getRows();
	}
	
	protected function getProfessor() {
		return $rows = $this->_database
					->search('professor')
					->innerJoinOn('user', 'user_id = professor_user')
					->getRows();
	}
	
	protected function getSubject() {
		return $rows = $this->_database
					->search('subject')
					->innerJoinOn('professor', 'professor_id = subject_professor')
					->innerJoinOn('user', 'user_id = professor_user')
					->getRows();
	}
	
	protected function updateTable($tableName = NULL, $colName = NULL, $filter = NULL, $list = NULL) {
		return $rows = $this->_database
					->setRow($tableName,$colName,$filter,$list);
	}
	
	protected function addUser($userType = NULL, $row = NULL){
		if($userType == 'professor') {
			$this->_database
				->model($row)
				->save('user')
				->copy('user_id','professor_user')
				->save('professor');
		} else {
			$this->_database
				->model($row)
				->save('user')
				->copy('user_id','student_user')
				->save('student');
		}
	}
	
	protected function addSubject($row = NULL){
		$this->_database
			->model($row)
			->save('subject');
	}
}