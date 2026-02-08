<?php
session_start();
$data = $_SESSION['eval_result'] ?? null;

if (!$data) {
    header("Location: student_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ผลการประเมิน</title>
    <style>
        .result-box { max-width: 500px; margin: 50px auto; padding: 30px; border: 2px solid #333; border-radius: 10px; text-align: center; font-family: sans-serif; }
        .pass { color: green; font-size: 24px; font-weight: bold; }
        .fail { color: red; font-size: 24px; font-weight: bold; }
        .remedy { margin: 20px 0; padding: 10px; background: #fff3cd; border: 1px solid #ffeeba; }
        .btn-home { display: inline-block; padding: 10px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>

<div class="result-box">
    <h2>ผลการประเมินความพร้อมจบ</h2>
    <p>นักศึกษา: <strong><?php echo $data['student']['fname'] . " " . $data['student']['lname']; ?></strong></p>
    
    <div class="<?php echo ($data['result'] == 'จบการศึกษา') ? 'pass' : 'fail'; ?>">
        <?php echo $data['result']; ?>
    </div>

    <p>ประเมินเมื่อ: <?php echo date("d/m/Y H:i"); ?></p>

    <a href="student_list.php" class="btn-home">กลับไปหน้ารวมนักศึกษา</a>
</div>

</body>
</html>