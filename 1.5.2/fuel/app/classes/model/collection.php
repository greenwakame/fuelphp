<?php

class Model_Collection extends Orm\Model
{
    //使用するフィールド名をセット
    protected static $_proerties = array(
        'id',
        'title',
        'created',
        'modified',
        'col_code',
        'save_space',
        'picture_id',
        'note',
    );
    //テーブル名がモデル名の複数形であれば省略可
    protected static $_table_name = 'collections';
    //プライマリーキーがidなら省略可
    protected static $_primary_key = 'id';
    //バリデーション設定
    public static function validate($factory)
    {
        $val = Validation::forge($factory);
        $val->add_field('title','タイトル','required|max_length[255]');
        $val->add_field('col_code','コード番号','required');
        $val->add_field('save_space','保管場所','required|max_length[100]');

        return $val;
    }
}