<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/user.css">
    <title>ユーザーページ</title>
</head>
<body>
<section id="wrapper">
<section class="header">
    <div class="img"><img src="images/logo.png"></div>
</section>
<section class="box">
    <div class="inner">
        <h1>基本データ</h1>
        <section class="profiles">
        <div class="profilesimg"><img src="data/profiles/<?php echo htmlspecialchars($user[2]); ?>" required></div>
        <form action="update_user.php" method="post" enctype="multipart/form-data">
            <dl class="profilesimg">
                <dd><label for="profile_img"></label>
                <input type="file" id="profile_img" name="profile_img"></dd>
            </dl> 
            <dl>
                <dt><label for="name">会員ID</label></dt>
                <dd><input type="text" id="newId" name="newId" value="<?php echo htmlspecialchars($user[0]); ?>" required readonly></dd>
            </dl>  
            <dl>
                <dt><label for="password">パスワード</label></dt>
                <dd><input type="password" id="password" name="password" value="<?php echo htmlspecialchars($user[1]); ?>" required></dd>
            </dl>  
            <dl>
                <dt><label for="name">名前</label></dt>
                <dd><input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user[3]); ?>" required></dd>
            </dl>  
            <dl>
                <dt><label for="kana">かな</label></dt>
                <dd><input type="text" id="kana" name="kana" value="<?php echo htmlspecialchars($user[4]); ?>" required></dd>
            </dl>  
            <dl>
                <dt><label for="tel">電話番号</label></dt>
                <dd><input type="text" id="tel" name="tel" value="<?php echo htmlspecialchars($user[5]); ?>" required></dd>
            </dl>  
            <dl>
                <dt><label for="mail">メールアドレス</label></dt>
                <dd><input type="email" id="mail" name="mail" value="<?php echo htmlspecialchars($user[6]); ?>" required></dd>
            </dl>  
            <dl>
                <dt><label for="zipcode">郵便番号</label></dt>
                <dd><input type="text" id="zipcode" name="zipcode" value="<?php echo htmlspecialchars($user[7]); ?>" required></dd>
            </dl>  
            <dl>
                <dt><label for="address1">都道府県</label></dt>
                <dd><input type="text" id="address1" name="address1" value="<?php echo htmlspecialchars($user[8]); ?>" required></dd>
            </dl>  
            <dl>
                <dt><label for="address2">市区町村</label></dt>
                <dd><input type="text" id="address2" name="address2" value="<?php echo htmlspecialchars($user[9]); ?>" required></dd>
            </dl>  
            <dl>
                <dt><label for="address3">番地</label></dt>
                <dd><input type="text" id="address3" name="address3" value="<?php echo htmlspecialchars($user[10]); ?>"></dd>
            </dl>  
            <input type="submit" value="更新">
        </form>
        </section>
        <div class="logout"><a href="logout.php">ログアウト</a></div>
        <div class="timeline"><a href="timeline.php">タイムラインを見る</a></div>
    </div>
</section>
</body>
</html>
