<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // 許可するファイル形式を制限
    $allowedTypes = array("jpg", "png", "pdf", "docx", "xlsm","xlsx");
    if (!in_array($fileType, $allowedTypes)) {
        echo "この形式のファイルはアップロードできません。";
        $uploadOk = 0;
    }

    // ここにファイルサイズをチェックするコードを追加します
    if ($_FILES["fileToUpload"]["size"] > 5000000) { // サイズはバイト単位で設定、ここでは5MBを設定
        echo "ファイルが大きすぎます。5MB以下のファイルをアップロードしてください。";
        $uploadOk = 0;
    }

    // ファイルが正しくアップロードされたかチェック
    if ($uploadOk && move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "ファイル ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " がアップロードされました。";
    } else {
        echo "ファイルのアップロード中にエラーが発生しました。";
    }
}
?>
