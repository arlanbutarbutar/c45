<?php
function predictStatus($input, $decisionTree)
{
  while (is_array($decisionTree)) {
    $attribute = key($decisionTree);
    $value = $input[$attribute];
    if (array_key_exists($value, $decisionTree[$attribute])) {
      $decisionTree = $decisionTree[$attribute][$value];
    } else {
      // Jika nilai input tidak ada dalam pohon, kembalikan nilai default
      return "Tidak Lulus";
    }
  }
  return $decisionTree;
}

if (isset($_POST['prediksi'])) {
  // Ambil input pengguna dari formulir
  $inputIPK = floatval($_POST["ipk"]);
  $inputSPA = $_POST["spa"]; // SPA masih dalam format huruf

  // Mappings untuk nilai SPA
  $spaMappings = array(
    "A" => 4,
    "B" => 3,
    "C" => 2,
    "D" => 1
  );

  if (array_key_exists($inputSPA, $spaMappings)) {
    $inputSPA = $spaMappings[$inputSPA];
  } else {
    // Jika input SPA tidak valid, kembalikan pesan kesalahan
    echo "Input SPA tidak valid.";
    exit;
  }

  // Load pohon keputusan yang telah dibangun
  $decisionTree = array(
    'ipk' => array(
      4 => 'Dengan Pujian',
      3 => 'Sangat Memuaskan',
      2 => 'Memuaskan',
      1 => 'Cukup'
    ),
    'spa' => array(
      4 => 'D',
      3 => 'C',
      2 => 'B',
      1 => 'A'
    )
  );

  // Bentuk data input
  $inputData = array(0 => $inputIPK, 1 => $inputSPA);

  // Lakukan prediksi
  $prediction = predictStatus($inputData, $decisionTree);

  // Tampilkan hasil prediksi
  echo "Hasil Prediksi: " . $prediction;
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Prediksi Kelulusan Mahasiswa</title>
</head>

<body>
  <h1>Prediksi Kelulusan Mahasiswa</h1>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="ipk">IPK:</label>
    <input type="number" step="0.01" name="ipk" required>
    <br>
    <label for="spa">SPA:</label>
    <input type="text" name="spa" required>
    <br>
    <button type="submit" name="prediksi">Submit</button>
  </form>
</body>

</html>