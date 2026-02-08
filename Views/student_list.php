<?php
// อ่านข้อมูลจากไฟล์ JSON 
$data = json_decode(file_get_contents('../database.json'), true);
$students = $data['student'];
$credits = $data['credit'];
$projects = $data['project'];
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>หน้ารายการนักศึกษา - ระบบประเมินจบ</title>
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
            padding: 20px;
            background-color: #f9f9f9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        .btn {
            padding: 6px 12px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
            display: inline-block;
        }

        .btn-eval {
            background-color: #4CAF50;
        }

        .btn-manage {
            background-color: #ff9800;
        }

        .status-pass {
            color: green;
            font-weight: bold;
        }

        .status-fail {
            color: red;
        }
    </style>
</head>

<body>

    <h2>ระบบประเมินความพร้อมจบการศึกษา</h2>
    <table>
        <thead>
            <tr>
                <th>รหัส</th>
                <th>ชื่อ-นามสกุล</th>
                <th>ภาควิชา</th>
                <th>หน่วยกิต (>=135)</th>
                <th>สถานะโครงงาน</th>
                <th>สถานะปัจจุบัน</th>
                <th>จัดการข้อมูล</th>
                <th>การประเมิน</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $s): ?>
                <tr>
                    <td><?php echo $s['id']; ?></td>
                    <td><?php echo $s['fname'] . " " . $s['lname']; ?></td>
                    <td><?php echo $s['dept']; ?></td>
                    <td>
                        <?php
                        $total_credit = 0;
                        foreach ($credits as $c) {
                            if ($c['student_id'] == $s['id']) {
                                $total_credit = $c['total_credit'];
                                break;
                            }
                        }
                        echo ($total_credit >= 135) ? "<span class='status-pass'>$total_credit</span>" : "<span class='status-fail'>$total_credit</span>";
                        ?>
                    </td>
                    <td>
                        <?php
                        $p_status = "ไม่พบข้อมูล";
                        foreach ($projects as $p) {
                            if ($p['student_id'] == $s['id']) {
                                $p_status = $p['status'];
                                break;
                            }
                        }
                        echo ($p_status == 'ผ่านแล้ว') ? "<span class='status-pass'>$p_status</span>" : "<span class='status-fail'>$p_status</span>";
                        ?>
                    </td>
                    <td><?php echo $s['status']; ?></td>
                    <td>
                        <a href="manage_project.php?id=<?php echo $s['id']; ?>" class="btn btn-manage">จัดการโครงงาน</a>
                    </td>
                    <td>
                        <a href="evaluate.php?id=<?php echo $s['id']; ?>" class="btn btn-eval">ประเมินความพร้อมจบ</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>