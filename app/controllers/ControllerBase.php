<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;

class ControllerBase extends Controller
{

	protected $_auth_user = '';

    /*
	 * session
	 */
	public function _registerSession(Users $user){
		$this->session->set('auth_user', array(
			'id'    => $user->id,
			'mail' =>  $user->mail,
			'name'  => $user->name
		));
	}

    protected function initialize()
    {
		//最後に/がない場合はリダイレクト
		if(substr($_SERVER['REQUEST_URI'], -1) != '/'){
			$this->response->redirect($_SERVER['REQUEST_URI'] . '/');
		}

    	//Viewに管理者情報を渡す
    	$this->setAuth();

    	if(!empty($this->_auth_user)){
			$this->view->auth_user_id   = $this->_auth_user['id'];
    		$this->view->auth_user_name = $this->_auth_user['name'];
    	}
    }

    public function setAuth()
    {
    	$this->_auth_user = $this->session->get('auth_user');
    }

    public function getAuth()
    {
    	return $this->_auth_user;
    }
}
