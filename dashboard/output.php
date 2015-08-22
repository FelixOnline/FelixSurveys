<?php
/*
 * Output response information into csv
 */

require_once('../db.php');

if(ACTIVE) { die('Please close the survey'); }

if(array_key_exists('delete', $_POST) && $_POST['delete'] == 'y') {
	foreach(glob('*.csv') as $file) {
		echo 'Deleting: '.$file . '<br>';
		unlink($file);
	}

	echo '<b>Deleted files</b>';
}

if(!pam_auth($_POST['user'], $_POST['password']) || ($_POST['user'] != 'pk1811' && $_POST['user'] != 'felix')) {
?>
<h1>Philip Kent or Felix Editor: Please log in</h1>
<form action="output.php" method="post">
user: <input type="text" name="user"><br>
password: <input type="password" name="password"><br>
<input type="submit" value="Get data">
</form>
<?php
exit();
}

$fp = fopen('data.csv', 'w+');

$questions = file_get_contents('../questions.json');
$questions = json_decode($questions, true);

foreach($questions as $key => $question) {
	if(array_key_exists('name', $question)) {
		if($question['type'] == 'secure-textbox'): continue; endif;
		if($question['type'] == 'checkbox') {
			$checkbox_headers[] = $question['name'];

			foreach($question['options'] as $option) {
				$headers[] = strip_tags($option['label'].' ('.$question['label'].')');
				$raw_headers[] = array($option['value'].'###'.$question['name'], $question['name']);
				$types[] = 'Checkbox option';
			}
		} elseif($question['type'] == 'widget') {
			$widget_headers[] = $question['name'];

			foreach($question['options'] as $option) {
				$headers[] = strip_tags($option['label'].' ('.$question['label'].')');
				$raw_headers[] = array($option['value'].'###'.$question['name'], $question['name']);
				$types[] = 'Widget option';
			}
		} else {
			$headers[] = strip_tags($question['label']);
			$raw_headers[] = array($question['name'], FALSE);
			$types[] = ucfirst($question['type']);
		}

		if($question['type'] == 'yesno') {
			$questions[$key]['options'] = array(array('label' => 'Yes', 'value' => 'yes'), array('label' => 'No', 'value' => 'no'),array('label' => 'Don\'t wish to say', 'value' => 'anon'));
		}

		if($question['type'] == 'yesnomaybe') {
			$questions[$key]['options'] = array(array('label' => 'Maybe', 'value' => 'maybe'), array('label' => 'Yes', 'value' => 'yes'), array('label' => 'No', 'value' => 'no'),array('label' => 'Don\'t wish to say', 'value' => 'anon'));
		}
	}
}

$headers[] = 'Troll check';
$types[] = '';

fputcsv($fp, $headers);
fputcsv($fp, $types);

$sql = "TRUNCATE TABLE `".TABLE_PREFIX."_completers`";
$rsc = mysql_query($sql);

$sql = "SELECT * FROM `".TABLE_PREFIX."_responses`";
$rsc = mysql_query($sql);

/*
	All data
 */
while($row = mysql_fetch_array($rsc)) {
	$answers = array();
	$places = array();
	$data = json_decode($row['data'], true);

	if(count($data) == 0) {
		continue;
		// No null rows
	}

	foreach($raw_headers as $column) {
		$checkbox_col = $column[1];
		$column = $column[0];

		if($checkbox_col !== FALSE) {
			$old = $column;
			$column = $checkbox_col;
		}

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
						if(!array_key_exists($dependency['id'], $data)) {
							$passed = false; // No value for dependency so did not pass (would only happen if dependent on checkbox and question not shown)
						} elseif ($questions[$dependency['id']]['type'] != 'checkbox' && $data[$dependency['id']][0] != $dependency['value']) {
							// If we did not meet the dependency, mark as so
							$passed = false;
						} elseif ($questions[$dependency['id']]['type'] == 'checkbox' && array_search($dependency['value'], $data[$dependency['id']][0]) === FALSE) {
							// If we did not meet the dependency, mark as so
							$passed = false;
						}
					} else {
						if ($questions[$dependency['id']]['type'] != 'checkbox' && $data[$dependency['id']][0] == $dependency['value']) {
							// If we met the dependency, then in reverse mode the test has not passed
							$passed = false;
						} elseif ($questions[$dependency['id']]['type'] == 'checkbox' && array_search($dependency['value'], $data[$dependency['id']][0]) !== FALSE) {
							// If we did not meet the dependency, mark as so
							$passed = false;
						}
					}
				}
			}

			if($dependent == false || ($dependent == true && $passed == true)) {
				switch($questions[$column]['type']) {
					case 'number':
					case 'textbox':
						$answers[] = $data[$column][0];
						break;
					case 'checkbox':
						if(array_search(explode('###', $old)[0], $data[$column][0]) !== false) {
							$answers[] = 1;
						} else {
							$answers[] = 0;
						}
						break;
					case 'label':
						// do nothing
						break;
					case 'widget':
						$datum = json_decode($data[$column][0], TRUE);

						if(is_null($datum)) {
							$answers[] = '0'; // No response to all options
							continue;
						}

						$searchfor = explode('###', $old)[0];
						if(array_key_exists($searchfor, $datum)) {
							$answers[] = $datum[$searchfor];
						} else {
							$answers[] = 0;
						}
						break;
					default:
						$realanswers = $questions[$column]['options'];
						foreach ($realanswers as $option) {
							if($option['value'] == $data[$column][0]) {
								$toadd = strip_tags($option['label']);
								if($toadd == '') {
									$toadd = $option['value'];
								}

								$answers[] = $toadd;
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

fclose($fp);

unset($headers);

$special_cols = array();
$text_cols = array();
$widget_cols = array();

/*
	Check box questions, separated
 */
foreach($checkbox_headers as $column) {
	if($questions[$column]['type'] != 'checkbox') { continue; }

	// RESPONSES FOR TICKBOXES
	$fp = fopen('data_checkbox_'.$column.'.csv', 'w+');
	$special_cols[$column] = $questions[$column]['label'];

	$i = 0;
	$headers = array();
	$headers_raw = array();
	foreach($questions[$column]['options'] as $location) {
		$headers[$i] = $location['label'];
		$headers_raw[$i] = $location['value'];
		$i++;
	}
	$headers[] = 'Troll check';

	fputcsv($fp, $headers);

	$sql = "SELECT * FROM `".TABLE_PREFIX."_responses`";
	$rsc = mysql_query($sql);

	while($row = mysql_fetch_array($rsc)) {
		$answers = array();
		$places = array();
		$data = json_decode($row['data'], true);

		if(count($data) == 0) {
			continue;
			// No null rows
		}

		$this_row = array();
	
		if(array_key_exists($column, $data)) {
			foreach($headers_raw as $id => $location) {
				if(array_search($location, $data[$column][0]) !== false) {
					$this_row[$id] = 1;
				} else {
					$this_row[$id] = 0;
				}
			}

			if($row['deptcheck'] == 1) {
					$this_row[] = 'Possible troll';
			} else {
					$this_row[] = 'Not flagged';
			}

			fputcsv($fp, $this_row);
		}
	}

	fclose($fp);
}

/*
	Widget questions, separated
 */
foreach($widget_headers as $column) {
	if($questions[$column]['type'] != 'widget') { continue; }

	// RESPONSES FOR WIDGETS
	$fp = fopen('data_widget_'.$column.'.csv', 'w+');
	$widget_cols[$column] = $questions[$column]['label'];

	$i = 0;
	$headers = array();
	$headers_raw = array();
	foreach($questions[$column]['options'] as $location) {
		$headers[$i] = $location['label'];
		$headers_raw[$i] = $location['value'];
		$i++;
	}
	$headers[] = 'Troll check';

	fputcsv($fp, $headers);

	$sql = "SELECT * FROM `".TABLE_PREFIX."_responses`";
	$rsc = mysql_query($sql);

	while($row = mysql_fetch_array($rsc)) {
		$answers = array();
		$places = array();
		$data = json_decode($row['data'], true);

		if(count($data) == 0) {
			continue;
			// No null rows
		}
	
		$this_row = array();
	
		if(array_key_exists($column, $data)) {
			$has_data = FALSE;

			foreach($headers_raw as $id => $location) {
				$datum = json_decode($data[$column][0], TRUE);

				if(is_null($datum)) {
					continue; // no response
				}

				$has_data = TRUE;

				$searchfor = $location;
				if(array_key_exists($searchfor, $datum)) {
					$this_row[] = $datum[$searchfor];
				} else {
					$this_row[] = 0;
				}
			}

			if($row['deptcheck'] == 1) {
					$this_row[] = 'Possible troll';
			} else {
					$this_row[] = 'Not flagged';
			}

			if($has_data): fputcsv($fp, $this_row); endif;
		}
	}

	fclose($fp);
}

/*
	Free text responses, separated
 */
foreach($raw_headers as $column) {
	if($column[1] === FALSE) {
		$column = $column[0];
	} else {
		$column = $column[1];
	}

	if($questions[$column]['type'] != 'textbox') { continue; }

	$fp = fopen('data_text_'.$column.'.csv', 'w+');
	$text_cols[$column] = $questions[$column]['label'];

	$i = 0;
	$headers = array();
	$headers_raw = array();
	$headers[] = $questions[$column]['label'];
	$headers_raw[] = $questions[$column]['name'];
	$headers[] = 'Troll check';
	$headers_raw[] = 'troll';

	fputcsv($fp, $headers);

	$sql = "SELECT * FROM `".TABLE_PREFIX."_responses`";
	$rsc = mysql_query($sql);

	while($row = mysql_fetch_array($rsc)) {
		$answers = array();
		$places = array();
		$data = json_decode($row['data'], true);

		if(count($data) == 0) {
			continue;
			// No null rows
		}

		$this_row = array();
		if(array_key_exists($column, $data)) {
			if(strip_tags($data[$column][0]) != '') {
				if($row['deptcheck'] == 1) {
					$troll = 'Possible troll';
				} else {
					$troll = 'Not flagged';
				}

				fputcsv($fp, array(strip_tags($data[$column][0]), $troll));
			}
		}
	}

	fclose($fp);
} 

?>

<h1>Export complete</h1>
<ul>
	<li><b><a href="data.csv">data.csv</a></b> contains the data on <b>all questions</b>.</li>
	<br>
<?php foreach($special_cols as $key => $qu): ?>
	<li><b><a href="data_checkbox_<?php echo $key; ?>.csv">data_checkbox_<?php echo $key; ?>.csv</a></b> contains separated true/false values for each option in: <b><?php echo $qu; ?></b></li>
<?php endforeach; ?>
<br>
<?php foreach($text_cols as $key => $qu): ?>
		<li><b><a href="data_text_<?php echo $key; ?>.csv">data_text_<?php echo $key; ?>.csv</a></b> contains separated free text responses for question: <b><?php echo $qu; ?></b></li>
<?php endforeach; ?>
<br>
<?php foreach($widget_cols as $key => $qu): ?>
		<li><b><a href="data_widget_<?php echo $key; ?>.csv">data_widget_<?php echo $key; ?>.csv</a></b> contains separated responses for the widget question: <b><?php echo $qu; ?></b></li>
<?php endforeach; ?>
</ul>
<form action="output.php" method="post">
<input type="hidden" name="delete" value="y">
<input type="submit" value="Log out and delete the output files">
</form>
<h1><b style="color: red">REMEMBER TO CLICK THE BUTTON ABOVE WHEN DONE</b></h1>
