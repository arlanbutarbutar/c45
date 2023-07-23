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