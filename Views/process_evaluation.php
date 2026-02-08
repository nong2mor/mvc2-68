<?php
// นำ Controller เข้ามาใช้งาน
require_once '../Controllers/GraduationController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['student_id'];

    // เรียกใช้ Controller เพื่อประเมินผล
    $controller = new GraduationController();
    $evaluationData = $controller->evaluate($studentId);

    // เก็บผลลัพธ์ไว้ใน Session เพื่อนำไปแสดงในหน้า result.php
    session_start();
    $_SESSION['eval_result'] = $evaluationData;

    // เมื่อประเมินและบันทึกผลเสร็จแล้ว ให้ไปที่หน้าผลการประเมิน 
    header("Location: result.php");
    exit();
}