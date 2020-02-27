<?php
$fn = (empty($_REQUEST["fn"])) ? "error" : base64_decode($_REQUEST["fn"]);
$id = (empty($_REQUEST["id"])) ? 0 : base64_decode($_REQUEST["id"]);

if($id == 0){
	error();
}
else{
	echo $fn($id);
}

function getOppoTypeList($id){
	include("config/DBcon.php");
	
	$sql = "SELECT * FROM tbl_oppo_type WHERE OTDLTE = '0' ORDER BY OTCODE, OTNAME";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$num = mysqli_num_rows($exc);
		if($num > 0){
			$res["sts"] = "success";
			$res["msg"] = "Success fetch data !";
			
			while($dta = mysqli_fetch_array($exc)){
				$dat["OTOPTYIY"] = $dta["OTOPTYIY"];
				$dat["OTCODE"] = $dta["OTCODE"];
				$dat["OTNAME"] = $dta["OTNAME"];
				$dat["OTREMK"] = $dta["OTREMK"];
				$dat["OTACTV"] = $dta["OTACTV"];
				
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
		$res["msg"] = "Error fetch data ! ".mysqli_query($con);
	}
	
	return json_encode($res);
}

function actOppTyp($id){
	include("config/DBcon.php");

	$uid = getUID($id);
	$mod = base64_decode($_REQUEST["md"]);
	
	$json = json_decode($_POST["postData"],1);
	
	if($mod == "delete"){
		$dataId = $json["id"];
		
		$sql = "UPDATE tbl_oppo_type SET OTDLTE = '1', OTACTV = '0', OTCHON = NOW(), OTCHBY = '".$uid."' WHERE OTOPTYIY = '".$dataId."'";
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
			$sql = "SELECT RIGHT(CONCAT('000',(RIGHT(OTCODE,3)+1)),3) AS runNo FROM tbl_oppo_type ORDER BY 1 DESC LIMIT 1";
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
				$code = "OTY".$no;
				
				$sql = "INSERT INTO tbl_oppo_type (OTCODE, OTNAME, OTACTV, OTDLTE, OTREMK, OTADON, OTADBY) VALUES ";
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
			$sql = "UPDATE tbl_oppo_type SET OTNAME = '".$name."', OTACTV = '".$actv."', OTREMK = '".$remk."', OTCHON = NOW(), OTCHBY = '".$uid."' ";
			$sql.= "WHERE OTOPTYIY = '".$dataId."'";
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

function getOppoTypeDetail($id){
	include("config/DBcon.php");

	$sql = "SELECT * FROM tbl_oppo_type WHERE OTOPTYIY = '".base64_decode($_REQUEST["mi"])."'";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$res["sts"] = "success";
		$res["msg"] = "Success fetch data !";
		
		$dta = mysqli_fetch_array($exc);
		
		$res["data"]["OTOPTYIY"] = $dta["OTOPTYIY"];
		$res["data"]["OTCODE"] = $dta["OTCODE"];
		$res["data"]["OTNAME"] = $dta["OTNAME"];
		$res["data"]["OTREMK"] = $dta["OTREMK"];
		$res["data"]["OTACTV"] = $dta["OTACTV"];
	}
	else{
		$res["sts"] = "error";
		$res["msg"] = "Failed fetch data ! ".$mysqli_error($con);
	}
	
	return json_encode($res);
}
?>