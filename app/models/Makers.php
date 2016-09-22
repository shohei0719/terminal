<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness as UniquenessValidator;
use Phalcon\Mvc\Model\Validator\PresenceOf as PresenceOfValidator;
use Phalcon\Mvc\Model\Message;

class Makers extends Model
{

    public function initilize()
    {
        //makersテーブル
        $this->setSource('makers');
    }

		/*
		 * 検索結果を返す
		 * @param $permission
		 * @param $name
		 * @param $mail
		 * @return $makers 検索結果
		 */
		public function getSearchResult($name)
		{
			$criteria = Makers::query();

			if(!empty($name)){
				$criteria->andwhere('name LIKE :name:', ['name' => '%' . $name . '%']);
			}

			$criteria->andwhere('delete_flg = :delete_flg:', ['delete_flg' => $this->getDI()->get('config')->define->valid]);
			$makers = $criteria->execute();

			return $makers;
		}

		/*
		 * 全結果を返す
		 * @return $makers 全結果
		 */
		public function getAllResult()
		{
			$criteria = Makers::query();
			$criteria->andwhere('delete_flg = :delete_flg:', ['delete_flg' => $this->getDI()->get('config')->define->valid]);
			$makers = $criteria->execute();

			return $makers;
		}

		/*
		 * IDで検索してメーカー情報を返す
		 * @param $id
		 * @return $maker 全結果
		 */
		public function getMakerInfo($id)
		{
			$maker = Makers::findFirst(array(
				"(id = :id:)",
				'bind' => array('id' => $id)
			));

			return $maker;
		}

}
