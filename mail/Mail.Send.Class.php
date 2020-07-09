<?php
include 'ICS.Generator.class.php';
require 'connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subject = $_POST['subject'];
    $msg = $_POST['msg'];
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom('ProjectStam@hotmail.com', $_SESSION['access_level']);
    $email->setSubject($subject); 
    $email->addContent("text/plain", $msg);
    $email_id = $_POST['email'];
    $email_id = str_replace(' ', '', $email_id);
    $str_arr = explode (",", $email_id);
    $personalization = new \SendGrid\Mail\Personalization();
    if (isset($_POST["shuttle"]) && $_SESSION['access_level'] === 'admin') {
        $shuttle = (int)$_POST['shuttle'];
        if ($shuttle === 3) {
            $students = $pdo->query('select * from tbl_student where shuttle = ' . $shuttle);
            foreach ($students as $val) {
                $personalization->addTo(new \SendGrid\Mail\To($val['student_mail']));
            }
        }
    }
    for ($i=0; $i < count($str_arr); $i++) { 
        if (filter_var($str_arr[$i], FILTER_VALIDATE_EMAIL)) {
            $personalization->addTo(new \SendGrid\Mail\To($str_arr[$i]));
        }
    }
    $email->addPersonalization($personalization);
    if (isset($_POST['includeReminder'])) {
        setICSValues();
        $att1 = new \SendGrid\Mail\Attachment();
        $att1->setContent(file_get_contents("reminders/invite.ics"));
        $att1->setFilename("invite.ics");
        $email->addAttachment($att1);
    }
    $sendgrid = new \SendGrid('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');
    try {
        $response = $sendgrid->send($email);
        echo "<script> succes(); </script>";
    } catch (Exception $e) {
        echo 'Caught exception: ' . $e->getMessage() . "\n";
    }
}
