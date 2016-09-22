<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness as UniquenessValidator;
use Phalcon\Mvc\Model\Validator\PresenceOf as PresenceOfValidator;
use Phalcon\Mvc\Model\Message;

class Oss extends Model
{

    public function initilize()
    {
      //ossテーブル
      $this->setSource('oss');
    }

    /*
     * 検索結果を返す
     * @param $permission
     * @param $name
     * @param $mail
     * @return $oss 検索結果
     */
    public function getSearchResult($name)
    {
        $criteria = Oss::query();

        if(!empty($name)){
            $criteria->andwhere('name LIKE :name:', ['name' => '%' . $name . '%']);
        }

        $criteria->andwhere('delete_flg = :delete_flg:', ['delete_flg' => $this->getDI()->get('config')->define->valid]);
        $oss = $criteria->execute();

        return $oss;
    }

    /*
     * 全結果を返す
     * @return $oss 全結果
     */
    public function getAllResult()
    {
        $criteria = Oss::query();
        $criteria->andwhere('delete_flg = :delete_flg:', ['delete_flg' => $this->getDI()->get('config')->define->valid]);
        $oss = $criteria->execute();

        return $oss;
    }

    /*
     * IDで検索してOS情報を返す
     * @param $id
     * @return $os 全結果
     */
    public function getOsInfo($id)
    {
        $os = Oss::findFirst(array(
            "(id = :id:)",
            'bind' => array('id' => $id)
        ));

        return $os;
    }
}
