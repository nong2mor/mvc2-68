<?php

class Credit {
    // ฟังก์ชันประเมินหน่วยกิตสะสม 
    public function checkCredits($total_credit) {
        // ต้องมีหน่วยกิตไม่ต่ำกว่า 135 หน่วยกิต จึงจะสามารถจบการศึกษาได้ 
        return $total_credit >= 135;
    }
}
