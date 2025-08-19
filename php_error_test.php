<?php
ini_set('display_errors', 1); // 画面にエラーを表示
ini_set('display_startup_errors', 1); // 起動時のエラーも表示
error_reporting(E_ALL); // すべてのエラーを報告

// ここに問題のPHPコードの一部（mail送信部分など）を記述
// 例: trigger_error("テストエラー", E_USER_WARNING);

echo "エラーテストページです。";
?>