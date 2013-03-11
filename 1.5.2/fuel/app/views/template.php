<!DOCTYPE html>
<html>
<hrad>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
</head>

<body>
    <h1><?php echo $title; ?></h1>
    <h2>ようこそ<?=Auth::get_screen_name()?>さん</h2>
    <div id="wrapper">
        <?php echo $content; ?>
        <hr />
        <p class="footer">
            Powered by <?php echo Html::anchor('http//huelphp.com/', 'FuelPHP'); ?>
        </p>
        <p><a href="http://localhost:8888/fuelphp/1.5.2/public/login/logout">ログアウト</a></p>
    </div>
</body>
</html>