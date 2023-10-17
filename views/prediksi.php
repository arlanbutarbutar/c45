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
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#perhitungan" aria-expanded="false" aria-controls="perhitungan">
                          Perhitungan
                        </button>
                      </h2>
                      <div id="perhitungan" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                          <pre>
                            <?php
                            $put_atribut = "SELECT * FROM atribut";
                            $putAtribut = mysqli_query($conn, $put_atribut);
                            $data_arrayAtribut = array();
                            foreach ($putAtribut as $row_put_atribut) {
                              $data_arrayAtribut[] = $row_put_atribut['atribut'];
                            }

                            $data_atribut_latih = "SELECT atribut_latih.*, atribut_sub.atribut_sub FROM atribut_latih JOIN atribut_sub ON atribut_latih.id_atribut_sub=atribut_sub.id_atribut_sub";
                            $dataAtributLatih = mysqli_query($conn, $data_atribut_latih);
                            $data_arrayAtributLatih = array();
                            foreach ($dataAtributLatih as $row_atribut_latih) {
                              $data_arrayAtributLatih[$row_atribut_latih['id_latih']][] = $row_atribut_latih['atribut_sub'];
                            }

                            $query = "SELECT * FROM data_latih";
                            $result = mysqli_query($conn, $query);
                            $data = array();
                            while ($row_latih = mysqli_fetch_assoc($result)) {
                              $data[] = array(
                                $data_arrayAtribut[0] => $data_arrayAtributLatih[$row_latih['id_latih']][0],
                                $data_arrayAtribut[1] => $data_arrayAtributLatih[$row_latih['id_latih']][1],
                                $data_arrayAtribut[2] => $data_arrayAtributLatih[$row_latih['id_latih']][2],
                                $data_arrayAtribut[3] => $data_arrayAtributLatih[$row_latih['id_latih']][3]
                              );
                            }

                            $atribut_data = "SELECT * FROM atribut";
                            $atributData = mysqli_query($conn, $atribut_data);
                            $atribut = array();
                            while ($row_atribut = mysqli_fetch_assoc($atributData)) {
                              $atribut[] = $row_atribut['atribut'];
                            }

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
                                <label for="nama" class="form-label">Nama <small class="text-danger">*</small></label>
                                <input type="text" name="nama" value="<?php if (isset($_POST['nama'])) {
                                                                        echo $_POST['nama'];
                                                                      } ?>" class="form-control text-center" id="nama" placeholder="Nama" required>
                              </div>
                              <?php if (mysqli_num_rows($jenisKelamin2) > 0) { ?>
                                <div class="mb-3">
                                  <label for="id_jenis_kelamin" class="form-label">Jenis Kelamin <small class="text-danger">*</small></label>
                                  <select name="jk" id="id_jenis_kelamin" class="form-select" aria-label="Default select example" required>
                                    <option selected value="">Pilih Jenis Kelamin</option>
                                    <?php while ($row_jk = mysqli_fetch_assoc($jenisKelamin2)) { ?>
                                      <option value="<?= $row_jk['id_atribut_sub'] ?>"><?= $row_jk['atribut_sub'] ?></option>
                                    <?php } ?>
                                  </select>
                                </div>
                              <?php } ?>
                              <div class="mb-3">
                                <label for="nilai_ipk" class="form-label">IPK <?= $row_ipk['status_ipk'] ?> <small class="text-danger">*</small></label>
                                <select name="ipk" id="nilai_ipk" class="form-select" aria-label="Default select example" required>
                                  <option selected value="">Pilih IPK</option>
                                  <option value="4">Dengan Pujian</option>
                                  <option value="3">Sangat Memuaskan</option>
                                  <option value="2">Memuaskan</option>
                                  <option value="1">Cukup</option>
                                </select>
                              </div>
                              <div class="mb-3">
                                <label for="nilai_spa" class="form-label">SPA <?= $row_spa['status_spa'] ?> <small class="text-danger">*</small></label>
                                <select name="spa" id="nilai_ipk" class="form-select" aria-label="Default select example" required>
                                  <option selected value="">Pilih SPA</option>
                                  <option value="4">A</option>
                                  <option value="3">B</option>
                                  <option value="2">C</option>
                                  <option value="1">D</option>
                                </select>
                              </div>
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
                          <table class="table table-bordered table-striped table-hover table-sm display" id="datatable">
                            <thead>
                              <tr>
                                <th scope="col" class="text-center">#</th>
                                <?php foreach ($atributs as $key => $val) : ?>
                                  <th scope="col" class="text-center"><?= str_replace("_", " ", $val['atribut']) ?></th>
                                <?php endforeach; ?>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $testings = array();
                              foreach ($data_prediksi as $row) {
                                $testings[$row['id_testing']][$row['atribut']] = $row['atribut_sub'];
                              }
                              $testings = array_values($testings);
                              ?>
                              <?php $no = 1;
                              foreach ($testings as $key => $val) : ?>
                                <tr>
                                  <td><?= $no++ ?></td>
                                  <?php foreach ($val as $k => $v) : ?>
                                    <td><?= $v ?></td>
                                  <?php endforeach ?>
                                  <td><?= $c45->predict($val) ?></td>
                                </tr>
                              <?php endforeach; ?>
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