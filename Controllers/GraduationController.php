<?php
require_once __DIR__ . '/../Models/Student.php';
require_once __DIR__ . '/../Models/Credit.php';
require_once __DIR__ . '/../Models/Project.php';

class GraduationController
{
    private $dbPath = '../database.json';

    public function evaluate($studentId)
    {
        // 1. ดึงข้อมูลจาก JSON 
        $db = json_decode(file_get_contents($this->dbPath), true);

        // 2. ค้นหาข้อมูลนักศึกษา, หน่วยกิต และโปรเจกต์
        $student = null;
        $totalCredit = 0;
        $projectStatus = "";

        foreach ($db['student'] as $s) if ($s['id'] == $studentId) $student = $s;
        foreach ($db['credit'] as $c) if ($c['student_id'] == $studentId) $totalCredit = $c['total_credit'];
        foreach ($db['project'] as $p) if ($p['student_id'] == $studentId) $projectStatus = $p['status'];

        // 3. เรียกใช้ Model เพื่อประเมินผล (แยกความรับผิดชอบชัดเจน) 
        $creditModel = new Credit($db['credit']);
        $projectModel = new Project($db['project']);

        $isCreditPass = $creditModel->checkCredits($totalCredit); // เช็ค >= 135 
        $isProjectPass = $projectModel->checkProject($projectStatus); // เช็คว่า "ผ่านแล้ว" 

        // 4. สรุปผลการประเมิน (ต้องผ่านทั้งสองส่วนจึงจะจบ) 
        $finalResult = ($isCreditPass && $isProjectPass) ? "จบการศึกษา" : "ไม่จบการศึกษา";
        if ($finalResult == "จบการศึกษา") {
            foreach ($db['student'] as &$s) {
                if ($s['id'] == $studentId) {
                    $s['status'] = "จบการศึกษา"; // อัปเดตสถานะในตารางหลักตามผลประเมิน
                    break;
                }
            }
        }
        // 5. บันทึกผลลงใน GraduationResults (JSON) 
        $newResult = [
            "student_id" => $studentId,
            "result" => $finalResult,
            "date" => date("Y-m-d H:i:s")
        ];
        $db['graduation_result'][] = $newResult;
        file_put_contents($this->dbPath, json_encode($db, JSON_PRETTY_PRINT));

        // 6. ส่งข้อมูลไปที่หน้า View (หน้าผลการประเมิน) 
        return [
            "student" => $student,
            "result" => $finalResult
        ];
    }
}
