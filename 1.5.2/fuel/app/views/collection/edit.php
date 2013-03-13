<?php foreach($query as $row):endforeach?>
<h2>データ更新</h2>
<form name="form1" method="post" action="">
<table width="100%" border="1">
<tr>
<th scope="row">タイトル</th>
<td><input name="title" type="text" id="title" value="<?=$row['title']?>"></td>
</tr>
<tr>
<th scope="row">更新日</th>
<td><label for="created"></label>
<input name="created" type="text" id="created" value="<?php echo date("Y-m-d H:i:s")?>"></td>
</tr>
<tr>
<th scope="row">コード番号</th>
<td><label for="col_code"></label>
<input name="col_code" type="text" id="col_code" value="<?=$row['col_code']?>"></td>
</tr>
<tr>
<th scope="row">保管場所</th>
<td><label for="save_space"></label>
<input name="save_space" type="text" id="save_space" value="<?=$row['save_space']?>"></td>
</tr>
<tr>
<th colspan="2" scope="row"><input type="submit" name="button" id="button" value="送信"></th>
</tr>
</table>
</form>