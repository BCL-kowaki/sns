<?php
session_start();
$_SESSION = array();
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
<title>ログアウト</title>
</head>
<body>
<h1>
<font size='5'>ログアウトしました</font>
</h1>
<p><a href='login.php'>ログインページに戻る</a></p>
</body>
</html>
