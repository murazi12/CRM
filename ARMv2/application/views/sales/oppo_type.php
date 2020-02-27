<?php
$json = json_decode($oppoTypeList,1);
$jsonAccss = json_decode($userAccs,1);

if($jsonAccss["data"]["ACAADD"] == '1'){
	$addURL = base_url("sls_oppo_type/sls_oppo_type_act/").$this->url_encode->base64_url_encode("add");
	$addDisabled = "";
}
else{
	$addURL = "#";
	$addDisabled = "disabled";
}

if($jsonAccss["data"]["ACAEDT"] == '1'){
	$edtDisabled = "";
}
else{
	$edtDisabled = "disabled";
}

if($jsonAccss["data"]["ACAVIW"] == '1'){
	$viwDisabled = "";
}
else{
	$viwDisabled = "disabled";
}

if($jsonAccss["data"]["ACADLT"] == '1'){
	$dltDisabled = "";
}
else{
	$dltDisabled = "disabled";
}

$tbody = "";
if($json["sts"] == "success"){
	for($i=0; $i<count($json["data"]); $i++){
	    $edit = "<a class='dropdown-item ".$edtDisabled."' href='".base_url("sls_oppo_type/sls_oppo_type_act/").$this->url_encode->base64_url_encode("edit")."/".$this->url_encode->base64_url_encode($json["data"][$i]["OTOPTYIY"])."'>Edit</a>";
	    $view = "<a class='dropdown-item ".$viwDisabled."' href='".base_url("sls_oppo_type/sls_oppo_type_act/").$this->url_encode->base64_url_encode("view")."/".$this->url_encode->base64_url_encode($json["data"][$i]["OTOPTYIY"])."'>View</a>";
	    $dlte = "<a class='dropdown-item ".$dltDisabled."' id='delItem_".$json["data"][$i]["OTOPTYIY"]."' href='#'>Delete</a>";
	    $stsText = ($json["data"][$i]["OTACTV"] == '1') ? 'Active' : 'Non Active';

	    $tbody .= "
	    	<tr>
	    		<td class='text-right'>".($i+1)."</td>
	    		<td>".$json["data"][$i]["OTCODE"]."</td>
	    		<td>".$json["data"][$i]["OTNAME"]."</td>
	    		<td>".$stsText."</td>
	    		<td>".$json["data"][$i]["OTREMK"]."</td>
	    		<td class='text-center'>
					<a href='#' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='fas fa-cogs'></i></a>
          			<div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
        				".$edit."
			            ".$view."
			            ".$dlte."
		          	</div>
    			</td>
	    	</tr>
	    ";
	}
}
else{
	$tbody .= "";
}
?>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
  			<div class="container-fluid">
        		<div class="row mb-2">
          			<div class="col-sm-6">
            			<h1>Master Opportunity Type</h1>
          			</div>
          			<div class="col-sm-6">
        				<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
							<li class="breadcrumb-item active">Master Opportunity Type</li>
						</ol>
					</div>
				</div>
			</div><!-- /.container-fluid -->
		</section>

		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<a href='<?= $addURL ?>' class="btn btn-primary float-sm-right <?= $addDisabled ?>"><i class="fas fa-plus"></i>&nbsp;Add</a>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<div class="table-responsive">
									<table id="tbl_oppo_type" class="table table-bordered table-hover table-sm nowrap">
										<thead class="thead-light">
											<tr>
												<th width="5%" class="text-right">No</th>
												<th width="10%">Code</th>
												<th width="30%">Name</th>
												<th width="10%">Status</th>
												<th>Remark</th>
												<th width="10%" class="text-center">Action</th>
											</tr>
										</thead>
										<tbody>
											<?= $tbody ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	    </section>
    	<!-- /.content -->
	</div>

	<script src="<?= base_url("assets/adminLTE/plugins/datatables/jquery.dataTables.js") ?>"></script>
	<script src="<?= base_url("assets/adminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.js") ?>"></script>
	<script type="text/javascript">
		$('#tbl_oppo_type').DataTable({
			"ordering": false
		});

		$(document).ready(function(){
			$("a[id^='delItem']").on('click', function(){
			    let id;
		        id = $(this).attr('id');
		        id = id.split('_');
		        id = id[1];

		        Swal.fire({
		          title: 'Are you sure want to delete ?',
		          icon: 'warning',
		          showCancelButton: true,
		          confirmButtonColor: '#3085d6',
		          cancelButtonColor: '#d33',
		          confirmButtonText: 'Yes, delete it!'
		        }).then((result) => {
		          if(result.value) {
		            oppTypAction('dlte',id);
		          }
		        });
      		});

      		function oppTypAction(mode,id=0){
      			let url, data;
      			if(mode == "dlte"){
      				url = "<?= API_URL ?>?pg="+btoa("sls_oppo_type")+"&fn="+btoa("actOppTyp")+"&id=<?= $this->session->userdata("UIY") ?>&md="+btoa("delete");
      				data = JSON.stringify({"id": id});
      				$.ajax({
						type: "POST",
						url: url,
						data: {"postData": data},
						dataType: "json",
						success: function(data){
							if(data.sts == "success"){
								Swal.fire({
            				  		icon: data.sts,
            				  		title: data.msg,
            				  		showConfirmButton: false,
            				  		timer: 1500,
        				  			onClose: () => {
            				    		location.reload(true)
            				  		}
                				});
							}
							else{
								Swal.fire({
            				  		icon: data.sts,
	            				  	title: "Oops...",
            				  		text: data.msg
                				});
      						}
						},
						error: function(jqXhr, textStatus, errorThrown){
							console.log(textStatus);
						}
      				})
      			}
      		}
		});
	</script>