<?php require_once("../controller/script.php");
require_once("redirect.php");
$_SESSION["page-name"] = "IMG Beranda";
$_SESSION["page-url"] = "img-beranda";
?>

<!DOCTYPE html>
<html lang="en">

<head><?php require_once("../resources/dash-header.php") ?></head>

<body>
  <?php if (isset($_SESSION["message-success"])) { ?>
    <div class="message-success" data-message-success="<?= $_SESSION["message-success"] ?>"></div>
  <?php }
  if (isset($_SESSION["message-info"])) { ?>
    <div class="message-info" data-message-info="<?= $_SESSION["message-info"] ?>"></div>
  <?php }
  if (isset($_SESSION["message-warning"])) { ?>
    <div class="message-warning" data-message-warning="<?= $_SESSION["message-warning"] ?>"></div>
  <?php }
  if (isset($_SESSION["message-danger"])) { ?>
    <div class="message-danger" data-message-danger="<?= $_SESSION["message-danger"] ?>"></div>
  <?php } ?>
  <div class="container-scroller">
    <?php require_once("../resources/dash-topbar.php") ?>
    <div class="container-fluid page-body-wrapper">
      <?php require_once("../resources/dash-sidebar.php") ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row flex-row-reverse">
            <div class="col-lg-4">
              <div class="card rounded-0">
                <div class="card-body text-center">
                  <h2>Ubah Image</h2>
                  <!--begin::Action-->
                  <div class="text-center" id="drop-area">
                    <form action="" method="post" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="images">Drag and Drop here:</label>
                        <input type="file" class="form-control-file d-none" id="images" name="images[]" multiple>
                      </div>
                      <div class="form-group shadow mb-3" style="height: 200px;">
                        <div id="fileList"></div>
                      </div>
                      <button type="submit" name="tambah-beranda" class="btn btn-primary border-0 btn-sm rounded-0">Upload</button>
                    </form>
                  </div>
                  <!--end::Action-->
                </div>
              </div>
            </div>
            <div class="col-lg-8">
              <div class="card rounded-0">
                <div class="card-body">
                  <h2>Image</h2>
                  <!--begin::Images content-->
                  <div class="d-flex flex-wrap justify-content-between">
                    <?php if (mysqli_num_rows($views_image) > 0) {
                      while ($row = mysqli_fetch_assoc($views_image)) { ?>
                        <form action="" method="post">
                          <img src="../assets/images/beranda/<?= $row['image'] ?>" class="img-thumbnail" style="width: 100%; height: 200px; object-fit: cover;" alt="">
                          <input type="hidden" name="id" value="<?= $row['id'] ?>">
                          <input type="hidden" name="image" value="<?= $row['image'] ?>">
                          <button type="submit" name="hapus-beranda" class="btn btn-danger btn-sm" style="margin-top: -200px;margin-left: 0px;border-top-left-radius: 0px;border-bottom-left-radius: 0px;"><i class="bi bi-trash3"></i></button>
                        </form>
                    <?php }
                    } ?>
                  </div>
                  <!--end::Images content-->
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php require_once("../resources/dash-footer.php") ?>
        <script>
          const dropArea = document.querySelector("#drop-area");
          const input = document.querySelector("#images");

          dropArea.addEventListener("dragover", function(e) {
            e.preventDefault();
          });

          dropArea.addEventListener("drop", function(e) {
            e.preventDefault();
            input.files = e.dataTransfer.files;

            var files = input.files,
              filesLength = files.length;
            for (var i = 0; i < filesLength; i++) {
              var file = files[i];
              var fileName = file.name;
              var list = document.createElement("li");
              list.innerHTML = fileName;
              document.querySelector("#fileList").appendChild(list);
            }
          });

          input.addEventListener("change", function(e) {
            var files = e.target.files,
              filesLength = files.length;
            for (var i = 0; i < filesLength; i++) {
              var file = files[i];
              var fileName = file.name;
              var list = document.createElement("li");
              list.innerHTML = fileName;
              document.querySelector("#fileList").appendChild(list);
            }
          });
        </script>
</body>

</html>