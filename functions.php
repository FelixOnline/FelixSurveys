<?php
	global $local;
	$local = true;

	// Mark a user as having completed the survey
	function markasdone($uname) {
		// FIXME
		return $uname;
	}

	// Check to see if a user has completed the survey
	function isdone($uname) {
		// FIXME
		return false;
	}

	// Check to see if we have authenticated
	function isloggedin() {
		return (array_key_exists('felix_sex_survey', $_SESSION) && array_key_exists('uname', $_SESSION['felix_sex_survey']));
	}
	
	// Log in
	function login($uname, $pass) {
		global $local;
		
		if ($local) {
			return true;
		}
		return pam_auth($uname, $pass);
	}
