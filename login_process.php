<?php
session_start();

$identifier = $_POST['identifier'];
$password = $_POST['password'];
$filepath = 'data/data.csv';

function authenticate($identifier, $password, $filepath) {
    if (!file_exists($filepath)) {
        return false;
    }

    $file = fopen($filepath, 'r');
    flock($file, LOCK_SH);

    while ($line = fgetcsv($file)) {
        if (($line[0] === $identifier || $line[5] === $identifier) && $line[1] === $password) {
            $_SESSION['user'] = $line;
            flock($file, LOCK_UN);
            fclose($file);
            return true;
        }
    }

    flock($file, LOCK_UN);
    fclose($file);
    return false;
}

if (authenticate($identifier, $password, $filepath)) {
    header("Location: user_page.php");
} else {
    echo "ログインに失敗しました。";
}
?>
