<?php
$json = json_decode($slsStgDtil,1);
$disabled = ($mod == "view") ? "disabled" : "";
$btnSubmit = ($mod == "view") ? "" : "<button id='btnSubmit' class='btn btn-success float-right'>Submit</button>";

if($json["sts"] == "success"){
	$SSSLTGIY = $json["data"]["SSSLTGIY"];
	$SSCODE = $json["data"]["SSCODE"];
	$SSNAME = $json["data"]["SSNAME"];
	$SSREMK = $json["data"]["SSREMK"];
	$SSACTV = $json["data"]["SSACTV"];
	$textSSACTV = ($SSACTV == '1') ? "Active" : "Non Active";

	$stsDropDown = "<option value='' disabled>Status</option>";
	$stsDropDown .= ($SSACTV == '1') ? "<option value='1' selected>Active</option>" : "<option value='1'>Active</option>";
	$stsDropDown .= ($SSACTV == '0') ? "<option value='0' selected>Non Active</option>" : "<option value='0'>Non Active</option>";
}
else{
	$SSSLTGIY = "Error";
	$SSCODE = "Error";
	$SSNAME = "Error";
	$SSREMK = "Error";
	$SSACTV = "Error";
	$textSSACTV = "Error";
}
?>

	<!-- Content Wrapper. Contains page content -->
  	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
    	<section class="content-header">
			<div class="container-fluid">
	        	<div class="row mb-2">
          			<div class="col-sm-6">
	            		<h1>Master Sales Stage</h1>
	          		</div>
	          		<div class="col-sm-6">
	            		<ol class="breadcrumb float-sm-right">
	              			<li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
	              			<li class="breadcrumb-item"><a href="<?= base_url("sls_stage") ?>">Master Sales Stage</a></li>
	              			<li class="breadcrumb-item active"><?= ucfirst($mod) ?> Sales Stage</li>
	            		</ol>
	          		</div>
	        	</div>
	      	</div><!-- /.container-fluid -->
	    </section>

	    <!-- Main content -->
	    <section class="content">
      		<div class="container-fluid">
		        <div class="card card-info">
          			<div class="card-header">
	            		<h3 class="card-title">General Information</h3>
            			<div class="card-tools">
	              			<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
			                	<i class="fas fa-minus"></i>
		              		</button>
			            </div>
		      		</div>
	          		<div class="card-body">
			            <form role="form">
							<div class="row">
			                	<div class="col-sm-6">
			                  		<div class="form-group row">
                    					<label for="SSSLTGIY" class="col-sm-2 col-form-label">Code</label>
                    					<div class="col-sm-3">
                      						<input type="hidden" class="form-control" id="SSSLTGIY" value="<?= $SSSLTGIY ?>">
                      						<input type="text" class="form-control" id="SSCODE" value="<?= $SSCODE ?>" disabled>
                    					</div>
                  					</div>
                  					<div class="form-group row">
                    					<label for="SSNAME" class="col-sm-2 col-form-label">Name</label>
                    					<div class="col-sm-6">
                      						<input type="text" class="form-control" id="SSNAME" value="<?= $SSNAME ?>" <?= $disabled ?>>
                    					</div>
                  					</div>
                				</div>
				                <div class="col-sm-6">
			                  		<div class="form-group row">
                    					<label for="SSACTV" class="col-sm-3 col-form-label">Status</label>
                    					<div class="col-sm-4">
                      						<select class="form-control" id="SSACTV" <?= $disabled ?>>
                        						<?= $stsDropDown ?>
                      						</select>
                    					</div>
                  					</div>
                  					<div class="form-group row">
                    					<label for="SSREMK" class="col-sm-3 col-form-label">Remark</label>
                    					<div class="col-sm-8">
                      						<textarea class="form-control" rows="3" id="SSREMK" <?= $disabled ?>><?= $SSREMK ?></textarea>
                    					</div>
                  					</div>
                				</div>
              				</div>
			            </form>
		          	</div>
		        </div>
				<div class="row mb-3">
    	      		<div class="col-6">
        	    		<a href="<?= base_url("sls_stage") ?>" class="btn btn-danger">Back</a>
          			</div>
          			<div class="col-6">
	            		<?= $btnSubmit ?>
	          		</div>
	        	</div>
	      	</div>
		</section>
		<!-- /.content -->
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#btnSubmit').on('click', function(){
				let id, name, actv, remk, data, url;
				id = $('#SSSLTGIY').val();
				name = $('#SSNAME').val();
				actv = $('#SSACTV').val();
				remk = $('#SSREMK').val();

				if(name == null || name == ''){
					Swal.fire({
		                icon: "warning",
		                title: "Oops...",
		                text : "Name can't be empty !"
	              	});
				}
				else{
					url = "<?= API_URL ?>?pg="+btoa("sls_sales_stage")+"&fn="+btoa("actSlsStg")+"&id=<?= $this->session->userdata("UIY") ?>&md=<?= base64_encode($mod) ?>";
					data = JSON.stringify({"id": id, "name": name, "actv": actv, "remk": remk});
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
                  						$(location).attr("href","<?= base_url('sls_stage') ?>");
                					}
              					});
							}
							else{
	  							Swal.fire({
				                	icon: data.sts,
                					title: "Oops...",
                					text : data.msg
              					});
							}
						},
						error: function(jqXhr, textStatus, errorThrown){
							console.log(textStatus);
						}
					})
				}
			})
		})
	</script>