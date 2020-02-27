<?php
$tbody = "";
$json = json_decode($userList,1);
$jsonAccss = json_decode($userAccs,1);

for($i=0; $i<count($json["data"]); $i++){
  if($jsonAccss["sts"] == "success"){
    $view = ($jsonAccss["data"]["ACAVIW"] == '1') ? "<a class='dropdown-item' href='".base_url("mst_profile/profile_act/").$this->url_encode->base64_url_encode('view')."/".$this->url_encode->base64_url_encode($json["data"][$i]["id"])."'>View</a>" : "<a class='dropdown-item disabled' href='".base_url("mst_profile/profile_act/").$this->url_encode->base64_url_encode('view')."/".$this->url_encode->base64_url_encode($json["data"][$i]["id"])."'>View</a>";
    $edit = ($jsonAccss["data"]["ACAEDT"] == '1') ? "<a class='dropdown-item' href='".base_url("mst_profile/profile_act/").$this->url_encode->base64_url_encode('edit')."/".$this->url_encode->base64_url_encode($json["data"][$i]["id"])."'>Edit</a>" : "<a class='dropdown-item disabled' href='".base_url("mst_profile/profile_act/").$this->url_encode->base64_url_encode('edit')."/".$this->url_encode->base64_url_encode($json["data"][$i]["id"])."'>Edit</a>";
  }
  else{
    $view = "<a class='dropdown-item disabled' href='".base_url("mst_profile/profile_act/").$this->url_encode->base64_url_encode('view')."/".$this->url_encode->base64_url_encode($json["data"][$i]["id"])."'>View</a>";
    $edit = "<a class='dropdown-item disabled' href='".base_url("mst_profile/profile_act/").$this->url_encode->base64_url_encode('edit')."/".$this->url_encode->base64_url_encode($json["data"][$i]["id"])."'>Edit</a>";
  }

  $tbody .= "
    <tr>
      <td class='text-right'>".($i+1)."</td>
      <td>".$json["data"][$i]["USUNIK"]."</td>
      <td>".$json["data"][$i]["USUSNM"]."</td>
      <td>".$json["data"][$i]["USMAIL"]."</td>
      <td>".$json["data"][$i]["USREMK"]."</td>
      <td class='text-center'>
        <a href='#' role='button' id='dropdownMenuLink' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><i class='fas fa-cogs'></i></a>
        <div class='dropdown-menu' aria-labelledby='dropdownMenuLink'>
          ".$view."
          ".$edit."
        </div>
      </td>
    </tr>
  ";
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
              <li class="breadcrumb-item active">Master User</li>
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
            <a href='./' class="btn btn-primary float-sm-right disabled"><i class="fas fa-plus"></i>&nbsp;Add</a>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-hover table-sm nowrap">
                    <thead class="thead-light">
                      <tr>
                        <th width="5%" class="text-right">No</th>
                        <th>NIK</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Remark</th>
                        <th class="text-center">Action</th>
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
  <!-- /.content-wrapper -->

  <!-- DataTables -->
  <script src="<?= base_url("assets/adminLTE/plugins/datatables/jquery.dataTables.js") ?>"></script>
  <script src="<?= base_url("assets/adminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.js") ?>"></script>
  <script type="text/javascript">
    $("#example1").DataTable({
      "ordering": false
    });
  </script>