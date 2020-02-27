<?php
$fn = (empty($_REQUEST["fn"])) ? "error" : base64_decode($_REQUEST["fn"]);
$id = (empty($_REQUEST["id"])) ? 0 : base64_decode($_REQUEST["id"]);

if($id == 0){
	error();
}
else{
	echo $fn($id);
}

function getJabtDropDown($id){
	include("config/DBcon.php");
	
	$sql = "SELECT * FROM tbl_jabatan WHERE JAACTV = '1' ORDER BY JANAME";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$res["sts"] = "success";
		$res["msg"] = "Success fetch data !";
		
		$num = mysqli_num_rows($exc);
		if($num > 0){
			while($dta = mysqli_fetch_array($exc)){
				$dat["data"]["JAJABTIY"] = $dta["JAJABTIY"];
				$dat["data"]["JANAME"] = $dta["JANAME"];
				$res["data"][] = $dat["data"];
			}
		}
		else{
			$dat["data"]["JAJABTIY"] = 0;
			$dat["data"]["JANAME"] = "No Data Found. . .";
			$res["data"][] = $dat["data"];
		}
	}
	else{
		$res["sts"] = "error";
		$res["msg"] = "Can`t fetch data ! ".mysqli_error($con);
	}
	
	return json_encode($res);
}

function getJabtList($id){
	include("config/DBcon.php");

	$sql = "SELECT * FROM tbl_jabatan WHERE JADLTE = '0' ORDER BY JACODE";
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
				$dat["JAJABTIY"] = $dta["JAJABTIY"];
				$dat["JACODE"] = $dta["JACODE"];
				$dat["JANAME"] = $dta["JANAME"];
				$dat["JAREMK"] = $dta["JAREMK"];
				$dat["JAACTV"] = $dta["JAACTV"];
				
				$res["data"][] = $dat;
			}
		}
	}
	else{
		$res["sts"] = "error";
		$res["msg"] = "Failed fetch data ! ".mysqli_error($con);
	}
	
	return json_encode($res);
}

function actJabt($id){
	include("config/DBcon.php");

	$uid = getUID($id);
	$mod = base64_decode($_REQUEST["md"]);
	$json = json_decode($_POST["postData"],1);
	
	if($mod == "delete"){
		$dataId = $json["id"];
		
		$sql = "UPDATE tbl_jabatan SET JADLTE = '1', JAACTV = '0', JACHON = NOW(), JACHBY = '".$uid."' WHERE JAJABTIY = '".$dataId."'";
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
		$remk = $json["remk"];
		$actv = $json["actv"];
		
		if($mod == "add"){
			$sql = "SELECT RIGHT(CONCAT('000',(RIGHT(JACODE,3)+1)),3) AS runNo FROM tbl_jabatan ORDER BY 1 DESC LIMIT 1";
			$exc = mysqli_query($con,$sql);
			if($exc){
				$num = mysqli_num_rows($exc);
				if($num < 1){
					$no = "001";
				}
				else{
					$dta = mysqli_fetch_array($exc);
					$no = $dta["runNo"];
				}
				$code = "JAB".$no;
				
				$sql = "INSERT INTO tbl_jabatan (JACODE, JANAME, JAACTV, JADLTE, JAREMK, JAADON, JAADBY) ";
				$sql.= "VALUES ('".$code."', '".$name."', '".$actv."', '0', '".$remk."', NOW(), '".$uid."')";
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
			$sql = "UPDATE tbl_jabatan SET JANAME = '".$name."', JAREMK = '".$remk."', JAACTV = '".$actv."', JACHON = NOW(), JACHBY = '".$uid."' ";
			$sql.= "WHERE JAJABTIY = '".$dataId."'";
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

function getJabtDetail($id){
	include("config/DBcon.php");

	$sql = "SELECT * FROM tbl_jabatan WHERE JAJABTIY = '".base64_decode($_REQUEST["mi"])."'";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$res["sts"] = "success";
		$res["msg"] = "Success fetch data !";
		
		$dta = mysqli_fetch_array($exc);
		
		$res["data"]["JAJABTIY"] = $dta["JAJABTIY"];
		$res["data"]["JACODE"] = $dta["JACODE"];
		$res["data"]["JANAME"] = $dta["JANAME"];
		$res["data"]["JAREMK"] = $dta["JAREMK"];
		$res["data"]["JAACTV"] = $dta["JAACTV"];
	}
	else{
		$res["sts"] = "success";
		$res["msg"] = "Failed fetch data ! ".mysqli_error($con);
	}
	
	return json_encode($res);
}
?>