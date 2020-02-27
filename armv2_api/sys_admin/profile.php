<?php
$fn = (empty($_REQUEST["fn"])) ? "error" : base64_decode($_REQUEST["fn"]);
$id = (empty($_REQUEST["id"])) ? 0 : base64_decode($_REQUEST["id"]);

if($id == 0){
	error();
}
else{
	echo $fn($id);
}

function getUserList(){
	include("config/DBcon.php");
	
	$sql = "SELECT * FROM tbl_user ORDER BY USUSNM";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$num = mysqli_num_rows($exc);
		if($num > 0){
			$res["sts"] = "success";
			$res["msg"] = "Success fetch data !";
			while($dta = mysqli_fetch_array($exc)){
				$dat["data"]["id"] = base64_encode($dta["USUSERIY"]);
				$dat["data"]["USUNIK"] = $dta["USUNIK"];
				$dat["data"]["USUSNM"] = $dta["USUSNM"];
				$dat["data"]["USMAIL"] = $dta["USMAIL"];
				$dat["data"]["USFLNM"] = $dta["USFLNM"];
				$dat["data"]["USACTV"] = $dta["USACTV"];
				$dat["data"]["USREMK"] = $dta["USREMK"];
				$res["data"][] = $dat["data"];
			}
		}
		else{
			$res["sts"] = "error";
			$res["msg"] = "No Data Available !";
		}
	}
	else{
		$res["sts"] = "error";
		$res["msg"] = "Can`t fetch data ! ".mysqli_error($con);
	}
	
	return json_encode($res);
}

function getUserDetail($id){
	include("config/DBcon.php");
	
	$sql = "SELECT * FROM tbl_user ";
	$sql .= "LEFT JOIN tbl_user_biodata ON UBUSERIY = USUSERIY ";
	$sql .= "LEFT JOIN tbl_dept ON DEDEPTIY = UBDEPTIY ";
	$sql .= "LEFT JOIN tbl_subdept ON SDSDPTIY = UBSDPTIY ";
	$sql .= "LEFT JOIN tbl_jabatan ON JAJABTIY = UBJABTIY ";
	$sql .= "WHERE USUSERIY = '".base64_decode($_REQUEST["ids"])."'";

	$exc = mysqli_query($con,$sql);
	if($exc){
		$dat = mysqli_fetch_array($exc);
		
		$res["sts"] = "success";
		$res["msg"] = "Success fetch data !";
		$res["data"]["USUSERIY"] = $dat["USUSERIY"];
		$res["data"]["DEDEPTIY"] = $dat["DEDEPTIY"];
		$res["data"]["SDSDPTIY"] = $dat["SDSDPTIY"];
		$res["data"]["JAJABTIY"] = $dat["JAJABTIY"];
		$res["data"]["USUNIK"] = $dat["USUNIK"];
		$res["data"]["USUSNM"] = $dat["USUSNM"];
		$res["data"]["USMAIL"] = $dat["USMAIL"];
		$res["data"]["USFLNM"] = $dat["USFLNM"];
		$res["data"]["USACTV"] = $dat["USACTV"];
		$res["data"]["USREMK"] = $dat["USREMK"];
	}
	else{
		$res["sts"] = "error";
		$res["msg"] = "Can`t fetch data ! ".mysqli_error($con);
	}
	
	return json_encode($res);
}

function updateUser($id){
	include("config/DBcon.php");
	
	$uid = getUID($id);
	
	$json = json_decode($_POST["postData"], 1);
	$dataId = $json["id"];
	$nik = $json["nik"];
	$flnm = $json["flnm"];
	$sts = $json["sts"];
	$dept = $json["dept"];
	$sdept = $json["sdept"];
	$jabt = $json["jabt"];
	$remk = $json["remk"];
	
	$sql = "UPDATE tbl_user SET USUNIK = '".$nik."', USFLNM = '".$flnm."', USACTV = '".$sts."', USREMK = '".$remk."', USCHON = NOW(), USCHBY = '".$uid."' ";
	$sql.= "WHERE USUSERIY = '".base64_decode($dataId)."'";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$sql = "SELECT * FROM tbl_user_biodata WHERE UBUSERIY = '".base64_decode($dataId)."' AND UBACTV = '1'";
		$exc = mysqli_query($con,$sql);
		if($exc){
			$num = mysqli_num_rows($exc);
			if($num < 1){
				$sql = "INSERT INTO tbl_user_biodata (UBUSERIY, UBDEPTIY, UBSDPTIY, UBJABTIY, UBACTV, UBADON, UBADBY) ";
				$sql.= "VALUES ('".base64_decode($dataId)."', NULLIF('".$dept."',''), NULLIF('".$sdept."',''), NULLIF('".$jabt."',''), '1', NOW(), '".$uid."')";
			}
			else{
				$dta = mysqli_fetch_array($exc);
				$ubId = $dta["UBBIODIY"];
				
				$sql = "UPDATE tbl_user_biodata SET UBDEPTIY = NULLIF('".$dept."',''), UBSDPTIY = NULLIF('".$sdept."',''), UBJABTIY = NULLIF('".$jabt."',''), ";
				$sql.= "UBCHON = NOW(), UBCHBY = '".$uid."' WHERE UBBIODIY = '".$ubId."'";
			}
			$exc = mysqli_query($con,$sql);
			if($exc){
				$res["sts"] = "success";
				$res["msg"] = "Success update data !";
			}
			else{
				$res["sts"] = "error";
				$res["msg"] = "Failed update data ! ".mysqli_error($con);
			}
		}
		else{
			$res["sts"] = "error";
			$res["msg"] = "Failed update data ! ".mysqli_error($con);
		}
	}
	else{
		$res["sts"] = "error";
		$res["msg"] = "Failed update data ! ".mysqli_error($con);
	}
	
	return json_encode($res);
}
/*
function getName($id){
	include("config/DBcon.php");
	
	$res = array();

	$sql = "SELECT * FROM tbl_user WHERE USUSERIY = '".$id."'";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$res["sts"] = "success";
		$res["data"]["unm"] = "";
	}
	else{
		
	}
	
	return json_encode($res);
}
*/
?>