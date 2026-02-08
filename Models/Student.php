<?php
class Student {
    private $dbPath = __DIR__ . '/../database.json';

    public function getAll() {
        $data = json_decode(file_get_contents($this->dbPath), true);
        return $data['student']; // คืนค่ารายการนักศึกษาทั้งหมด 
    }

    public function getById($id) {
        $data = json_decode(file_get_contents($this->dbPath), true);
        foreach ($data['student'] as $student) {
            if ($student['id'] == $id) return $student;
        }
        return null;
    }
}