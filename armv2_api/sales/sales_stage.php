<?php
$fn = (empty($_REQUEST["fn"])) ? "error" : base64_decode($_REQUEST["fn"]);
$id = (empty($_REQUEST["id"])) ? 0 : base64_decode($_REQUEST["id"]);

if($id == 0){
	error();
}
else{
	echo $fn($id);
}

function getSalesStageList($id){
	include("config/DBcon.php");
	
	$sql = "SELECT * FROM tbl_sales_stage WHERE SSDLTE = '0' ORDER BY SSCODE, SSNAME";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$num = mysqli_num_rows($exc);
		if($num > 0){
			$res["sts"] = "success";
			$res["msg"] = "Success fetch data !";
			
			while($dta = mysqli_fetch_array($exc)){
				$dat["SSSLTGIY"] = $dta["SSSLTGIY"];
				$dat["SSCODE"] = $dta["SSCODE"];
				$dat["SSNAME"] = $dta["SSNAME"];
				$dat["SSACTV"] = $dta["SSACTV"];
				$dat["SSDLTE"] = $dta["SSDLTE"];
				$dat["SSREMK"] = $dta["SSREMK"];
				
				$res["data"][] = $dat;
			}
			
		}
		else{
			$res["sts"] = "error";
			$res["msg"] = "No data found !";
		}
	}
	else{
		$res["sts"] = "error";
		$res["msg"] = "Error fetch data ! ".mysqli_error($con);
	}

	return json_encode($res);
}

function actSlsStg($id){
	include("config/DBcon.php");

	$uid = getUID($id);
	$mod = base64_decode($_REQUEST["md"]);
	
	$json = json_decode($_POST["postData"],1);
	
	if($mod == "delete"){
		$dataId = $json["id"];
		
		$sql = "UPDATE tbl_sales_stage SET SSDLTE = '1', SSACTV = '0', SSCHON = NOW(), SSCHBY = '".$uid."' WHERE SSSLTGIY = '".$dataId."'";
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
	else{
		$dataId = $json["id"];
		$name = $json["name"];
		$actv = $json["actv"];
		$remk = $json["remk"];
		if($mod == "add"){
			$sql = "SELECT RIGHT(CONCAT('000',(RIGHT(SSCODE,3)+1)),3) AS runNo FROM tbl_sales_stage ORDER BY 1 DESC LIMIT 1";
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
				$code = "STG".$no;
				
				$sql = "INSERT INTO tbl_sales_stage (SSCODE, SSNAME, SSACTV, SSDLTE, SSREMK, SSADON, SSADBY) VALUES ";
				$sql.= "('".$code."', '".$name."', '".$actv."', '0', '".$remk."', NOW(), '".$uid."')";
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
			$sql = "UPDATE tbl_sales_stage SET SSNAME = '".$name."', SSACTV = '".$actv."', SSREMK = '".$remk."', SSCHON = NOW(), SSCHBY = '".$uid."' ";
			$sql.= "WHERE SSSLTGIY = '".$dataId."'";
			$exc = mysqli_query($con,$sql);
			if($exc){
				$res["sts"] = "success";
				$res["msg"] = "Success edit data !";
			}
			else{
				$res["sts"] = "error";
				$res["msg"] = "Failed edit data ! ".mysqli_error($con);
			}
		}
	}
	
	return json_encode($res);
}

function getSalesStageDetail($id){
	include("config/DBcon.php");
	
	$sql = "SELECT * FROM tbl_sales_stage WHERE SSSLTGIY = '".base64_decode($_REQUEST["mi"])."'";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$res["sts"] = "success";
		$res["msg"] = "Success fetch data !";
		
		$dta = mysqli_fetch_array($exc);
		
		$res["data"]["SSSLTGIY"] = $dta["SSSLTGIY"];
		$res["data"]["SSCODE"] = $dta["SSCODE"];
		$res["data"]["SSNAME"] = $dta["SSNAME"];
		$res["data"]["SSACTV"] = $dta["SSACTV"];
		$res["data"]["SSREMK"] = $dta["SSREMK"];
	}
	else{
		$res["sts"] = "error";
		$res["msg"] = "Error fetch data ! ".mysqli_error($con);		
	}
	
	return json_encode($res);
}
?>