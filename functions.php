<?php
	global $local;
	$local = true;

	// Mark a user as having completed the survey
	function markasdone($uname) {
		$sql = "INSERT INTO `sexsurvey_completers` (uname) VALUES ('".mysql_real_escape_string(sha1($uname))."')";
		return mysql_query($sql);
	}

	// Check to see if a user has completed the survey
	function isdone($uname) {
		$sql = "SELECT COUNT(*) FROM `sexsurvey_completers` WHERE uname='".mysql_real_escape_string(sha1($uname))."'";
		$rsc = mysql_query($sql);
		list($match) = mysql_fetch_array($rsc);
		if ($match > 0) {
			return true;
		} else {
			return false;
		}
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

    function outputclasses($classes) {
        foreach($classes as $class) {
            echo $class.' ';
        }
    }

	// get dept from ldap for user
	function getdept($uname) {
		global $local;
		
	    if(!$local) { // if on union server
	        $ds=ldap_connect("addressbook.ic.ac.uk");
	        $r=ldap_bind($ds);
	        $justthese = array("o");
	        $sr=ldap_search($ds, "ou=People, ou=shibboleth, dc=ic, dc=ac, dc=uk", "uid=$uname", $justthese);
	        $info = ldap_get_entries($ds, $sr);
	        if ($info["count"] > 0) {
	            $data = explode('|', $info[0]['o'][0]);
			return $data[2];
	        } else {
	            return 'Unknown';
			}
	    } else {
	        return 'Unknown';
	    }
	}
	
	// add survey responses to database
	function addresponse($response, $troll) {
		$sql = "INSERT INTO `sexsurvey_responses` (id, data, deptcheck) VALUES (NULL, '".mysql_real_escape_string($response)."', ".mysql_real_escape_string($troll).")";
		return mysql_query($sql);
	}
