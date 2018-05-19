<?php
function dr_checkaccesslevel($access_level, $user_info)
{
	global $db;
	
	$return = false;
	
	$accessstmt = $db->prepare
	("
		SELECT *
		FROM user_user
		INNER JOIN user_accesslevel ON user_user.fk_user_accesslevel = user_accesslevel.id_user_accesslevel
		WHERE user_user.id_user_user = :id
	");
	$accessstmt->bindValue(':id', $user_info['id_user_user'], PDO::PARAM_STR);
	$accessstmt->execute();
	$accessresult = $accessstmt->fetchAll(PDO::FETCH_ASSOC);
	$accessresult = $accessresult[0];
	
	if($accessresult['level'] >= $access_level)
	{
		$return = true;
	}
	
	return $return;
	
}

function dr_checkemail($email)
{
	$return = false;

	
	if(filter_var($email, FILTER_VALIDATE_EMAIL))
	{
	
		// Ok, seems like an email adress. Let's check if it is already used
		global $db;
		
		$emailstmt = $db->prepare
		("
			SELECT * FROM user_user	WHERE user_user.email = :email
		");
		$emailstmt->bindValue(':email', $email, PDO::PARAM_STR);
		$emailstmt->execute();
		$emailresult = $emailstmt->fetchAll(PDO::FETCH_ASSOC);
		$emailresult = $emailresult[0];
		
		if(empty($emailresult))
		{
			$return = true;
		}		
	}
	
	return $return;
}

function dr_checknickname($nickname)
{
	$return = false;
	
	if(preg_match("/^[A-Za-z0-9]+$/", $nickname))
	{
		// Ok, seems like a normal nick name. Let's check if it's already used
		global $db;
		
		$nicknamestmt = $db->prepare
		("
			SELECT * FROM user_user	WHERE user_user.name = :name
		");
		$nicknamestmt->bindValue(':name', $nickname, PDO::PARAM_STR);
		$nicknamestmt->execute();
		$nicknameresult = $nicknamestmt->fetchAll(PDO::FETCH_ASSOC);
		$nicknameresult = $nicknameresult[0];
		
		if(empty($nicknameresult))
		{
			$return = true;
		}
		
	}
		
	return $return;
}


function dr_checkpassword($user_info, $password)
{
	$return = false;
	
	global $db;
	
	// Ok, we'll try to query our user
	$passwordstmt = $db->prepare("SELECT * FROM user_user WHERE id_user_user=:id");
	$passwordstmt->bindValue(':id', $user_info['id_user_user'], PDO::PARAM_STR);
	$passwordstmt->execute();
	$users = $passwordstmt->fetchAll(PDO::FETCH_ASSOC);
	
	$user = $users[0];
	
	// Let's verify his password
	if(password_verify($password ,$user['password']))
	{
		$return = true;
	}
	
	return $return;
}

function dr_checknewpassword($password)
{
	$return = false;
	
	
	// 8 chars at minimum
	if(strlen($password) >= 8)
	{
		$return = true;
	}
	
	return $return;
}

// Checks if string is an URL
function dr_isip($ip)
{
	$return = false;
	
	// Public IPv4, no private or reserved ranges
	if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE))
	{
		$return = $ip;
	}
	 	
	return $return;
}

function dr_isport($port)
{
	$return = false;
	
	if
	(
		// A port is a number
		is_numeric($port)
		AND
		// Ranging from 0
		$port >= 0
		AND
		// to 65535 (16 bits)
		$port < pow(2,16)
	)
	{
		$return = $port;
	}

	return $return;
}

function dr_isurl($url)
{
	$return = false;
	
	$domainfile = "{$_SERVER['DOCUMENT_ROOT']}/inc/shared/tlds-alpha-by-domain.txt";
	
	// Less restrictive than FILTER_VALIDATE_URL, a scheme is not needed.
	// To overcome this, we check if a scheme is given. If not, we use http:// as the default one
	// ftp:// and so is not needed for now
	// We only use the first 4, https:// matches this too.
	$url_scheme = substr($url, 0, 4);
	
	// Ok, if this is http
	if($url_scheme == "http")
	{
		// It's already given, work is done on the formal side
		$url_search = $url;
	}
	else
	{
		// Ok, try to do some modifications before customs...
		$url_search = "http://{$url}";
	}
	
	// Ok, now check if it seems like an URL
	// Is it given and seems ok?
	if(filter_var($url_search, FILTER_VALIDATE_URL))
	{
		// Ok, now we gotta do further filtering, because validate URL is reeeeally too lazy (except for the damn scheme)
		// We want it to be at least an FQDN, so a . is needed
		if
		(substr_count($url_search, ".") >= 1)
		{
			// Ok, it is a FQDN. Now, is it of a IANA-valid TLD?
			// Try to parse it
			$url_parts = parse_url($url_search);
			// Get host part
			$host = $url_parts['host'];
			// Split it
			$host_parts = explode(".", $host);
			// Get last part
			end($host_parts);
			$last = key($host_parts);  
			// Which is the TLD
			$tld = $host_parts[$last];
			
			// Is this TLD one of the official ones?
			if(dr_searchstring($domainfile, $tld))
			{
				$return = $url_search;
			}
		}
	}
	
	return $return;
}


function dr_getaccesslevel($user_info)
{
	global $db;
	
	$accessstmt = $db->prepare
	("
		SELECT *
		FROM user_user
		INNER JOIN user_accesslevel ON user_user.fk_user_accesslevel = user_accesslevel.id_user_accesslevel
		WHERE user_user.id_user_user = :id
	");
	$accessstmt->bindValue(':id', $user_info['id_user_user'], PDO::PARAM_STR);
	$accessstmt->execute();
	$accessresult = $accessstmt->fetchAll(PDO::FETCH_ASSOC);
	$accessresult = $accessresult[0];
	
	return $accessresult['level'];
}

function dr_getaccesslevelname($user_info)
{
	global $db;
	
	$accessstmt = $db->prepare
	("
		SELECT *
		FROM user_user
		INNER JOIN user_accesslevel ON user_user.fk_user_accesslevel = user_accesslevel.id_user_accesslevel
		WHERE user_user.id_user_user = :id
	");
	$accessstmt->bindValue(':id', $user_info['id_user_user'], PDO::PARAM_STR);
	$accessstmt->execute();
	$accessresult = $accessstmt->fetchAll(PDO::FETCH_ASSOC);
	$accessresult = $accessresult[0];
	
	
	return "{$accessresult['access_level']}";
	
}

function dr_getaccesslevelid($access_level)
{
	global $db;
	
	$accessstmt = $db->prepare
	("
		SELECT *
		FROM user_accesslevel
		WHERE level = :level
	");
	$accessstmt->bindValue(':level', $access_level, PDO::PARAM_STR);
	$accessstmt->execute();
	$accessresult = $accessstmt->fetchAll(PDO::FETCH_ASSOC);
	$accessresult = $accessresult[0];
	
	return "{$accessresult['id_user_accesslevel']}";
	
}

function dr_getcharname($character)
{
	$return = false;
	$chars=array
	(
		" "=>"Leerzeichen",
		"\r\n"=>"Neue Zeile",
		"\t"=>"Tabstopp",
	);
		
	$return = $chars[$character];
	
	if(empty($return))
	{
		$return = $character;
	}
	
	return $return;
}

function dr_getgravatar($email, $size = 80)
{
	$default = "identicon";
	$grav_url = "//www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
	
	echo "<img class='img' src=$grav_url; alt='Gravatar' />";
}



function dr_getip($ip)
{
	$return = false;
	
	// Is it an IP?
	if(dr_isip($ip))
	{
		$return = $ip;
	}
	else
	{
		// Is it an URL?
		if($url = dr_isurl($ip))
		{
			// Ok, parse it, get the IP by the hostname
			$url_parse = parse_url($url);
			$url_host = $url_parse['host'];
			$ipcheck = gethostbyname($url_host);
		}
		
		// Check if what we assumed could be an IP, is indeed one
		if(dr_isip($ipcheck))
		{
			$return = $ipcheck;
		}
	}
	
	return $return;
}

function dr_getporttype($port)
{
	// Get type of port
	if($port <= 1023)
	{
		$type = "Well Known";
	}
	else if($port <= 49151)
	{
		$type = "Registered";
	}
	else
	{
		$type = "Dynamic";
	}
	
	return $type;
}

function dr_getrfclink($rfc)
{
	return "<a href='https://tools.ietf.org/html/rfc{$rfc}' target='rfc'>[RFC{$rfc}]";
}

function dr_makethumbnail($path,$caption,$group = "",$width)
{
	if($group == "")
	{
		$group = rand();
	}
	
	$url = urlencode($path);
	echo "<a href=\"$path\" data-lightbox='$group' title=\"$caption\">";
		echo "<img src=\"/inc/lib/thumb/phpThumb.php?src=$url&w=$width\" class='img-rounded img-center' alt=\"$caption\">";
	echo "</a>";
}

function dr_print_input($label, $placeholder, $help, $id, $type, $input = "", $autofocus="", $required="")
{
	echo "<div class='form-group'>";
		echo "<label for='$id' class='control-label'>$label</label>";
		echo "<input name='$id' id='$id' class='form-control' type='$type' placeholder='$placeholder' $required value='$input' $autofocus>";
		echo "<p class='help-block'>$help</p>";
	echo "</div>";
}

function dr_print_navheading($heading)
{
	 echo "<li class='dropdown-header'>$heading</li>";
		echo "<li class='divider'></li>";
}

function dr_print_notfound($additional_info = "", $hidden = "")
{
	echo "<div class='alert alert-danger' $hidden>";
		echo "<strong>Achtung!</strong> Leider kein Eintrag gefunden. $additional_info<br>";
	echo "</div>";
}

function dr_print_notpermitted($additional_info = "", $hidden = "")
{
	echo "<div class='alert alert-danger' $hidden>";
		echo "<strong>Achtung!</strong> Sorry, du darfst diese Seite nicht besuchen. $additional_info<br>";
	echo "</div>";
}

function dr_print_notvalid($additional_info = "", $hidden = "")
{
	echo "<div class='alert alert-warning' id='alert-data' $hidden>";
		echo "<strong>Achtung!</strong> Irgendwas stimmt mit der Eingabe nicht, überprüf das noch mal. $additional_info<br>";
	echo "</div>";
}

function dr_print_success($text_before, $text_after, $id_result, $id_container, $text_result = "", $hidden = true)
{
	if($hidden)
	{
		$hidden = "hidden";
	}
	else
	{
		$hidden = "";
	}
	echo "<div class='alert alert-success' id='{$id_container}' $hidden>";
		echo "$text_before <strong><span id='{$id_result}'>$text_result</span></strong> $text_after";
	echo "</div>";
}
function dr_print_underconstruction()
{
	echo "<div class='jumbotron'>";
		echo "<h1>Under construction</h1>";
		echo "<p>Ich verzichte auf ein hässliches GIF einer Baustellentafel, ich denke jeder weiss was gemeint ist ;)</p>";
	echo "</div>";
}

function dr_redirect($target = "/", $timeout = 1000)
{
	echo "<script type='text/javascript'>window.setTimeout(function(){window.location.href = '$target'},$timeout)</script>";
    echo "<p>Wenn du nicht automatisch weitergeleitet wirst, klicke <a href='$target'>hier</a>.</p>";
}

function dr_searchstring($file, $string, $delimiter = "")
{
	$return = false;
	// Read the file
	$contents = file_get_contents($file);
	// Escape query
	$pattern = preg_quote($string, '/');
	// Finalize pattern, multiple lines, case-independent
	if($delimiter == ",")
	{
		$pattern = "/^.*\,$pattern\,.*\$/mi";
	}
	else
	{
		$pattern = "/^.*$pattern.*\$/mi";
	}

	// Ok, we're set, now search
	if(preg_match_all($pattern, $contents, $matches))
	{
		$return = $matches;
	}

	return $return;
}

function dr_showlastmodified($file, $description)
{
	// Read last modify date of database
	$lastmodified = filemtime($file);
	// Get date
	$lastmodifieddate = date("d.m.Y",$lastmodified);
	echo "<p>Letztes Update (seitens $description-Datenbasis): $lastmodifieddate</p>";
}

// 3rd party

// http://www.phpf1.com/tutorial/generate-random-string.html
function third_getRandomString($length)
{

	$validCharacters = "abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ01234567890";
	$validCharNumber = strlen($validCharacters);

	$result = "";

	for ($i = 0; $i < $length; $i++)
	{
		$index = mt_rand(0, $validCharNumber - 1);
		$result .= $validCharacters[$index];
	}

	return $result;
}
?>