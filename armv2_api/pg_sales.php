<?php
if($pg == "sls_sales_stage"){
	$file = "sales/sales_stage.php";
}
elseif($pg == "sls_oppo_type"){
	$file = "sales/oppo_type.php";
}
else{
	error();
}

include($file);
?>