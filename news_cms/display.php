<?php
$news_file = __DIR__ . '/data/news.json';
$news_data = [];

if (file_exists($news_file)) {
    $json_content = file_get_contents($news_file);
    $news_data = json_decode($json_content, true);
    if (!is_array($news_data)) {
        $news_data = [];
    }
}

// 曜日を日本語で取得する関数
function getJapaneseDayOfWeek($dateString) {
    $timestamp = strtotime($dateString);
    $dayOfWeek = date('w', $timestamp); // 0 (日) から 6 (土)
    $days = ['日', '月', '火', '水', '木', '金', '土'];
    return '(' . $days[$dayOfWeek] . ')';
}

// 最新のお知らせが上に来るように並び替え（IDの降順）
krsort($news_data);

// ページネーションの設定
$items_per_page = 10;
$total_items = count($news_data);
$total_pages = ceil($total_items / $items_per_page);

$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) $current_page = 1;
if ($current_page > $total_pages && $total_pages > 0) $current_page = $total_pages;

$offset = ($current_page - 1) * $items_per_page;
$paged_news_data = array_slice($news_data, $offset, $items_per_page, true);
?>
    <div class="news-list">
        <?php if (empty($paged_news_data)): ?>
            <p>現在、お知らせはありません。</p>
        <?php else: ?>
            <?php foreach ($paged_news_data as $id => $news_item): ?>
                <div class="news-item">
                    <span class="news-date"><?php echo htmlspecialchars($news_item['date']) . getJapaneseDayOfWeek($news_item['date']); ?></span>
                    <span class="news-category">[<?php echo htmlspecialchars($news_item['category']); ?>]</span>
                    <a href="news_cms/detail.php?id=<?php echo htmlspecialchars($id); ?>" class="news-title-link">
                        <?php echo htmlspecialchars($news_item['title']); ?>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="pagination">
            <?php if ($current_page > 1): ?>
                <a href="?page=<?php echo $current_page - 1; ?>">前へ</a>
            <?php else: ?>
                <span class="disabled">前へ</span>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == $current_page): ?>
                    <span class="current"><?php echo $i; ?></span>
                <?php else: ?>
                    <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($current_page < $total_pages): ?>
                <a href="?page=<?php echo $current_page + 1; ?>">次へ</a>
            <?php else: ?>
                <span class="disabled">次へ</span>
            <?php endif; ?>
        </div>
    </div>