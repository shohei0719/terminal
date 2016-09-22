<?php

class SignoutController extends ControllerBase
{
	/*
	 * session
	 */
	private function _removeSession()
	{
		$this->session->remove('auth_user');
		//$this->session->destroy();
	}

	public function initialize()
	{
		//parent::initialize();
		$this->logger->info($this->logMsg("ログアウトしました。"));
	}

  public function indexAction()
  {
  	$request = new \Phalcon\Http\Request();
  	$this->_removeSession();
  	//$this->response->redirect($request->getHTTPReferer());
		$this->response->redirect('terminal/signin');
  }
}
