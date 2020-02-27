<?php
header("Content-Type: application/json; charset=UTF-8");

$pg = (empty($_REQUEST["pg"])) ? "error" : base64_decode($_REQUEST["pg"]);

if($pg !== "error"){
	if(strpos($pg,"sys_") !== false){
		$path = "pg_system.php";
	}
	elseif(strpos($pg,"sls_") !== false){
		$path = "pg_sales.php";
	}
	include($path);
}
else{
	error();
}

function error(){
	echo "function error";
}

function getUID($id){
	include("config/DBcon.php");
	
	$sql = "SELECT USUSNM FROM tbl_user WHERE USUSERIY = '".$id."'";
	$exc = mysqli_query($con,$sql);
	if($exc){
		$dta = mysqli_fetch_array($exc);
		$uid = $dta["USUSNM"];
	}
	else{
		return false;
	}
	return $uid;
}


?>