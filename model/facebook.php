<?php
date_default_timezone_set('Asia/Manila');
class Facebook extends Eden_Class {
	protected $_userInfo = array();
	protected $_test = NULL;
	
	public function __construct() {
		$this->_app = Eden::i()->getActiveApp()->database();
	}
	
	public function getDatabase() {
		$database = $this->_app->search('user')->getRows();
		return $database;
	}
	
	public function savePost($userId, $content, $platform) {
		$model = $this->_app->model();
		$model
			->setPostUser($userId)
			->setPostContent($content)
			->setPostPlatform($platform)
			->setPostCreated(date('Y-m-d H:i:s', time()))
			->save('post');
			
		return $this;
	}
	
	public function setUserInfo($user) {
		$this->_userInfo = $user;
		return $this;
	}
	
	public function storeUserInfo() {
		$user = $this->_userInfo;
		$data = $this->_app
			->search('user')
			->setColumns('*, COUNT(user_id) as total')
			->filterByUserFbid($user['id'])
			->getTotal();
			
		if($data == 0 && !empty($user['name']) && !empty($user['id'])) {
			$model = $this->_app->model();
			$model
				->setUserName($user['name'])
				->setUserFbid($user['id'])
				->setUserTtid('0')
				->setUserFbaccesstoken($_SESSION['access_token'])
				->setUserTtaccesstoken('0')
				->setUserTtaccesssecret('0')
				->save('user');
		} else {
			$settings = array('user_fbaccesstoken' => $_SESSION['access_token']);
			$filter[] = array('user_fbid=%s', $user['id']);
			$this->_app->updateRows('user', $settings, $filter);  
		}
		
		return $this;
	}
	
	public function getUserInfo() {
		$data = $this->_app
			->search('user')
			->innerJoinOn('post', 'post_user = user_id')
			->sortByPostCreated('DESC')
			->getCollection()
			->get();
						
		return $data; 
	}
}
?>