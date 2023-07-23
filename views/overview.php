<?php require_once("../controller/script.php"); ?>
<script src="../assets/ckeditor/ckeditor.js"></script>

<div class="row">
  <div class="col-md-10">
    <?php foreach ($overview as $row) : ?>
      <div class="card border-0 rounded-0 shadow mt-3">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <div class="col-lg-11">
              <?php if (empty($row['judul'])) {
                echo "<small>belum ada judul/teks disini!</small>";
              } else {
                echo "<h2>" . $row['judul'] . "</h2>";
              } ?>
            </div>
            <?php if ($_SESSION['data-user']['role'] == 1) { ?>
              <div class="col-lg-1">
                <button type="button" class="btn btn-link text-warning btn-sm border-0 text-decoration-none p-0" data-bs-toggle="modal" data-bs-target="#ubah">
                  <i class="mdi mdi-pencil"></i> Ubah
                </button>
                <div class="modal fade" id="ubah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header border-bottom-0 shadow">
                        <h5 class="modal-title" id="exampleModalLabel">Ubah Overview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="" method="post" name="random_form">
                        <div class="modal-body text-center">
                          <div class="mb-3">
                            <label for="judul" class="form-label">Judul <small class="text-danger">*</small></label>
                            <input type="text" name="judul" value="<?= $row['judul'] ?>" class="form-control text-center" id="judul" minlength="3" placeholder="Judul" required>
                          </div>
                          <div class="mb-3">
                            <label for="konten" class="form-label">Konten/Isi <small class="text-danger">*</small></label>
                            <textarea name="konten" id="konten" class="form-control" cols="30" rows="10"><?= $row['konten'] ?></textarea>
                          </div>
                        </div>
                        <div class="modal-footer border-top-0 justify-content-center">
                          <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Batal</button>
                          <button type="submit" name="overview" class="btn btn-primary btn-sm rounded-0 border-0 text-white">Ubah</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="card-body">
          <?= $row['konten'] ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script src="../assets/datatable/datatables.js"></script>
<script>
  CKEDITOR.replace('konten');
</script>
<script>
  $(document).ready(function() {
    $("#datatable").DataTable();
  });
</script>
<script>
  (function() {
    function scrollH(e) {
      e.preventDefault();
      e = window.event || e;
      let delta = Math.max(-1, Math.min(1, (e.wheelDelta || -e.detail)));
      document.querySelector(".table-responsive").scrollLeft -= (delta * 40);
    }
    if (document.querySelector(".table-responsive").addEventListener) {
      document.querySelector(".table-responsive").addEventListener("mousewheel", scrollH, false);
      document.querySelector(".table-responsive").addEventListener("DOMMouseScroll", scrollH, false);
    }
  })();
</script>