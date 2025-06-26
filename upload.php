<?php


// 保存先ディレクトリ
$audioDir = 'uploads/audio/';
$imageDir = 'uploads/images/';
$dataFile = 'data/songs.json';

// ユーザーキー確認（固定キーで簡易認証）
$expectedKey = ''; //キー削除してあります
if ($_POST['user_key'] !== $expectedKey) {
    die('不正なユーザーキーです。');
}

// 入力チェック
$artist = htmlspecialchars($_POST['artist'] ?? '');
$title = htmlspecialchars($_POST['title'] ?? '');
$bpm = intval($_POST['bpm'] ?? 0);
$key = htmlspecialchars($_POST['key'] ?? '');
$genre = htmlspecialchars($_POST['genre'] ?? '');

if (!$artist || !$title || !$bpm || !$key || !$genre || !isset($_FILES['audio']) || !isset($_FILES['image'])) {
    die('すべての項目を入力してください');
}

// ファイルアップロード処理
$audioName = uniqid() . '_' . basename($_FILES['audio']['name']);
$imageName = uniqid() . '_' . basename($_FILES['image']['name']);



move_uploaded_file($_FILES['audio']['tmp_name'], $audioDir . $audioName);
move_uploaded_file($_FILES['image']['tmp_name'], $imageDir . $imageName);


// JSONファイルに保存
$newSong = [
    'artist' => $artist,
    'title' => $title,
    'bpm' => $bpm,
    'key' => $key,
    'genre' => $genre,
    'audio' => $audioDir . $audioName,
    'image' => $imageDir . $imageName,
    'created_at' => date('Y-m-d H:i:s')
];

if (!file_exists($dataFile)) {
    file_put_contents($dataFile, json_encode([$newSong], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
} else {
    $json = json_decode(file_get_contents($dataFile), true);
    $json[] = $newSong;
    file_put_contents($dataFile, json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// アップロード後にトップページに戻る
header('Location: index.html');
exit;

?>
