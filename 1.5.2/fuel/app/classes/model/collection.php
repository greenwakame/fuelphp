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

    public static function get_all($pagination)
    {
        $query = DB::select()->from('collections')
                             ->limit($pagination->per_page)
                             ->offset($pagination->offset)
                             ->execute();
        return $query;
    }

    public static function get_count()
    {
        $query = DB::count_records('collections');

        return $query;
    }

    public static function add($data)
    {
        $query = DB::insert('collections')->set($data)->execute();

        return $query;
    }

    public static function update_selection($id,$data)
    {
        $query = DB::update('collections')->set($data)->where('id',$id)->execute();

        return $query;
    }

    public static function get_selection($id)
    {
        $query = DB::select()->from('collections')->where('id',$id)->execute();

        return $query;
    }

    public static function delete_selection($id)
    {
        $query = DB::delete('collections')->where('id',$id)->execute();

        return $query;
    }

    public static function search($search)
    {
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
        //var_dump($sql);
        //SQL発行
        $query = DB::query($sql)->execute();

        return $query;
    }
}