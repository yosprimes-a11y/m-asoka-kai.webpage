<?php
require_once 'auth.php';

$json_path = '../disclosure_data.json';
$data = [];
if (file_exists($json_path)) {
    $json = file_get_contents($json_path);
    $data = json_decode($json, true);
}

$corporation_files = isset($data['corporation']) ? $data['corporation'] : [];
$location_files = isset($data['locations']) ? $data['locations'] : [];

// Combine files for display, ensuring corporation files are identifiable
$all_files = [];
foreach ($corporation_files as $file) {
    $file['main_category'] = '法人情報';
    $all_files[] = $file;
}
foreach ($location_files as $file) {
    $file['main_category'] = $file['category'];
    $all_files[] = $file;
}

// Pagination variables
$items_per_page = 10;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$total_items = count($all_files);
$total_pages = ceil($total_items / $items_per_page);
$offset = ($current_page - 1) * $items_per_page;

// Slice the array for the current page
$paged_files = array_slice($all_files, $offset, $items_per_page);


// Define categories for the upload form
$categories = [
    '法人情報',
    '赤城野荘',
    '光明園',
    'ルンビニー苑',
    'たんぽぽ学園',
    'やすらぎ園',
    'その他'
];

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理ダッシュボード</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body { font-family: sans-serif; background: #f0f2f5; color: #333; }
        .container { max-width: 1200px; margin: 2rem auto; background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h1, h2 { color: #0056b3; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #ddd; padding-bottom: 1rem; margin-bottom: 2rem; }
        .header a { text-decoration: none; background: #dc3545; color: white; padding: 0.5rem 1rem; border-radius: 4px; }
        .header a:hover { background: #c82333; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 2rem; }
        th, td { border: 1px solid #ddd; padding: 0.8rem; text-align: left; }
        th { background-color: #f8f9fa; }
        .delete-form button { background: #dc3545; color: white; border: none; padding: 0.5rem; border-radius: 4px; cursor: pointer; }
        .delete-form button:hover { background: #c82333; }
        .upload-form { border-top: 2px solid #ddd; padding-top: 2rem; }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        .form-group input[type="text"], .form-group select { width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 4px; }
        .form-group select:disabled { background-color: #e9ecef; cursor: not-allowed; }
        .form-group button { background: #28a745; color: white; padding: 0.8rem 1.5rem; border: none; border-radius: 4px; cursor: pointer; font-size: 1rem; }
        .form-group button:hover { background: #218838; }
        #drop-zone { border: 2px dashed #ccc; border-radius: 8px; padding: 2rem; text-align: center; transition: border-color 0.3s, background-color 0.3s; }
        #drop-zone.drag-over { border-color: #007bff; background-color: #f0f8ff; }
        #file-name-display { margin-top: 10px; font-style: italic; color: #555; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>管理ダッシュボード</h1>
            <a href="logout.php">ログアウト</a>
        </div>

        <h2>登録ファイル一覧</h2>
        <table>
            <thead>
                <tr>
                    <th>表示タイトル</th>
                    <th>カテゴリ</th>
                    <th>サブカテゴリ</th>
                    <th>ファイル名</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($all_files)): ?>
                    <?php foreach ($paged_files as $file): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($file['title']); ?></td>
                            <td><?php echo htmlspecialchars($file['main_category']); ?></td>
                            <td><?php echo htmlspecialchars(isset($file['sub_category']) ? $file['sub_category'] : '---'); ?></td>
                            <td><a href="../uploads/disclosure/<?php echo htmlspecialchars($file['file']); ?>" target="_blank"><?php echo htmlspecialchars($file['file']); ?></a></td>
                            <td>
                                <form action="delete.php" method="POST" class="delete-form" onsubmit="return confirm('本当にこのファイルを削除しますか？');">
                                    <input type="hidden" name="file_id" value="<?php echo htmlspecialchars($file['id']); ?>">
                                    <button type="submit">削除</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">登録されているファイルはありません。</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="pagination" style="text-align: center; margin-top: 20px;">
            <?php if ($total_pages > 1): ?>
                <?php if ($current_page > 1): ?>
                    <a href="?page=<?php echo $current_page - 1; ?>" style="margin: 0 5px; padding: 8px 12px; border: 1px solid #ddd; text-decoration: none; color: #007bff; border-radius: 4px;">前へ</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" style="margin: 0 5px; padding: 8px 12px; border: 1px solid #ddd; text-decoration: none; color: <?php echo ($i == $current_page) ? 'white; background-color: #007bff;' : '#007bff;'; ?>; border-radius: 4px;"><?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                    <a href="?page=<?php echo $current_page + 1; ?>" style="margin: 0 5px; padding: 8px 12px; border: 1px solid #ddd; text-decoration: none; color: #007bff; border-radius: 4px;">次へ</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="upload-form">
            <h2>新規ファイルアップロード</h2>
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">表示タイトル</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="category">カテゴリ</label>
                    <select id="category" name="category" required>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat; ?>"><?php echo $cat; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group" id="sub-category-group">
                    <label for="sub_category">サブカテゴリ（法人情報）</label>
                    <select id="sub_category" name="sub_category" disabled>
                        <option value="決算報告">決算報告</option>
                        <option value="その他">その他</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="file">ファイル</label>
                    <div id="drop-zone">
                        <p>ここにファイルをドラッグ＆ドロップするか、下のボタンをクリックして選択</p>
                        <input type="file" id="file" name="file" required>
                        <p id="file-name-display"></p>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit">アップロード</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('file');
        const fileNameDisplay = document.getElementById('file-name-display');
        const categorySelect = document.getElementById('category');
        const subCategorySelect = document.getElementById('sub_category');

        // Set initial state on page load
        subCategorySelect.disabled = categorySelect.value !== '法人情報';

        dropZone.addEventListener('click', (e) => {
            if (e.target.id !== 'file') {
                fileInput.click();
            }
        });

        dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('drag-over'); });
        dropZone.addEventListener('dragleave', (e) => { e.preventDefault(); dropZone.classList.remove('drag-over'); });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('drag-over');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                fileNameDisplay.textContent = `選択されたファイル: ${files[0].name}`;
            }
        });

        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) {
                fileNameDisplay.textContent = `選択されたファイル: ${fileInput.files[0].name}`;
            }
        });

        categorySelect.addEventListener('change', () => {
            subCategorySelect.disabled = categorySelect.value !== '法人情報';
        });
    </script>

</body>
</html>
