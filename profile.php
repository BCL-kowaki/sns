<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$loggedInUser = $_SESSION['user'];
$profileUserId = isset($_GET['id']) ? $_GET['id'] : $loggedInUser[0]; // URLパラメータからユーザーIDを取得、なければログインユーザー

$filepath = 'data/data.csv';
$profileUser = null;

if (file_exists($filepath)) {
    $file = fopen($filepath, 'r');
    flock($file, LOCK_SH);

    while ($line = fgetcsv($file)) {
        if ($line[0] === $profileUserId) {
            $profileUser = $line;
            break;
        }
    }

    flock($file, LOCK_UN);
    fclose($file);
}

if (!$profileUser) {
    echo "ユーザーが見つかりません。";
    exit();
}

// タイムラインデータを読み込む
$timelineFilepath = 'data/timeline.csv';
$posts = [];

if (file_exists($timelineFilepath)) {
    $file = fopen($timelineFilepath, 'r');
    flock($file, LOCK_SH);

    while ($line = fgetcsv($file)) {
        if ($line[0] === $profileUserId) {
            $posts[] = $line; // 現在のユーザーの投稿を追加
        }
    }

    flock($file, LOCK_UN);
    fclose($file);

    // 行を逆順にする（新しい投稿を上に表示）
    $posts = array_reverse($posts);
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/user.css">
    <title>プロフィールページ</title>
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
        <div class="profilesimg"><img src="data/profiles/<?php echo htmlspecialchars($profileUser[2]); ?>" required></div>
        <?php if ($profileUserId === $loggedInUser[0]): ?>
            <form action="update_user.php" method="post" enctype="multipart/form-data">
                <dl class="profilesimg">
                    <dd><label for="profile_img"></label>
                    <input type="file" id="profile_img" name="profile_img"></dd>
                </dl> 
                <dl>
                    <dt><label for="name">会員ID</label></dt>
                    <dd><input type="text" id="newId" name="newId" value="<?php echo htmlspecialchars($profileUser[0]); ?>" required readonly></dd>
                </dl>  
                <dl>
                    <dt><label for="password">パスワード</label></dt>
                    <dd><input type="password" id="password" name="password" value="<?php echo htmlspecialchars($profileUser[1]); ?>" required></dd>
                </dl>  
                <dl>
                    <dt><label for="name">名前</label></dt>
                    <dd><input type="text" id="name" name="name" value="<?php echo htmlspecialchars($profileUser[3]); ?>" required></dd>
                </dl>  
                <dl>
                    <dt><label for="kana">かな</label></dt>
                    <dd><input type="text" id="kana" name="kana" value="<?php echo htmlspecialchars($profileUser[4]); ?>" required></dd>
                </dl>  
                <dl>
                    <dt><label for="tel">電話番号</label></dt>
                    <dd><input type="text" id="tel" name="tel" value="<?php echo htmlspecialchars($profileUser[5]); ?>" required></dd>
                </dl>  
                <dl>
                    <dt><label for="mail">メールアドレス</label></dt>
                    <dd><input type="email" id="mail" name="mail" value="<?php echo htmlspecialchars($profileUser[6]); ?>" required></dd>
                </dl>  
                <dl>
                    <dt><label for="zipcode">郵便番号</label></dt>
                    <dd><input type="text" id="zipcode" name="zipcode" value="<?php echo htmlspecialchars($profileUser[7]); ?>" required></dd>
                </dl>  
                <dl>
                    <dt><label for="address1">都道府県</label></dt>
                    <dd><input type="text" id="address1" name="address1" value="<?php echo htmlspecialchars($profileUser[8]); ?>" required></dd>
                </dl>  
                <dl>
                    <dt><label for="address2">市区町村</label></dt>
                    <dd><input type="text" id="address2" name="address2" value="<?php echo htmlspecialchars($profileUser[9]); ?>" required></dd>
                </dl>  
                <dl>
                    <dt><label for="address3">番地</label></dt>
                    <dd><input type="text" id="address3" name="address3" value="<?php echo htmlspecialchars($profileUser[10]); ?>"></dd>
                </dl>  
                <input type="submit" value="更新">
            </form>
        <?php else: ?>
            <!-- <dl>
                <dt>会員ID</dt>
                <dd><?php echo htmlspecialchars($profileUser[0]); ?></dd>
        </dl> -->
            <dl>   
                <dt>名前</dt>
                <dd><?php echo htmlspecialchars($profileUser[3]); ?></dd>
                </dl>
            <!--<dl>      
                <dt>かな</dt>
                <dd><?php echo htmlspecialchars($profileUser[4]); ?></dd>
                </dl>
              
                <dl>  <dt>電話番号</dt>
                <dd><?php echo htmlspecialchars($profileUser[5]); ?></dd>
                        </dl>
            <dl>   
                <dt>メールアドレス</dt>
                <dd><?php echo htmlspecialchars($profileUser[6]); ?></dd>
                        </dl>
            <dl>   
                <dt>郵便番号</dt>
                <dd><?php echo htmlspecialchars($profileUser[7]); ?></dd> 
                </dl>-->
            <dl>   
                <dt>住まい</dt>
                <dd><?php echo htmlspecialchars($profileUser[8]); ?></dd>

        </dl>   
                <!--      <dl> <dt>市区町村</dt>
                <dd><?php echo htmlspecialchars($profileUser[9]); ?></dd>
                     </dl>      <dl> 
                <dt>番地</dt>
                <dd><?php echo htmlspecialchars($profileUser[10]); ?></dd>      </dl> -->
            </dl>
        <?php endif; ?>
        </section>
        <div class="logout"><a href="logout.php">ログアウト</a></div>
        <div class="timeline"><a href="timeline.php">全体のタイムラインを見る</a></div>
    </div>
   
</section> 
            <!-- ユーザーの投稿表示 -->
        <div class="timelineUser">
            <?php foreach ($posts as $post): ?>
                <section class='box'>
                    <div class='post'>
                        <?php if ($post[5]): ?>
                            <dl>
                                <dt><img src='data/profiles/<?php echo htmlspecialchars($post[5], ENT_QUOTES, 'UTF-8'); ?>' alt='プロフィール画像' width='50'></dt>
                        <?php endif; ?>
                        <dd>
                            <ul>
                                <li><a class="" href='profile.php?id=<?php echo htmlspecialchars($post[0], ENT_QUOTES, 'UTF-8'); ?>'><strong><?php echo htmlspecialchars($post[1], ENT_QUOTES, 'UTF-8'); ?></strong></a></li>
                                <li class='timestamp'><?php echo htmlspecialchars($post[3], ENT_QUOTES, 'UTF-8'); ?></li>
                            </ul>
                        </dd>

                        </dl>
                        <div class='postarea'><p><?php echo htmlspecialchars($post[2]); ?></p></div>
                        <?php if ($post[3]): ?>
                            <img src='data/uploads/<?php echo htmlspecialchars($post[4], ENT_QUOTES, 'UTF-8'); ?>' alt='投稿画像'>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>
</body>
</html>
