<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['student_id'];
    $newStatus = $_POST['new_status'];

    $db = json_decode(file_get_contents('../database.json'), true);

    // อัปเดตสถานะในตาราง project
    foreach ($db['project'] as &$p) {
        if ($p['student_id'] == $studentId) {
            $p['status'] = $newStatus;
            break;
        }
    }

    // เซฟกลับลงไฟล์ JSON
    file_put_contents('../database.json', json_encode($db, JSON_PRETTY_PRINT));

    header("Location: student_list.php");
    exit();
}
