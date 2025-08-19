<?php
session_start();

// ログインしていない場合はログインページへリダイレクト
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$news_file = __DIR__ . '/../data/news.json';
$categories = ['お知らせ', '重要なお知らせ']; // 既存のカテゴリを参考に設定

$message = '';
$news_item = null;
$news_id = null;

// 編集対象のIDを取得
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

    if (isset($news_data[$news_id])) {
        $news_item = $news_data[$news_id];
    } else {
        $message = '<p style="color: red;">指定されたお知らせが見つかりません。</p>';
    }
} else {
    $message = '<p style="color: red;">編集するお知らせが指定されていません。</p>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $news_item) {
    $date = $_POST['date'] ?? '';
    $category = $_POST['category'] ?? '';
    $title = $_POST['title'] ?? '';
    $url = $_POST['url'] ?? '';
    $target = $_POST['target'] ?? '_self';
    $content = $_POST['content'] ?? '';
    $image = $_POST['image'] ?? '';

    // 簡単なバリデーション
    if (empty($date) || empty($title) || empty($content)) {
        $message = '<p style="color: red;">日付、タイトル、本文は必須です。</p>';
    } else {
        $news_data = [];
        if (file_exists($news_file)) {
            $json_content = file_get_contents($news_file);
            $news_data = json_decode($json_content, true);
            if (!is_array($news_data)) {
                $news_data = [];
            }
        }

        // 既存のデータを更新
        $news_data[$news_id] = [
            'date' => $date,
            'category' => $category,
            'title' => $title,
            'url' => $url,
            'target' => $target,
            'content' => $content,
            'image' => $image,
        ];

        // JSONデータをファイルに保存
        if (file_put_contents($news_file, json_encode($news_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
            $message = '<p style="color: green;">お知らせが更新されました。</p>';
            // 更新後のデータを再読み込み
            $news_item = $news_data[$news_id];
        } else {
            $message = '<p style="color: red;">お知らせの更新に失敗しました。</p>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お知らせCMS - 編集</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); max-width: 800px; margin: 20px auto; }
        h2 { color: #333; margin-bottom: 20px; }
        .menu { margin-bottom: 20px; }
        .menu a { display: inline-block; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; margin-right: 10px; }
        .menu a:hover { background-color: #0056b3; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input[type="text"],
        .form-group input[type="date"],
        .form-group select,
        .form-group textarea { width: calc(100% - 22px); padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .form-group textarea { resize: vertical; min-height: 100px; }
        .form-group input[type="submit"] { background-color: #ffc107; color: #333; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .form-group input[type="submit"]:hover { background-color: #e0a800; }
    </style>
</head>
<body>
    <div class="container">
        <h2>お知らせ編集</h2>
        <div class="menu">
            <a href="index.php">管理画面トップへ</a>
        </div>

        <?php echo $message; ?>

        <?php if ($news_item): ?>
        <form action="edit.php?id=<?php echo htmlspecialchars($news_id); ?>" method="post">
            <div class="form-group">
                <label for="date">日付:</label>
                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($news_item['date']); ?>" required>
            </div>
            <div class="form-group">
                <label for="category">カテゴリ:</label>
                <select id="category" name="category">
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo ($news_item['category'] === $cat) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="title">タイトル:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($news_item['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="url">URL (リンク先):</label>
                <input type="text" id="url" name="url" value="<?php echo htmlspecialchars($news_item['url']); ?>" placeholder="例: https://example.com/detail.html">
            </div>
            <div class="form-group">
                <label for="target">リンクの開き方:</label>
                <select id="target" name="target">
                    <option value="_self" <?php echo ($news_item['target'] === '_self') ? 'selected' : ''; ?>>同じウィンドウ (_self)</option>
                    <option value="_blank" <?php echo ($news_item['target'] === '_blank') ? 'selected' : ''; ?>>新しいウィンドウ (_blank)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="content">本文:</label>
                <textarea id="content" name="content" required><?php echo htmlspecialchars($news_item['content']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="image">画像パス (オプション):</label>
                <!-- ここにドラッグ＆ドロップエリアを追加 -->
                <div id="drop-area" style="border: 2px dashed #ccc; padding: 20px; text-align: center; cursor: pointer; margin-bottom: 10px;">
                    画像をここにドラッグ＆ドロップ、またはクリックして選択
                    <input type="file" id="image-upload" accept="image/*" style="display: none;">
                </div>
                <p id="upload-status" style="color: blue;"></p>
                <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($news_item['image']); ?>" placeholder="例: /news_cms/uploads/your_image.jpg" readonly>
            </div>
            <div class="form-group">
                <input type="submit" value="お知らせを更新">
            </div>
        </form>
        <?php endif; ?>
    </div>
    <script>
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('image-upload');
        const imagePathInput = document.getElementById('image');
        const uploadStatus = document.getElementById('upload-status');

        // ドロップエリアクリックでファイル選択ダイアログを開く
        dropArea.addEventListener('click', () => {
            fileInput.click();
        });

        // ファイル選択時の処理
        fileInput.addEventListener('change', (e) => {
            const files = e.target.files;
            if (files.length > 0) {
                uploadFile(files[0]);
            }
        });

        // ドラッグ＆ドロップイベント
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            dropArea.style.borderColor = '#007bff';
        }

        function unhighlight() {
            dropArea.style.borderColor = '#ccc';
        }

        dropArea.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files.length > 0) {
                uploadFile(files[0]);
            }
        }, false);

        function uploadFile(file) {
            uploadStatus.textContent = 'アップロード中...';
            // imagePathInput.value = ''; // アップロード中はパスをクリア (編集時は既存パスを残すためコメントアウト)

            const formData = new FormData();
            formData.append('file', file);

            fetch('upload_image.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    imagePathInput.value = data.url;
                    uploadStatus.textContent = 'アップロード成功！';
                } else {
                    uploadStatus.textContent = 'エラー: ' + data.error;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                uploadStatus.textContent = 'アップロード中にエラーが発生しました。';
            });
        }
    </script>
</body>
</html>