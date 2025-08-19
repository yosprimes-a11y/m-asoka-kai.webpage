<?php
require_once 'auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $title = isset($_POST['title']) ? trim($_POST['title']) : '無題';
        $category = isset($_POST['category']) ? $_POST['category'] : 'その他';
        $sub_category = isset($_POST['sub_category']) ? $_POST['sub_category'] : 'その他';

        $upload_dir = '../uploads/disclosure/';
        $original_filename = basename($_FILES['file']['name']);
        $safe_filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_.-]/', '_', $original_filename);
        $target_path = $upload_dir . $safe_filename;

        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
            $json_path = '../disclosure_data.json';
            $data = ['corporation' => [], 'locations' => []];
            if (file_exists($json_path)) {
                $json = file_get_contents($json_path);
                $data = json_decode($json, true);
            }

            $new_entry = [
                'id' => uniqid(),
                'title' => $title,
                'file' => $safe_filename,
                'date' => date('Y-m-d')
            ];

            if ($category === '法人情報') {
                $new_entry['sub_category'] = $sub_category;
                array_unshift($data['corporation'], $new_entry);
            } else {
                $new_entry['category'] = $category;
                array_unshift($data['locations'], $new_entry);
            }

            file_put_contents($json_path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            
            header('Location: dashboard.php?status=success');
            exit;
        } else {
            header('Location: dashboard.php?status=move_error');
            exit;
        }
    } else {
        header('Location: dashboard.php?status=upload_error');
        exit;
    }
}