<?php
$json = json_decode($deptDtil,1);
$disabled = ($mod == "view") ? "disabled" : "";
$btnSubmit = ($mod == "view") ? "" : "<button id='btnSubmit' class='btn btn-success float-right'>Submit</button>";
if($json["sts"] == "success"){
	$DEDEPTIY = $json["data"]["DEDEPTIY"];
	$DECODE = $json["data"]["DECODE"];
	$DENAME = $json["data"]["DENAME"];
	$DEREMK = $json["data"]["DEREMK"];
	$DEACTV = $json["data"]["DEACTV"];
	$textDEACTV = ($DEACTV == "1") ? "Active" : "Non Active";

	$stsDropDown = "<option value='' disabled>Status</option>";
	$stsDropDown .= ($DEACTV == '1') ? "<option value='1' selected>Active</option>" : "<option value='1'>Active</option>";
	$stsDropDown .= ($DEACTV == '0') ? "<option value='0' selected>Non Active</option>" : "<option value='0'>Non Active</option>";
}
else{
	$DEDEPTIY = "error";
	$DECODE = "error";
	$DENAME = "error";
	$DEREMK = "error";
	$DEACTV = "error";
	$textDEACTV = "error";
}
?>
	
	<!-- Content Wrapper. Contains page content -->
  	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
    	<section class="content-header">
			<div class="container-fluid">
	        	<div class="row mb-2">
          			<div class="col-sm-6">
	            		<h1>Master Department</h1>
	          		</div>
	          		<div class="col-sm-6">
	            		<ol class="breadcrumb float-sm-right">
	              			<li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
	              			<li class="breadcrumb-item"><a href="<?= base_url("mst_dept") ?>">Master Department</a></li>
	              			<li class="breadcrumb-item active"><?= ucfirst($mod) ?> Department</li>
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
                    					<label for="DEDEPTIY" class="col-sm-2 col-form-label">Code</label>
                    					<div class="col-sm-3">
                      						<input type="hidden" class="form-control" id="DEDEPTIY" value="<?= $DEDEPTIY ?>">
                      						<input type="text" class="form-control" id="DECODE" value="<?= $DECODE ?>" disabled>
                    					</div>
                  					</div>
                  					<div class="form-group row">
                    					<label for="DENAME" class="col-sm-2 col-form-label">Name</label>
                    					<div class="col-sm-6">
                      						<input type="text" class="form-control" id="DENAME" value="<?= $DENAME ?>" <?= $disabled ?>>
                    					</div>
                  					</div>
                				</div>
				                <div class="col-sm-6">
			                  		<div class="form-group row">
                    					<label for="DEACTV" class="col-sm-3 col-form-label">Status</label>
                    					<div class="col-sm-4">
                      						<select class="form-control" id="DEACTV" <?= $disabled ?>>
                        						<?= $stsDropDown ?>
                      						</select>
                    					</div>
                  					</div>
                  					<div class="form-group row">
                    					<label for="DEREMK" class="col-sm-3 col-form-label">Remark</label>
                    					<div class="col-sm-8">
                      						<textarea class="form-control" rows="3" id="DEREMK" <?= $disabled ?>><?= $DEREMK ?></textarea>
                    					</div>
                  					</div>
                				</div>
              				</div>
			            </form>
		          	</div>
		        </div>
				<div class="row mb-3">
    	      		<div class="col-6">
        	    		<a href="<?= base_url("mst_dept") ?>" class="btn btn-danger">Back</a>
          			</div>
          			<div class="col-6">
	            		<?= $btnSubmit ?>
	          		</div>
	        	</div>
	      	</div>
		</section>
		<!-- /.content -->
	</div>
  	<!-- /.content-wrapper -->

  	<script type="text/javascript">
  		$(document).ready(function(){
  			$('#btnSubmit').on('click', function(){
  				let id, name, sts, remk, data, url;
  				id = $('#DEDEPTIY').val();
  				name = $('#DENAME').val();
  				sts = $('#DEACTV').val();
  				remk = $('#DEREMK').val();

  				if(name == '' || name == null){
					Swal.fire({
		                icon: "warning",
		                title: "Oops...",
		                text : "Name can't be empty !"
	              	});
  				}
  				else{
	  				url = "<?= API_URL ?>?pg="+btoa("sys_dept")+"&fn="+btoa("actDept")+"&id=<?= $this->session->userdata("UIY") ?>&md=<?= base64_encode($mod) ?>";
	  				data = JSON.stringify({"id": id, "name": name, "sts": sts, "remk": remk});
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
                  						$(location).attr("href","<?= base_url('mst_dept') ?>");
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
	  					error: function(jqXhr,textStatus,errorThrown){
							console.log(textStatus);
	  					}
	  				});
	  			}
  			});
  		});
  	</script>