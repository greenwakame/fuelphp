<?php

class Controller_Login extends Controller_Template
{
    public function before()
    {
        parent::before();

        Package::load('auth');
    }

    public function action_index()
    {
        $data = array();

        if ($_POST)
        {
            //Authのインスタンス化
            $auth = Auth::instance();

            //資格情報の確認
            //if ($auth->login($_POST['username'],$_POST['password']))
            if ($auth->login())
            {
                //認証OKならフォームページへ
                $this->template->title = 'コンタクトフォーム';
                Response::redirect('form/index');
            }
            else
            {
                //認証が失敗した時の処理
                $this->template->login_error = 'ユーザ名かパスワードが違います。再入力して下さい。';
                $this->template->title = 'ログインフォーム エラー';
                Response::redirect('login/index');
                //$this->template->content = View::forge('login/index',$data);
            }
        }

        //ログインフォームの表示
        $this->template->title = 'ファーストログインフォーム';
        $this->template->content = View::forge('login/index');

    }

    public function action_add_user()
    {
        if ($_POST)
        {
            //POSTデータを受け取る
            $username = Input::post('username');
            $password = Input::post('password');
            $email = Input::post('email');

            //Authのインスタンス化
            $auth = Auth::instance();
            //ユーザ登録
            $auth->create_user($username,$password,$email);
        }

        //登録フォームの表示
        $this->template->title = '登録フォーム';
        $this->template->content = View::forge('login/add_user');
    }

    public function action_logout()
    {
        //ログアウト
        Auth::logout();
        // ログインページ表示
        Response::redirect('login/index');
    }
}