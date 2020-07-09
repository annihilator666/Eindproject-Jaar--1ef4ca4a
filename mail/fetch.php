<?php

require 'connect.php';
if (isset($_GET["term"])) {

    $query = "
 SELECT * FROM tbl_student
 WHERE student_name LIKE '%" . $_GET["term"] . "%'
 ORDER BY student_name ASC
 ";

    $statement = $connect->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

    $total_row = $statement->rowCount();

    // voor elk column op de database met $student_name en $imgsrc worden deze opgehaald van de database en gedisplayed op de index.php bestand
    $output = array();
    if ($total_row > 0) {
        foreach ($result as $row) {
            $temp_array = array();
            $temp_array['value'] = $row['student_name'];
            $temp_array['label'] = '<img src="images/' . $row['image'] . '" width=100 />&nbsp;&nbsp;&nbsp;' . $row['student_name'] . '';
            $output[] = $temp_array;
        }
    } else {
        $output['value'] = '';
        $output['label'] = 'No Record Found';
    }
// json_encode neemt de php code en laat deze zien als een json_encode formaat
    echo json_encode($output);
}