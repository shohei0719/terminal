<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Uniqueness as UniquenessValidator;
use Phalcon\Mvc\Model\Validator\PresenceOf as PresenceOfValidator;
use Phalcon\Mvc\Model\Message;

class Versions extends Model
{

    /*
		 * 検索結果を返す
		 * @param $related_os
		 * @param $name
		 * @return $versions 検索結果
		 */
		public function getSearchResult($related_os, $name)
		{
      $criteria = Versions::query();
			$criteria->columns('Versions.id, o.name as os_name, Versions.name');
			$criteria->leftJoin('Oss', 'o.id = Versions.related_os', 'o');

			//related_osがPostされているとき
			if(!empty($related_os)){
				$criteria->andwhere('Versions.related_os = :related_os:', ['related_os' => $related_os]);
			}

			//nameがPostされているとき
			if(!empty($name)){
				$criteria->andwhere('Versions.name LIKE :name:', ['name' => '%' . $name . '%']);
			}

			$criteria->andwhere('Versions.delete_flg = :delete_flg:', ['delete_flg' => $this->getDI()->get('config')->define->valid]);
			$criteria->andwhere('o.delete_flg = :delete_flg:', ['delete_flg' => $this->getDI()->get('config')->define->valid]);
			$versions = $criteria->execute();

      return $versions;
		}

		/*
		 * 全結果を返す
		 * @return $oss 全結果
		 */
		public function getAllResult()
		{
      $criteria = Versions::query();
			$criteria->columns('Versions.id, o.name as os_name, Versions.name');
			$criteria->leftJoin('Oss', 'o.id = Versions.related_os', 'o');
			$criteria->andwhere('Versions.delete_flg = :delete_flg:', ['delete_flg' => $this->getDI()->get('config')->define->valid]);
			$criteria->andwhere('o.delete_flg = :delete_flg:', ['delete_flg' => $this->getDI()->get('config')->define->valid]);

			$versions = $criteria->execute();

      return $versions;
		}

		/*
		 * IDで検索してOS情報を返す
		 * @param $id
		 * @return $versions 全結果
		 */
		public function getVersionInfo($id)
		{
			$version = Versions::findFirst(array(
				"(id = :id:)",
				'bind' => array('id' => $id)
			));

			return $version;
		}
}
