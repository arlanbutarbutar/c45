<nav class="sidebar sidebar-offcanvas shadow" style="background-color: rgb(3, 164, 237);" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='./'">
        <i class="mdi mdi-view-dashboard menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <?php if ($_SESSION['data-user']['role'] == 1) { ?>
      <li class="nav-item nav-category">Kelola Pengguna</li>
      <li class="nav-item">
        <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='users'">
          <i class="mdi mdi-account-multiple-outline menu-icon"></i>
          <span class="menu-title">Users</span>
        </a>
      </li>
    <?php } ?>
    <li class="nav-item nav-category">Data Prodi Arsitektur</li>
    <?php if ($_SESSION['data-user']['role'] == 1) { ?>
      <li class="nav-item">
        <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='data-latih'">
          <i class="mdi mdi-account-multiple-plus menu-icon"></i>
          <span class="menu-title">Dataset Mahasiswa</span>
        </a>
      </li>
    <?php } ?>
    <li class="nav-item">
      <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='data-testing'">
        <i class="mdi mdi-account-multiple-plus menu-icon"></i>
        <span class="menu-title">Data Predict</span>
      </a>
    </li>
    <li class="nav-item nav-category">Algoritma c4.5</li>
    <?php if ($_SESSION['data-user']['role'] == 1) { ?>
      <li class="nav-item">
        <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='atribut'">
          <i class="mdi mdi-database-plus menu-icon"></i>
          <span class="menu-title">Atribut</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='atribut-sub'">
          <i class="mdi mdi-database-plus menu-icon"></i>
          <span class="menu-title">Sub Atribut</span>
        </a>
      </li>
    <?php } ?>
    <li class="nav-item">
      <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='prediksi'">
        <i class="mdi mdi-matrix menu-icon"></i>
        <span class="menu-title">Prediksi</span>
      </a>
    </li>
    <?php if ($_SESSION['data-user']['role'] == 0) { ?>
      <!-- <li class="nav-item">
      <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='laporan'">
        <i class="mdi mdi-file-export menu-icon"></i>
        <span class="menu-title">Laporan</span>
      </a>
    </li> -->
    <?php } ?>
    <li class="nav-item nav-category"></li>
    <?php if ($_SESSION['data-user']['role'] == 0) { ?>
      <!-- <li class="nav-item">
      <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='icons'">
        <i class="mdi mdi-face-profile menu-icon"></i>
        <span class="menu-title">Icons</span>
      </a>
    </li> -->
    <?php } ?>
    <li class="nav-item">
      <a class="nav-link" style="cursor: pointer;" onclick="window.location.href='../auth/signout'">
        <i class="mdi mdi-logout-variant menu-icon"></i>
        <span class="menu-title">Keluar</span>
      </a>
    </li>
  </ul>
</nav>