<?php require_once("../controller/script.php");
require_once("redirect.php");
require_once("c45.php");

$_SESSION["page-name"] = "Prediksi";
$_SESSION["page-url"] = "prediksi";
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
          <div class="row">
            <div class="col-sm-12">
              <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <h3>Prediksi</h3>
                    </li>
                  </ul>
                </div>
                <div class="data-main">
                  <div class="accordion mt-3" id="accordionExample">

                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingOne">
                        <!-- collapsed -->
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#perhitungan" aria-expanded="false" aria-controls="perhitungan">
                          Perhitungan
                        </button>
                      </h2>
                      <div id="perhitungan" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                          <pre>
                            <?php
                            $query = "SELECT * FROM atribut_latih INNER JOIN atribut ON atribut_latih.id_atribut=atribut.id_atribut INNER JOIN atribut_sub ON atribut_latih.id_atribut_sub=atribut_sub.id_atribut_sub ORDER BY atribut_latih.id_latih, atribut.id_atribut";
                            $dataset = mysqli_query($conn, $query);
                            $data = array();
                            foreach ($dataset as $row_latih) {
                              $data[$row_latih['id_latih']][$row_latih['atribut']] = $row_latih['atribut_sub'];
                            }
                            $data = array_values($data);

                            function get_atribut($atribute)
                            {
                              $rows = $atribute;
                              foreach ($rows as $row) {
                                $ATRIBUT[$row['id_atribut']] = $row['atribut'];
                              }

                              end($ATRIBUT);
                              reset($ATRIBUT);
                              return $ATRIBUT;
                            }

                            $atribut_data = "SELECT * FROM atribut";
                            $atributData = mysqli_query($conn, $atribut_data);
                            $atribut = get_atribut($atributData);

                            $last_atribut = "SELECT * FROM atribut ORDER BY id_atribut DESC LIMIT 1";
                            $lastAtribut = mysqli_query($conn, $last_atribut);
                            $row_lastAtribut = mysqli_fetch_assoc($lastAtribut);
                            $target = $row_lastAtribut['atribut'];

                            $c45 = new c45($data, $atribut, $target, true);
                            ?>
                          </pre>
                        </div>
                      </div>
                    </div>

                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#decision-tree" aria-expanded="false" aria-controls="decision-tree">
                          Decision Tree
                        </button>
                      </h2>
                      <div id="decision-tree" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                          <pre>
                            <?php
                            $c45->display();
                            ?>
                          </pre>
                        </div>
                      </div>
                    </div>

                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button <?php if (!isset($_SESSION['prediksi'])) {
                                                          echo "collapsed";
                                                        } ?>" type="button" data-bs-toggle="collapse" data-bs-target="#prediksi" aria-expanded="false" aria-controls="prediksi">
                          Prediksi
                        </button>
                      </h2>
                      <div id="prediksi" class="accordion-collapse collapse <?php if (isset($_SESSION['prediksi'])) {
                                                                              echo "show";
                                                                            } ?>" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                          <?php if (!isset($_SESSION['prediksi'])) { ?>
                            <form action="" method="post">
                              <div class="mb-3">
                                <label for="nim" class="form-label">NIM <small class="text-danger">*</small></label>
                                <input type="number" name="nim" value="<?php if (isset($_POST['nim'])) {
                                                                          echo $_POST['nim'];
                                                                        } ?>" class="form-control text-center" id="nim" minlength="3" placeholder="NIM" required>
                              </div>
                              <div class="mb-3">
                                <label for="nama" class="form-label">Nama <small class="text-danger">*</small></label>
                                <input type="text" name="nama" value="<?php if (isset($_POST['nama'])) {
                                                                        echo $_POST['nama'];
                                                                      } ?>" class="form-control text-center" id="nama" placeholder="Nama" required>
                              </div>
                              <?php if (mysqli_num_rows($jenisKelamin2) > 0) { ?>
                                <div class="mb-3">
                                  <label for="id_jenis_kelamin" class="form-label">Jenis Kelamin <small class="text-danger">*</small></label>
                                  <select name="id_jenis_kelamin" id="id_jenis_kelamin" class="form-select" aria-label="Default select example" required>
                                    <option selected value="">Pilih Jenis Kelamin</option>
                                    <?php while ($row_jk = mysqli_fetch_assoc($jenisKelamin2)) { ?>
                                      <option value="<?= $row_jk['id_atribut_sub'] ?>"><?= $row_jk['atribut_sub'] ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              <?php }
                              foreach ($statusIPK as $key_ipk => $row_ipk) : ?>
                                <div class="mb-3">
                                  <label for="nilai_ipk" class="form-label">Nilai IPK <?= $row_ipk['status_ipk'] ?> <small class="text-danger">*</small></label>
                                  <input type="number" step="0.01" min="0" name="nilai_ipk[]" value="<?php if (isset($_POST['nilai_ipk'][$key_ipk])) {
                                                                                                        echo $_POST['nilai_ipk'][$key_ipk];
                                                                                                      } else {
                                                                                                        echo 0;
                                                                                                      } ?>" class="form-control text-center" id="nilai_ipk" placeholder="Nilai IPK <?= $row_ipk['status_ipk'] ?>" required>
                                </div>
                              <?php endforeach;
                              foreach ($statusSPA as $key_spa => $row_spa) : ?>
                                <div class="mb-3">
                                  <label for="nilai_spa" class="form-label">Nilai SPA <?= $row_spa['status_spa'] ?> <small class="text-danger">*</small></label>
                                  <input type="number" step="0.01" min="0" name="nilai_spa[]" value="<?php if (isset($_POST['nilai_spa'][$key_spa])) {
                                                                                                        echo $_POST['nilai_spa'][$key_spa];
                                                                                                      } else {
                                                                                                        echo 0;
                                                                                                      } ?>" class="form-control text-center" id="nilai_spa" placeholder="Nilai SPA <?= $row_spa['status_spa'] ?>" required>
                                </div>
                              <?php endforeach; ?>
                              <div class="mb-3">
                                <button type="submit" name="prediksi-checking" class="btn btn-primary btn-sm rounded-0 border-0">Submit</button>
                              </div>
                            </form>
                          <?php } else if (isset($_SESSION['prediksi'])) { ?>
                            <div class="col-lg-6">
                              <p><strong>Nama : </strong><?= $_SESSION['prediksi']['nama'] ?></p>
                              <p><strong>Jenis Kelamin : </strong><?= $_SESSION['prediksi']['jk'] ?></p>
                              <p><strong>IPK : </strong><?= $_SESSION['prediksi']['ipk'] ?></p>
                              <p><strong>SPA : </strong><?= $_SESSION['prediksi']['spa'] ?></p>
                              <p><strong>Hasil Prediksi : <span style="font-size: 16px;"><?= $_SESSION['prediksi']['hasil_prediksi'] ?></span></strong></p>
                              <form action="" method="post">
                                <button type="submit" name="reload-prediksi" class="btn btn-success btn-sm border-0 rounded-0 shadow"><i class="mdi mdi-reload"></i></button>
                              </form>
                            </div>
                          <?php } ?>
                        </div>
                      </div>
                    </div>

                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#hasil-prediksi" aria-expanded="false" aria-controls="hasil-prediksi">
                          Hasil Prediksi
                        </button>
                      </h2>
                      <div id="hasil-prediksi" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body table-responsive">
                          <button type="button" class="btn btn-success btn-success rounded-0 text-white" data-bs-toggle="modal" data-bs-target="#export">
                            <i class="bi bi-download"></i> Export
                          </button>
                          <div class="modal fade" id="export" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <div class="modal-header border-bottom-0 shadow">
                                  <h5 class="modal-title" id="exampleModalLabel">Export</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <div class="row">
                                    <div class="col-lg-4">
                                      <div class="card border-0 rounded-0">
                                        <div class="card-body">
                                          <h5 class="card-title">Lulus Tepat dan Tidak Tepat</h5>
                                          <a href="export-lttt" class="btn btn-primary border-0 rounded-0 text-white" target="_blank">Export</a>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-lg-4">
                                      <div class="card border-0 rounded-0">
                                        <div class="card-body">
                                          <h5 class="card-title">Lulus Tepat</h5>
                                          <a href="export-lt" class="btn btn-primary border-0 rounded-0 text-white" target="_blank">Export</a>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-lg-4">
                                      <div class="card border-0 rounded-0">
                                        <div class="card-body">
                                          <h5 class="card-title">Tidak Tepat</h5>
                                          <a href="export-tt" class="btn btn-primary border-0 rounded-0 text-white" target="_blank">Export</a>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <table class="table table-bordered table-striped table-hover table-sm display" id="datatable">
                            <thead>
                              <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col" class="text-center">Nama</th>
                                <?php foreach ($atributs as $key => $val) : ?>
                                  <th scope="col" class="text-center" rowspan="2"><?= str_replace("_", " ", $val['atribut']) ?></th>
                                <?php endforeach; ?>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $data_prediksi = mysqli_query($conn, "SELECT * FROM data_testing ORDER BY id_testing DESC");
                              if (mysqli_num_rows($data_prediksi) > 0) {
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($data_prediksi)) {
                                  $id_testing = $row['id_testing']; ?>
                                  <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row["nama"] ?></td>
                                    <?php $atribut_sub_view = "SELECT atribut_sub.atribut_sub FROM atribut_testing JOIN atribut_sub ON atribut_testing.id_atribut_sub=atribut_sub.id_atribut_sub WHERE atribut_testing.id_testing='$id_testing' ORDER BY atribut_testing.id_testing DESC";
                                    $atributSubView = mysqli_query($conn, $atribut_sub_view);
                                    foreach ($atributSubView as $row_atribut_sub_view) :
                                      $atribut_sub = $row_atribut_sub_view['atribut_sub']; ?>
                                      <td><?= $atribut_sub ?></td>
                                    <?php endforeach; ?>
                                  </tr>
                              <?php }
                              } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>

                    <div class="accordion-item">
                      <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#hasil-akurasi" aria-expanded="false" aria-controls="hasil-akurasi">
                          Hasil Akurasi
                        </button>
                      </h2>
                      <div id="hasil-akurasi" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body table-responsive">
                          <!-- Start => Perhitungan akurasi -->
                          <?php
                          $data_tp = mysqli_query($conn, "SELECT * FROM atribut_sub 
                                                                    JOIN atribut_testing ON atribut_sub.id_atribut_sub=atribut_testing.id_atribut_sub 
                                                                    JOIN data_testing ON atribut_testing.id_testing=data_testing.id_testing 
                                                                    WHERE atribut_sub.atribut_sub='Lulus Tepat'
                                                          ");
                          $tp = mysqli_num_rows($data_tp);
                          $data_tn = mysqli_query($conn, "SELECT * FROM atribut_sub 
                                                                    JOIN atribut_testing ON atribut_sub.id_atribut_sub=atribut_testing.id_atribut_sub 
                                                                    JOIN data_testing ON atribut_testing.id_testing=data_testing.id_testing 
                                                                    WHERE atribut_sub.atribut_sub='Tidak Tepat'
                                                          ");
                          $tn = mysqli_num_rows($data_tn);
                          $data_fp = mysqli_query($conn, "SELECT * FROM atribut_sub 
                                                                    JOIN atribut_testing ON atribut_sub.id_atribut_sub=atribut_testing.id_atribut_sub 
                                                                    JOIN data_testing ON atribut_testing.id_testing=data_testing.id_testing 
                                                                    WHERE atribut_sub.atribut_sub='Lulus Tepat'
                                                                    AND atribut_sub.atribut_sub='D'
                                                          ");
                          $fp = mysqli_num_rows($data_fp);
                          $data_fn = mysqli_query($conn, "SELECT * FROM atribut_sub 
                                                                    JOIN atribut_testing ON atribut_sub.id_atribut_sub=atribut_testing.id_atribut_sub 
                                                                    JOIN data_testing ON atribut_testing.id_testing=data_testing.id_testing 
                                                                    WHERE atribut_sub.atribut_sub='Tidak Tepat'
                                                                    AND atribut_sub.atribut_sub!='D'
                                                          ");
                          $fn = mysqli_num_rows($data_fn);

                          $akurasi = ($tp + $tn) / ($tp + $tn + $fp + $fn) * 100;
                          $presisi = ($tp / ($fp + $tp)) * 100;
                          $recall = ($tp / ($fn + $tp)) * 100;

                          echo "<strong>Akurasi:</strong> <br>(TP + TN) / (TP + TN + FP + FN) x 100% <br>";
                          echo "(" . $tp . " + " . $tn . ") / (" . $tp . " + " . $tn . " + " . $fp . " + " . $fn . ") x 100% <br>";
                          echo "Hasil akurasi: $akurasi <br>";
                          echo "<strong>Presisi:</strong> <br>(TP / (FP + TP)) x 100% <br>";
                          echo "(" . $tp . " / (" . $fp . " + " . $tp . ")) x 100% <br>";
                          echo "Hasil presisi: $presisi <br>";
                          echo "<strong>Recall:</strong> <br>(TP / (FN + TP)) x 100% <br>";
                          echo "(" . $tp . " / (" . $fn . " + " . $tp . ")) x 100% <br>";
                          echo "Hasil recall: $recall <br>";
                          echo "<br>";
                          echo "<strong>Keterangan:</strong> <br>";
                          echo "True Positif(TP)=> Lulus tepat waktu <br>";
                          echo "True Negatif(TN)=> Tidak lulus tepat waktu <br>";
                          echo "False Positive(FP)=> Mahasiswa diprediksi lulus tepat, ternyata tidak tepat prediksi salah(false) <br>";
                          echo "False Negatif(FN)=> Mahasiswa tidak lulus tepat waktu, tapi ternyata lulus(true) prediksi salah (false) <br>";
                          echo "<br>";
                          ?>
                          <!-- End => Perhitungan akurasi -->
                          <table class="table table-bordered table-striped table-hover table-sm display" id="datatable">
                            <thead>
                              <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col" class="text-center">Nama</th>
                                <?php foreach ($atributs as $key => $val) : ?>
                                  <th scope="col" class="text-center" rowspan="2"><?= str_replace("_", " ", $val['atribut']) ?></th>
                                <?php endforeach; ?>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $data_prediksi = mysqli_query($conn, "SELECT * FROM data_testing ORDER BY id_testing DESC");
                              if (mysqli_num_rows($data_prediksi) > 0) {
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($data_prediksi)) {
                                  $id_testing = $row['id_testing']; ?>
                                  <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row["nama"] ?></td>
                                    <?php $atribut_sub_view = "SELECT atribut_sub.atribut_sub FROM atribut_testing JOIN atribut_sub ON atribut_testing.id_atribut_sub=atribut_sub.id_atribut_sub WHERE atribut_testing.id_testing='$id_testing' ORDER BY atribut_testing.id_testing DESC";
                                    $atributSubView = mysqli_query($conn, $atribut_sub_view);
                                    foreach ($atributSubView as $row_atribut_sub_view) :
                                      $atribut_sub = $row_atribut_sub_view['atribut_sub']; ?>
                                      <td><?= $atribut_sub ?></td>
                                    <?php endforeach; ?>
                                  </tr>
                              <?php }
                              } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php require_once("../resources/dash-footer.php") ?>
</body>

</html>