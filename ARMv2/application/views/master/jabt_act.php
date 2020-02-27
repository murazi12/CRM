<?php
$json = json_decode($jabtDtil,1);
$disabled = ($mod == "view") ? "disabled" : "";
$btnSubmit = ($mod == "view") ? "" : "<button id='btnSubmit' class='btn btn-success float-right'>Submit</button>";

if($json["sts"] == "success"){
	$JAJABTIY = $json["data"]["JAJABTIY"];
	$JACODE = $json["data"]["JACODE"];
	$JANAME = $json["data"]["JANAME"];
	$JAREMK = $json["data"]["JAREMK"];
	$JAACTV = $json["data"]["JAACTV"];
	$textJAACTV = ($JAACTV == '1') ? 'Active' : 'Non Active';

	$stsDropDown = "<option value='' disabled>Status</option>";
	$stsDropDown .= ($JAACTV == '1') ? "<option value='1' selected>Active</option>" : "<option value='1'>Active</option>";
	$stsDropDown .= ($JAACTV == '0') ? "<option value='0' selected>Non Active</option>" : "<option value='0'>Non Active</option>";
}
else{
	$JAJABTIY = "Error";
	$JACODE = "Error";
	$JANAME = "Error";
	$JAREMK = "Error";
	$JAACTV = "Error";
	$textJAACTV = "Error";
}
?>

	<!-- Content Wrapper. Contains page content -->
  	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
    	<section class="content-header">
			<div class="container-fluid">
	        	<div class="row mb-2">
          			<div class="col-sm-6">
	            		<h1>Master Jabatan</h1>
	          		</div>
	          		<div class="col-sm-6">
	            		<ol class="breadcrumb float-sm-right">
	              			<li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
	              			<li class="breadcrumb-item"><a href="<?= base_url("mst_jabt") ?>">Master Jabatan</a></li>
	              			<li class="breadcrumb-item active"><?= ucfirst($mod) ?> Jabatan</li>
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
                    					<label for="JAJABTIY" class="col-sm-3 col-form-label">Code</label>
                    					<div class="col-sm-3">
                      						<input type="hidden" class="form-control" id="JAJABTIY" value="<?= $JAJABTIY ?>">
                      						<input type="text" class="form-control" id="JACODE" value="<?= $JACODE ?>" disabled>
                    					</div>
                  					</div>
                  					<div class="form-group row">
                    					<label for="JANAME" class="col-sm-3 col-form-label">Name</label>
                    					<div class="col-sm-6">
                      						<input type="text" class="form-control" id="JANAME" value="<?= $JANAME ?>" <?= $disabled ?>>
                    					</div>
                  					</div>
                				</div>
				                <div class="col-sm-6">
			                  		<div class="form-group row">
                    					<label for="JAACTV" class="col-sm-3 col-form-label">Status</label>
                    					<div class="col-sm-4">
                      						<select class="form-control" id="JAACTV" <?= $disabled ?>>
                        						<?= $stsDropDown ?>
                      						</select>
                    					</div>
                  					</div>
                  					<div class="form-group row">
                    					<label for="JAREMK" class="col-sm-3 col-form-label">Remark</label>
                    					<div class="col-sm-8">
                      						<textarea class="form-control" rows="3" id="JAREMK" <?= $disabled ?>><?= $JAREMK ?></textarea>
                    					</div>
                  					</div>
                				</div>
              				</div>
			            </form>
		          	</div>
		        </div>
				<div class="row mb-3">
    	      		<div class="col-6">
        	    		<a href="<?= base_url("mst_jabt") ?>" class="btn btn-danger">Back</a>
          			</div>
          			<div class="col-6">
	            		<?= $btnSubmit ?>
	          		</div>
	        	</div>
	      	</div>
		</section>
	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#btnSubmit').on('click', function(){
				let id, code, name, remk, sts, url, data;
				id = $('#JAJABTIY').val();
				code = $('#JACODE').val();
				name = $('#JANAME').val();
				remk = $('#JAREMK').val();
				sts = $('#JAACTV').val();

				if(name == '' || name == null){
					Swal.fire({
		                icon: "warning",
		                title: "Oops...",
		                text : "Name can't be empty !"
	              	});
				}
				else{
					url = "<?= API_URL ?>?pg="+btoa("sys_jabt")+"&fn="+btoa("actJabt")+"&id=<?= $this->session->userdata("UIY") ?>&md=<?= base64_encode($mod) ?>";
					data = JSON.stringify({"id": id, "code": code, "name": name, "remk": remk, "actv": sts});
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
                  						$(location).attr("href","<?= base_url('mst_jabt') ?>");
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
					});
				}
			});
		});
	</script>