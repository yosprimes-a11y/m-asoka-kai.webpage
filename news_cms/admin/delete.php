<?php
session_start();

// ログインしていない場合はログインページへリダイレクト
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$news_file = __DIR__ . '/../data/news.json';

if (isset($_GET['id'])) {
    $news_id = htmlspecialchars($_GET['id']);
    $news_data = [];

    if (file_exists($news_file)) {
        $json_content = file_get_contents($news_file);
        $news_data = json_decode($json_content, true);
        if (!is_array($news_data)) {
            $news_data = [];
        }
    }

    // 指定されたIDのお知らせが存在すれば削除
    if (isset($news_data[$news_id])) {
        unset($news_data[$news_id]); // データを削除

        // JSONデータをファイルに保存
        if (file_put_contents($news_file, json_encode($news_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
            // 削除成功
        } else {
            // 削除失敗（エラーハンドリングが必要であればここに記述）
        }
    }
}

// 処理後、管理画面トップへリダイレクト
header('Location: index.php');
exit;
?>