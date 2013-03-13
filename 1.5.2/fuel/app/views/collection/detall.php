<?php foreach($query as $row):endforeach?>
 <div class="btn-group">
 <h3>明細ページ</h3>
 <?php echo Html::anchor('collection/edit/'.$row['id'],'修正',array('class'=>'btn btn-success span1'))?>
 <?php echo Html::anchor('collection/delete/'.$row['id'],'削除',array('class'=>'btn btn-danger span1'))?>
 </div>
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
 <th scope="row">保管場所</th>
 <td><?=$row['save_space']?></td>
 </tr>
 <tr>
 <th scope="row">備考</th>
 <td><?=$row['note']?></td>
 </tr>
 </table>