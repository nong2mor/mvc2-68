<?php
$studentId = $_GET['id'] ?? null;
$data = json_decode(file_get_contents('../database.json'), true);

$student = null;
$project = null;

// ค้นหานักศึกษาและโปรเจกต์จาก JSON
foreach ($data['student'] as $s) if ($s['id'] == $studentId) $student = $s;
foreach ($data['project'] as $p) if ($p['student_id'] == $studentId) $project = $p;
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>จัดการสถานะโครงงาน</title>
</head>

<body>
    <h2>จัดการสถานะโครงงาน: <?php echo $student['fname'] . " " . $student['lname']; ?></h2>
    <p>สถานะปัจจุบัน: <strong><?php echo $project['status']; ?></strong></p>

    <form action="update_project.php" method="POST">
        <input type="hidden" name="student_id" value="<?php echo $studentId; ?>">
        <label>เปลี่ยนเป็น:</label>
        <select name="new_status">
            <option value="ยังไม่ผ่าน" <?php echo ($project['status'] == 'ยังไม่ผ่าน') ? 'selected' : ''; ?>>ยังไม่ผ่าน</option>
            <option value="ผ่านแล้ว" <?php echo ($project['status'] == 'ผ่านแล้ว') ? 'selected' : ''; ?>>ผ่านแล้ว</option>
        </select>
        <br><br>
        <button type="submit" style="background: green; color: white; padding: 10px;">บันทึกสถานะ</button>
        <a href="student_list.php">กลับหน้าหลัก</a>
    </form>
</body>

</html>