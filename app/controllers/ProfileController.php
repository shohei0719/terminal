<?php

class ProfileController extends ControllerBase
{
	public function initialize()
	{
		parent::initialize();
		if(empty(parent::getAuth())){
			$this->response->redirect('terminal/signin');
		}
		$this->user = new Users();
		$this->logger->info($this->logMsg('プロフィール変更を操作しました。'));
	}

  public function indexAction()
  {
		//この形式で取得でき
		$this->view->disable();

		/*
		 * ajaxの場合のみ処理する
		 */
		if($this->request->isAjax() == true){

			$user_name = $this->request->getPost('user_name');
			$user_mail = $this->request->getPost('user_mail');
			$this->logger->info('user_name : ' . $user_name);
			$this->logger->info('user_mail : ' . $user_mail);

			$user = Users::findFirst(array(
				"(id = :id:)",
				'bind' => array('id' => $this->_auth_user['id'])
			));

			$user->name = $user_name;
			$user->mail = $user_mail;
			$user->updated_user_type = 2; //1:管理者 2:ユーザ
			$user->updated_id  = $this->_auth_user['id'];
			$user->updated_at  = date('Y-m-d H:i:s');

			if ($user->save() == false) {
				//バリデーションエラー内容
				foreach ($user->getMessages() as $message) {
					$errorMsg[$message->getField()] = $message->getMessage();
					$this->logger->info($this->logMsg($message->getMessage()));
				}

				$result = array('status' => false, 'errorMsg_name' => $errorMsg['name'], 'errorMsg_mail' => $errorMsg['mail']);

			} else {

				//セッション更新
				$user = Users::findFirst(array(
					"(id = :id:)",
					'bind' => array('id' => $this->_auth_user['id'])
				));
				$this->_registerSession($user);

				$this->logger->info($this->logMsg("プロフィールの更新に成功しました。"));
				$result = array('status' => true, 'successMsg' => "プロフィールの更新に成功しました。画面上に反映させる場合は、ページを更新してください。");

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
