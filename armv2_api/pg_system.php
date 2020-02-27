<?php
if($pg == "sys_login"){
	$file = "sys_admin/login.php";
}
elseif($pg == "sys_user"){
	$file = "sys_admin/profile.php";
}
elseif($pg == "sys_menu"){
	$file = "sys_admin/menu.php";
}
elseif($pg == "sys_dept"){
	$file = "sys_admin/department.php";
}
elseif($pg == "sys_subdept"){
	$file = "sys_admin/subdepartment.php";
}
elseif($pg == "sys_jabt"){
	$file = "sys_admin/jabatan.php";
}
else{
	error();
}
include($file);
?>