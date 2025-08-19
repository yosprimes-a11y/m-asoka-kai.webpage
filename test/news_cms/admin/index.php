<?php
session_start();

// ログインしていない場合はログインページへリダイレクト
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// ログアウト処理
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お知らせCMS - 管理画面</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); max-width: 800px; margin: 20px auto; }
        h2 { color: #333; margin-bottom: 20px; }
        .menu { margin-bottom: 20px; }
        .menu a { display: inline-block; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; margin-right: 10px; }
        .menu a:hover { background-color: #0056b3; }
        .logout-btn { background-color: #dc3545; }
        .logout-btn:hover { background-color: #c82333; }
    </style>
</head>
<body>
    <div class="container">
        <h2>お知らせCMS 管理画面</h2>
        <div class="menu">
            <a href="add.php">お知らせ新規作成</a>
            <a href="index.php?logout=true" class="logout-btn">ログアウト</a>
        </div>

        <h3>お知らせ一覧</h3>
        <?php
        $news_file = __DIR__ . '/../data/news.json';
        $news_data = [];

        if (file_exists($news_file)) {
            $json_content = file_get_contents($news_file);
            $news_data = json_decode($json_content, true);
            if (!is_array($news_data)) {
                $news_data = [];
            }
        }

        // IDの降順でソート（新しいものが上に来るように）
        krsort($news_data);

        if (empty($news_data)) {
            echo '<p>現在、登録されているお知らせはありません。</p>';
        } else {
            echo '<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse;">';
            echo '<thead><tr><th>ID</th><th>日付</th><th>カテゴリ</th><th>タイトル</th><th>操作</th></tr></thead>';
            echo '<tbody>';
            foreach ($news_data as $id => $news_item) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($id) . '</td>';
                echo '<td>' . htmlspecialchars($news_item['date']) . '</td>';
                echo '<td>' . htmlspecialchars($news_item['category']) . '</td>';
                echo '<td>' . htmlspecialchars($news_item['title']) . '</td>';
                echo '<td>';
                echo '<a href="edit.php?id=' . htmlspecialchars($id) . '">編集</a> | ';
                echo '<a href="delete.php?id=' . htmlspecialchars($id) . '" onclick="return confirm("本当に削除しますか？");">削除</a>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        }
        ?>
    </div>
</body>
</html>