<?php

class student_select
{
    public $list = array();
    
    function studentSelect() {
        require 'connect.php';
        $students = $pdo->query('select * from tbl_student');
        foreach ($students as $key => $val) {
            $this->list[$val['student_name']] = $val['student_mail'];
        }
        $JSON = json_encode($this->list);

        $file = fopen("students.json", "w") or die("Unable to open file!");
        fwrite($file, $JSON);
        fclose($file);
    }
}
$select = new student_select();
$select->studentSelect() ?>