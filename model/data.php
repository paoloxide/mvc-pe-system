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
			}
			return $this->getData($tableName); 
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
	
	protected function updateTable() {
		
	}
	
}