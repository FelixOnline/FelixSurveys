<?php
/*
 * Output response information into csv
 */

require_once('../db.php');

$fp = fopen('data.csv', 'w+');

$questions = file_get_contents('../questions.json');
$questions = json_decode($questions, true);

foreach($questions as $question) {
    if(array_key_exists('name', $question)) {
        $headers[] = $question['name'];
    }
}

fputcsv($fp, $headers);

$sql = "SELECT * FROM `sexsurvey_responses`";
$rsc = mysql_query($sql);

while($row = mysql_fetch_array($rsc)) {
    $answers = array();
    $places = array();
    $data = json_decode($row['data'], true);
    foreach($headers as $column) {
        if(array_key_exists($column, $data)) {
            switch($column) {
                case 'campuswhere':
                    $answers[] = json_encode($data[$column]);
                    break;
                case 'other':
                    $order   = array("\r\n", "\n", "\r");
                    $replace = '<br />';
                    $answers[] = str_replace($order, $replace, $data[$column]);
                    break;
                default:
                    $answers[] = $data[$column];
                    break;
            }
        } else {
            $answers[] = 'NULL';
        }
    }
    fputcsv($fp, $answers);
}

