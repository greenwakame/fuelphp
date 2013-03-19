<?php

class Controller_Upload extends Controller_Template
{
    public function before()
    {
        parent::before();

        //Package::load('auth');
        //Package::load('orm');
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
        //検索テスト
        //$test = Finder::search('views', 'upload/index');
        //var_dump($test);

        //ビューファイルの呼び出し
        $this->template->title = 'アップロードページ';
        $this->template->content = View::forge('upload/index');
    }

    public function post_index()
    {
        //collection_idを取得
        $id = $_POST['id'];

        //アップロードクラスの設定
        $config = array(
            'path'          => DOCROOT . '/uploads/',
            'ext_whitelist' => array('gif', 'jpg' ,'png'),
            'max_size'      => 100 * 1024,
        );

        //画像チェック
        Upload::register('validate', function (&$file) {
            if($file['error'] == Upload::UPLOAD_ERR_OK)
            {
                switch($file['extension'])
                {
                    case 'jpg':
                    case 'png':
                    case 'gif':

                        $checkImage = getimagesize($file['file']);
                        $type = $checkImage[2];

                        if ($checkImage === false)
                        {
                            return Upload::UPLOAD_ERR_EXT_BLACKLISTED;
                        }
                        else if ($file['extension'] === 'gif' && $type !== IMAGETYPE_GIF)
                        {
                            return Upload::UPLOAD_ERR_EXT_BLACKLISTED;
                        }
                        else if ($file['extension'] === 'png' && $type !== IMAGETYPE_PNG)
                        {
                            return Upload::UPLOAD_ERR_EXT_BLACKLISTED;
                        }
                        else if ($file['extension'] === 'jpg' && $type !== IMAGETYPE_JPEG)
                        {
                            return Upload::UPLOAD_ERR_EXT_BLACKLISTED;
                        }
                        break;
                    default:
                }
            }
        });

        //アップロード処理
        Upload::process($config);

        if (Upload::is_valid())
        {
            //ファイルの保存
            Upload::save();
            //ファイル結果をDBに保存
            foreach(Upload::get_files() as $file)
            {
                $query = Model_Upload::add($file,$id);
            }

            //DB保存のエラー処理
            if (!Upload::get_files(0))
            {
            //エラーメッセージを表示
            Session::set_flash('error','保存に失敗しました。');
            Response::redirect('collection/index');
            }
            //var_dump($images);
            Session::set_flash('success', '保存が成功しました。');
            Response::redirect('collection/index');
        }

        //エラー処理
        if (Upload::errors())
        {
            //エラーメッセージを表示
            Session::set_flash('error','保存に失敗しました。');
            Response::redirect('collection/index');
        }
    }
}