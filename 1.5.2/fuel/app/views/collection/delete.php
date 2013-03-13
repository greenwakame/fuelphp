<?php foreach($query as $row):endforeach?>
 <?php echo Form::open('collection/delete/'.$row['id'])?>
 <?php echo Form::hidden('id',$row['id'])?>
 <?php echo Form::submit('','このデータを削除いたします',array('class'=>'btn btn-danger span9'))?>
 <?php echo Form::close()?>
 <h4>データ削除</h4>
 <table width="100%" border="1">
 <tr>
 <th width="20%" scope="row">ID</th>
 <td width="80%"><?=$row['id']?></td>
 </tr>
 <tr>
 <th scope="row">タイトル</th>
 <td><?=$row['title']?></td>
 </tr>
 <tr>
 <th scope="row">作成日</th>
 <td><?=$row['created']?></td>
 </tr>
 <tr>
 <th scope="row">更新日</th>
 <td><?=$row['modified']?></td>
 </tr>
 <tr>
 <th scope="row">コード番号</th>
 <td><?=$row['col_code']?></td>
 </tr>
 <tr>
 <th scope="row">保管場所</th>
 <td><?=$row['save_space']?></td>
 </tr>
 <tr>
 <th scope="row">備考</th>
 <td><?=$row['note']?></td>
 </tr>
 </table>