<h2>コレクション一覧</h2>
<table width="100%" border="1">
<tr>
<th scope="col">ID</th>
<th scope="col">タイトル</th>
<th scope="col">作成日</th>
<th scope="col">コード</th>
<th scope="col">保管場所</th>
</tr>
<?php foreach($query as $row):?>
<tr>
<td><?=$row['id']?></td>
<td><?php echo Html::anchor('collection/detail/' . $row['id'],$row['title'],array('class'=>'btn btn-success','id'=>'a_btn')) ?></td>
<td><?=$row['created']?></td>
<td><?=$row['col_code']?></td>
<td><?=$row['save_space']?></td>
</tr>
<?php endforeach;?>
</table>