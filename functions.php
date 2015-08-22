<?php
	function selfURL()
	{
	    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
	    $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
	    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
	    return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
	}

	function strleft($s1, $s2) { return substr($s1, 0, strpos($s1, $s2)); }

	// Mark a user as having completed the survey
	function markasdone($uname) {
		$sql = "INSERT INTO `".TABLE_PREFIX."_completers` (uname) VALUES ('".mysql_real_escape_string(sha1($uname.getcourse($uname)))."')";
		return mysql_query($sql);
	}

	// Check to see if a user has completed the survey
	function isdone($uname) {
		$sql = "SELECT COUNT(*) FROM `".TABLE_PREFIX."_completers` WHERE uname='".mysql_real_escape_string(sha1($uname.getcourse($uname)))."'";
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
		return (array_key_exists(COOKIE, $_SESSION) && array_key_exists('uname', $_SESSION[COOKIE]));
	}
	
	// Log in
	function login($uname, $pass) {
		if (LOCAL == true) {
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
	    if(!LOCAL) { // if on union server
	        $data = ldap_get_info($uname);
			return($data[2]);
	    } else {
	        return 'Unknown (local)';
	    }
	}

	// get course from ldap for user
	function getcourse($uname) {
	    if(!LOCAL) { // if on union server
	        $data = ldap_get_info($uname);
			return($data[0]);
	    } else {
	        return 'Unknown (local)';
	    }
	}
	
	// add survey responses to database
	function addresponse($response, $secure_response, $troll) {
		$sql = "INSERT INTO `".TABLE_PREFIX."_responses` (id, data, deptcheck) VALUES (NULL, '".mysql_real_escape_string($response)."', ".mysql_real_escape_string($troll).")";
		$status = mysql_query($sql);
		
		if($status) {
			if($secure_response != '[]') {
				// has secure entries
				$sql = "INSERT INTO `".TABLE_PREFIX."_secure_responses` (data, deptcheck) VALUES ('".mysql_real_escape_string($secure_response)."', ".mysql_real_escape_string($troll).");";
				return mysql_query($sql);
			} else {
				return true;
			}
		}
		
		return false;
	}
	
