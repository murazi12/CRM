<?php
$json = json_decode($sdptDtil,1);
$disabled = ($mod == "view") ? "disabled" : "";
$btnSubmit = ($mod == "view") ? "" : "<button id='btnSubmit' class='btn btn-success float-right'>Submit</button>";

if($json["sts"] == "success"){
	$SDSDPTIY = $json["data"]["SDSDPTIY"];
	$SDDEPTIY = $json["data"]["SDDEPTIY"];
	$DENAME = $json["data"]["DENAME"];
	$SDCODE = $json["data"]["SDCODE"];
	$SDNAME = $json["data"]["SDNAME"];
	$SDREMK = $json["data"]["SDREMK"];
	$SDACTV = $json["data"]["SDACTV"];
	$textSDACTV = ($SDACTV == '1') ? 'Active' : 'Non Active';

	$stsDropDown = "<option value='' disabled>Status</option>";
	$stsDropDown .= ($SDACTV == '1') ? "<option value='1' selected>Active</option>" : "<option value='1'>Active</option>";
	$stsDropDown .= ($SDACTV == '0') ? "<option value='0' selected>Non Active</option>" : "<option value='0'>Non Active</option>";
}
else{
	$SDSDPTIY = "error";
	$SDDEPTIY = "error";
	$DENAME = "error";
	$SDCODE = "error";
	$SDNAME = "error";
	$SDREMK = "error";
	$SDACTV = "error";
	$textSDACTV = "error";
}
?>

	<!-- Content Wrapper. Contains page content -->
  	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
    	<section class="content-header">
			<div class="container-fluid">
	        	<div class="row mb-2">
          			<div class="col-sm-6">
	            		<h1>Master Sub Department</h1>
	          		</div>
	          		<div class="col-sm-6">
	            		<ol class="breadcrumb float-sm-right">
	              			<li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
	              			<li class="breadcrumb-item"><a href="<?= base_url("mst_subdept") ?>">Master Sub Department</a></li>
	              			<li class="breadcrumb-item active"><?= ucfirst($mod) ?> Sub Department</li>
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
                    					<label for="SDDEPTIY" class="col-sm-3 col-form-label">Department</label>
                    					<div class="col-sm-6 input-group">
									 		<input type="hidden" class="form-control" id="SDDEPTIY" value="<?= $SDDEPTIY ?>" disabled>
									 		<input type="text" class="form-control" id="DENAME" placeholder="Browse Dept. . ." value="<?= $DENAME ?>" readonly>
  											<div class="input-group-append">
    											<span id="browseDept" class="input-group-text"><i class="fas fa-bars"></i></span>
  											</div>
                    					</div>
                  					</div>
			                  		<div class="form-group row">
                    					<label for="SDSDPTIY" class="col-sm-3 col-form-label">Code</label>
                    					<div class="col-sm-3">
                      						<input type="hidden" class="form-control" id="SDSDPTIY" value="<?= $SDSDPTIY ?>">
                      						<input type="text" class="form-control" id="SDCODE" value="<?= $SDCODE ?>" disabled>
                    					</div>
                  					</div>
                  					<div class="form-group row">
                    					<label for="SDNAME" class="col-sm-3 col-form-label">Name</label>
                    					<div class="col-sm-6">
                      						<input type="text" class="form-control" id="SDNAME" value="<?= $SDNAME ?>" <?= $disabled ?>>
                    					</div>
                  					</div>
                				</div>
				                <div class="col-sm-6">
			                  		<div class="form-group row">
                    					<label for="SDACTV" class="col-sm-3 col-form-label">Status</label>
                    					<div class="col-sm-4">
                      						<select class="form-control" id="SDACTV" <?= $disabled ?>>
                        						<?= $stsDropDown ?>
                      						</select>
                    					</div>
                  					</div>
                  					<div class="form-group row">
                    					<label for="SDREMK" class="col-sm-3 col-form-label">Remark</label>
                    					<div class="col-sm-8">
                      						<textarea class="form-control" rows="3" id="SDREMK" <?= $disabled ?>><?= $SDREMK ?></textarea>
                    					</div>
                  					</div>
                				</div>
              				</div>
			            </form>
		          	</div>
		        </div>
				<div class="row mb-3">
    	      		<div class="col-6">
        	    		<a href="<?= base_url("mst_subdept") ?>" class="btn btn-danger">Back</a>
          			</div>
          			<div class="col-6">
	            		<?= $btnSubmit ?>
	          		</div>
	        	</div>
	      	</div>
		</section>
	</div>

	<!-- Modal Access -->
	<div class="modal fade" id="deptModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    	<div class="modal-dialog modal-lg" role="document">
      		<div class="modal-content">
        		<div class="modal-header">
      				<h5 class="modal-title" id="exampleModalLabel">Master Department</h5>
        		</div>
        		<div class="modal-body" id="deptModalBody"></div>
        		<div class="modal-footer" id="deptModalFooter">
          			<button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
        		</div>
      		</div>
    	</div>
  	</div>

	<script type="text/javascript">
		$(document).ready(function(){
			$('#browseDept').on('click', function(){
				let url, html;
				url = "<?= API_URL ?>?pg="+btoa("sys_dept")+"&fn="+btoa("getDeptList")+"&id=<?= $this->session->userdata("UIY") ?>&sqlfil="+btoa("AND DEACTV = '1'");
				$.getJSON(url, function(data){
					if(data.sts == "success"){
						html = `
							<div class="modal-body" id="deptModalBody">
								<div class="table-responsive">
	                  				<table id="tbl_dept" class="table table-bordered table-hover table-sm nowrap">
	                    				<thead class="thead-light">
	                      					<tr>
						                        <th width="5%" class="text-right">No</th>
						                        <th width="10%">Code</th>
						                        <th width="30%">Name</th>
						                        <th>Remark</th>
			                      			</tr>
	                    				</thead>
	                    				<tbody>
						`;
						for(var i=0; i<data.data.length; i++){
							let remk = (data.data[i].DEREMK == null) ? '' : data.data[i].DEREMK;
							html += `
								<tr id='deptId_`+data.data[i].DEDEPTIY+`'>
									<td class='text-right'>`+(i+1)+`</td>
									<td>`+data.data[i].DECODE+`</td>
									<td>`+data.data[i].DENAME+`</td>
									<td>`+remk+`</td>
								</tr>
							`;
						}
						html += `
									</tbody>
								</div>
							</div>
						`;
						$('#deptModalBody').replaceWith(html);
						$('#deptModal').modal('toggle');

						$("tr[id^='deptId']").on('dblclick', function(){
							let row, id, name;
							id = $(this).attr('id');
							id = id.split('_');
							id = id[1];

							row = $(this).find('td');
							name = row[2].innerText;

							$('#SDDEPTIY').val(id);
							$('#DENAME').val(name);

							$('#deptModal').modal('hide');
						});
					}
				});
			});

			$('#btnSubmit').on('click', function(){
				let id, deptId, name, sts, remk, url, data;
				id = $('#SDSDPTIY').val();
				deptId = $('#SDDEPTIY').val();
				name = $('#SDNAME').val();
				sts = $('#SDACTV').val();
				remk = $('#SDREMK').val();

				if(deptId == '' || deptId == null){
					Swal.fire({
		                icon: "warning",
		                title: "Oops...",
		                text : "Department can't be empty !"
	              	});
				}
				else if(name == '' || name == null){
					Swal.fire({
		                icon: "warning",
		                title: "Oops...",
		                text : "Name can't be empty !"
	              	});
				}
				else{
					url = "<?= API_URL ?>?pg="+btoa("sys_subdept")+"&fn="+btoa("actSdept")+"&id=<?= $this->session->userdata("UIY") ?>&md=<?= base64_encode($mod) ?>";
					data = JSON.stringify({"id": id, "deptId": deptId, "name": name, "actv": sts, "remk": remk});
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
                  						$(location).attr("href","<?= base_url('mst_subdept') ?>");
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
		});

	</script>