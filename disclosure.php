<?php
// ====================================================================
// Helper & Data Processing
// ====================================================================

// Helper function to get icon class based on file extension
function get_file_icon_class($filename) {
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    switch ($extension) {
        case 'pdf': return 'fa-file-pdf';
        case 'doc': case 'docx': return 'fa-file-word';
        case 'xls': case 'xlsx': return 'fa-file-excel';
        case 'ppt': case 'pptx': return 'fa-file-powerpoint';
        case 'zip': case 'rar': return 'fa-file-archive';
        case 'jpg': case 'jpeg': case 'png': case 'gif': return 'fa-file-image';
        default: return 'fa-file';
    }
}

// --- Load JSON Data --- //
$json_path = 'disclosure_data.json';
$data = ['corporation' => [], 'locations' => []];
if (file_exists($json_path)) {
    $json = file_get_contents($json_path);
    $data = json_decode($json, true);
}

// --- Prepare Data for 7 Fixed Boxes --- //
$all_categories = [
    '法人情報' => [],
    '赤城野荘' => [],
    '光明園' => [],
    'たんぽぽ学園' => [],
    'ルンビニー苑' => [],
    'やすらぎ園' => [],
    'その他' => []
];

// Sort Corporation Files into sub-categories
$corporation_files = isset($data['corporation']) ? $data['corporation'] : [];
$all_categories['法人情報']['決算報告'] = [];
$all_categories['法人情報']['その他'] = [];
foreach ($corporation_files as $file) {
    if (isset($file['sub_category']) && $file['sub_category'] === '決算報告') {
        $all_categories['法人情報']['決算報告'][] = $file;
    } else {
        $all_categories['法人情報']['その他'][] = $file;
    }
}

// Group Location Files
$location_files = isset($data['locations']) ? $data['locations'] : [];
foreach ($location_files as $file) {
    $category = isset($file['category']) ? $file['category'] : 'その他';
    if (array_key_exists($category, $all_categories)) {
        $all_categories[$category][] = $file;
    }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>情報開示・ダウンロード｜社会福祉法人あそか会</title>
<meta name="description" content="社会福祉法人あそか会の情報開示・ダウンロードページです。決算報告書、定款、各事業所の資料などをダウンロードいただけます。">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/header-menu.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<style>
    .disclosure-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        padding: 10px;
    }
    .disclosure-box {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px 20px 10px 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        flex: 1 1 100%;
        display: flex;
        flex-direction: column;
    }
    .disclosure-box h3 {
        font-size: 1.5em;
        color: #0056b3;
        border-bottom: 2px solid #0056b3;
        padding-bottom: 10px;
        margin-top: 0;
        margin-bottom: 10px;
    }
    .disclosure-box h4 {
        font-size: 1.2em;
        color: #333;
        margin-top: 15px;
        margin-bottom: 10px;
        border-left: 5px solid #007bff;
        padding-left: 10px;
    }
    .file-list {
        list-style: none;
        padding: 0;
        flex-grow: 1;
    }
    .file-item {
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
    }
    .file-item:last-child { border-bottom: none; }
    .file-item.hidden { display: none; }
    .file-item .fas {
        color: #007bff;
        font-size: 1.2em;
        margin-right: 15px;
        width: 20px;
        text-align: center;
    }
    .file-item .fa-file-pdf { color: #d93025; }
    .file-item .fa-file-word { color: #2b579a; }
    .file-item .fa-file-excel { color: #1d6f42; }
    .file-item a { text-decoration: none; color: #333; font-weight: 500; }
    .file-item a:hover { text-decoration: underline; }
    .pagination-controls {
        text-align: center;
        padding: 15px 0 5px 0;
    }
    .pagination-controls button {
        background: #007bff;
        color: white;
        border: none;
        padding: 5px 12px;
        border-radius: 4px;
        cursor: pointer;
        margin: 0 5px;
    }
    .pagination-controls button:disabled {
        background: #ccc;
        cursor: not-allowed;
    }
    .pagination-info {
        display: inline-block;
        margin: 0 10px;
        font-size: 0.9em;
        color: #555;
    }
</style>
<style>@media (min-width: 769px) { .header-logo { display: block !important; } }</style>
</head>
<body id="reports">

  <header class="header">
    <div class="header-left">
      <a href="index.php"><img class="header-logo" src="images/asokalogoxmini.png" alt="sub-logo"></a>
    </div>
    <div class="header-right">
      <ul class="menu-items">
        <li class="menu-item"><a href="index.php#latest-news">お知らせ</a></li>
        <li class="menu-item menu-item-has-children">
          <a href="index.php#philosophy">法人について</a>
          <ul class="submenu">
            <li><a href="houjin.html">理事長挨拶</a></li>
            <li><a href="houjin.html#hist">法人沿革</a></li>
            <li><a href="index.php#philosophy">法人理念</a></li>
          </ul>
        </li>
        <li class="menu-item menu-item-has-children">
          <a href="index.php#works">事業について</a>
          <ul class="submenu">
            <li><a href="akagi.html">赤城野荘</a></li>
            <li><a href="kou.html">光明園</a></li>
            <li><a href="tan.html">たんぽぽ学園</a></li>
            <li><a href="yas.html">やすらぎ園</a></li>
            <li><a href="run.html">ルンビニー苑</a></li>
          </ul>
        </li>
        <li class="menu-item"><a href="index.php#skills">約束について</a></li>
        <li class="menu-item"><a href="recruit.html">採用について</a></li>
        <li class="menu-item"><a href="disclosure.php">情報開示・ダウンロード</a></li>
        <li class="menu-item"><a href="policy.html">サイトポリシー</a></li>
        <li class="menu-item"><a href="contactform.php">お問い合わせ</a></li>
      </ul>
      <button class="menu-toggle">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
  </header>

<div id="main" class="content">
  <div class="section-title">
    <h2 class="mincho">情報開示・ダウンロード</h2>
    <p>Information Disclosure & Downloads</p>
  </div>

  <div class="disclosure-container">
    <?php foreach ($all_categories as $main_category_name => $files_or_subcategories): ?>
        <div class="disclosure-box" id="box-<?php echo strtolower(preg_replace('/[^a-zA-Z0-9]/','', $main_category_name)); ?>">
            <h3><?php echo htmlspecialchars($main_category_name); ?></h3>
            <?php if ($main_category_name === '法人情報'): ?>
                <?php foreach ($files_or_subcategories as $sub_category_name => $files): ?>
                    <h4><?php echo htmlspecialchars($sub_category_name); ?></h4>
                    <?php if (!empty($files)): ?>
                        <ul class="file-list">
                            <?php foreach ($files as $file): ?>
                                <li class="file-item">
                                    <i class="fas <?php echo get_file_icon_class($file['file']); ?>"></i>
                                    <a href="uploads/disclosure/<?php echo htmlspecialchars($file['file']); ?>"><?php echo htmlspecialchars($file['title']); ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>ファイルはありません。</p>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <?php if (!empty($files_or_subcategories)): ?>
                    <ul class="file-list">
                        <?php foreach ($files_or_subcategories as $file): ?>
                            <li class="file-item">
                                <i class="fas <?php echo get_file_icon_class($file['file']); ?>"></i>
                                <a href="uploads/disclosure/<?php echo htmlspecialchars($file['file']); ?>"><?php echo htmlspecialchars($file['title']); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>ファイルはありません。</p>
                <?php endif; ?>
            <?php endif; ?>
            <div class="pagination-controls"></div>
        </div>
    <?php endforeach; ?>
  </div>

</div>

  <footer class="footer">
    <div class="social-buttons">
      <a href="https://www.instagram.com/akagi_no_sou" class="instagram-btn red" target="_blank">
        <i class="fab fa-instagram"></i> 赤城野荘 Instagram
      </a>
      <a href="https://www.instagram.com/koumyouen" class="instagram-btn blue" target="_blank">
        <i class="fab fa-instagram"></i> 光　明　園 Instagram
      </a>
      <a href="https://www.instagram.com/tanpopo_gakuen" class="instagram-btn yellow" target="_blank">
        <i class="fab fa-instagram"></i> たんぽぽ学園 Instagram
      </a>
      <a href="https://www.instagram.com/maebashi.asoka.yasuragi.dei" class="instagram-btn green" target="_blank">
        <i class="fab fa-instagram"></i> やすらぎ園 Instagram
      </a>
      <a href="https://www.instagram.com/asokarunbinien" class="instagram-btn purple" target="_blank">
        <i class="fab fa-instagram"></i> ルンビニー苑 Instagram
      </a>
      <a href="https://www.instagram.com/kiiro.pro" class="instagram-btn white" target="_blank">
        <i class="fab fa-instagram"></i> 幸せのベンチ Instagram
      </a>
    </div>
    © 2024 社会福祉法人前橋あそか会
  </footer>
  <script src="script/script.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const itemsPerPage = 5;

        document.querySelectorAll('.disclosure-box').forEach(box => {
            const fileLists = box.querySelectorAll('.file-list');
            if (fileLists.length === 0) return;

            let totalItems = [];
            fileLists.forEach(list => {
                totalItems.push(...list.querySelectorAll('.file-item'));
            });

            if (totalItems.length <= itemsPerPage) return;

            const paginationControls = box.querySelector('.pagination-controls');
            let currentPage = 1;
            const totalPages = Math.ceil(totalItems.length / itemsPerPage);

            function showPage(page) {
                totalItems.forEach((item, index) => {
                    const startIndex = (page - 1) * itemsPerPage;
                    const endIndex = startIndex + itemsPerPage;
                    item.classList.toggle('hidden', index < startIndex || index >= endIndex);
                });
                updateControls();
            }

            function updateControls() {
                paginationControls.innerHTML = `
                    <button class="prev-btn" ${currentPage === 1 ? 'disabled' : ''}>前へ</button>
                    <span class="pagination-info">${currentPage} / ${totalPages}</span>
                    <button class="next-btn" ${currentPage === totalPages ? 'disabled' : ''}>次へ</button>
                `;
                
                paginationControls.querySelector('.prev-btn').addEventListener('click', () => {
                    if (currentPage > 1) {
                        currentPage--;
                        showPage(currentPage);
                    }
                });

                paginationControls.querySelector('.next-btn').addEventListener('click', () => {
                    if (currentPage < totalPages) {
                        currentPage++;
                        showPage(currentPage);
                    }
                });
            }

            showPage(1);
        });
    });
  </script>

</body>
</html>
