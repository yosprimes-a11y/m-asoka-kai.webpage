<?php
$news_file = __DIR__ . '/data/news.json';
$news_item = null;

if (isset($_GET['id'])) {
    $news_id = htmlspecialchars($_GET['id']);
    if (file_exists($news_file)) {
        $json_content = file_get_contents($news_file);
        $news_data = json_decode($json_content, true);
        if (is_array($news_data) && isset($news_data[$news_id])) {
            $news_item = $news_data[$news_id];
        }
    }
}

// 曜日を日本語で取得する関数
function getJapaneseDayOfWeek($dateString) {
    $timestamp = strtotime($dateString);
    $dayOfWeek = date('w', $timestamp); // 0 (日) から 6 (土)
    $days = ['日', '月', '火', '水', '木', '金', '土'];
    return '(' . $days[$dayOfWeek] . ')';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お知らせ詳細</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; background-color: #f4f4f4; }
        .container { max-width: 800px; margin: 20px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); } 
        h1 { color: #007bff; margin-bottom: 10px; }
        .news-meta { font-size: 0.9em; color: #666; margin-bottom: 20px; }
        .news-content { margin-top: 20px; }
        .news-content img { max-width: 100%; height: auto; display: block; margin: 15px 0; border-radius: 4px; }
        .back-link { display: inline-block; margin-top: 30px; padding: 10px 15px; background-color: #6c757d; color: white; text-decoration: none; border-radius: 4px; }
        .back-link:hover { background-color: #5a6268; }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($news_item): ?>
            <h1><?php echo htmlspecialchars($news_item['title']); ?></h1>
            <div class="news-meta">
                <span><?php echo htmlspecialchars($news_item['date']) . getJapaneseDayOfWeek($news_item['date']); ?></span>
                <span style="margin-left: 15px;">カテゴリ: <?php echo htmlspecialchars($news_item['category']); ?></span>
            </div>
            <?php if (!empty($news_item['image'])): ?>
                <img src="<?php echo htmlspecialchars($news_item['image']); ?>" alt="<?php echo htmlspecialchars($news_item['title']); ?>">
            <?php endif; ?>
            <div class="news-content">
                <?php echo nl2br(htmlspecialchars($news_item['content'])); ?>
            </div>
            <?php if (!empty($news_item['url'])): ?>
                <p><a href="<?php echo htmlspecialchars($news_item['url']); ?>" target="<?php echo htmlspecialchars($news_item['target']); ?>">詳細リンクへ</a></p>
            <?php endif; ?>
            <a href="/" class="back-link">メインページへ戻る</a>
        <?php else: ?>
            <p>指定されたお知らせが見つかりませんでした。</p>
            <a href="/" class="back-link">メインページへ戻る</a>
        <?php endif; ?>
    </div>
</body>
</html>