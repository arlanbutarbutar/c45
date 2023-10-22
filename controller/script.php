<?php if (!isset($_SESSION[""])) {
  session_start();
}
error_reporting(~E_NOTICE & ~E_DEPRECATED);
require_once("db_connect.php");
require_once("functions.php");
if (isset($_SESSION["time-message"])) {
  if ((time() - $_SESSION["time-message"]) > 2) {
    if (isset($_SESSION["message-success"])) {
      unset($_SESSION["message-success"]);
    }
    if (isset($_SESSION["message-info"])) {
      unset($_SESSION["message-info"]);
    }
    if (isset($_SESSION["message-warning"])) {
      unset($_SESSION["message-warning"]);
    }
    if (isset($_SESSION["message-danger"])) {
      unset($_SESSION["message-danger"]);
    }
    if (isset($_SESSION["message-dark"])) {
      unset($_SESSION["message-dark"]);
    }
    unset($_SESSION["time-alert"]);
  }
}

$baseURL = "http://$_SERVER[HTTP_HOST]/apps/data-mining-c45/";

if (!isset($_SESSION["data-user"])) {
  if (isset($_POST["masuk"])) {
    if (masuk($_POST) > 0) {
      header("Location: ../views/");
      exit();
    }
  }
}

if (isset($_SESSION["data-user"])) {
  $idUser = valid($_SESSION["data-user"]["id"]);

  $profile = mysqli_query($conn, "SELECT * FROM users WHERE id_user='$idUser'");
  if (isset($_POST["ubah-profile"])) {
    if (edit_profile($_POST) > 0) {
      $_SESSION["message-success"] = "Profil akun anda berhasil di ubah.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }

  $users = mysqli_query($conn, "SELECT users.*, users_role.role FROM users JOIN users_role ON users.id_role=users_role.id_role WHERE users.id_user!='$idUser'");
  $users_role = mysqli_query($conn, "SELECT * FROM users_role");
  if (isset($_POST["tambah-user"])) {
    if (add_user($_POST) > 0) {
      $_SESSION["message-success"] = "Pengguna " . $_POST["username"] . " berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }
  if (isset($_POST["ubah-user"])) {
    if (edit_user($_POST) > 0) {
      $_SESSION["message-success"] = "Pengguna " . $_POST["usernameOld"] . " berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }
  if (isset($_POST["hapus-user"])) {
    if (delete_user($_POST) > 0) {
      $_SESSION["message-success"] = "Pengguna " . $_POST["username"] . " berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }

  $overview = mysqli_query($conn, "SELECT * FROM overview");
  if (isset($_POST["overview"])) {
    if (overview($_POST) > 0) {
      $_SESSION["message-success"] = "Data overview berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }

  $atribut = "SELECT * FROM atribut";
  $atributs = mysqli_query($conn, $atribut);
  if (isset($_POST["tambah-atribut"])) {
    if (add_atribut($_POST) > 0) {
      $_SESSION["message-success"] = "Data atribut berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }
  if (isset($_POST["ubah-atribut"])) {
    if (edit_atribut($_POST) > 0) {
      $_SESSION["message-success"] = "Data atribut berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }
  if (isset($_POST["hapus-atribut"])) {
    if (delete_atribut($_POST) > 0) {
      $_SESSION["message-success"] = "Data atribut berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }

  $atribut_sub = "SELECT atribut_sub.*, atribut.atribut FROM atribut_sub JOIN atribut ON atribut_sub.id_atribut=atribut.id_atribut";
  $atribut_subs = mysqli_query($conn, $atribut_sub);
  if (isset($_POST["tambah-atribut-sub"])) {
    if (add_atribut_sub($_POST) > 0) {
      $_SESSION["message-success"] = "Data sub atribut berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }
  if (isset($_POST["ubah-atribut-sub"])) {
    if (edit_atribut_sub($_POST) > 0) {
      $_SESSION["message-success"] = "Data sub atribut berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }
  if (isset($_POST["hapus-atribut-sub"])) {
    if (delete_atribut_sub($_POST) > 0) {
      $_SESSION["message-success"] = "Data sub atribut berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }

  $jenis_kelamin = "SELECT atribut_sub.* FROM atribut JOIN atribut_sub ON atribut.id_atribut=atribut_sub.id_atribut WHERE atribut.atribut LIKE '%jenis_kelamin%'";
  $jenisKelamin2 = mysqli_query($conn, $jenis_kelamin);
  $status_ipk = "SELECT * FROM status_ipk";
  $statusIPK = mysqli_query($conn, $status_ipk);
  $status_spa = "SELECT * FROM status_spa";
  $statusSPA = mysqli_query($conn, $status_spa);

  $data_latih = mysqli_query($conn, "SELECT * FROM data_latih");
  if (isset($_POST["import-latih"])) {
    $targetDir = "../assets/document/data-latih/";
    $targetFile = $targetDir . basename($_FILES["excelFile"]["name"]);
    $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);
    if ($fileType != "xlsx" && $fileType != "xls") {
      $_SESSION["message-success"] = "Hanya file Excel yang diizinkan.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
    if (move_uploaded_file($_FILES["excelFile"]["tmp_name"], $targetFile)) {
      if (import_latih($targetFile) > 0) {
        $_SESSION["message-success"] = "Data latih berhasil ditambahkan.";
        $_SESSION["time-message"] = time();
        header("Location: " . $_SESSION["page-url"]);
        exit();
      }
    }
  }
  if (isset($_POST["tambah-latih"])) {
    if (add_latih($_POST) > 0) {
      $_SESSION["message-success"] = "Data latih berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }
  if (isset($_POST["ubah-latih"])) {
    if (edit_latih($_POST) > 0) {
      $_SESSION["message-success"] = "Data latih berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }
  if (isset($_POST["hapus-latih"])) {
    if (delete_latih($_POST) > 0) {
      $_SESSION["message-success"] = "Data latih berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }

  $data_testing = mysqli_query($conn, "SELECT * FROM data_testing");
  if (isset($_POST["tambah-testing"])) {
    if (add_testing($_POST) > 0) {
      $_SESSION["message-success"] = "Data predict berhasil ditambahkan.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }
  if (isset($_POST["ubah-testing"])) {
    if (edit_testing($_POST) > 0) {
      $_SESSION["message-success"] = "Data predict berhasil diubah.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }
  if (isset($_POST["hapus-testing"])) {
    if (delete_testing($_POST) > 0) {
      $_SESSION["message-success"] = "Data predict berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }

  $data_prediksi = mysqli_query($conn, "SELECT * FROM atribut_testing INNER JOIN atribut_sub ON atribut_testing.id_atribut_sub=atribut_sub.id_atribut_sub INNER JOIN atribut ON atribut_sub.id_atribut=atribut.id_atribut");

  if (isset($_POST["prediksi-checking"])) {
    if (prediksi_checking($_POST) > 0) {
      $_SESSION["message-success"] = "Data berhasil diprediksi.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }
  if (isset($_POST["reload-prediksi"])) {
    unset($_SESSION['prediksi']);
    header("Location: " . $_SESSION["page-url"]);
    exit();
  }

  if (isset($_POST["delete-all-latih"])) {
    if (delete_all_latih($_POST) > 0) {
      $_SESSION["message-success"] = "Semua data latih mahasiswa berhasil dihapus.";
      $_SESSION["time-message"] = time();
      header("Location: " . $_SESSION["page-url"]);
      exit();
    }
  }
}
