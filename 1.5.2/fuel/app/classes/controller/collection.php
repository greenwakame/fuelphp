<?php

class Controller_Collection extends Controller_Template
{
    public function before()
    {
        parent::before();

        Package::load('auth');
        Package::load('orm');
        //ログイン認証
/*        if (!Auth::check())
        {
            Response::redirect('login/index');
        }
*/  }

    //テンプレートの指定
    public $template='collection_template';

    public function action_index()
    {
        //テーブルの合計数を取得
        $count = Model_Collection::get_count();
        //ページネーションの設定
        $config = array(
            'name'          => 'default',
            'total_items'   => $count,
            'per_page'      => 5,
            'uri_segment'   => 'p',
        );

        $pagination = Pagination::forge('revision', $config);

        //var_dump($pagination->per_page);

        //タイトルをテンプレートに渡す
        $this->template->title = 'コレクションページ';

        //ページャー用のデータを取得
        $query = Model_Collection::get_all($pagination);
        //ビューファイルの呼び出し
        $this->template->content = View::forge('collection/index');
        //データベース情報をテンプレートに渡す
        $this->template->content->set('query',$query->as_array());
        //ページネーションを生成してビューにセット
        $this->template->content->set_safe('pagination', $pagination->render());
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
            $note       = $_POST['note'];

            //連想配列にデータをセット
            $data = array(
                'title'         => $title,
                'created'       => $created,
                'col_code'      => $col_code,
                'save_space'    => $save_space,
                'note'          => $note,
            );

            var_dump($_POST);

            $val = Model_Collection::validate('add');

            if ($val->run())
            {
                //データをデータベースへ格納
                $query = Model_Collection::add($data);
                //データベースへ格納出来たかチェック
                if ($query)
                {
                    Session::set_flash('success','保存に成功しました');
                    Response::redirect('collection/index');
                }
                else
                {
                    Session::set_flash('error','保存できませんでした');
                }
            }
            else
            {
                Session::set_flash('error', $val->show_errors());
            }
        }
        $this->template->title = '新規作成';
        $this->template->content = View::forge('collection/add');
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
            $note       = $_POST['note'];

            //連想配列にデータをセット
            $data = array(
                'title'         => $title,
                'created'       => $created,
                'col_code'      => $col_code,
                'save_space'    => $save_space,
                'note'          => $note,
            );

            //指定されたデータを更新
            $val = Model_Collection::validate('add');

            if ($val->run())
            {
                //指定IDのデータを更新する
                $query = Model_Collection::update_selection($id,$data);

                if ($query)
                {
                    Session::set_flash('success','保存に成功しました');
                    Response::redirect('collection/index');
                }
                else
                {
                    Session::set_flash('error','保存できませんでした');
                }
            }
            else
            {
                Session::set_flash('error', $val->show_errors());
            }
        }

        //POST送信されていない処理
        $query = Model_Collection::get_selection($id);

        var_dump($query);

        //タイトルをテンプレートに渡す
        $this->template->title = 'データ更新ページ';
        //ビューファイルの呼び出し
        $this->template->content = View::forge('collection/edit');
        //データベース情報をテンプレートに渡す
        $this->template->content->set('query',$query->as_array());
    }

    public function action_detail($id)
    {
        //if ($_GET)
        if(Input::method() == 'GET')
        {
            //指定されたデータを取得
            $query = Model_Collection::get_selection($id);
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
            //指定したデータを削除
            $query = Model_Collection::delete_selection($id);
            //indexページに移動
            return Response::redirect('collection/index');
        }
        else
        {
            //指定されたデータを取得
            $query = Model_Collection::get_selection($id);
            //ビューの設定
            $this->template->title = '削除ページ';
            $this->template->content = View::forge('collection/delete');
            $this->template->content->set('query',$query->as_array());
        }
    }

    public function action_search()
    {
        if (Input::post('search'))
        {
            var_dump($_POST);
            $search = Input::post('search');
            //指定されたデータを検索して取得
            $query = Model_Collection::search($search);
            //テンプレートファイルの呼び出し
            $this->template->title = '検索結果ページ';
            $this->template->content = View::forge('collection/search');
            //テンプレートファイルに値の引渡し
            $this->template->content->set('query',$query->as_array());
        }
        else
        {
            //降順で取得
            //$query = DB::select()->from('collections')->order_by('modified','desc')->execute();
            //テンプレートファイル呼び出し
            //$this->template->title = 'サンプルページ';
            //$this->template->content = View::forge('collection/index');
            //データベースをテンプレートに渡す
            //$this->template->content->set('query',$query->as_array());
            //action_index変更により下記に変更
            Session::set_flash('error','検索に失敗もしくは検索ワードを変更してください。');
            Response::redirect('collection/index');
        }
    }
}