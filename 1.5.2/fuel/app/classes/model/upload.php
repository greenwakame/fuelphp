<?php
class Model_Upload extends Model
{
    public static function add($image)
    {
        //連想配列にデータをセット
        $data = array(
            'filename'      => $image['name'],
            'mimetype'      => $image['mimetype'],
            'filepath'      => $image['saved_as'],
        );

        $query = DB::insert('col_images')->set($data)->execute();

        return $query;
    }
}