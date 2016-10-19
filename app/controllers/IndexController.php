<?php

class IndexController extends ControllerBase
{

    public function initialize()
    {
        parent::initialize();
        if(empty(parent::getAuth())){
            $this->response->redirect('terminal/signin');
            $this->logger->info($this->logMsg("ログイン画面へリダイレクトしました。"));
        }
        $this->terminal = new Terminals();
        $this->search = new Searches();
        $this->logger->info($this->logMsg("端末一覧を表示または操作しました。"));
    }

    public function indexAction()
    {
        //検索結果を取得する
        if($_GET['search']){
            $search = ($_GET['search']);
//$this->logger->debug($search);
            $this->view->search = $search;

            //受け取ったキーワードの全角スペースを半角スペースに変換する
            $words = str_replace("　", " ", $search);
            //キーワードを空白で分割する
            $array = explode(" ", $words);
            //検索結果結果取得(ids)
            $search_result = $this->search->getSearchResult($array);
            //search結果のidsを基に結果取得
            $terminal = $this->terminal->getIdSearchResult($search_result);

        } else {
            //表示条件を満たす全端末情報を取得
            $terminal = $this->terminal->getAllResult();
        }

        //ログイン中のユーザ情報を取得
        $user_name = $this->_auth_user['name'];
        $user_mail = $this->_auth_user['mail'];

        //ページャ処理
        if($_GET['page']){
            $currentPage = ($_GET['page']);
        }
        $paginator = new Phalcon\Paginator\Adapter\Model(array(
            "data" => $terminal,
            "limit" => 20,
            "page" => $currentPage
        ));
        $page = $paginator->getPaginate();

        $this->view->setVar("page", $page);
        $this->view->user_name = $user_name;
        $this->view->user_mail = $user_mail;
    }

    public function editAction()
    {
        //ID取得
        if($_GET['id']){
            $id = ($_GET['id']);
        }

        //idの端末情報取得
        $terminal = $this->terminal->getTerminalInfo($id);

        //レンタルフラグとコメント取得
        $rental_flg = $this->request->getPost('rental_flg');
        $comment         = $this->request->getPost('comment');

        $terminal->rental_flg  = $rental_flg;
        $terminal->rental_user = $this->_auth_user['id'];
        $terminal->comment     = $comment;
        $terminal->updated_id  = $this->_auth_user['id'];
        $terminal->updated_at  = date('Y-m-d H:i:s');

        if ($terminal->save() == false) {
            //バリデーションエラー
            foreach ($terminal->getMessages() as $message) {
                $errorMsg[$message->getField()] = $message->getMessage();
            }
        }
        else {
            $this->logger->info($this->logMsg("端末[$id]の更新に成功しました。"));
            $this->response->redirect('terminal');
        }
    }
}
