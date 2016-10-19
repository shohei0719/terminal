<?php

class SigninController extends ControllerBase
{
    /*
     * session
     */

    public function initialize()
    {
        parent::initialize();
        if(parent::getAuth()){
            $this->response->redirect('terminal');
            $this->logger->info($this->logMsg("ログイン中のためトップ画面へリダイレクトしました。"));
        }
    }

    public function indexAction()
    {
        if($this->request->isPost() == true){
            //Post Params
            $mail        = $this->request->getPost('mail');
            $password    = $this->request->getPost('password');

            $user = Users::findFirst(array(
                "(mail = :mail:)",
                'bind' => array('mail' => $mail)
            ));

            if(!empty($user->mail)){
                if ($this->security->checkHash($password , $user->password)) {
                    $this->_registerSession($user);
                    $this->logger->info($this->logMsg('ログインに成功しました。'));
                    $this->response->redirect('/terminal/');
                }
            }

            $this->view->errorMsg = 'メールアドレスもしくはパスワードが間違っています。';
            $this->logger->info($this->logMsg('メールアドレスもしくはパスワードが間違っています。'));
        }
    }
}
