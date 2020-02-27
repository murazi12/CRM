<?php
$fn = (empty($_REQUEST["fn"])) ? "error" : base64_decode($_REQUEST["fn"]);
$id = (empty($_REQUEST["id"])) ? 0 : base64_decode($_REQUEST["id"]);

echo $fn($id);

function masuk($id){
	include("config/DBcon.php");
	$res = array();
	
	$json = json_decode($_POST["postData"],1);
	$uid = $json["uid"];
	$pas = $json["pas"];
	$agt = $json["agt"]; // User agent (browser / mobile)
	$ops = $json["ops"]; // Operating System
	$ips = $json["ips"]; // IP Address
	
	$ldapCon = @ldap_connect("172.25.206.8", "389");
	@ldap_set_option($ldapCon, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
	@ldap_set_option($ldapCon, LDAP_OPT_REFERRALS, 0); // We need this for doing an LDAP search.

	$ldapTree = "cn=".$uid.",ou=users,o=asyst";
	$ldapBind = @ldap_bind($ldapCon,$ldapTree,$pas);
	if($ldapBind){
		$ldapBaseDn = "ou=users,o=asyst";
		$ldapFilter = "(&(objectClass=user)(cn=".$uid."))";
		$ldapAttr = array("fullName","mail","uid","givenName");
		$ldapSearch = ldap_search($ldapCon,$ldapBaseDn,$ldapFilter,$ldapAttr);
		$ldapData = ldap_get_entries($ldapCon,$ldapSearch);

		$uidLdap = $ldapData[0]["uid"][0];
		$ufnLdap = $ldapData[0]["fullname"][0];
		$umlLdap = $ldapData[0]["mail"] [0];
		
		$sql = "SELECT * FROM tbl_user WHERE USUSNM = '".$uidLdap."'";
		$exc = mysqli_query($con,$sql);
		if($exc){
			$num = mysqli_num_rows($exc);
			if($num < 1){
				$sql = "INSERT INTO tbl_user (USUSNM, USPASS, USMAIL, USFLNM, USACTV, USREMK, USADON, USADBY) ";
				$sql .= "VALUES ('".$uidLdap."', '".password_hash($pas,PASSWORD_DEFAULT)."', '".$umlLdap."', '".$ufnLdap."', '1', '', NOW(), 'system')";
				$exc = mysqli_query($con,$sql);
				if($exc){
					$sql = "SELECT * FROM tbl_user WHERE USUSNM = '".$uidLdap."' AND USACTV = '1'";
					$exc = mysqli_query($con,$sql);
					if($exc){
						$dta = mysqli_fetch_array($exc);
						if(tulisHist($dta["USUSERIY"],$ops,$agt,$ips) == TRUE){
							$res["sts"] = "success";
							$res["msg"] = "Success Login, user data has been recorded !";
							$res["data"]["uiy"] = $dta["USUSERIY"];
							$res["data"]["uid"] = $uidLdap;
							$res["data"]["nme"] = $ufnLdap;
							$res["data"]["eml"] = $umlLdap;
						}
						else{
							$res["sts"] = "error";
							$res["msg"] = "Failed Login, Can`t write history !";
						}
					}
				}
				else{
					$res["sts"] = "error";
					$res["msg"] = "Failed Login, ".mysqli_error($con);
				}
			}
			else{
				$dta = mysqli_fetch_array($exc);

				$sqlU = "UPDATE tbl_user SET USPASS = '".password_hash($pas,PASSWORD_DEFAULT)."', USCHON = NOW(), USCHBY = 'system' ";
				$sqlU .= "WHERE USUSERIY = '".$dta["USUSERIY"]."'";
				$excU = mysqli_query($con,$sqlU);
				if($excU){
					if(tulisHist($dta["USUSERIY"],$ops,$agt,$ips) == TRUE){
						$res["sts"] = "success";
						$res["msg"] = "Success Login, user data has been updated !";
						$res["data"]["uiy"] = $dta["USUSERIY"];
						$res["data"]["uid"] = $dta["USUSNM"];
						$res["data"]["nme"] = $dta["USFLNM"];
						$res["data"]["eml"] = $dta["USMAIL"];
					}
					else{
						$res["sts"] = "error";
						$res["msg"] = "Failed Login, Can`t write history !";						
					}
				}
				else{
					$res["sts"] = "error";
					$res["msg"] = "Failed Login, ".mysqli_error($con);
				}
			}
		}
		else{
			$res["sts"] = "error";
			$res["msg"] = "Failed Login, ".mysqli_error($con);
		}
	}
	else{
		if($uid == "admin" || @ldap_errno($ldapCon) == -1){
			$sql = "SELECT * FROM tbl_user WHERE USUSNM = '".$uid."' AND USACTV = '1' LIMIT 1";
			$exc = mysqli_query($con,$sql);
			if($exc){
				$num = mysqli_num_rows($exc);
				if($num > 0){
					$dta = mysqli_fetch_array($exc);
					if(password_verify($pas,$dta["USPASS"])){
						$sqlU = "UPDATE tbl_user SET USPASS = '".password_hash($pas,PASSWORD_DEFAULT)."', USCHON = NOW(), USCHBY = 'system' ";
						$sqlU .= "WHERE USUSERIY = '".$dta["USUSERIY"]."'";
						$excU = mysqli_query($con,$sqlU);
						if($excU){
							if(tulisHist($dta["USUSERIY"],$ops,$agt,$ips) == TRUE){
								$res["sts"] = "success";
								$res["msg"] = "Success Login, user data has been updated !";
								$res["data"]["uiy"] = $dta["USUSERIY"];
								$res["data"]["uid"] = $dta["USUSNM"];
								$res["data"]["nme"] = $dta["USFLNM"];
								$res["data"]["eml"] = $dta["USMAIL"];
							}
							else{
								$res["sts"] = "error";
								$res["msg"] = "Failed Login, Can`t write history !";
							}
						}
						else{
							$res["sts"] = "error";
							$res["msg"] = "Failed Login, ".mysqli_error($con);
						}
					}
					else{
						$res["sts"] = "error";
						$res["msg"] = "Failed Login, Invalid password";
					}	
				}
				else{
					$res["sts"] = "error";
					$res["msg"] = "Failed Login, User Not Found";
				}
			}
			else{
				$res["sts"] = "error";
				$res["msg"] = "Failed Login, ".mysqli_error($con);
			}
		}
		else{
			$res["sts"] = "error";
			$res["msg"] = "Failed Login, ".@ldap_error($ldapCon);
		}
	}
	return json_encode($res);
}

function tulisHist($uid,$ops,$agt,$ips){
	include("config/DBcon.php");
	
	$res = TRUE;
	
	$sql = "INSERT INTO tbl_user_log (ULUSERIY, ULDATE, ULOPSY, ULAGNT, ULIPAD) ";
	$sql .= "VALUES ('".$uid."', NOW(), '".$ops."', '".$agt."', '".$ips."')";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$res = TRUE;
	}
	else{
		$res = FALSE;
	}
	return $res;
}
?>