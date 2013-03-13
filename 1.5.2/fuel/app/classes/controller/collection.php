<?php

class Controller_Collection extends Controller_Template
{
    public function before()
    {
        parent::before();

        Package::load('auth');

        //ログイン認証
/*        if (!Auth::check())
        {
            Response::redirect('login/index');
        }
*/    }

    //テンプレートの指定
    public $template='collection_template';

    public function action_index()
    {
        //テーブルのデータ取得
        //$query = DB::select()->from('collections')->execute();

        //$view = View::forge('collection/index');
        //$view->set('query',$query->as_array());

        //return $view;

        //タイトルをテンプレートに渡す
        $this->template->title = 'サンプルページ';
        //Collectionsテーブルのデータを降順で取得
        $query = DB::select()->from('collections')->limit('5')->execute();
        //ビューファイルの呼び出し
        $this->template->content = View::forge('collection/index');
        //データベース情報をテンプレートに渡す
        $this->template->content->set('query',$query->as_array());
    }

    public function action_add()
    {
        //POST処理
        //if (Input::method() == 'POST')
        if($_POST)
        {
            //データの整理(省略してもいいかも)
            $title      = $_POST['title'];
            $created    = $_POST['created'];
            $col_code   = $_POST['col_code'];
            $save_space = $_POST['save_space'];

            //連想配列にデータをセット
            $data = array(
                'title'         => $title,
                'created'       => $created,
                'col_code'      => $col_code,
                'save_space'    => $save_space,
            );

        //SQLの発行
        $query = DB::insert('collections')->set($data)->execute();
        //発行したSQLチェック
        echo DB::last_query();
        // indexページへ移動
        return Response::redirect('collection/index');
        }
        //$this->template->title = '新規作成';
        //$this->template->content = View::forge('collection/add');
        //ビューの呼び出し
        $view = View::forge('collection/add');

        return $view;
    }

    public function action_edit($id)
    {
        //POST処理
        if ($_POST)
        {
            //データの整理(省略してもいいかも)
            $title      = $_POST['title'];
            $created    = $_POST['created'];
            $col_code   = $_POST['col_code'];
            $save_space = $_POST['save_space'];

            //連想配列にデータをセット
            $data = array(
                'title'         => $title,
                'created'       => $created,
                'col_code'      => $col_code,
                'save_space'    => $save_space,
            );

            //指定IDのデータを更新するSQL発行
            $query = DB::update('collections')->set($data)->where('id',$id)->execute();
            return Response::redirect('collection/index');
        }

        //POST送信されていない処理
        $query = DB::select()->from('collections')->where('id',$id)->execute();
        $view = View::forge('collection/edit');
        $view->set('query',$query->as_array());

        return $view;
    }

    public function action_detail($id)
    {
        //if ($_GET)
        if(Input::method() == 'GET')
        {
            //SQL発行
            $query = DB::select()->from('collections')->where('id',$id)->execute();
            //ビューの呼び出し
            $this->template->title = '詳細ページ';
            $this->template->content = View::forge('collection/detail');
            //ビューに値の引渡し
            $this->template->content->set('query',$query->as_array());
        }
    }

    public function action_delete($id)
    {
        if($_POST)
        {
            //SQL発行
            $query = DB::delete('collections')->where('id',$id)->execute();
            //indexページに移動
            return Response::redirect('collection/index');
        }
        else
        {
            $query = DB::select()->from('collections')->where('id',$id)->execute();
            $this->template->title = '削除ページ';
            $this->template->content = View::forge('collection/delete');
            $this->template->content->set('query',$query->as_array());
        }
    }
}