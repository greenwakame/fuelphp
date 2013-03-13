<h2>新規作成</h2>
<form name="form1" method="post" action="">
<table width="100%" border="1">
<tr>
<th scope="row">タイトル</th>
<td><input type="text" name="title" id="title"></td>
</tr>
<tr>
<th scope="row">作成日</th>
<td><label for="created"></label>
<input name="created" type="text" id="created" value="<?php echo date("Y-m-d H:i:s")?>"></td>
</tr>
<tr>
<th scope="row">コード番号</th>
<td><label for="col_code"></label>
<input type="text" name="col_code" id="col_code"></td>
</tr>
<tr>
<th scope="row">保管場所</th>
<td><label for="save_space"></label>
<input type="text" name="save_space" id="save_space"></td>
</tr>
<tr>
<th colspan="2" scope="row"><input type="submit" name="button" id="button" value="送信"></th>
</tr>
</table>
</form>