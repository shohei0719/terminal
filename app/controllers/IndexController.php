<?php

class IndexController extends ControllerBase
{

	public function initialize()
	{
		parent::initialize();
		if(empty(parent::getAuth())){
			$this->response->redirect('terminal/signin');
		}
		$this->terminal = new Terminals();
	}

  public function indexAction()
  {
		$terminal = $this->terminal->getAllResult();

  	if(!empty($this->request->getQuery('page'))){
  		$currentPage = $this->request->getQuery('page');
  	}

  	$paginator = new Phalcon\Paginator\Adapter\Model(array(
  			"data" => $terminal,
  			"limit" => 5,
  			"page" => $currentPage
  	));

  	//$this->view->paginator = $pginator
  	$page = $paginator->getPaginate();

  	$this->logger->info(print_r($page,1));

  	$this->view->setVar("page", $page);

  }

	public function editAction()
  {
		//ID取得
		if(!empty($this->request->getQuery('id'))){
			$id = $this->request->getQuery('id');
		}

		//検索
		$terminal = $this->terminal->getTerminalInfo($id);

		//Post Params
		$rental_flg = $this->request->getPost('rental_flg');
		$comment = $this->request->getPost('comment');

$this->logger->info($this->_auth_user['id']);

		$terminal->rental_flg  = $rental_flg;
		$terminal->comment     = $comment;
		$terminal->updated_id  = $this->_auth_user['id'];
		$terminal->updated_at  = date('Y-m-d H:i:s');

		if ($terminal->save() == false) {

			//バリデーションエラー内容
			foreach ($terminal->getMessages() as $message) {
				$errorMsg[$message->getField()] = $message->getMessage();
			}

		}
		else {
			$this->response->redirect('terminal');
		}
  }

	public function testAction(){
		//ajaxの場合
		if($this->request->isAjax() == true){

			$page = $this->request->getPost('page');
$this->logger->info($page);
			$status = 200;
			$description = 'OK';
			$headers = array();
			$contentType = 'application/json';

			$this->response->setContentType($contentType, 'UTF-8');

		}
	}
}
