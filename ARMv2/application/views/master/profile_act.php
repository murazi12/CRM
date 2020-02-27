<?php
$json = json_decode($userDtil,1);
$jsonAccss = json_decode($userAccs,1);
$jsonDeptDropDown = json_decode($deptDropDown,1);
$jsonJabtDropDown = json_decode($jabtDropDown,1);
$jsonAccsList = json_decode($userAccsList,1);

if($mod == "view"){
  $disabled = "disabled";
  $btnSubmit = "";
}
else{
  $disabled = "";
  $btnSubmit = "<button id='btnSubmit' class='btn btn-success float-right'>Submit</button>";
}

if($jsonAccsList["sts"] == "success"){
  $tblAccss = "";
  for($i=0; $i<count($jsonAccsList["data"]); $i++){
    $tblAccss .= "
      <tr style='background-color: #ededed' class='text-bold'>
        <td class='text-right'>".($i+1)."</td>
        <td>".$jsonAccsList["data"][$i]["menu"]["pMENAME"]."</td>
        <td colspan='5'></td>
      </tr>
    ";
    for($j=0; $j<count($jsonAccsList["data"][$i]["menu"]["submenu"]); $j++){
      if($jsonAccss["sts"] == "success" && $mod !== "view"){
        $edit = ($jsonAccss["data"]["ACAEDT"] == '1') ? "<a class='dropdown-item' id='edtItem_".$jsonAccsList["data"][$i]["menu"]["submenu"][$j]["sACACCSIY"]."' href='#'>Edit</a>" : "<a class='dropdown-item disabled' href='#'>Edit</a>";
        $dlte = ($jsonAccss["data"]["ACADLT"] == '1') ? "<a class='dropdown-item' id='delItem_".$jsonAccsList["data"][$i]["menu"]["submenu"][$j]["sACACCSIY"]."' href='#'>Delete</a>" : "<a class='dropdown-item disabled' href='#'>Delete</a>";
      }
      else{
        $edit = "<a class='dropdown-item disabled' href='#'>Edit</a>";
        $dlte = "<a class='dropdown-item disabled' href='#'>Delete</a>";
      }

      $add = ($jsonAccsList["data"][$i]["menu"]["submenu"][$j]["sACAADD"] == '1') ? "<i class='fas fa-check'></i>" : "<i class='fas fa-times'></i>";
      $edt = ($jsonAccsList["data"][$i]["menu"]["submenu"][$j]["sACAEDT"] == '1') ? "<i class='fas fa-check'></i>" : "<i class='fas fa-times'></i>";
      $viw = ($jsonAccsList["data"][$i]["menu"]["submenu"][$j]["sACAVIW"] == '1') ? "<i class='fas fa-check'></i>" : "<i class='fas fa-times'></i>";
      $dlt = ($jsonAccsList["data"][$i]["menu"]["submenu"][$j]["sACADLT"] == '1') ? "<i class='fas fa-check'></i>" : "<i class='fas fa-times'></i>";
      $tblAccss .= "
        <tr>
          <td class='text-right'>".($i+1).".".($j+1)."</td>
          <td>".$jsonAccsList["data"][$i]["menu"]["submenu"][$j]["sMENAME"]."</td>
          <td class='text-center'>".$add."</td>
          <td class='text-center'>".$edt."</td>
          <td class='text-center'>".$viw."</td>
          <td class='text-center'>".$dlt."</td>
          <td class='text-center'>
            <a href='#' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='fas fa-cogs'></i></a>
            <div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
              ".$edit."
              ".$dlte."
            </div>
          </td>
        </tr>
      ";
    }
  }
}
else{
  $tblAccss = "
    <tr style='background-color: #ededed' class='text-bold'>
      <td colspan='7'>".$jsonAccsList["msg"]."</td>
    </tr>
    ";  
}

if($json["sts"] == "success"){

  $USUSERIY = $json["data"]["USUSERIY"];
  $DEDEPTIY = $json["data"]["DEDEPTIY"];
  $SDSDPTIY = $json["data"]["SDSDPTIY"];
  $JAJABTIY = $json["data"]["JAJABTIY"];
  $USUNIK = $json["data"]["USUNIK"];
  $USUSNM = $json["data"]["USUSNM"];
  $USMAIL = $json["data"]["USMAIL"];
  $USFLNM = $json["data"]["USFLNM"];
  $USACTV = $json["data"]["USACTV"];
  $USREMK = $json["data"]["USREMK"];
  $textUSACTV = ($USACTV == '1' ? 'Active' : 'Non Active');

  $stsDropDown = "<option value='' disabled>Status</option>";
  $stsDropDown .= ($USACTV == '1') ? "<option value='1' selected>Active</option>" : "<option value='1'>Active</option>";
  $stsDropDown .= ($USACTV == '0') ? "<option value='0' selected>Non Active</option>" : "<option value='0'>Non Active</option>";

  $deptDropDown = "<option value='' selected disabled>- - - Choose Dept - - -</option>";
  if($jsonDeptDropDown["sts"] == "success"){
    for($i=0; $i<count($jsonDeptDropDown["data"]); $i++){
      $slct = ($jsonDeptDropDown["data"][$i]["DEDEPTIY"] == $DEDEPTIY) ? "selected" : "";
      $deptDropDown .= "<option value='".$jsonDeptDropDown["data"][$i]["DEDEPTIY"]."' ".$slct.">".$jsonDeptDropDown["data"][$i]["DENAME"]."</option>";
    }
  }

  $jabtDropDown = "<option value = '' selected disabled>- - - Choose Position - - -</option>";
  if($jsonJabtDropDown["sts"] == "success"){
    for($i=0; $i<count($jsonJabtDropDown["data"]); $i++){
      $slct = ($jsonJabtDropDown["data"][$i]["JAJABTIY"] == $JAJABTIY) ? "selected" : "";
      $jabtDropDown .= "<option value='".$jsonJabtDropDown["data"][$i]["JAJABTIY"]."' ".$slct.">".$jsonJabtDropDown["data"][$i]["JANAME"]."</option>";
    }
  }
}
else{
  $USUSERIY = "Error";
  $DEDEPTIY = "Error";
  $SDSDPTIY = "Error";
  $JAJABTIY = "Error";
  $USUNIK = "Error";
  $USUSNM = "Error";
  $USMAIL = "Error";
  $USFLNM = "Error";
  $USACTV = "Error";
  $textUSACTV = "Error";
  $deptDropDown = "<option value='' selected disabled>- - - Error - - -</option>";
}
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Master User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item"><a href="<?= base_url("mst_profile") ?>">Master User</a></li>
              <li class="breadcrumb-item active"><?= ucfirst($mod) ?> User</li>
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
                    <label for="USUNIK" class="col-sm-2 col-form-label">NIK</label>
                    <div class="col-sm-3">
                      <input type="hidden" class="form-control" id="USUSERIY" value="<?= $USUSERIY ?>">
                      <input type="text" class="form-control" id="USUNIK" value="<?= $USUNIK ?>" <?= $disabled ?>>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="USUSNM" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="USUSNM" value="<?= $USUSNM ?>" disabled>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="USMAIL" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="USMAIL" value="<?= $USMAIL ?>" disabled>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="USFLNM" class="col-sm-2 col-form-label">Fullname</label>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" id="USFLNM" value="<?= $USFLNM ?>" <?= $disabled ?>>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="USACTV" class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-4">
                      <select class="form-control" id="USACTV" <?= $disabled ?>>
                        <?= $stsDropDown ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group row">
                    <label for="DENAME" class="col-sm-3 col-form-label">Department</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="DENAME" <?= $disabled ?>>
                        <?= $deptDropDown ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="SDNAME" class="col-sm-3 col-form-label">Sub. Dept</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="SDNAME" disabled>
                        <option value='0' selected disabled>- - - Choose Sub. Dept - - -</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="JANAME" class="col-sm-3 col-form-label">Jabatan</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="JANAME" <?= $disabled ?>>
                        <?= $jabtDropDown ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="USREMK" class="col-sm-3 col-form-label">Remark</label>
                    <div class="col-sm-8">
                      <textarea class="form-control" rows="3" id="USREMK" <?= $disabled ?>><?= $USREMK ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="card card-warning">
          <div class="card-header">
            <h3 class="card-title">Access Information</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="row justify-content-end">
              <button class="btn btn-info btn-sm" id="btnAccess" <?= $disabled ?>><i class="fas fa-plus"></i>&nbsp;&nbsp;Access</button>
            </div>
            <div class="row mt-2">
              <div class="table-responsive">
                <table class="table table-hover table-bordered table-sm">
                  <thead class="thead-light">
                    <tr>
                      <th width="5%" class="text-right">No</th>
                      <th>Menu Name</th>
                      <th width="10%" class="text-center">Add</th>
                      <th width="10%" class="text-center">Edit</th>
                      <th width="10%" class="text-center">View</th>
                      <th width="10%" class="text-center">Delete</th>
                      <th width="10%" class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?= $tblAccss ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-6">
            <a href="<?= base_url("mst_profile") ?>" class="btn btn-danger">Back</a>
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

  <!-- Modal Access -->
  <div class="modal fade" id="accessModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
        </div>
        <div class="modal-body" id="accessModalBody">
        </div>
        <div class="modal-footer" id="accessModalFooter">
          <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="#" id="btnModalSubmit">Submit</a>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $(document).ready(function(){

      $('#DENAME').on('change', function(){
        let DEDEPTIY = $('#DENAME').val();
        let URL = "<?= API_URL ?>?pg="+btoa("sys_subdept")+"&fn="+btoa("getSdptDropDown")+"&id=<?= $this->session->userdata("UIY") ?>&mi="+btoa(DEDEPTIY);

        $.getJSON(URL, function(data){
          let htmlString, dsbld;
          
          if(data.data.length > 1){
            dsbld = "";
          }
          else{
            dsbld = "disabled"
          }
          if(data.sts == "success"){
            htmlString = "<select class='form-control' id='SDNAME'>";
            htmlString += "<option value='0' selected disabled>- - - Choose Sub. Dept - - -</option>";
            for(var i=0; i<data.data.length; i++){
              htmlString += "<option value='"+data.data[i].SDSDPTIY+"' "+dsbld+">"+data.data[i].SDNAME+"</option>";
            }
            htmlString += "</select>";
          }
          else{
            htmlString = `
              <select class='form-control' id='SDNAME' disabled>
                <option value='0'>Error. . .</option>
              </select>
            `;
          }
          $('#SDNAME').replaceWith(htmlString);
        });
      });

      $('#btnAccess').on('click', function(){
        accessAction('add');
      });

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
            accessAction('dlte',id);
          }
        })
      });

      $("a[id^='edtItem']").on('click', function(){
        let id;
        id = $(this).attr('id');
        id = id.split('_');
        id = id[1];
        accessAction('edit',id);
      });

      function accessAction(mode,id=0){
        let url, html, cAdd, cEdt, cViw, cDlt;
        if(mode == 'dlte'){
          url = "<?= API_URL ?>?pg="+btoa("sys_menu")+"&fn="+btoa("updateUserAkses")+"&id=<?= $this->session->userdata("UIY") ?>&md="+btoa("delete");
          data = JSON.stringify({"id": id});
          $.ajax({
            type: "POST",
            url: url,
            data: {"postData" : data},
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
                  text : data.msg
                });
              }
            }
          });
        }
        else if(mode == 'add'){
          let menuDropDown;
          url = "<?= API_URL ?>?pg="+btoa("sys_menu")+"&fn="+btoa("getMenuDropDown")+"&id=<?= $this->session->userdata("UIY") ?>&mi=<?= $dataId ?>";
          $.getJSON(url, function(data){
            if(data.sts == "success"){
              menuDropDown = "<option value='' selected disabled>- - - Choose Menu - - -</option>";
              for(var i=0; i<data.data.length; i++){
                menuDropDown += "<option value='"+data.data[i].MEMENUIY+"'>"+data.data[i].MENAME+"</option>";
              }
            }
            else{
              menuDropDown = "<option value='' selected disabled>- - - Choose Menu - - -</option>";
              menuDropDown += "<option value='' disabled>"+data.msg+"</option>";
            }
            
            html = `
              <div class="modal-body" id="accessModalBody">
                <form role="form">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group row">
                        <label for="MENAME" class="col-sm-2 col-form-label">Menu</label>
                        <div class="col-sm-6">
                          <input type="hidden" class="form-control" id="ACACCSIY" value="">
                          <input type="hidden" class="form-control" id="actType" value="add">
                          <select class="form-control" id="MENAME">
                            `+menuDropDown+`
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" id="ACAADD" value="">
                          <label class="form-check-label text-bold" for="ACAADD">Add</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" id="ACAEDT" value="">
                          <label class="form-check-label text-bold" for="ACAEDT">Edit</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" id="ACAVIW" value="">
                          <label class="form-check-label text-bold" for="ACAVIW">View</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" id="ACADLT" value="">
                          <label class="form-check-label text-bold" for="ACADLT">Delete</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            `;
  
            $('#accessModalBody').replaceWith(html); 
            $('#accessModal').modal('show');
          });
        }
        else{
          url = "<?= API_URL ?>?pg="+btoa("sys_menu")+"&fn="+btoa("getUserAkses")+"&id=<?= $this->session->userdata("UIY") ?>&mi="+btoa(id);
          $.getJSON(url, function(data){
            if(data.sts == "success"){
              cAdd = (data.data.ACAADD == '1') ? 'checked' : '';
              cEdt = (data.data.ACAEDT == '1') ? 'checked' : '';
              cViw = (data.data.ACAVIW == '1') ? 'checked' : '';
              cDlt = (data.data.ACADLT == '1') ? 'checked' : '';
              html = `
                <div class="modal-body" id="accessModalBody">
                  <form role="form">
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="form-group row">
                          <label for="MENAME" class="col-sm-2 col-form-label">Menu</label>
                          <div class="col-sm-6">
                            <input type="hidden" class="form-control" id="actType" value="update">
                            <input type="hidden" class="form-control" id="ACACCSIY" value="`+data.data.ACACCSIY+`">
                            <input type="text" class="form-control" id="MENAME" value="`+data.data.MENAME+`" disabled>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-sm-2"></div>
                          <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" id="ACAADD" value="`+data.data.ACAADD+`" `+cAdd+`>
                          <label class="form-check-label text-bold" for="ACAADD">Add</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" id="ACAEDT" value="`+data.data.ACAEDT+`" `+cEdt+`>
                          <label class="form-check-label text-bold" for="ACAEDT">Edit</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" id="ACAVIW" value="`+data.data.ACAVIW+`" `+cViw+`>
                          <label class="form-check-label text-bold" for="ACAVIW">View</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" id="ACADLT" value="`+data.data.ACADLT+`" `+cDlt+`>
                          <label class="form-check-label text-bold" for="ACADLT">Delete</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              `;
            }
            else{
              html = `
                <div class="modal-body" id="accessModalBody">
                  <h4>`+data.msg+`</h4>
                </div>
              `;
            }
            $('#accessModalBody').replaceWith(html); 
            $('#accessModal').modal('show');
          });
        }
      };

      $('#btnModalSubmit').on('click', function(){
        let id, data, vAdd, vEdt, vViw, vDlt, url, mId, actType;

        id = $('#ACACCSIY').val();
        mId = $('#MENAME').val();
        vAdd = ($('#ACAADD').prop('checked') == true) ? '1' : '0';
        vEdt = ($('#ACAEDT').prop('checked') == true) ? '1' : '0';
        vViw = ($('#ACAVIW').prop('checked') == true) ? '1' : '0';
        vDlt = ($('#ACADLT').prop('checked') == true) ? '1' : '0';
        actType = $('#actType').val();

        if(mId == null || mId == ""){
          Swal.fire({
            icon: "warning",
            title: "Oops...",
            text : "Menu can't be empty"
          });
          return;
        }
        else if(vAdd == '0' && vEdt == '0' && vViw == '0' && vDlt == '0'){
          Swal.fire({
            icon: "warning",
            title: "Oops...",
            text : "Access mode can't be emty, please choose at least an access mode !"
          });
          return;
        }

        url = "<?= API_URL ?>?pg="+btoa("sys_menu")+"&fn="+btoa("updateUserAkses")+"&id=<?= $this->session->userdata("UIY") ?>&md="+btoa(actType);
        data = JSON.stringify({"id": id, "mId": mId, "uId": "<?= $dataId ?>","vAdd": vAdd, "vEdt": vEdt, "vViw": vViw, "vDlt": vDlt});
        $.ajax({
          type: "POST",
          url: url,
          data: {"postData" : data},
          dataType: "json",
          beforeSend : function(){
            $('#accessModal').modal('hide');
          },
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
                text : data.msg
              });              
            }
          },
          error: function(jqXhr,errorThrown,textStatus){
            console.log(textStatus);
          }
        });
      });

      $('#btnSubmit').on('click', function(){
        let nik, flnm, sts, dept, sdept, jabt, remk, data
        nik = $('#USUNIK').val();
        flnm = $('#USFLNM').val();
        sts = $('#USACTV').val();
        dept = $('#DENAME').val();
        sdept = $('#SDNAME').val();
        jabt = $('#JANAME').val();
        remk = $('#USREMK').val();

        url = "<?= API_URL."?pg=".base64_encode("sys_user")."&fn=".base64_encode("updateUser")."&id=".$this->session->userdata("UIY"); ?>";
        data = JSON.stringify({"id": "<?= $dataId?>", "nik": nik, "flnm": flnm, "sts": sts, "dept": dept, "sdept": sdept, "jabt": jabt, "remk": remk});
        $.ajax({
          type: "POST",
          url : url,
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
                  $(location).attr("href","<?= base_url('mst_profile') ?>");
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
      });

    });
  </script>