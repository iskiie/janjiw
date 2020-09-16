<?php

$headers = array();
$headers[] = 'Content-Type: application/json; charset=utf-8';
$headers[] = 'User-Agent: okhttp/3.12.1';
$headers[] = 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjhjODFlM2I2MGUzNjkxNDgzMzc2NGFkZmQ3Njk5MGRhOGNlN2ZkNTdiNDk0ZTYyYjQzN2IwNmZiOTgwMzRkMGVlODFlOWQ4N2JhMjQyNzEzIn0.eyJhdWQiOiIxIiwianRpIjoiOGM4MWUzYjYwZTM2OTE0ODMzNzY0YWRmZDc2OTkwZGE4Y2U3ZmQ1N2I0OTRlNjJiNDM3YjA2ZmI5ODAzNGQwZWU4MWU5ZDg3YmEyNDI3MTMiLCJpYXQiOjE2MDAyMzU1NjQsIm5iZiI6MTYwMDIzNTU2NCwiZXhwIjoyODk2MjM1NTYzLCJzdWIiOiIiLCJzY29wZXMiOlsiYXBwcyJdfQ.LG-jNO64pYEQrnh57AcvTfQYmZ7E7tf-9NYVUYOJtQIWFV0s6jivhuR6i5QHZL40nxLo52Iplx24mgDhdWNhSn9v5YAujMHidPAuiXZo9MUQml9EhpfqzH8vVthd3FfouELmo4NgnSiNLOwhS9PyRV6S29soOpW_hIelFZxEU6sWelRZRBaN2P7aYtU9mqi0sfL6vVNAxaXhQgS52MLYWUxAm5U6IjLC2GCt_7ep-hwl-Ml0vzOfjPdof_caylT6IH2qDAWdaPXIqadZcOrthqguCS4LqKD5wjcgUK2C9XivC5PPGNQEiLd_lK5vxSAk03GFl65p_RJXdPGgf6htdzitZ7Q9cXHpQZrv_Bgf1xHOIkJq9npU1guwpMRsYAWNLFDjwUk0fokjyJH3bRf_7ASDS1sp8aCjWtdn2r7-yCKoEGC_NmLQvjaNlB_gnkkcQck2FeJLURAaDjVJAVEFjbz0AwH6KSKlmgfo68K3bpthBjykZiCTov89cW-jnZIdlD4THyIphdaWLiVX9hwR6ZqOI3rmCLasTnZ5nqlTXkhPD4YB-LfaTBROvXLHe2cl6WIj9QXA5n4OsHXszp1RYkOf98bJXhO76LusHv_viOQum7M2PIxf-IJqZHKJNPFb8QZ55v5LVqrkZMndyZGX_iH2GJSL-sucsRKR_p5_a6g';

$nope = '0812'.random(8,0);
$dev = random(16,1);
$na = explode(" ", nama());

echo "[+] Janji Jiwa Account Creator - By: GidhanB.A\n";
echo "[+] Nomer HP: $nope\n";
echo "[+] PIN: 121212\n";

$cek = curl('https://api.jiwa.app/api/users/phone/check', '{"device_id":"'.$dev.'","phone":"'.$nope.'"}', $headers);
if (strpos($cek[1], 'Anda akan mendaftar')) {
	$cret = curl('https://api.jiwa.app/api/users/pin/create', '{"phone":"'.$nope.'"}', $headers);
	if (strpos($cret[1], '"status":"success"')) {
		$pin = substr(json_decode($cret[1])->result->pin, 4);
		$pin = substr($pin, 0, -3);
		$ver = curl('https://api.jiwa.app/api/users/pin/verify', '{"phone":"'.$nope.'","pin":"'.$pin.'","device_id":"'.$dev.'"}', $headers);
		if (strpos($ver[1], '"status":"success"')) {
			$chg = curl('https://api.jiwa.app/api/users/pin/change', '{"phone":"'.$nope.'","pin_new":"121212","pin_old":"'.$pin.'"}', $headers);
			if (strpos($chg[1], '"status":"success"')) {
				Token:
				$tkn = curl('https://api.jiwa.app/oauth/token', '{"client_id":2,"client_secret":"DhS2WkfjVV8sdRJOhJra84qFauISRSeMsV0G4fkV","grant_type":"password","password":"121212","scope":"apps","username":"'.$nope.'"}', $headers);
				if (strpos($tkn[1], '"access_token"')) {
					$cfg = curl('https://api.jiwa.app/api/users/profile/update', '{"address":"","birthday":"","celebrate":"","email":"'.strtolower(trim($na[0])).mt_rand(10,99).'@v7ecub.com","gender":"","id_city":"","job":"","name":"'.trim($na[0]).'","phone":"'.$nope.'","pin":"'.$pin.'"}', $headers);
					if (strpos($cfg[1], '"status":"success"')) {
						$token = json_decode($tkn[1])->access_token;
						array_pop($headers);
						$headers[] = 'Authorization: Bearer '.$token;
						$gas = curl('https://api.jiwa.app/api/home/membership', '{"device_token":"c7lBDLiAT_uACerrBiBT65:APA91bE7OguwPwspE4TwK_z6fVv_4sNxWD9X_b4jBa1-wRN_PunIVCQIyoFpSdoHWzaMzCauXLk4Qp7ZqbnHiAWn7zP7BRs1zHRHIyZWlBBFdrEvztp0ZGqvG4ZL'.random(16,1).'","device_id":"'.$dev.'","device_type":"Android"}', $headers);
						if (strpos($gas[1], '"status":"success"')) {
							echo "[+] Registration Successfuly!\n";		
						} else {
							die($gas[1]);
						}
					} else {
						die($cfg[1]);
					}
				} elseif (empty($tkn[1])) {
					echo "[+] Error, tryagain\n";
					goto Token;
				} else {
					die($tkn[1]);
				}
			} else {
				die($chg[1]);
			}
		} else {
			die($ver[1]);
		}
	} else {
		die($cret[1]);
	}
} else {
	die($cek[1]);
}

function nama()
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://ninjaname.horseridersupply.com/indonesian_name.php");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$ex = curl_exec($ch);
		preg_match_all('~(&bull; (.*?)<br/>&bull; )~', $ex, $name);
		return $name[2][mt_rand(0, 14) ];
	}

function curl($url,$post,$headers,$follow=false,$method=null)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		if ($follow == true) curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		if ($method !== null) curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		if ($headers !== null) curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		if ($post !== null) curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$result = curl_exec($ch);
		$header = substr($result, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
		$body = substr($result, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
		preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
		$cookies = array();
		foreach($matches[1] as $item) {
		  parse_str($item, $cookie);
		  $cookies = array_merge($cookies, $cookie);
		}
		return array (
		$header,
		$body,
		$cookies
		);
	}

function get_between($string, $start, $end) 
    {
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
    }

function random($length,$a) 
	{
		$str = "";
		if ($a == 0) {
			$characters = array_merge(range('0','9'));
		}elseif ($a == 1) {
			$characters = array_merge(range('0','9'),range('a','z'));
		}
		$max = count($characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $characters[$rand];
		}
		return $str;
	}