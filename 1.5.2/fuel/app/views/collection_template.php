<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $title; ?></title>
<meta name="viewport" content="width=device-width,minimum-scale=1">
<?php echo Asset::css('bootstrap.min.css');?>
<?php echo Asset::css('bootstrap-responsive.min.css');?>
<?php //echo Asset::css('my-style.css');?>
</head>
<body>
<div class="navbar">
<div class="navbar-inner">
<div class="container">
<a class="brand" href="#">wakame</a>
<form action="" method="post" class="navbar-search pull-right">
<input name="search" type="text" class="search-query" id="search" placeholder="search">
</form>
</div><!--/contain-->
</div><!--/navbar-innner-->
</div><!--/navbar-->
<div class="container">
<div class="row" id="content">
<div class="span3">
<ul class="nav nav-list">
<li><?php echo Html::anchor('collection/index/','TOP',array('class'=>'btn'))?></li>
<li><?php echo Html::anchor('collection/add/','新規作成',array('class'=>'btn'))?></li>
</ul>
</div><!--/span3-->
<div class="span9">
<?php echo $content; ?>
</div><!--/span9-->
</div><!--/content-->
<div class="row" id="footer">
<p>copyright(c)2013 greenwakame {exec_time}s<br>
 表示速度{exec_time}s　使用メモリ{mem_usage}mb</p>
</div><!--/footer-->
</div><!--/container-->
<?php //echo Asset::js('jquery-1.7.1.min.js');?>
<?php echo Asset::js('bootstrap.min.js');?>
</body>
</html>