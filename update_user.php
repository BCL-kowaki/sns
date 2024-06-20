<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

$name = $_POST['name'];
$kana = $_POST['kana'];
$tel = $_POST['tel'];
$mail = $_POST['mail'];
$zipcode = $_POST['zipcode'];
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$address3 = $_POST['address3'];
$password = $_POST['password'];
$profile_img = $user[2];

// プロフィール画像のアップロード処理
if (!empty($_FILES['profile_img']['name'])) {
    $target_dir = "data/profiles/";
    $target_file = $target_dir . basename($_FILES['profile_img']['name']);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $new_file_name = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $new_file_name;
    move_uploaded_file($_FILES['profile_img']['tmp_name'], $target_file);
    $profile_img = $new_file_name;
}

$updatedData = [
    $user[0], // ID
    $password,
    $profile_img,
    $name,
    $kana,
    $tel,
    $mail,
    $zipcode,
    $address1,
    $address2,
    $address3
];

$filepath = 'data/data.csv';
$tempFile = 'data/temp.csv';

$file = fopen($filepath, 'r');
$temp = fopen($tempFile, 'w');

flock($file, LOCK_EX);
flock($temp, LOCK_EX);

while ($line = fgetcsv($file)) {
    if ($line[0] === $user[0]) {
        fputcsv($temp, $updatedData);
    } else {
        fputcsv($temp, $line);
    }
}

flock($file, LOCK_UN);
flock($temp, LOCK_UN);

fclose($file);
fclose($temp);

rename($tempFile, $filepath);

$_SESSION['user'] = $updatedData;

header("Location: profile.php?id=" . $user[0]);
?>
