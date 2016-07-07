<?php

class EditController extends ControllerBase
{
	public function initialize()
	{
		parent::initialize();
		if(empty(parent::getAuth())){
			$this->response->redirect('terminal/signin');
		}
	}
	
    public function indexAction()
    {
		$user = Users::findFirst(array(
			"(email = :email:)",
			'bind' => array('email' => $this->_auth['email'])
		));
		
    	if ($this->request->isPost() == true) {
    		//$user = Users::findFirsr($this->_auth['email']);
    		 
    		//Post Params
			$name 	   = $this->request->getPost('name');
			$extension = $this->request->getPost('extension');
			
			//拡張子取得
			$info = new SplFileInfo($_FILES["image"]["name"]);
			$image     = uniqid() . "." . $info->getExtension();
    		
			$user->name      = $name;
			$user->extension = $extension;
			$user->image     = $image;
    		 
    		if ($user->save() == false) {
    			//バリデーションエラー内容
    			foreach ($user->getMessages() as $message) {
    				$errorMsg[$message->getField()] = $message->getMessage();
    			}
				
    			$this->view->errorMsg  = $errorMsg;
				$this->view->name      = $name;
				$this->view->extention = $extension;
				$this->view->image     = $image;
    		} else {
				//$this->logger->info(print_r($_FILES, 1));
				//$this->logger->info(dirname(__FILE__));
				
				//画像の保存
				if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
					if (move_uploaded_file($_FILES["image"]["tmp_name"], "/Applications/MAMP/htdocs/terminal/public/img/users_img/" . $image)) {
						chmod("/Applications/MAMP/htdocs/terminal/public/img/users_img/" . $image, 0644);
						$this->logger->info($image . "をアップロードしました。");
					} else {
						$this->logger->info("アップロードに失敗しました。");
					}
				}
				
				$this->_registerSession($user);
    			$this->dispatcher->forward(
    				array(
    					 'controller' => 'Edit'
    					,'action'     => 'success'
    				)
    			);
    		}
    	} else {
			$this->view->name        = $user->name;
			$this->view->extension   = $user->extension;
			$this->view->image       = $user->image;
		}
    }
    
    //登録成功時
    public function successAction()
    {
    	//新規登録画面から遷移時のみ表示
    	if($this->request->isPost() == false){
    		$this->response->redirect();
    	}
    }
    
}