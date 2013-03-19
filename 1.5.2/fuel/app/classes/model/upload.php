<?php
class Model_Upload extends Model
{
    public static function add($image,$id)
    {
        //連想配列にデータをセット
        $data = array(
            'filename'      => $image['name'],
            'mimetype'      => $image['mimetype'],
            'filepath'      => $image['saved_as'],
            'collection_id' => $id,
        );

        $query = DB::insert('col_images')->set($data)->execute();

        return $query;
    }
}