<?php

class Model_Mail extends Model
{
    public function send($post)
    {
        $data = $this->build_mail($post);
        $this->sendmail($data);
    }

    protected function build_mail($post)
    {
        $data['from']       = $post['email'];
        $data['from_name']  = $post['name'];
        $data['to']         = 'tabata@jaythree.com';
        $data['to_name']    = 'FuelPHP';
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

    protected function sendmail($data)
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