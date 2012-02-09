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
    	preg_match('/(?<= - )(.*)((?=\?))/', $question['label'], $matches);
        $headers[] = strip_tags($matches[0]);
		$raw_headers[] = $question['name'];
    }
}

$headers[] = 'Troll check';

fputcsv($fp, $headers);

$sql = "SELECT * FROM `sexsurvey_responses`";
$rsc = mysql_query($sql);

while($row = mysql_fetch_array($rsc)) {
    $answers = array();
    $places = array();
    $data = json_decode($row['data'], true);
    foreach($raw_headers as $column) {
        if(array_key_exists($column, $data)) {
            switch($column) {
                case 'campuswhere':
					foreach ($questions['campuswhere']['options'] as $tmp_option) {
						$tmp_label[] = $tmp_option['label'];
						$tmp_value[] = $tmp_option['value'];
					}
					
					foreach ($data[$column] as $tmp_choice) {
						$final_data[] = str_replace($tmp_value, $tmp_label, $tmp_choice);
					}
					
                    $answers[] = json_encode($final_data);
                    break;
                case 'other':
                    $order   = array("\r\n", "\n", "\r");
                    $replace = '<br />';
                    $answers[] = str_replace($order, $replace, $data[$column]);
                    break;
                default:
					$realanswers = $questions[$column]['options'];
					foreach ($realanswers as $option) {
						if($option['value'] == $data[$column]) {
							$answers[] = $option['label'];
						}
					}
                    break;
            }
        } else {
            $answers[] = 'NULL';
        }
    }
	
	if($row['deptcheck'] == 1) {
		$answers[] = 'Possible troll';
	} else {
		$answers[] = 'Not flagged';
	}
	
    fputcsv($fp, $answers);
}

