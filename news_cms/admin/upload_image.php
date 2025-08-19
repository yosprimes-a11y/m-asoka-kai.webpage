<?php
session_start();

// ログインチェック
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('HTTP/1.1 401 Unauthorized');
    echo json_encode(['error' => 'Unauthorized access.']);
    exit;
}

header('Content-Type: application/json');

$upload_dir = __DIR__ . '/../uploads/'; // アップロードディレクトリ
$base_url = '/news_cms/uploads/'; // ウェブからのアクセスパス

// ディレクトリが存在しない場合は作成
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['file'];

    // ファイルタイプとサイズをチェック
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 5 * 1024 * 1024; // 5MB

    if (!in_array($file['type'], $allowed_types)) {
        echo json_encode(['error' => '許可されていないファイル形式です。JPEG, PNG, GIFのみアップロード可能です。']);
        exit;
    }

    if ($file['size'] > $max_size) {
        echo json_encode(['error' => 'ファイルサイズが大きすぎます。5MB以下にしてください。']);
        exit;
    }

    // ファイル名のサニタイズとユニーク化
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $new_file_name = uniqid() . '.' . $file_extension;
    $destination_path = $upload_dir . $new_file_name;
    $public_url = $base_url . $new_file_name;

    if (move_uploaded_file($file['tmp_name'], $destination_path)) {
        echo json_encode(['success' => true, 'url' => $public_url]);
    } else {
        echo json_encode(['error' => 'ファイルのアップロードに失敗しました。']);
    }
} else {
    echo json_encode(['error' => 'ファイルが選択されていないか、アップロードエラーが発生しました。']);
}
?>