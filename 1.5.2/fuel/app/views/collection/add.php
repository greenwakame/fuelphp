<?php echo Form::open(array('name'=>'add','method'=>'post')); ?>
<?php echo '<div class="alert-error">'.Session::get_flash('error').'</div>'?>
 <table width="100%" border="0">
 <tr>
 <th align="right" scope="row">タイトル：</th>
 <td class="input"><?php echo Form::input('title', Input::post('title', isset($query) ? $query['title'] : ''), array('class' => 'span6')); ?>
&nbsp;</td>
 </tr>
 <th scope="row">作成日</th>
 <td><label for="created"></label>
 <input name="created" type="text" id="created" value="<?php echo date("Y-m-d H:i:s")?>"></td>
 </tr>
 <tr>
 <th align="right" scope="row">コード番号：</th>
 <td><?php echo Form::input('col_code', Input::post('col_code', isset($query) ? $query['col_code'] : ''), array('class' => 'span6')); ?>
&nbsp;</td>
 </tr>
 <tr>
 <th align="right" scope="row">保管場所：</th>
 <td><?php echo Form::input('save_space', Input::post('save_space', isset($query) ? $query['save_space'] : ''), array('class' => 'span6')); ?>
&nbsp;</td>
 </tr>
 <tr>
 <th align="right" scope="row">備考：</th>
 <td><?php echo Form::textarea('note', Input::post('note', isset($query) ? $query['note'] : ''), array('class' => 'span6', 'rows' => 8)); ?>
&nbsp;</td>
 </tr>
 <tr>
 <th colspan="2" scope="row">
 <?php echo Form::submit('submit', '保存', array('class' => 'btn btn-primary span4')); ?>
 </th>
 </tr>

</table>
<?php echo Form::close(); ?>