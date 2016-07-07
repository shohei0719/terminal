<?php

class SigninController extends ControllerBase
{
	/*
	 * session
	 */

	public function initialize()
	{
		parent::initialize();
	}

    public function indexAction()
    {

    	if($this->request->isPost() == true){
    		//$user = new Users();

    		//Post Params
    		$mail		= $this->request->getPost('mail');
    		$password	= $this->request->getPost('password');
$this->logger->info($password);
    		echo $mail;

    		$user = Users::findFirst(array(
				      "(mail = :mail:)",
            	'bind' => array('mail' => $mail)
        ));
$this->logger->info($user->mail);
    		if(!empty($user->mail)){
$this->logger->info('aaaaaaaaaaaaa');
$this->logger->info($user->password);
    			if ($this->security->checkHash($password , $user->password)) {
$this->logger->info($user->mail);
    				$this->_registerSession($user);
    				$this->response->redirect('/terminal/');
			    }
    		}

    		$this->view->errorMsg = 'メールアドレスもしくはパスワードが間違っています。';
    	}

    }

}
