<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

// コメントデータを読み込む関数
function getComments($postId) {
    $comments = [];
    $filepath = 'data/comments.csv';
    if (file_exists($filepath)) {
        $file = fopen($filepath, 'r');
        flock($file, LOCK_SH);

        while ($line = fgetcsv($file)) {
            if ($line[0] == $postId) {
                $comments[] = $line;
            }
        }

        flock($file, LOCK_UN);
        fclose($file);
    }
    return $comments;
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/reset.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/timeline.css">
    <title>FREInet</title>
</head>
<body>
<section id="wrapper">
<section class="header">
    <div class=img><img src="images/logo.png"></div>
</section>
<section class="timelinebox">
    <div class="inner">
    <form action="post_timeline.php" method="post" enctype="multipart/form-data">
       <dl> 
        <dd>
            <div class="flex">
            <div class="postimg">

        <?php
            // ログインしているユーザーのアイコンを表示
            if (!empty($user[2])) {
                echo "<img src='data/profiles/" . htmlspecialchars($user[2], ENT_QUOTES, 'UTF-8') . "' alt='プロフィール画像' width='50' style='vertical-align: middle;'>";
            } else {
                echo "<img src='images/default_icon.png' alt='デフォルトアイコン' width='50' style='vertical-align: middle;'>";
            }
            ?>  
            </div>          
        <textarea name="post_content" rows="4" cols="50" placeholder="今の気持ちを投稿しよう" required></textarea></div><dd>
        <dd>
            <ul>
                <li>
            <input type="file" id="post_img" name="post_img"></li>
            <li><input type="submit" value="投稿"></li>
</dd>
    </form>
    </div>
</section>    

    <div class="timeline">
    <?php
$filepath = 'data/timeline.csv';

if (file_exists($filepath)) {
    $file = fopen($filepath, 'r');
    flock($file, LOCK_SH);

    $lines = [];
    while ($line = fgetcsv($file)) {
        $lines[] = $line;
    }

    flock($file, LOCK_UN);
    fclose($file);

    // 行を逆順にする
    $lines = array_reverse($lines);

    // 逆順にした行を表示する
    foreach ($lines as $line) {
        echo "
        <section class='box'>
        <div class='post'>";
        if ($line[5]) {
            echo "<dl><dt><img src='data/profiles/" . htmlspecialchars($line[5], ENT_QUOTES, 'UTF-8') . "' alt='プロフィール画像' width='50'></dt>";
        }
        echo "<dd><ul><li><a href='profile.php?id=" . htmlspecialchars($line[0], ENT_QUOTES, 'UF-8') . "'><strong>" . htmlspecialchars($line[1], ENT_QUOTES, 'UTF-8') . "</strong></a></li>";
        echo "<li class='timestamp'>" . htmlspecialchars($line[3], ENT_QUOTES, 'UTF-8') . "</li></ul></dd></dl>";
        echo "<div class='postarea'><p>" . htmlspecialchars($line[2], ENT_QUOTES, 'UTF-8') . "</p></div>";
        if ($line[4]) {
            echo "<img src='data/uploads/" . htmlspecialchars($line[4], ENT_QUOTES, 'UTF-8') . "' alt='投稿画像'>";
        }
        echo "</div></section>";

            // // コメントを表示
            // $comments = getComments($postId);
            // echo "<div class='comments'>";
            // foreach ($comments as $comment) {
            //     echo "<div class='comment'>";
            //     echo "<p><strong>" . htmlspecialchars($comment[3], ENT_QUOTES, 'UTF-8') . "</strong>: " . convertToLinks($comment[1]) . "</p>";
            //     echo "<p class='timestamp'>" . htmlspecialchars($comment[2], ENT_QUOTES, 'UTF-8') . "</p>";
            //     echo "</div>";
            // }
            // echo "</div>";

            // // コメント投稿フォーム
            // echo "
            // <form action='post_comment.php' method='post'>
            //     <input type='hidden' name='post_id' value='" . htmlspecialchars($postId, ENT_QUOTES, 'UTF-8') . "'>
            //     <textarea name='comment_content' rows='2' cols='50' placeholder='コメントを追加' required></textarea>
            //     <button type='submit'>コメント</button>
            // </form>";

    }
}
?>

    </div>
    </div>
</section>


</section>    
</body>
</html>
