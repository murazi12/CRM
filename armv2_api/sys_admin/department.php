<?php
$fn = (empty($_REQUEST["fn"])) ? "error" : base64_decode($_REQUEST["fn"]);
$id = (empty($_REQUEST["id"])) ? 0 : base64_decode($_REQUEST["id"]);

if($id == 0){
	error();
}
else{
	echo $fn($id);
}

function getDeptDropDown($id){
	include("config/DBcon.php");
	
	$sql = "SELECT * FROM tbl_dept WHERE DEACTV = '1' ORDER BY DENAME";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$res["sts"] = "success";
		$res["msg"] = "Success fetch data !";
		
		while($dta = mysqli_fetch_array($exc)){
			$dat["data"]["DEDEPTIY"] = $dta["DEDEPTIY"];
			$dat["data"]["DENAME"] = $dta["DENAME"];
			$res["data"][] = $dat["data"];
		}
	}
	else{
		$res["sts"] = "error";
		$res["msg"] = "Can`t fetch data ! ".mysqli_error($con);
	}

	return json_encode($res);
}

function getDeptList($id){
	include("config/DBcon.php");
	
	$sql = "SELECT * FROM tbl_dept WHERE DEDLTE = '0' ORDER BY DECODE, DENAME";
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
				$dat["DEDEPTIY"] = $dta["DEDEPTIY"];
				$dat["DECODE"] = $dta["DECODE"];
				$dat["DENAME"] = $dta["DENAME"];
				$dat["DEACTV"] = $dta["DEACTV"];
				$dat["DEREMK"] = $dta["DEREMK"];
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

function actDept($id){
	include("config/DBcon.php");

	$uid = getUID($id);
	$mod = base64_decode($_REQUEST["md"]);
	
	$json = json_decode($_POST["postData"],1);
	
	if($mod == "delete"){
		$dataId = $json["id"];

		$sql = "UPDATE tbl_dept SET DEDLTE = '1', DEACTV = '0', DECHON = NOW(), DECHBY = '".$uid."' WHERE DEDEPTIY = '".$dataId."'";
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
		$sql = "SELECT RIGHT(CONCAT('000',(RIGHT(DECODE,3)+1)),3) AS runNo FROM tbl_dept ORDER BY 1 DESC LIMIT 1";
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
			$code = "DEP".$no;
			$name = $json["name"];
			$remk = $json["remk"];
			$actv = $json["sts"];
			
			$sql = "INSERT INTO tbl_dept (DECODE, DENAME, DEREMK, DEACTV, DEADON, DEADBY) ";
			$sql.= "VALUES ('".$code."', '".$name."', '".$remk."', '".$actv."', NOW(), '".$uid."')";
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
		$name = $json["name"];
		$remk = $json["remk"];
		$actv = $json["sts"];
		
		$sql = "UPDATE tbl_dept SET DENAME = '".$name."', DEREMK = '".$remk."', DEACTV = '".$actv."', ";
		$sql.= "DECHON = NOW(), DECHBY = '".$uid."' WHERE DEDEPTIY = '".$dataId."'";
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

function getDeptDetail($id){
	include("config/DBcon.php");
	
	$sql = "SELECT * FROM tbl_dept WHERE DEDEPTIY = '".base64_decode($_REQUEST["mi"])."'";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$res["sts"] = "success";
		$res["msg"] = "Success fetch data !";
		
		$dta = mysqli_fetch_array($exc);
		
		$res["data"]["DEDEPTIY"] = $dta["DEDEPTIY"];
		$res["data"]["DECODE"] = $dta["DECODE"];
		$res["data"]["DENAME"] = $dta["DENAME"];
		$res["data"]["DEACTV"] = $dta["DEACTV"];
		$res["data"]["DEREMK"] = $dta["DEREMK"];
		
	}
	else{
		$res["sts"] = "error";
		$res["msg"] = "Failed fetch data ! ".mysqli_error($con);
	}
	
	return json_encode($res);
}
?>