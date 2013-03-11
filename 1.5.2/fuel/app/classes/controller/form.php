<?php

class Controller_Form extends Controller_Template
{
    public function before()
    {
        parent::before();

        Package::load('auth');

        //ログイン認証
        if (!Auth::check())
        {
            Response::redirect('login/index');
        }
    }


    public function action_index()
    {
        $this->template->title = 'コンタクトフォーム';
        $this->template->content = View::forge('form/index');
    }

    public function action_confirm()
    {
//        $val = $this->get_validation();
        $val = $this->get_validation()->add_callable('MyValidationRules');

        if($val->run())
        {
            $data['input'] = $val->validated();
            $this->template->title = 'コンタクトフォーム: 確認';
            $this->template->content = View::forge('form/confirm', $data);
        }
        else
        {
            $this->template->title = 'コンタクトフォーム: エラー';
            $this->template->content = View::forge('form/index');
            $this->template->content->set_safe('html_error', $val->show_errors());
        }
    }

    public function action_send()
    {
        //CSRF対応
        if ( ! Security::check_token())
        {
            return 'ページ遷移が正しくありません。';
        }

//        $val = $this->get_validation();
        $val = $this->get_validation()->add_callable('MyValidationRules');

        if ( ! $val->run())
        {
            $this->template->title = 'コンタクトフォーム : エラー';
            $this->template->content = View::forge('form/index');
            $this->template->content->set_safe('html_error', $val->show_eorrors());
            return;
        }

        $post = $val->validated();
        $post['ip_address'] = Input::ip();
        $post['user_agent'] = Input::user_agent();
        unset($post['submit']);

        //データベースへ保存
        $model_form = Model_Form::forge()->set($post);
        list($id, $rows) = $model_form->save();

        if ($rows != 1)
        {
            Log::error('データベース保存エラー', __METHOD__);

            $form->repopulate();
            $this->template->title = 'コンタクトフォーム： サーバエラー';
            $this->template->content = View::forge('form/index');
            $html_error = '<p>サーバでエラーが発生しました。</p>';
            $this->template->content->set_safe('html_error', $html_error);
            $this->template->content->set_safe('html_form', $form->build('form/confim'));
            return;
        }

        try
        {
            $mail = new Model_Mail();
            $mail->send($post);
            $this->template->title = 'コンタクトフォーム: 送信完了';
            $this->template->content = View::forge('form/send');
            return;
        }
        catch (EmailValidationFailedException $e)
        {
            Log::error(
                'メール送信エラー:' . $e->getMessage(), __METHOD__
            );
            $html_error = '<p>メールを送信出来ませんでした。</p>';
        }
        catch (EmailSendingFailedException $e)
        {
            Log::error(
                'メール送信エラー: ' . $e->getMessage(), __METHOD__
            );
            $html_error = '<p>メールを送信できませんでした。</p>';
        }

        $this->template->title = 'コンタクトフォーム: 送信エラー';
        $this->template->content = View::forge('form/index');
        $this->template->content->set_safe('html_error', $html_error);
    }

    //検証ルールの定義
    public function get_validation()
    {
        $val = Validation::forge();

        $val->add('name', 'お名前')
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('no_tab_and_newline')
            ->add_rule('max_length', 50);

        $val->add('email', 'メールアドレス')
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('no_tab_and_newline')
            ->add_rule('max_length', 100)
            ->add_rule('valid_email');

        $val->add('comment', 'コメント')
            ->add_rule('required')
            ->add_rule('max_length', 400);

        return $val;
    }

    public function build_mail($post)
    {
        $data['from']       = $post['email'];
        $data['from_name']  = $post['name'];
        $data['to']         = 'tabata@jaythree.com';
        $data['to_name']    = 'FuelPHP_Admin';
        $data['subject']    = 'コンタクトフォーム';

        $ip    = Input::ip();
        $agent = Input::user_agent();


        $data['body'] = '名前:' . $post['name'] . "\r\n"
                     .  'メールアドレス:' . $post['email'] . "\r\n"
                     .  'IPアドレス:' . $ip . "\r\n"
                     .  'ブラウザ:' . $agent . "\r\n"
                     .  'コメント:' . "\r\n"
                     .  $post['comment'];
        return $data;
    }

    public function sendmail($data)
    {
        Package::load('email');

        $email = Email::forge();
        $email->from($data['from'], $data['from_name']);
        $email->to($data['to'],$data['to_name']);
        $email->subject($data['subject']);
        $email->body($data['body']);

        $email->send();
    }
}