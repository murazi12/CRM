<?php
$json = json_decode($menuDtil,1);
$disabled = ($mod == "view") ? 'disabled' : '';
$btnSubmit = ($mod == "view") ? '' : "<button id='btnSubmit' class='btn btn-success float-right'>Submit</button>";

if($json["sts"] == "success"){
  $MEMENUIY = $json["data"]["MEMENUIY"];
  $MECODE = $json["data"]["MECODE"];
  $MENAME = $json["data"]["MENAME"];
  $MELINK = $json["data"]["MELINK"];
  $MEREMK = $json["data"]["MEREMK"];
  $MEACTV = $json["data"]["MEACTV"];
  $textMEACTV = ($MEACTV == '1' ? 'Active' : 'Non Active');

  $stsDropDown = "<option value='' disabled>Status</option>";
  $stsDropDown .= ($MEACTV == '1') ? "<option value='1' selected>Active</option>" : "<option value='1'>Active</option>";
  $stsDropDown .= ($MEACTV == '0') ? "<option value='0' selected>Non Active</option>" : "<option value='0'>Non Active</option>";

}
else{
  $MEMENUIY = "error";
  $MECODE = "error";
  $MENAME = "error";
  $MELINK = "error";
  $MEREMK = "error";
  $MEACTV = "error";
  $textMEACTV = "error";
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
              <li class="breadcrumb-item"><a href="<?= base_url("mst_menu") ?>">Master Menu</a></li>
              <li class="breadcrumb-item active"><?= ucfirst($mod) ?> Menu</li>
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
                    <label for="MEMENUIY" class="col-sm-2 col-form-label">Code</label>
                    <div class="col-sm-3">
                      <input type="hidden" class="form-control" id="MEMENUIY" value="<?= $MEMENUIY ?>">
                      <input type="text" class="form-control" id="MECODE" value="<?= $MECODE ?>" disabled>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="MENAME" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="MENAME" value="<?= $MENAME ?>" <?= $disabled ?>>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="MELINK" class="col-sm-2 col-form-label">Link</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" id="MELINK" value="<?= $MELINK ?>" disabled>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group row">
                    <label for="MEACTV" class="col-sm-3 col-form-label">Status</label>
                    <div class="col-sm-4">
                      <select class="form-control" id="MEACTV" <?= $disabled ?>>
                        <?= $stsDropDown ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="MEREMK" class="col-sm-3 col-form-label">Remark</label>
                    <div class="col-sm-8">
                      <textarea class="form-control" rows="3" id="MEREMK" <?= $disabled ?>><?= $MEREMK ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-6">
            <a href="<?= base_url("mst_menu") ?>" class="btn btn-danger">Back</a>
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
        id = $('#MEMENUIY').val();
        name = $('#MENAME').val();
        sts = $('#MEACTV').val();
        remk = $('#MEREMK').val();

        url = "<?= API_URL ?>?pg="+btoa('sys_menu')+"&fn="+btoa('updateMenu')+"&id=<?= $this->session->userdata("UIY") ?>";
        data = JSON.stringify({"id": id, "name": name, "sts": sts, "remk": remk});
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
                  $(location).attr("href","<?= base_url('mst_menu') ?>");
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