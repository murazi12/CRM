<?php
$json = json_decode($menuList,1);
$jsonAccss = json_decode($userAccs,1);

if($jsonAccss["data"]["ACAADD"] == '1'){
  $addURL = base_url('mst_menu/menu_add');
  $addDisabled = "disabled";
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
$no = 0;
for($i=0; $i<count($json["data"]); $i++){
  $no++;
  $tbody .= "
    <tr style='background-color: #ededed' class='text-bold'>
      <td class='text-right'>".$no."</td>
      <td>".$json["data"][$i]["MECODE"]."</td>
      <td>".$json["data"][$i]["MENAME"]."</td>
      <td colspan='4'></td>
      <td style='display: none;'></td>
      <td style='display: none;'></td>
      <td style='display: none;'></td>
    </tr>
  ";
  for($j=0; $j<count($json["data"][$i]["submenu"]); $j++){
    $no++;
    $edit = "<a class='dropdown-item ".$edtDisabled."' href='".base_url("mst_menu/menu_act/").$this->url_encode->base64_url_encode("edit")."/".$this->url_encode->base64_url_encode($json["data"][$i]["submenu"][$j]["sMEMENUIY"])."'>Edit</a>";
    $view = "<a class='dropdown-item ".$viwDisabled."' href='".base_url("mst_menu/menu_act/").$this->url_encode->base64_url_encode("view")."/".$this->url_encode->base64_url_encode($json["data"][$i]["submenu"][$j]["sMEMENUIY"])."'>View</a>";
    $dlte = "<a class='dropdown-item ".$dltDisabled."' id='delItem_".$json["data"][$i]["submenu"][$j]["sMEMENUIY"]."' href='#'>Delete</a>";
    $tbody .= "
      <tr>
        <td class='text-right'>".$no."</td>
        <td>".$json["data"][$i]["submenu"][$j]["sMECODE"]."</td>
        <td>".$json["data"][$i]["submenu"][$j]["sMENAME"]."</td>
        <td>".$json["data"][$i]["submenu"][$j]["sMELINK"]."</td>
        <td class='text-right'>".$json["data"][$i]["submenu"][$j]["sMESORT"]."</td>
        <td>".$json["data"][$i]["submenu"][$j]["sMEREMK"]."</td>
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
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Master Menu</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
              <li class="breadcrumb-item active">Master Menur</li>
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
                  <table id="tbl_menu" class="table table-bordered table-hover table-sm nowrap">
                    <thead class="thead-light">
                      <tr>
                        <th width="5%" class="text-right">No</th>
                        <th width="10%">Code</th>
                        <th width="25%">Name</th>
                        <th width="15%">Link</th>
                        <th width="5%">Sort</th>
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
  <!-- /.content-wrapper -->

  <script src="<?= base_url("assets/adminLTE/plugins/datatables/jquery.dataTables.js") ?>"></script>
  <script src="<?= base_url("assets/adminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.js") ?>"></script>
  <script type="text/javascript">
    $("#tbl_menu").DataTable({
      "ordering": false
    });
  </script>