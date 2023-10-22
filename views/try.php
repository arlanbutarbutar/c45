<!DOCTYPE html>
<html>

<head>
  <title>Hasil Klasifikasi Pohon Keputusan C4.5</title>
</head>

<body>
  <h1>Hasil Klasifikasi Pohon Keputusan C4.5</h1>

  <?php
  // Data dummy
  $data = array(
    array('Jenis Kelamin' => 'Laki-Laki', 'IPK' => 3.5, 'SPA' => 'Baik', 'Prediksi' => 'Lulus'),
    array('Jenis Kelamin' => 'Perempuan', 'IPK' => 3.2, 'SPA' => 'Cukup', 'Prediksi' => 'Lulus'),
    array('Jenis Kelamin' => 'Laki-Laki', 'IPK' => 3.8, 'SPA' => 'Baik', 'Prediksi' => 'Lulus'),
    array('Jenis Kelamin' => 'Perempuan', 'IPK' => 2.9, 'SPA' => 'Kurang', 'Prediksi' => 'Tidak Lulus'),
    array('Jenis Kelamin' => 'Laki-Laki', 'IPK' => 2.7, 'SPA' => 'Kurang', 'Prediksi' => 'Tidak Lulus'),
    array('Jenis Kelamin' => 'Perempuan', 'IPK' => 3.6, 'SPA' => 'Baik', 'Prediksi' => 'Lulus'),
    array('Jenis Kelamin' => 'Laki-Laki', 'IPK' => 3.1, 'SPA' => 'Cukup', 'Prediksi' => 'Lulus'),
    array('Jenis Kelamin' => 'Perempuan', 'IPK' => 3.9, 'SPA' => 'Baik', 'Prediksi' => 'Lulus'),
    array('Jenis Kelamin' => 'Laki-Laki', 'IPK' => 2.5, 'SPA' => 'Kurang', 'Prediksi' => 'Tidak Lulus'),
    array('Jenis Kelamin' => 'Perempuan', 'IPK' => 3.7, 'SPA' => 'Baik', 'Prediksi' => 'Lulus')
  );

  $attributes = array('Jenis Kelamin', 'IPK', 'SPA', 'Prediksi');
  $targetAttribute = 'Prediksi';

  // Implementasi C4.5 (perhitungan, pemilihan atribut terbaik, dan pembangunan pohon)
  class C45DecisionTree
  {
    public $data;
    public $attributes;
    public $targetAttribute;

    public function __construct($data, $attributes, $targetAttribute)
    {
      $this->data = $data;
      $this->attributes = $attributes;
      $this->targetAttribute = $targetAttribute;
    }

    public function calculateEntropy($data)
    {
      $totalInstances = count($data);
      $entropy = 0;

      $classCounts = array_count_values(array_column($data, $this->targetAttribute));

      foreach ($classCounts as $class => $count) {
        $probability = $count / $totalInstances;
        $entropy -= $probability * log($probability, 2);
      }

      return $entropy;
    }

    public function calculateInformationGain($data, $attribute)
    {
      $totalInstances = count($data);
      $entropyS = $this->calculateEntropy($data);
      $weightedEntropy = 0;

      $uniqueAttributeValues = array_unique(array_column($data, $attribute));

      foreach ($uniqueAttributeValues as $value) {
        $subset = array_filter($data, function ($row) use ($attribute, $value) {
          return $row[$attribute] == $value;
        });

        $subsetCount = count($subset);
        $subsetEntropy = $this->calculateEntropy($subset);
        $weightedEntropy += ($subsetCount / $totalInstances) * $subsetEntropy;
      }

      $informationGain = $entropyS - $weightedEntropy;
      return $informationGain;
    }

    public function chooseBestAttribute($data, $attributes)
    {
      $informationGains = array();

      foreach ($attributes as $attribute) {
        if ($attribute == $this->targetAttribute) continue; // Skip target attribute

        $informationGain = $this->calculateInformationGain($data, $attribute);
        $informationGains[$attribute] = $informationGain;
      }

      // Pilih atribut dengan gain informasi tertinggi
      $bestAttribute = array_search(max($informationGains), $informationGains);

      return $bestAttribute;
    }

    public function buildDecisionTree($data, $attributes)
    {
      // Jika semua sampel memiliki label yang sama, buat simpul daun dengan label tersebut
      if (count(array_unique(array_column($data, $this->targetAttribute))) === 1) {
        $uniqueLabels = array_unique(array_column($data, $this->targetAttribute));
        return reset($uniqueLabels);
      }

      // Jika tidak ada atribut yang tersisa, buat simpul daun dengan label mayoritas
      if (empty($attributes)) {
        $classCounts = array_count_values(array_column($data, $this->targetAttribute));
        return array_search(max($classCounts), $classCounts);
      }

      // Pilih atribut terbaik
      $bestAttribute = $this->chooseBestAttribute($data, $attributes);

      // Inisialisasi pohon dengan atribut terbaik
      $tree = array($bestAttribute => array());

      $uniqueAttributeValues = array_unique(array_column($data, $bestAttribute));

      foreach ($uniqueAttributeValues as $value) {
        $subset = array_filter($data, function ($row) use ($bestAttribute, $value) {
          return $row[$bestAttribute] == $value;
        });

        // Hapus atribut yang dipilih dari atribut yang tersedia
        $remainingAttributes = array_diff($attributes, [$bestAttribute]);

        // Rekursi untuk membangun subtree
        $tree[$bestAttribute][$value] = $this->buildDecisionTree($subset, $remainingAttributes);
      }

      return $tree;
    }

    public function classify($instance, $tree)
    {
      // Jika mencapai simpul daun, kembalikan label dari simpul daun tersebut
      if (!is_array($tree)) {
        return $tree;
      }

      // Ambil atribut terbaik dari pohon
      $bestAttribute = key($tree);
      $instanceValue = $instance[$bestAttribute];

      // Cek apakah ada cabang sesuai dengan nilai atribut instance
      if (isset($tree[$bestAttribute][$instanceValue])) {
        // Rekursi ke cabang yang sesuai
        return $this->classify($instance, $tree[$bestAttribute][$instanceValue]);
      } else {
        // Jika tidak ada cabang yang sesuai, kembalikan label mayoritas dari subtree
        $subtreeLabels = array();
        foreach ($tree[$bestAttribute] as $value => $subtree) {
          $subtreeLabels[] = $this->classify($instance, $subtree);
        }
        return array_search(max(array_count_values($subtreeLabels)), array_count_values($subtreeLabels));
      }
    }
    public function calculateSplitInfo($data, $attribute)
    {
      $totalInstances = count($data);
      $splitInfo = 0;

      $uniqueAttributeValues = array_unique(array_column($data, $attribute));

      foreach ($uniqueAttributeValues as $value) {
        $subset = array_filter($data, function ($row) use ($attribute, $value) {
          return $row[$attribute] == $value;
        });

        $subsetCount = count($subset);
        $probability = $subsetCount / $totalInstances;

        if ($probability > 0) {
          $splitInfo -= $probability * log($probability, 2);
        }
      }

      return $splitInfo;
    }

    public function calculateGainRatio($informationGain, $splitInfo)
    {
      if ($splitInfo == 0) {
        return 0; // Menghindari pembagian dengan nol
      }

      return $informationGain / $splitInfo;
    }

    public function printDecisionTree($tree, $level = 0)
    {
      foreach ($tree as $attribute => $subtree) {
        echo str_repeat("&nbsp;&nbsp;", $level);
        echo "$attribute";
        if (is_array($subtree)) {
          echo "<br>";
          $this->printDecisionTree($subtree, $level + 1);
        } else {
          echo " : $subtree<br>";
        }
      }
    }
  }

  $decisionTree = new C45DecisionTree($data, $attributes, $targetAttribute);
  $tree = $decisionTree->buildDecisionTree($data, $attributes);

  // Instance yang akan diklasifikasikan (di sini, contoh instance dari data dummy)
  $testInstance = array(
    'Jenis Kelamin' => 'Laki-Laki',
    'IPK' => 2.5,
    'SPA' => 'Cukup',
  );

  $classification = $decisionTree->classify($testInstance, $tree);

  // Menampilkan jumlah data
  $totalData = count($data);
  echo "<p>Total Data: $totalData</p>";

  // Menampilkan hasil perhitungan Gain, Split Info, dan Gain Ratio
  $informationGain = $decisionTree->calculateInformationGain($data, $targetAttribute);
  $splitInfo = $decisionTree->calculateSplitInfo($data, $targetAttribute);
  $gainRatio = $decisionTree->calculateGainRatio($informationGain, $splitInfo);

  echo "<p>Information Gain: $informationGain</p>";
  echo "<p>Split Info: $splitInfo</p>";
  echo "<p>Gain Ratio: $gainRatio</p>";

  // Menampilkan pohon keputusan
  echo "<h2>Decision Tree:</h2>";
  $decisionTree->printDecisionTree($tree);
  ?>
</body>

</html>