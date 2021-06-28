<?php 
session_start();
if ($_SESSION['login']!=='admin') {
    header("Location: /index.php");
}
?>
<head>
<link rel="stylesheet" type="text/css" href="./static/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./static/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./static/util.css">
    <link rel="stylesheet" type="text/css" href="./static/main.css">
	<link rel="stylesheet" type="text/css" href="./static/login.css">
</head>
<img src="./static/bg.jpeg" width="100%" height="100%" style="position:absolute;top:0;left:0;right:100;bottom:500;z-index:-1" />
<div class="login">
  <div class="login-triangle"></div>
  
  <h2 class="login-header">hello <?php print($_SESSION['login']==='admin'?'admin':'');?> !，在这里测试你的PHP文件</h2>

  <form class="login-container" method="post" action="admin.php">
    <p><input type="text" placeholder="php file here, example:info.php" name="file"></p>
    <p><input type="submit" value="test"></p>
  </form>
</div>

<?php
$file=$_POST['file'];
if (isset($file)) {
    var_dump($_POST['file']);
    @system("php ".escapeshellarg($file));
}
?> 