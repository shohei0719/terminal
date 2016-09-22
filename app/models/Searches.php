<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness as UniquenessValidator;
use Phalcon\Mvc\Model\Validator\PresenceOf as PresenceOfValidator;
use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\Model\Query;
//use Phalcon\Db\Dialect\MysqlExtended as MysqlExtended;
//use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class Searches extends Model
{

    public function initilize()
    {
        //searchesテーブル
        $this->setSource('searches');
    }

    /*
     * 検索結果を返す
     * @param $words 検索ワードをスペース区切りで分解
     * @return $terminals 検索結果
     */
    public function getSearchResult($words)
    {
        $phql = "SELECT s.terminal_id FROM Searches AS s";

        $cnt = 0;
        foreach($words as $word){
            if($cnt == 0){
              $phql .= " WHERE ";
            } else {
              $phql .= " AND ";
            }

            $phql .= "(s.name LIKE '%$word%'";
            $phql .= " OR s.os LIKE '%$word%'";
            $phql .= " OR s.version LIKE '%$word%'";
            $phql .= " OR s.carrier LIKE '%$word%'";
            $phql .= " OR s.maker LIKE '%$word%'";
            $phql .= " OR s.organization LIKE '%$word%'";
            $phql .= " OR s.comment LIKE '%$word%')";

            $cnt++;
        }

        $datas = $this->modelsManager->executeQuery($phql);

        $terminal_ids = array();
        foreach($datas as $value){
            $terminal_ids[] = $value['terminal_id'];
        }

        //検索結果が0件の場合ダミーのID:0を入れる(処理的に気持ち悪いので直せるか検討)
        if(empty($terminal_ids)){
            $terminal_ids[] = 0;
        }

        return $terminal_ids;
    }
}
