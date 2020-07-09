<?php

function setICSValues()
{
    $stamp = str_replace("/", "", date("Y/m/d") . "T" . date("H/i/s"));
    $date = str_replace("-", "", $_POST["setDate"]);
    $start = str_replace(":", "", $_POST["setStartTime"]);
    if (!isset($_POST['setEndTime'])) {
        $end = $start + 1000;
    }
    else {
        $end = str_replace(":", "", $_POST["setEndTime"]);
    }
    $startTime = $date . "T" . $start . 00;
    $endTime = $date . "T" . $end . 00;
    if (isset($_POST["repeat"])) {
        $repeatEnd = str_replace("-", "", $_POST["repeat"]);
    } else {
        $repeatEnd = $date;
    }
    $context = $_POST["subject"];
    $description = $_POST["msg"];
    $organizer = $_SESSION['user_email'];
    setReminder($iCalReminder, $stamp, $date, $startTime, $endTime, $context, $description, $repeatEnd, $organizer);
}
function createUID()
{
    $alphas = range('A', 'Z');
    $UID = "";
    $example = strlen("4000F192713-0052");
    for ($i = 0; $i < $example; $i++) {
        $type = rand(0, 1);
        if ($i === 11) {
            $UID = $UID . "-";
        } else {
            if ($type === 0) {
                $randomNumb = rand(0, 9);
                $UID = $UID . $randomNumb;
            } else {
                $randomLetter = rand(0, 25);
                    $UID = $UID . $alphas[$randomLetter];
            }
        }
    }
    return $UID;
}

function setReminder(&$iCalReminder, $stamp, $date, $startTime, $endTime, $context, $description, $repeatEnd, $organizer)
{

    $UID = $startTime . "-" . createUID() . "@projects.bit-academy.nl";
    $iCalReminder =
        "BEGIN:VCALENDAR
        VERSION:2.0
        METHOD:REQUEST
        PRODID:-//Bit Academy//Bit Calendar//NL
        CALSCALE:GREGORIAN
        BEGIN:VEVENT
        ORGANIZER;CN=Bit Academy:mailto:$organizer
        CLASS:PUBLIC
        PRIORITY:5
        UID:$UID
        CATEGORIES:Bit Reminder
        SEQUENCE:0
        DTSTAMP:$stamp
        DTSTART:$startTime
        DTEND:$endTime
        RRULE:FREQ=WEEKLY;UNTIL=$repeatEnd 
        SUMMARY:$context
        DESCRIPTION:$description
        TRIGGER:-PT30M
        ACTION:DISPLAY
        END:VEVENT
        END:VCALENDAR";
    $iCalReminder = str_replace(["\r\n", "\r", "\n"], "\r\n", $iCalReminder);
    $iCalReminder = str_replace("    ", "", $iCalReminder);
    $myfile = fopen("reminders/invite.ics", "w");
    fwrite($myfile, $iCalReminder);
    fclose($myfile);
}

