<?php
require_once 'auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['file_id'])) {
        $file_id = $_POST['file_id'];
        $json_path = '../disclosure_data.json';

        if (file_exists($json_path)) {
            $json = file_get_contents($json_path);
            $data = json_decode($json, true);

            $file_to_delete = null;
            $found_key = null;
            $found_in = null;

            // Search in corporation files
            foreach ($data['corporation'] as $key => $file) {
                if ($file['id'] === $file_id) {
                    $file_to_delete = $file;
                    $found_key = $key;
                    $found_in = 'corporation';
                    break;
                }
            }

            // Search in locations files if not found yet
            if (!$file_to_delete) {
                foreach ($data['locations'] as $key => $file) {
                    if ($file['id'] === $file_id) {
                        $file_to_delete = $file;
                        $found_key = $key;
                        $found_in = 'locations';
                        break;
                    }
                }
            }

            if ($file_to_delete) {
                // Delete the actual file
                $file_path = '../uploads/disclosure/' . $file_to_delete['file'];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }

                // Remove the entry from the array
                array_splice($data[$found_in], $found_key, 1);

                // Save the updated JSON
                file_put_contents($json_path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            }
        }
    }
}

header('Location: dashboard.php?status=deleted');
exit;
