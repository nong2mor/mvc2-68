<?php
// 1. รับ ID จาก URL และดึงข้อมูลจาก JSON
$studentId = $_GET['id'] ?? null;
$data = json_decode(file_get_contents('../database.json'), true);

$student = null;
$credits = 0;
$projectStatus = "";

// ค้นหาข้อมูลจากตารางต่างๆ ใน JSON
foreach ($data['student'] as $s) if ($s['id'] == $studentId) $student = $s;
foreach ($data['credit'] as $c) if ($c['student_id'] == $studentId) $credits = $c['total_credit'];
foreach ($data['project'] as $p) if ($p['student_id'] == $studentId) $projectStatus = $p['status'];

if (!$student) {
    die("ไม่พบข้อมูลนักศึกษา");
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>หน้าประเมินความพร้อมจบ</title>
    <style>
        .container {
            max-width: 600px;
            margin: 20px auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            font-family: sans-serif;
        }

        .data-row {
            margin-bottom: 15px;
            border-bottom: 1px hide #eee;
            padding-bottom: 5px;
        }

        .label {
            font-weight: bold;
            color: #555;
        }

        .btn-confirm {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            border: none;
            cursor: pointer;
        }

        .btn-back {
            display: inline-block;
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>การประเมินความพร้อมจบการศึกษา</h2>

        <div class="data-row">
            <span class="label">ชื่อ-นามสกุล:</span> <?php echo $student['fname'] . " " . $student['lname']; ?>
        </div>
        <div class="data-row">
            <span class="label">ภาควิชา:</span> <?php echo $student['dept']; ?>
        </div>

        <hr>

        <h3>ข้อมูลประกอบการพิจารณา</h3>
        <div class="data-row">
            <span class="label">หน่วยกิตสะสม:</span> <?php echo $credits; ?> หน่วยกิต
            (เกณฑ์: 135) 
        </div>
        <div class="data-row">
            <span class="label">สถานะโครงงาน:</span> <?php echo $projectStatus; ?>
            (เกณฑ์: ผ่านแล้ว) 
        </div>

        <form action="process_evaluation.php" method="POST">
            <input type="hidden" name="student_id" value="<?php echo $studentId; ?>">
            <button type="submit" class="btn-confirm">ยืนยันการประเมินและบันทึกผล</button>
            <a href="student_list.php" class="btn-back">ยกเลิก</a>
        </form>
    </div>

</body>

</html>