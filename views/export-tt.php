<?php require_once("../controller/script.php");
require_once __DIR__ . '/../assets/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->SetTitle("Laporan Prediksi Lama Studi Mahasiswa Tidak Tepat");
$mpdf->WriteHTML('<div style="border-bottom: 3px solid black;width: 100%;">
  <table border="0" style="width: 100%;">
    <tbody>
      <tr>
        <th style="text-align: center;">
          <img src="../assets/images/logo.png" alt="" style="width: 110px;height: 100px;">
        </th>
        <td style="text-align: center;">
          <h3>LAPORAN PREDIKSI LAMA STUDI MAHASISWA<br>TIDAK TEPAT<br>PROGRAM STUDI ARSITEKTUR UNWIRA</h3>
        </td>
      </tr>
    </tbody>
  </table>
</div>');
$mpdf->WriteHTML('<h4 style="text-align: center;"></h4>
<table border="0" style="width: 100%;margin-top: 10px;vertical-align: top;">
  <thead>
    <tr>
      <th scope="col" class="text-center" style="border: 1px solid black;">#</th>
      <th scope="col" class="text-center" style="border: 1px solid black;">Nama</th>');
foreach ($atributs as $key => $val) {
  $mpdf->WriteHTML('<th scope="col" class="text-center" style="border: 1px solid black;">' . str_replace("_", " ", $val['atribut']) . '</th>');
}
$mpdf->WriteHTML('</tr>
  </thead>
  <tbody>');
$data_prediksi = mysqli_query($conn, "SELECT data_testing.* FROM data_testing JOIN atribut_testing ON data_testing.id_testing=atribut_testing.id_testing WHERE atribut_testing.id_atribut_sub='13' ORDER BY data_testing.id_testing DESC");
if (mysqli_num_rows($data_prediksi) > 0) {
  $no = 1;
  while ($row = mysqli_fetch_assoc($data_prediksi)) {
    $id_testing = $row['id_testing'];
    $mpdf->WriteHTML('
          <tr>
            <th style="border: 1px solid black;">' . $no++ . '</th>
            <td style="border: 1px solid black;">' . $row['nama'] . '</td>');
    $atribut_sub_view = "SELECT atribut_sub.atribut_sub FROM atribut_testing JOIN atribut_sub ON atribut_testing.id_atribut_sub=atribut_sub.id_atribut_sub WHERE atribut_testing.id_testing='$id_testing' ORDER BY atribut_testing.id_testing DESC";
    $atributSubView = mysqli_query($conn, $atribut_sub_view);
    foreach ($atributSubView as $row_atribut_sub_view) :
      $atribut_sub = $row_atribut_sub_view['atribut_sub'];
      $mpdf->WriteHTML('<td style="border: 1px solid black;">' . $atribut_sub . '</td>
          </tr>');
    endforeach;
  }
}
$mpdf->WriteHTML('
  </tbody>
</table>');

$mpdf->Output();
// $mpdf->OutputHttpDownload('Laporan-Permintaan-Darah-UTD-PMI-Pemprov-NTT' . date("Y-m-d") . '.pdf');
// header("Location: laporan");
// exit;
