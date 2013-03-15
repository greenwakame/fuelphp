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
        $count = DB::count_records('collections');

        //var_dump($count);

        $config = array(
            'name'          => 'default',
            'total_items'   => $count,
            'per_page'      => 5,
            'uri_segment'   => 'p',
        );

        $pagination = Pagination::forge('revision', $config);

        var_dump($pagination->per_page);

        //$this->template->content->set_safe('pagination', $pagination->render());

        //テーブルのデータ取得
        //$query = DB::select()->from('collections')->execute();

        //$view = View::forge('collection/index');
        //$view->set('query',$query->as_array());

        //return $view;

        //タイトルをテンプレートに渡す
        $this->template->title = 'サンプルページ';
        //Collectionsテーブルのデータを降順で取得
        //$query = DB::select()->from('collections')->limit('10')->execute();
        //ページャー用のデータを取得
        $query = DB::select()->from('collections')
                                 ->limit($pagination->per_page)
                                 ->offset($pagination->offset)
                                 ->execute();
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

            //連想配列にデータをセット
            $data = array(
                'title'         => $title,
                'created'       => $created,
                'col_code'      => $col_code,
                'save_space'    => $save_space,
            );

            var_dump($_POST);

        //SQLの発行
        //$query = DB::insert('collections')->set($data)->execute();
        //発行したSQLチェック
        //echo DB::last_query();
        // indexページへ移動
        //return Response::redirect('collection/index');

            $val = Model_Collection::validate('add');

            if ($val->run())
            {
                //SQLの発行
                $query = DB::insert('collections')->set($data)->execute();

                if ($query)
                {
                    //Session::set_flash('success','<span class="btn btn-primary span8">ID-'.$query->id.'の『'.$query->title.'』を追加しました</span><br>');
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
        //ビューの呼び出し
        //$view = View::forge('collection/add');
        //return $view;
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
            //$query = DB::update('collections')->set($data)->where('id',$id)->execute();
            //return Response::redirect('collection/index');

            $val = Model_Collection::validate('add');

            if ($val->run())
            {
                //指定IDのデータを更新するSQL発行
                $query = DB::update('collections')->set($data)->where('id',$id)->execute();

                if ($query)
                {
                    //Session::set_flash('success','<span class="btn btn-primary span8">ID-'.$query->id.'の『'.$query->title.'』を追加しました</span><br>');
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
        $query = DB::select()->from('collections')->where('id',$id)->execute();
        //$view = View::forge('collection/edit');
        //$view->set('query',$query->as_array());

        //return $view;

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

    public function action_search()
    {
        if (Input::post('search'))
        {
            var_dump($_POST);
            //$search = '%' . Input::post('search') . '%';
            $search = Input::post('search');
            //検索文字を空白で区切って配列に代入
            $keywords = preg_split('/　|\\s/',$search);
            //配列の数だけ繰り返し処理
            foreach($keywords as $key=>$keyword)
            {
                $keywords[$key] = '(TITLE LIKE "%' . $keyword . '%" OR NOTE LIKE "%' . $keyword . '%")';
            }
            //配列のkeywordsをANDで区切ってwhereに代入
            $where = implode(' OR',$keywords);
            //SQL文生成
            $sql = sprintf("SELECT * FROM collections WHERE %s",$where);
            var_dump($sql);
            //SQL発行
            $query = DB::query($sql)->execute();
            //該当データを検索
            //$query = DB::select()->from('collections')->where('title','LIKE',$search)->or_where('note','LIKE',$search)->execute();
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