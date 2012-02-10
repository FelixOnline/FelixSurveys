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
    	preg_match('/(?<= - )(.*)$/', $question['label'], $matches);
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
        	$dependent = false;
        	if(array_key_exists('dependencies', $questions[$column])) {
        		$dependent = true;
        		$required = true;
				$passed = true; // Assume we met the dependency
				
				if(array_key_exists('reverse', $questions[$column]) && $questions[$column]['reverse'] == true) {
					$required = false;
					$passed = true; // Assume the dependency is not met. This means that this test passed
				}
				
				foreach($questions[$column]['dependencies'] as $dependency) {
					if($required) {
						if ($data[$dependency['id']] != $dependency['value']) {
							// If we did not meet the dependency, mark as so
							$passed = false;
						}
					} else {
						if ($data[$dependency['id']] == $dependency['value']) {
							// If we met the dependency, then in reverse mode the test has not passed
							$passed = false;
						}
					}
				}
        	}
			
			if($dependent == false || ($dependent == true && $passed == true)) {
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
				$answers[] = 'N/A';
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

