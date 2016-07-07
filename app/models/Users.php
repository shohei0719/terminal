<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Email as EmailValidator;
use Phalcon\Mvc\Model\Validator\Uniqueness as UniquenessValidator;
use Phalcon\Mvc\Model\Validator\PresenceOf as PresenceOfValidator;
use Phalcon\Mvc\Model\Validator\StringLength as StringLengthValidator;
use Phalcon\Mvc\Model\Validator\Regex as RegexValidator;

class Users extends Model
{
	/*
    protected $id;
    protected $email;
    protected $password;
	*/

    public function initilize()
    {

        //usersテーブル
        $this->setSource('users');

    }

    /*
     * バリデーションチェック前
     * Not Nullの自動バリデーションチェックが入る前に「必須」バリデーションチェックする（ちょっと気持ち悪いので別のやり方を考えたほうがいいかもしれない）
     */
    public function beforeValidationOnCreate()
    {

        //必須入力チェック
        $this->validate(new PresenceOfValidator(array(
            'field'		=> 'mail',
            'message' 	=> 'メールアドレスを入力してください。'
        )));

        $this->validate(new PresenceOfValidator(array(
            'field'		=> 'password',
            'message' 	=> 'パスワードを入力してください。'
        )));

        $this->validate(new PresenceOfValidator(array(
            'field'		=> 'name',
            'message' 	=> '氏名を入力してください。'
        )));

        if ($this->validationHasFailed() == true) {
            return false;
        }

    }

    /*
     * バリデーションチェック後
     */
    public function afterValidationOnCreate()
    {
        //パスワードをハッシュ化
    	$security = new \Phalcon\Security();
    	$this->password = $security->hash($this->password);
    }

    /*
     * バリデーション処理
     */
    public function validation()
    {
        //個人情報更新時にはパスワード、メールアドレスのチェックをしない
        if($_SERVER['REQUEST_URI'] !== '/terminal/edit'){
            //形式チェック
            if (empty($this->getMessages('password'))) {
                $this->validate(new RegexValidator(array(
                        'field' 	=> 'password',
                        'pattern' 	=> '/^[a-zA-Z0-9]+$/',
                        'message' 	=> '半角英数字でパスワードをご入力ください。'
                )));
            }

            //長さチェック
            //if ($this->validationHasFailed('password') == false) {
            if (empty($this->getMessages('password'))) {
                $this->validate(new StringLengthValidator(array(
                    'field'				=> 'password',
                    'max'				=> 20,
                    'min'				=> 8,
                    //'message'			=> '8文字以上20文字以下でパスワードをご入力ください。'
                    'messageMaximum' 	=> 'パスワードが長すぎます。20文字以内でパスワードをご入力ください。',
                    'messageMinimum' 	=> 'パスワードが短すぎます。8文字以上でパスワードをご入力ください。'
                )));
            }

            //メールアドレスの形式チェック
            if (empty($this->getMessages('mail'))) {
                $this->validate(new EmailValidator(array(
                        'field' 	=> 'mail',
                        'message'   => '正しいメールアドレスを入力してください。',
                        'required' 	=> 'false'
                )));
            }

            //重複チェック
            if (empty($this->getMessages('mail'))) {
                $this->validate(new UniquenessValidator(array(
                    'field' => 'mail',
                    'message' => 'ご入力いただいたメールアドレスは既に使用されています。'
                )));
            }

            if ($this->validationHasFailed() == true) {
                return false;
            }
        }
    }
}
