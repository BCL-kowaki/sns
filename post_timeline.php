<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
$post_content = $_POST['post_content'];
$timestamp = date("Y-m-d H:i:s");
$post_img = '';

// 投稿画像のアップロード処理
if (!empty($_FILES['post_img']['name'])) {
    $target_dir = "data/uploads/";
    $target_file = $target_dir . basename($_FILES['post_img']['name']);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $new_file_name = uniqid() . '.' . $fileType;
    $target_file = $target_dir . $new_file_name;
    move_uploaded_file($_FILES['post_img']['tmp_name'], $target_file);
    $post_img = $new_file_name;
}

$filepath = 'data/timeline.csv';

$write_data = "{$user[0]},{$user[3]},{$post_content},{$timestamp},{$post_img},{$user[2]}";

$file = fopen($filepath, 'a');
flock($file, LOCK_EX);

fwrite($file, $write_data . "\n");

flock($file, LOCK_UN);
fclose($file);

header("Location: timeline.php");
?>
