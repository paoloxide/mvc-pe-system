<?php //-->
/*
 * This file is part a custom application package.
 */

/**
 * The base class for any class that defines a view.
 * A view controls how templates are loaded as well as 
 * being the final point where data manipulation can occur.
 *
 * @package    Eden
 */
abstract class Enrolment_Page extends Eden_Class {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_meta	= array();
	protected $_head 	= array();
	protected $_body 	= array();
	protected $_foot 	= array();
	
	protected $_title 		= NULL;
	protected $_class 		= NULL;
	protected $_template 	= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Get
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public function __toString() {
		try {
			$output = $this->render();
		} catch(Exception $e) {
			Eden_Error_Event::i()->exceptionHandler($e);
			return '';
		}
		
		if(is_null($output)) {
			return '';
		}
		
		return $output;
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Returns a string rendered version of the output
	 *
	 * @return string
	 */
	abstract public function render();
	
	/* Protected Methods
	-------------------------------*/
	protected function _page() {
		$this->_head['page'] = $this->_class;
	
		$page = enrolment()->path('template');
		$head = enrolment()->trigger('head')->template($page.'/_head.phtml', $this->_head);
		$body = enrolment()->trigger('body')->template($page.$this->_template, $this->_body);
		$foot = enrolment()->trigger('foot')->template($page.'/_foot.phtml', $this->_foot);
		
		if($this->_template == '/index.phtml' || $this->_template == '/login.phtml' ) {
			$head = NULL;
			$foot = NULL;
		}
		
		$foot = NULL;
		//page
		return enrolment()->template($page.'/_page.phtml', array(
			'meta' 			=> $this->_meta,
			'title'			=> $this->_title,
			'class'			=> $this->_class,
			'head'			=> $head,
			'body'			=> $body,
			'foot'			=> $foot));
	}
	
	/* Private Methods
	-------------------------------*/
}