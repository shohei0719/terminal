<?php

class PasswordController extends ControllerBase
{
	public function initialize()
	{
		parent::initialize();
		if(empty(parent::getAuth())){
			$this->response->redirect('terminal/signin');
		}
		$this->user = new Users();
		$this->logger->info($this->logMsg("パスワード変更を操作しました。"));
	}

	/*
	 * Ajax
	 */
  public function indexAction()
  {

		//View使用しない
		$this->view->disable();

		/*
		 * ajaxの場合のみ処理する
		 */
		if($this->request->isAjax() == true){

			$user = Users::findFirst(array(
				"(id = :id:)",
				'bind' => array('id' => $this->_auth_user['id'])
			));

			//Post Params
			$new_password  = $this->request->getPost('new_password');
			$re_password 	 = $this->request->getPost('re_password');

			$user->password   				= $new_password;
			$user->re_password 				= $re_password;
			$user->updated_user_type 	= 2; //1:管理者 2:ユーザ
			$user->updated_id  				= $this->_auth_user['id'];
			$user->updated_at  				= date('Y-m-d H:i:s');

			if ($user->save() == false) {
				//バリデーションエラー内容
				foreach ($user->getMessages() as $message) {
					$errorMsg[$message->getField()] = $message->getMessage();
					$this->logger->info($this->logMsg($message->getMessage()));
				}

				$result = array('status' => false, 'errorMsg_new_password' => $errorMsg['password'], 'errorMsg_re_password' => $errorMsg['re_password']);

			} else {

				$this->logger->info($this->logMsg("パスワードの更新に成功しました。"));
				$result = array('status' => true, 'successMsg' => "パスワードの更新に成功しました。画面上に反映させる場合は、ページを更新してください。");

			}

			//インスタンス作成
			$response = new \Phalcon\Http\Response();

			//JSON形式
			$contentType = 'application/json';
			$response->setContentType($contentType, 'UTF-8');
			$response->setContent(json_encode($result));

			//処理結果を返す
			return $response;

		} else {

			$this->logger->info($this->logMsg("AJax以外でアクセスしたためTOPへリダイレクトしました。"));
			//Ajaxでのリクエスト以外はTOPへリダイレクト
			$this->response->redirect('terminal');
		}
  }
}
