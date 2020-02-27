<?php
$menuNav = "";
$json = json_decode($menu,1);

if($json["sts"] == "success"){
  for($i=0; $i<count($json["menu"]); $i++){
    if(array_key_exists("child", $json["menu"][$i])){
      $menuNav .= "
        <li class='nav-item has-treeview'>
          <a href='#' class='nav-link'>
            <i class='nav-icon fas fa-ellipsis-v'></i>

            <p>".$json["menu"][$i][0]["pMenuName"]."<i class='right fas fa-angle-left'></i></p>
          </a>
          <ul class='nav nav-treeview'>
      ";
      for($j=0; $j<count($json["menu"][$i]["child"]); $j++){
        $menuNav .= "
          <li class='nav-item'>
            <a href='".base_url($json["menu"][$i]["child"][$j]["sMenuLink"])."' class='nav-link'>
              <i class='fas fa-angle-right nav-icon'></i>
              <p>".$json["menu"][$i]["child"][$j]["sMenuName"]."</p>
            </a>
          </li>
        ";
      }
      $menuNav .= "</ul>";
    }
    else{
      $menuNav .= "
        <li class='nav-item'>
          <a href='./' class='nav-link'>
            <i class='nav-icon fas fa-home'></i>
            <p>Home</p>
          </a>
        </li>
      ";
    }
  }
}
else{
  $menuNav .= "<li class='nav-item'>&nbsp;".$menu["msg"]."</li>";
}
?>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4" style="background-color: #ededed">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <center><a href="<?= base_url() ?>"><img src="<?= base_url("img/logo_color.png") ?>" class="img-brand" alt="logo" style="width: 75%; background-color: transparent;"></a></center>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?= base_url() ?>" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>Home</p>
            </a>
          </li>
          <?= $menuNav ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>