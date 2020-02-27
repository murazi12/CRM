<?php
$fn = (empty($_REQUEST["fn"])) ? "error" : base64_decode($_REQUEST["fn"]);
$id = (empty($_REQUEST["id"])) ? 0 : base64_decode($_REQUEST["id"]);

if($id == 0){
	error();
}
else{
	echo $fn($id);
}

function getMenu($id){	// Fungsi ini dipanggil untuk menampilkan list menu di sidebar
	include("config/DBcon.php");
	$ret_value = array();
	
	$sql = "SELECT * FROM tbl_access WHERE ACUSERIY = '".$id."' AND ACACTV = '1'";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$num = mysqli_num_rows($exc);
		if($num > 0){
			$res["sts"] = "success";
			$res["msg"] = "Success fetch data";
			
			$sqlP = "SELECT * FROM tbl_access LEFT JOIN tbl_menu ON MEMENUIY = ACMENUIY WHERE ACUSERIY = '".$id."' AND METYPE = 'parent' AND MEACTV = '1' ";
			$sqlP .= "AND ACACTV = '1' ORDER BY MESORT";
			$excP = mysqli_query($con,$sqlP);
			if($excP){
				$i = 0;
				while($dtaP = mysqli_fetch_array($excP)){
					$dat["menu"]["pMenuId"] = $dtaP["MEMENUIY"];
					$dat["menu"]["pMenuCode"] = $dtaP["MECODE"];
					$dat["menu"]["pMenuName"] = $dtaP["MENAME"];
					$dat["menu"]["pMenuLink"] = $dtaP["MELINK"];
					$res["menu"][$i][] = $dat["menu"];
					
					$sqlS = "SELECT * FROM tbl_access LEFT JOIN tbl_menu ON MEMENUIY = ACMENUIY WHERE ACUSERIY = '".$id."' AND METYPE = 'child' ";
					$sqlS .= "AND MEMNPRIY = '".$dtaP["MEMENUIY"]."' AND MEACTV = '1' AND ACACTV = '1' ORDER BY MESORT";
					$excS = mysqli_query($con,$sqlS);
					if($excS){
						while($dtaS = mysqli_fetch_array($excS)){
							$dat["submenu"]["sMenuId"] = $dtaS["MEMENUIY"];
							$dat["submenu"]["sMenuCode"] = $dtaS["MECODE"];
							$dat["submenu"]["sMenuPrId"] = $dtaS["MEMNPRIY"];
							$dat["submenu"]["sMenuName"] = $dtaS["MENAME"];
							$dat["submenu"]["sMenuLink"] = $dtaS["MELINK"];
							$res["menu"][$i]["child"][] = $dat["submenu"];
						}
					}
					else{
						$res["sts"] = "error";
						$res["msg"] = "Can`t fetch data ".mysqli_error($con);
					}
					$i++;
				}
			}
			else{
				$res["sts"] = "error";
				$res["msg"] = "Can`t fetch data ".mysqli_error($con);
			}
		}
		else{
			$res["sts"] = "error";
			$res["msg"] = "Authentication Required !";
		}
	}
	else{
		$res["sts"] = "error";
		$res["msg"] = "Can`t fetch data ".mysqli_error($con);
	}
	return json_encode($res);
}

function getAkses($id){
	include("config/DBcon.php");
	
	$sql = "SELECT * FROM tbl_access WHERE ACUSERIY = '".$id."' AND ACMENUIY = (SELECT MEMENUIY FROM tbl_menu WHERE MELINK = '".base64_decode($_REQUEST["mi"])."') AND ACACTV = '1' LIMIT 1";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$num = mysqli_num_rows($exc);
		if($num > 0){
			$dat = mysqli_fetch_array($exc);
			
			$res["sts"] = "success";
			$res["msg"] = "Success fetch data !";
			$res["data"]["ACAADD"] = $dat["ACAADD"];
			$res["data"]["ACAEDT"] = $dat["ACAEDT"];
			$res["data"]["ACADLT"] = $dat["ACADLT"];
			$res["data"]["ACAVIW"] = $dat["ACAVIW"];
		}
		else{
			$res["sts"] = "error";
			$res["msg"] = "No Access Available";
		}
	}
	else{
		$res["sts"] = "error";
		$res["msg"] = "Error fetch data ".mysqli_error($con);
	}
	
	return json_encode($res);
}

function getUserAksesList($id){
	include("config/DBcon.php");
	
	$sql = "SELECT * FROM tbl_access ";
	$sql .= "LEFT JOIN tbl_menu ON MEMENUIY = ACMENUIY ";
	$sql .= "WHERE MEMNPRIY = '0' AND ACUSERIY = '".base64_decode($_REQUEST["mi"])."' AND ACACTV = '1' ORDER BY MESORT";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$num = mysqli_num_rows($exc);
		if($num > 0){
			$res["sts"] = "success";
			$res["msg"] = "Success fetch data !";
			
			while($dta = mysqli_fetch_array($exc)){
				$dat["data"]["menu"]["pMEMENUIY"] = $dta["MEMENUIY"];
				$dat["data"]["menu"]["pMENAME"] = $dta["MENAME"];
				
				$sqlC = "SELECT * FROM tbl_menu ";
				$sqlC .= "LEFT JOIN tbl_access ON ACMENUIY = MEMENUIY ";
				$sqlC .= "WHERE MEMNPRIY = '".$dta["MEMENUIY"]."' AND ACUSERIY = '".base64_decode($_REQUEST["mi"])."' AND ACACTV = '1' ORDER BY MESORT";
				$excC = mysqli_query($con,$sqlC);
				if($excC){
					$i=0;
					while($dtaC = mysqli_fetch_array($excC)){
						$sub["data"]["sMEMENUIY"] = $dtaC["MEMENUIY"];
						$sub["data"]["sACACCSIY"] = $dtaC["ACACCSIY"];
						$sub["data"]["sMENAME"] = $dtaC["MENAME"];
						$sub["data"]["sACAADD"] = $dtaC["ACAADD"];
						$sub["data"]["sACAEDT"] = $dtaC["ACAEDT"];
						$sub["data"]["sACAVIW"] = $dtaC["ACAVIW"];
						$sub["data"]["sACADLT"] = $dtaC["ACADLT"];
						$dat["data"]["menu"]["submenu"][] = $sub["data"];
					}
					$i++;
				}
				else{
					$res["sts"] = "error";
					$res["msg"] = "Can`t fetch data ! ".mysqli_error($con);
				}
				$res["data"][] = $dat["data"];
				$dat["data"]["menu"]["submenu"] = array();
			}
		}
		else{
			$res["sts"] = "error";
			$res["msg"] = "No Data Found. . .";
		}
	}
	else{
		$res["sts"] = "error";
		$res["msg"] = "Can`t fetch data ! ".mysqli_error($con);
	}
	
	return json_encode($res);
}

function getUserAkses($id){
	include("config/DBcon.php");
	
	$sql = "SELECT * FROM tbl_access ";
	$sql .= "LEFT JOIN tbl_menu ON MEMENUIY = ACMENUIY ";
	$sql .= "WHERE ACACCSIY = '".base64_decode($_REQUEST["mi"])."'";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$dta = mysqli_fetch_array($exc);
		
		$res["sts"] = "success";
		$res["msg"] = "Success fetch data !";
		$res["data"]["MEMENUIY"] = $dta["MEMENUIY"];
		$res["data"]["ACACCSIY"] = $dta["ACACCSIY"];
		$res["data"]["MENAME"] = $dta["MENAME"];
		$res["data"]["ACAADD"] = $dta["ACAADD"];
		$res["data"]["ACAEDT"] = $dta["ACAEDT"];
		$res["data"]["ACADLT"] = $dta["ACADLT"];
		$res["data"]["ACAVIW"] = $dta["ACAVIW"];
	}
	else{
		$res["sts"] = "error";
		$res["msg"] = "Can`t fetch data ! ".mysqli_error($con);
	}
	
	return json_encode($res);
}

function updateUserAkses($id){
	include("config/DBcon.php");
	
	$uid = getUID($id);
	$mod = base64_decode($_REQUEST["md"]);
	
	if($mod == "delete"){
		$json = json_decode($_POST["postData"],1);
		$accsId = $json["id"];
		
		$sql = "SELECT MEMENUIY, MEMNPRIY FROM tbl_menu WHERE MEMNPRIY = ";
		$sql.= "(SELECT MEMNPRIY FROM tbl_access LEFT JOIN tbl_menu ON MEMENUIY = ACMENUIY WHERE ACACCSIY = '".$accsId."')";
		$exc = mysqli_query($con,$sql);
		while($dta = mysqli_fetch_array($exc)){
			$menuPrnt = $dta["MEMNPRIY"];
			$dat["MEMENUIY"][] = $dta["MEMENUIY"];
		}
		$dat["MEMENUIY"][] = $menuPrnt;
		
		$sql = "SELECT * FROM tbl_access WHERE ACACTV = '1' AND ACMENUIY IN (".implode(',', array_map('intval', $dat["MEMENUIY"])).")";
		$exc = mysqli_query($con,$sql);
		$num = mysqli_num_rows($exc);
		if($num <= 2){
			$sql = "UPDATE tbl_access SET ACACTV = '0', ACCHON = NOW(), ACCHBY = '".$uid."' WHERE ACMENUIY = '".$menuPrnt."'";
			$exc = mysqli_query($con,$sql);
			if(!$exc){
				$res["sts"] = "error";
				$res["msg"] = mysqli_error($con);
			}
		}
		
		$sql = "UPDATE tbl_access SET ACACTV = '0', ACCHON = NOW(), ACCHBY = '".$uid."' ";
		$sql .= "WHERE ACACCSIY = '".$accsId."'";
		$exc = mysqli_query($con,$sql);
		if($exc){
			$res["sts"] = "success";
			$res["msg"] = "Delete Data Success !";
		}
		else{
			$res["sts"] = "error";
			$res["msg"] = "Delete Data Failed ! ".mysqli_error($con);
		}		
	}
	else{
		$json = json_decode($_POST["postData"],1);
		$accsId = $json["id"];
		$menuId = $json["mId"];
		$userId = $json["uId"];
		$accsAdd = $json["vAdd"];
		$accsEdt = $json["vEdt"];
		$accsViw = $json["vViw"];
		$accsDlt = $json["vDlt"];
		
		if($mod == "update"){
			$sql = "UPDATE tbl_access SET ACAADD = '".$accsAdd."', ACAEDT = '".$accsEdt."', ACAVIW = '".$accsViw."', ACADLT = '".$accsDlt."', ";
			$sql .= "ACCHON = NOW(), ACCHBY = '".$uid."' ";
			$sql .= "WHERE ACACCSIY = '".$accsId."'";
			$exc = mysqli_query($con,$sql);
			if($exc){
				$res["sts"] = "success";
				$res["msg"] = "Edit Data Success !";
			}
			else{
				$res["sts"] = "error";
				$res["msg"] = "Edit Data Failed ! ".mysqli_error($con);
			}
		}
		else{
			$sql = "SELECT * FROM tbl_access WHERE ACMENUIY = '".$menuId."' AND ACUSERIY = '".base64_decode($userId)."' LIMIT 1";
			$exc = mysqli_query($con,$sql);
			$num = mysqli_num_rows($exc);
			if($num > 0){
				$dta = mysqli_fetch_array($exc);
				
				$sql = "UPDATE tbl_access SET ACACTV = '1', ACAADD = '".$accsAdd."', ACAEDT = '".$accsEdt."', ACAVIW = '".$accsViw."', ";
				$sql.= "ACADLT = '".$accsDlt."', ACCHON = NOW(), ACCHBY = '".$uid."' WHERE ACACCSIY = '".$dta["ACACCSIY"]."'";
				$exc = mysqli_query($con,$sql);
				if($exc){
					$sql = "UPDATE tbl_access SET ACACTV = '1', ACCHON = NOW(), ACCHBY = '".$uid."' ";
					$sql.= "WHERE ACACCSIY = (SELECT ACACCSIY FROM tbl_access WHERE ACMENUIY = ";
					$sql.= "(SELECT MEMNPRIY FROM tbl_menu WHERE MEMENUIY = '".$dta["ACMENUIY"]."') AND ACUSERIY = '".base64_decode($userId)."')";
					$exc = mysqli_query($con,$sql);
					if($exc){
						$res["sts"] = "success";
						$res["msg"] = "Add data success !";
					}
					else{
						$res["sts"] = "error";
						$res["msg"] = $sql;
					}
				}
				else{
					$res["sts"] = "error";
					$res["msg"] = mysqli_error($con);
				}
			}
			else{
				$sql = "SELECT * FROM tbl_menu WHERE MEMENUIY = '".$menuId."' LIMIT 1";
				$exc = mysqli_query($con,$sql);
				if($exc){
					$dta = mysqli_fetch_array($exc);
					
					$sql = "SELECT ACMENUIY FROM tbl_access WHERE ACMENUIY = '".$dta["MEMNPRIY"]."' AND ACUSERIY = '".base64_decode($userId)."'";
					$exc = mysqli_query($con,$sql);
					if($exc){
						$num = mysqli_num_rows($exc);
						if($num < 1){
							$sql = "INSERT INTO tbl_access (ACMENUIY, ACUSERIY, ACAADD, ACAEDT, ACAVIW, ACADLT, ACREMK, ACACTV, ACADON, ACADBY) VALUES ";
							$sql.= "('".$dta["MEMNPRIY"]."', '".base64_decode($userId)."', NULL, NULL, NULL, NULL, '', '1', NOW(), '".$uid."'), ";
							$sql.= "('".$menuId."', '".base64_decode($userId)."', '".$accsAdd."', '".$accsEdt."', '".$accsViw."', '".$accsDlt."', '', '1', NOW(), '".$uid."')";
						}
						else{
							$sql = "INSERT INTO tbl_access (ACMENUIY, ACUSERIY, ACAADD, ACAEDT, ACAVIW, ACADLT, ACREMK, ACACTV, ACADON, ACADBY) VALUES ";
							$sql.= "('".$menuId."', '".base64_decode($userId)."', '".$accsAdd."', '".$accsEdt."', '".$accsViw."', '".$accsDlt."', '', '1', NOW(), '".$uid."')";
						}
						$exc = mysqli_query($con,$sql);
						if($exc){
							$res["sts"] = "success";
							$res["msg"] = "Add data success !";
						}
						else{
							$res["sts"] = "error";
							$res["msg"] = "Error add data ! ".mysqli_error($con);
						}
					}
					else{
						$res["sts"] = "error";
						$res["msg"] = "Error add data ! ".mysqli_error($con);
					}
				}
				else{
					$res["sts"] = "error";
					$res["msg"] = "Error add data ! ".mysqli_error($con);
				}
			}
		}
	}
	
	return json_encode($res);
}

function getMenuDropDown($id){
	include("config/DBcon.php");
	
	$uid = getUID($id);
	$sql = "SELECT * FROM tbl_menu WHERE MEACTV = '1' AND METYPE = 'child' ";
	$sql .= "AND MEMENUIY NOT IN (SELECT ACMENUIY FROM tbl_access WHERE ACUSERIY = '".base64_decode($_REQUEST["mi"])."' AND ACACTV = '1')";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$num = mysqli_num_rows($exc);
		if($num > 0){
			$res["sts"] = "success";
			$res["msg"] = "Success fetch data !";
			
			while($dta = mysqli_fetch_array($exc)){
				$dat["data"]["MEMENUIY"] = $dta["MEMENUIY"];
				$dat["data"]["MENAME"] = $dta["MENAME"];
				$res["data"][] = $dat["data"];
			}
		}
		else{
			$res["sts"] = "error";
			$res["msg"] = "No Data Found. . .";
		}
	}
	else{
		$res["sts"] = "error";
		$res["mgs"] = "Error fetch data ! ".mysqli_error($con);
	}
	
	return json_encode($res);
}

function getMenuList($id){
	include("config/DBcon.php");
	
	$sql = "SELECT * FROM tbl_menu WHERE MEACTV = '1' AND METYPE = 'parent' ORDER BY MESORT";
	$exc = mysqli_query($con,$sql);
	if($exc){
		while($dta = mysqli_fetch_array($exc)){
			$res["sts"] = "success";
			$res["msg"] = "Success fetch data !";
			
			$dat["data"]["MEMENUIY"] = $dta["MEMENUIY"];
			$dat["data"]["MECODE"] = $dta["MECODE"];
			$dat["data"]["MENAME"] = $dta["MENAME"];
			
			$sqlS = "SELECT * FROM tbl_menu WHERE MEACTV = '1' AND METYPE = 'child' AND MEMNPRIY = '".$dta["MEMENUIY"]."' ORDER BY MESORT";
			$excS = mysqli_query($con,$sqlS);
			if($excS){
				$dat["data"]["submenu"] = array();
				while($dtaS = mysqli_fetch_array($excS)){
					$dat["submenu"]["sMEMENUIY"] = $dtaS["MEMENUIY"];
					$dat["submenu"]["sMECODE"] = $dtaS["MECODE"];
					$dat["submenu"]["sMENAME"] = $dtaS["MENAME"];
					$dat["submenu"]["sMELINK"] = $dtaS["MELINK"];
					$dat["submenu"]["sMESORT"] = $dtaS["MESORT"];
					$dat["submenu"]["sMEREMK"] = $dtaS["MEREMK"];
					$dat["data"]["submenu"][] = $dat["submenu"];
				}
			}
			else{
				$res["sts"] = "error";
				$res["mgs"] = "Error fetch data ! ".mysqli_error($con);				
			}
			$res["data"][] = $dat["data"];
		}
	}
	else{
		$res["sts"] = "error";
		$res["mgs"] = "Error fetch data ! ".mysqli_error($con);
	}

	return json_encode($res);
}

function getMenuDetail($id){
	include("config/DBcon.php");
	
	$sql = "SELECT * FROM tbl_menu WHERE MEMENUIY = '".base64_decode($_REQUEST["mi"])."'";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$num = mysqli_num_rows($exc);
		if($num < 1){
			$res["sts"] = "error";
			$res["msg"] = "No Data Found !";
		}
		else{
			$res["sts"] = "success";
			$res["msg"] = "Success fetch data !";
			while($dta = mysqli_fetch_array($exc)){
				$res["data"]["MEMENUIY"] = $dta["MEMENUIY"];
				$res["data"]["MECODE"] = $dta["MECODE"];
				$res["data"]["MENAME"] = $dta["MENAME"];
				$res["data"]["MELINK"] = $dta["MELINK"];
				$res["data"]["MEACTV"] = $dta["MEACTV"];
				$res["data"]["MEREMK"] = $dta["MEREMK"];
			}
		}
	}
	else{
		$res["sts"] = "error";
		$res["msg"] = "Error fetch data ! ".mysqli_error($con);
	}
	
	return json_encode($res);
}

function updateMenu($id){
	include("config/DBcon.php");
	
	$uid = getUID($id);
	$json = json_decode($_POST["postData"],1);
	$dataId = $json["id"];
	$name = $json["name"];
	$sts = $json["sts"];
	$remk = $json["remk"];
	
	$sql = "UPDATE tbl_menu SET MENAME = '".$name."', MEACTV = '".$sts."', MEREMK = '".$remk."', MECHON = NOW(), MECHBY = '".$uid."' ";
	$sql.= "WHERE MEMENUIY = '".$dataId."'";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$res["sts"] = "success";
		$res["msg"] = "Success update data !";
	}
	else{
		$res["sts"] = "error";
		$res["msg"] = "Error update data ! ".mysqli_error($con);
	}

	return json_encode($res);
}
?>