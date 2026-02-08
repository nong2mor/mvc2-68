<?php

class Project {
    // ฟังก์ชันประเมินโครงงาน 
    public function checkProject($status) {
        // การประเมินโครงงาน ต้องผ่าน จึงจะสามารถจบการศึกษาได้ 
        return $status === "ผ่านแล้ว";
    }
}
