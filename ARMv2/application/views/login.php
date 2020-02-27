<div class="container-fluid">
  <div class="row">
    <div class="col-md-12 pt-2">
      <a href="./"><img src="<?= base_url("img/logo_color.png") ?>" style="width: 10%"></a>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="row justify-content-center mt-5">
        <h1 class="text-dark"><strong>ARMv2 Login</strong></h1>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-4 px-5 pt-1">
          <form class="user">
            <div class="form-group">
              <input type="text" class="form-control form-control-user" id="userId" aria-describedby="emailHelp" placeholder="Enter your LDAP UID...">
            </div>
            <div class="form-group">
              <input type="password" class="form-control form-control-user" id="userPassword" placeholder="Password">
            </div>
            <button type="button" class="btn btn-primary btn-user btn-block" id="btnLogin">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="loading" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body">
          <center>
            <h1 class="text-dark">Please Wait. . .</h1>
            <img src="<?= base_url("img/loading.gif") ?>" style="height: 10%">
          </center>
        </div>
      </div>
    </div>
</div>

<script src="<?= base_url("assets/adminLTE/plugins/jquery/jquery.min.js") ?>"></script>
<script src="<?= base_url("assets/adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js") ?>"></script>
<script src="<?= base_url("js/swal.js") ?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    
    $('#btnLogin').on('click', function(){
      if($('#userId').val() == ""){
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Please Fill Your Username !'
        });
      }
      else if($('#userPassword').val() == ""){
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Please Fill Your Password !'
        });
      }
      else{
        let uid = $('#userId').val();
        let pas = $('#userPassword').val();
        let userData = JSON.stringify({"uid": uid, "pas":pas, "agt": "<?= $agent ?>", "ops": "<?= $ops ?>", "ips": "<?= $ips ?>"});
        $.ajax({
          type: "POST",
          url: "<?= $url_api ?>",
          data: {"postData": userData},
          dataType: "json",
          beforeSend: function(){
            $('#loading').modal('show');
          },
          success: function(data){
            $('#loading').modal('hide');
            if(data.sts == "success"){

              $(location).attr('href','login?uiy='+btoa(data.data.uiy)+'&uid='+btoa(data.data.uid)+'&eml='+btoa(data.data.eml));
            }
            else{
              Swal.fire({
                icon: data.sts,
                title: "Oops...",
                text: data.msg
              })
            }
          },
          error: function(jqXhr,errorThrown,textStatus){
            console.log(textStatus);
          }
        });
      }
    });
  });
</script>