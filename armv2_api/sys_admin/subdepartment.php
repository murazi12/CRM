<?php
$fn = (empty($_REQUEST["fn"])) ? "error" : base64_decode($_REQUEST["fn"]);
$id = (empty($_REQUEST["id"])) ? 0 : base64_decode($_REQUEST["id"]);

if($id == 0){
	error();
}
else{
	echo $fn($id);
}

function getSdptDropDown($id){
	include("config/DBcon.php");
	
	$sql = "SELECT * FROM tbl_subdept WHERE SDDEPTIY = '".base64_decode($_REQUEST["mi"])."' AND SDACTV = '1' ORDER BY SDNAME";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$res["sts"] = "success";
		$res["msg"] = "Success fetch data !";
		
		$num = mysqli_num_rows($exc);
		if($num > 0){
			while($dta = mysqli_fetch_array($exc)){
				$dat["data"]["SDSDPTIY"] = $dta["SDSDPTIY"];
				$dat["data"]["SDNAME"] = $dta["SDNAME"];
				$res["data"][] = $dat["data"];
			}
		}
		else{
			$dat["data"]["SDDEPTIY"] = 0;
			$dat["data"]["SDNAME"] = "No Data Found. . .";
			$res["data"][] = $dat["data"];
		}
	}
	else{
		$res["sts"] = "error";
		$res["msg"] = "Can`t fetch data ! ".mysqli_error($con);		
	}
	
	return json_encode($res);
}

function getSubdeptList($id){
	include("config/DBcon.php");
	
	$sql = "SELECT * FROM tbl_subdept WHERE SDDLTE = '0'";
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
				$dat["SDDEPTIY"] = $dta["SDDEPTIY"];
				$dat["SDSDPTIY"] = $dta["SDSDPTIY"];
				$dat["SDCODE"] = $dta["SDCODE"];
				$dat["SDNAME"] = $dta["SDNAME"];
				$dat["SDREMK"] = $dta["SDREMK"];
				$dat["SDACTV"] = $dta["SDACTV"];

				$res["data"][] = $dat;
			}
		}
	}
	else{
		$res["sts"] = "error";
		$res["msg"] = "Error fetch data ! ".mysqli_error($con);
	}
	
	return json_encode($res);
}

function actSdept($id){
	include("config/DBcon.php");
	
	$uid = getUID($id);
	$mod = base64_decode($_REQUEST["md"]);
	$json = json_decode($_POST["postData"],1);
	
	if($mod == "delete"){
		$dataId = $json["id"];
		
		$sql = "UPDATE tbl_subdept SET SDDLTE = '1', SDACTV = '0', SDCHON = NOW(), SDCHBY = '".$uid."' WHERE SDSDPTIY = '".$dataId."'";
		$exc = mysqli_query($con,$sql);
		if($exc){
			$res["sts"] = "success";
			$res["msg"] = "Success delete data !";
		}
		else{
			$res["sts"] = "error";
			$res["msg"] = "Failed delete data ! ".mysqli_error($con);
		}		
	}
	elseif($mod == "add"){
		$sql = "SELECT RIGHT(CONCAT('000',(RIGHT(SDCODE,3)+1)),3) AS runNo FROM tbl_subdept ORDER BY 1 DESC LIMIT 1";
		$exc = mysqli_query($con,$sql);
		if($exc){
			$num = mysqli_num_rows($exc);
			if($num < 1){
				$no = '001';
			}
			else{
				$dta = mysqli_fetch_array($exc);
				$no = $dta["runNo"];
			}
			
			$code = "SDP".$no;
			$deptId = $json["deptId"];
			$name = $json["name"];
			$actv = $json["actv"];
			$remk = $json["remk"];
			
			$sql = "INSERT INTO tbl_subdept (SDDEPTIY, SDCODE, SDNAME, SDREMK, SDACTV, SDDLTE, SDADON, SDADBY) ";
			$sql.= "VALUES ('".$deptId."', '".$code."', '".$name."', '".$remk."', '".$actv."', '0', NOW(), '".$uid."')";
			$exc = mysqli_query($con,$sql);
			if($exc){
				$res["sts"] = "success";
				$res["msg"] = "Success add data !";
			}
			else{
				$res["sts"] = "error";
				$res["msg"] = "Failed add data ! ".mysqli_error($con);
			}
		}
		else{
			$res["sts"] = "error";
			$res["msg"] = "Failed add data ! ".mysqli_error($con);
		}
	}
	else{
		$dataId = $json["id"];
		$deptId = $json["deptId"];
		$name = $json["name"];
		$actv = $json["actv"];
		$remk = $json["remk"];
		
		$sql = "UPDATE tbl_subdept SET SDDEPTIY = '".$deptId."', SDNAME = '".$name."', SDACTV = '".$actv."', SDREMK = '".$remk."', SDCHON = NOW(), ";
		$sql.= "SDCHBY = '".$uid."' WHERE SDSDPTIY = '".$dataId."'";
		$exc = mysqli_query($con,$sql);
		if($exc){
			$res["sts"] = "success";
			$res["msg"] = "Success edit data !";
		}
		else{
			$res["sts"] = "error";
			$res["msg"] = "Failed add data ! ".mysqli_error($con);
		}
	}
	
	return json_encode($res);
}

function getSubdeptDetail($id){
	include("config/DBcon.php");
	
	$sql = "SELECT * FROM tbl_subdept LEFT JOIN tbl_dept ON DEDEPTIY = SDDEPTIY WHERE SDSDPTIY = '".base64_decode($_REQUEST["mi"])."'";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$res["sts"] = "success";
		$res["msg"] = "Success fetch data !";
		
		$dta = mysqli_fetch_array($exc);
		
		$res["data"]["SDSDPTIY"] = $dta["SDSDPTIY"];
		$res["data"]["SDDEPTIY"] = $dta["SDDEPTIY"];
		$res["data"]["DENAME"] = $dta["DENAME"];
		$res["data"]["SDCODE"] = $dta["SDCODE"];
		$res["data"]["SDNAME"] = $dta["SDNAME"];
		$res["data"]["SDACTV"] = $dta["SDACTV"];
		$res["data"]["SDREMK"] = $dta["SDREMK"];
	}
	else{
		$res["sts"] = "error";
		$res["msg"] = "Error fetch data ! ".mysqli_error($con);
	}
	
	return json_encode($res);
}
?>