<?php require_once("support_code.php");
if (!isset($_SESSION["data-user"])) {
  function masuk($data)
  {
    global $conn;
    $email = valid($data["email"]);
    $password = valid($data["password"]);

    // check account
    $checkAccount = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($checkAccount) == 0) {
      $_SESSION["message-danger"] = "Maaf, akun yang anda masukan belum terdaftar.";
      $_SESSION["time-message"] = time();
      return false;
    } else if (mysqli_num_rows($checkAccount) > 0) {
      $row = mysqli_fetch_assoc($checkAccount);
      if (password_verify($password, $row["password"])) {
        $_SESSION["data-user"] = [
          "id" => $row["id_user"],
          "role" => $row["id_role"],
          "email" => $row["email"],
          "username" => $row["username"],
        ];
      } else {
        $_SESSION["message-danger"] = "Maaf, kata sandi yang anda masukan salah.";
        $_SESSION["time-message"] = time();
        return false;
      }
    }
  }
}
if (isset($_SESSION["data-user"])) {
  function edit_profile($data)
  {
    global $conn, $idUser;
    $username = valid($data["username"]);
    $password = valid($data["password"]);
    $password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($conn, "UPDATE users SET username='$username', password='$password' WHERE id_user='$idUser'");
    return mysqli_affected_rows($conn);
  }
  function add_user($data)
  {
    global $conn;
    $username = valid($data["username"]);
    $email = valid($data["email"]);
    $checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($checkEmail) > 0) {
      $_SESSION["message-danger"] = "Maaf, email yang anda masukan sudah terdaftar.";
      $_SESSION["time-message"] = time();
      return false;
    }
    $password = valid($data["password"]);
    $password = password_hash($password, PASSWORD_DEFAULT);
    $id_role = valid($data['id_role']);
    mysqli_query($conn, "INSERT INTO users(id_role,username,email,password) VALUES('$id_role','$username','$email','$password')");
    return mysqli_affected_rows($conn);
  }
  function edit_user($data)
  {
    global $conn, $time;
    $id_user = valid($data["id-user"]);
    $username = valid($data["username"]);
    $email = valid($data["email"]);
    $emailOld = valid($data["emailOld"]);
    if ($email != $emailOld) {
      $checkEmail = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
      if (mysqli_num_rows($checkEmail) > 0) {
        $_SESSION["message-danger"] = "Maaf, email yang anda masukan sudah terdaftar.";
        $_SESSION["time-message"] = time();
        return false;
      }
    }
    $id_role = valid($data['id_role']);
    mysqli_query($conn, "UPDATE users SET id_role='$id_role', username='$username', email='$email', updated_at=current_timestamp WHERE id_user='$id_user'");
    return mysqli_affected_rows($conn);
  }
  function delete_user($data)
  {
    global $conn;
    $id_user = valid($data["id-user"]);
    mysqli_query($conn, "DELETE FROM users WHERE id_user='$id_user'");
    return mysqli_affected_rows($conn);
  }
  function overview($data)
  {
    global $conn;
    $judul = valid($data['judul']);
    $konten = $data['konten'];
    mysqli_query($conn, "UPDATE overview SET judul='$judul', konten='$konten'");
    return mysqli_affected_rows($conn);
  }
  function add_atribut($data)
  {
    global $conn;
    $atribut = valid($data['atribut']);
    $atribut = str_replace(" ", "_", $atribut);
    $checkAtribut = "SELECT * FROM atribut WHERE atribut='$atribut'";
    $checkAtribut = mysqli_query($conn, $checkAtribut);
    if (mysqli_num_rows($checkAtribut) > 0) {
      $_SESSION["message-danger"] = "Maaf, atribut yang anda masukan sudah terdaftar.";
      $_SESSION["time-message"] = time();
      return false;
    }
    $sql = "INSERT INTO atribut(atribut) VALUES('$atribut')";
    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }
  function edit_atribut($data)
  {
    global $conn;
    $id_atribut = valid($data['id_atribut']);
    $atribut = valid($data['atribut']);
    $atribut = str_replace(" ", "_", $atribut);
    $atributOld = valid($data['atributOld']);
    if ($atribut != $atributOld) {
      $checkAtribut = "SELECT * FROM atribut WHERE atribut='$atribut'";
      $checkAtribut = mysqli_query($conn, $checkAtribut);
      if (mysqli_num_rows($checkAtribut) > 0) {
        $_SESSION["message-danger"] = "Maaf, atribut yang anda masukan sudah ada.";
        $_SESSION["time-message"] = time();
        return false;
      }
    }
    $sql = "UPDATE atribut SET atribut='$atribut' WHERE id_atribut='$id_atribut'";
    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }
  function delete_atribut($data)
  {
    global $conn;
    $id_atribut = valid($data['id_atribut']);
    $sql = "DELETE FROM atribut WHERE id_atribut='$id_atribut'";
    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }
  function add_atribut_sub($data)
  {
    global $conn;
    $id_atribut = valid($data['id_atribut']);
    $atribut_sub = valid($data['atribut_sub']);
    $checkAtributSub = "SELECT * FROM atribut_sub WHERE atribut_sub='$atribut_sub'";
    $checkAtributSub = mysqli_query($conn, $checkAtributSub);
    if (mysqli_num_rows($checkAtributSub) > 0) {
      $_SESSION["message-danger"] = "Maaf, sub atribut yang anda masukan sudah ada.";
      $_SESSION["time-message"] = time();
      return false;
    }
    $sql = "INSERT INTO atribut_sub(id_atribut,atribut_sub) VALUES('$id_atribut','$atribut_sub')";
    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }
  function edit_atribut_sub($data)
  {
    global $conn;
    $id_atribut_sub = valid($data['id_atribut_sub']);
    $id_atribut = valid($data['id_atribut']);
    $atribut_sub = valid($data['atribut_sub']);
    $atribut_subOld = valid($data['atribut_subOld']);
    if ($atribut_sub != $atribut_subOld) {
      $checkAtributSub = "SELECT * FROM atribut_sub WHERE atribut_sub='$atribut_sub'";
      $checkAtributSub = mysqli_query($conn, $checkAtributSub);
      if (mysqli_num_rows($checkAtributSub) > 0) {
        $_SESSION["message-danger"] = "Maaf, sub atribut yang anda masukan sudah ada.";
        $_SESSION["time-message"] = time();
        return false;
      }
    }
    $sql = "UPDATE atribut_sub SET id_atribut='$id_atribut', atribut_sub='$atribut_sub' WHERE id_atribut_sub='$id_atribut_sub'";
    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }
  function delete_atribut_sub($data)
  {
    global $conn;
    $id_atribut_sub = valid($data['id_atribut_sub']);
    $sql = "DELETE FROM atribut_sub WHERE id_atribut_sub='$id_atribut_sub'";
    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }
  function hitungRataRata($array)
  {
    $jumlah_data = count($array);
    if ($jumlah_data === 0) {
      return 0;
    }
    $total = array_sum($array);
    $rata_rata = $total / $jumlah_data;
    return $rata_rata;
  }
  function add_atribut_sub_jenis_kelamin($tour, $id_latih, $id_atr, $id_atribut_sub, $conn)
  {
    $sql = "INSERT INTO atribut_$tour(id_$tour,id_atribut,id_atribut_sub) VALUES('$id_latih','$id_atr','$id_atribut_sub');";
    $result = mysqli_multi_query($conn, $sql);
    return $result;
  }
  function edit_atribut_sub_jenis_kelamin($tour, $id_latih, $id_atr, $id_atribut_sub, $conn)
  {
    $sql_delete = "DELETE FROM atribut_$tour WHERE id_$tour='$id_latih'";
    $result_delete = mysqli_query($conn, $sql_delete);

    // Periksa jika penghapusan gagal
    if (!$result_delete) {
      return false;
    }

    $sql_insert = "INSERT INTO atribut_$tour(id_$tour,id_atribut,id_atribut_sub) VALUES('$id_latih','$id_atr','$id_atribut_sub')";
    $result_insert = mysqli_query($conn, $sql_insert);

    // Periksa jika penambahan gagal
    if (!$result_insert) {
      return false;
    }

    return true;
  }
  function add_atribut_sub_other($tour, $id_latih, $id_atr, $atribut_sub, $conn)
  {
    $checkCukup = "SELECT * FROM atribut_sub WHERE atribut_sub='$atribut_sub'";
    $queryCukup = mysqli_query($conn, $checkCukup);
    if (mysqli_num_rows($queryCukup) > 0) {
      $row = mysqli_fetch_assoc($queryCukup);
      $id_atribut_sub = $row['id_atribut_sub'];
      $sql = "INSERT INTO atribut_$tour(id_$tour,id_atribut,id_atribut_sub) VALUES('$id_latih','$id_atr','$id_atribut_sub')";
      $result = mysqli_query($conn, $sql);
    }
    return $result;
  }
  function add_latih($data)
  {
    global $conn;
    $data_latih = "SELECT * FROM data_latih ORDER BY id_latih DESC LIMIT 1";
    $checkID = mysqli_query($conn, $data_latih);
    if (mysqli_num_rows($checkID) > 0) {
      $row = mysqli_fetch_assoc($checkID);
      $id_latih = $row['id_latih'] + 1;
    } else {
      $id_latih = 1;
    }
    $nim = valid($data['nim']);
    $checkNIM = mysqli_query($conn, "SELECT * FROM data_latih WHERE nim='$nim'");
    if (mysqli_num_rows($checkNIM) > 0) {
      $_SESSION["message-danger"] = "Maaf, NIM yang anda masukan sudah terdaftar.";
      $_SESSION["time-message"] = time();
      return false;
    }
    $nama = valid($data['nama']);
    $id_jenis_kelamin = valid($data['id_jenis_kelamin']);
    $nilai_ipk = $data['nilai_ipk'];
    $nilai_spa = $data['nilai_spa'];
    $tour = "latih";

    // Mencari nilai rata-rata ipk
    $nilai_rata_rata_ipk = hitungRataRata($nilai_ipk);

    // Mencari nilai rata-rata spa
    $nilai_rata_rata_spa = hitungRataRata($nilai_spa);

    // Menghitung nilai rata-rata ipk dan spa
    $nilai_gabungan = array_merge($nilai_ipk, $nilai_spa);
    $nilai_rata_rata = hitungRataRata($nilai_gabungan);

    // Menginput data latih
    mysqli_query($conn, "INSERT INTO data_latih(id_latih,nim,nama,nilai_rata_rata_ipk,nilai_rata_rata_spa,nilai_rata_rata) VALUES('$id_latih','$nim','$nama','$nilai_rata_rata_ipk','$nilai_rata_rata_spa','$nilai_rata_rata')");

    // Menentukan jenis kelamin
    add_atribut_sub_jenis_kelamin($tour, $id_latih, $id_atr = 1, $id_jenis_kelamin, $conn);

    // Menentukan predikat ipk
    if (round($nilai_rata_rata, 0) < 2.5) {
      $atribut_ipk = "Cukup";
      add_atribut_sub_other($tour, $id_latih, $id_atr = 2, $atribut_ipk, $conn);
    } else if (round($nilai_rata_rata, 0) < 2.8) {
      $atribut_ipk = "Memuaskan";
      add_atribut_sub_other($tour, $id_latih, $id_atr = 2, $atribut_ipk, $conn);
    } else if (round($nilai_rata_rata, 0) < 3) {
      $atribut_ipk = "Sangat Memuaskan";
      add_atribut_sub_other($tour, $id_latih, $id_atr = 2, $atribut_ipk, $conn);
    } else if (round($nilai_rata_rata, 0) >= 3) {
      $atribut_ipk = "Dengan Pujian";
      add_atribut_sub_other($tour, $id_latih, $id_atr = 2, $atribut_ipk, $conn);
    }

    // Menentukan predikat spa
    if (round($nilai_rata_rata, 0) < 2.5) {
      $atribut_spa = "D";
      add_atribut_sub_other($tour, $id_latih, $id_atr = 3, $atribut_spa, $conn);
    } else if (round($nilai_rata_rata, 0) < 2.8) {
      $atribut_spa = "C";
      add_atribut_sub_other($tour, $id_latih, $id_atr = 3, $atribut_spa, $conn);
    } else if (round($nilai_rata_rata, 0) < 3) {
      $atribut_spa = "B";
      add_atribut_sub_other($tour, $id_latih, $id_atr = 3, $atribut_spa, $conn);
    } else if (round($nilai_rata_rata, 0) >= 3) {
      $atribut_spa = "A";
      add_atribut_sub_other($tour, $id_latih, $id_atr = 3, $atribut_spa, $conn);
    }

    // Menentukan prediksi
    if (round($nilai_rata_rata, 0) < 2.5) {
      $atribut_prediksi = "Tidak Tepat";
      add_atribut_sub_other($tour, $id_latih, $id_atr = 4, $atribut_prediksi, $conn);
    } else if (round($nilai_rata_rata, 0) >= 2.5) {
      $atribut_prediksi = "Lulus Tepat";
      add_atribut_sub_other($tour, $id_latih, $id_atr = 4, $atribut_prediksi, $conn);
    }

    // menginput IPK dari data latih
    for ($ipk = 1; $ipk <= count($nilai_ipk); $ipk++) {
      $ipk_fix = $ipk - 1;
      $insert_ipk = "INSERT INTO ipk_latih(id_latih,id_status_ipk,nilai_ipk) VALUES('$id_latih','$ipk','$nilai_ipk[$ipk_fix]')";
      mysqli_query($conn, $insert_ipk);
    }

    // menginput SPA dari data latih
    for ($spa = 1; $spa <= count($nilai_spa); $spa++) {
      $spa_fix = $spa - 1;
      $insert_spa = "INSERT INTO spa_latih(id_latih,id_status_spa,nilai_spa) VALUES('$id_latih','$spa','$nilai_spa[$spa_fix]')";
      mysqli_query($conn, $insert_spa);
    }

    return mysqli_affected_rows($conn);
  }
  function edit_latih($data)
  {
    global $conn;
    $id_latih = valid($data['id_latih']);
    $nim = valid($data['nim']);
    $nimOld = valid($data['nimOld']);
    if ($nim != $nimOld) {
      $checkNIM = mysqli_query($conn, "SELECT * FROM data_latih WHERE nim='$nim'");
      if (mysqli_num_rows($checkNIM) > 0) {
        $_SESSION["message-danger"] = "Maaf, NIM yang anda masukan sudah terdaftar.";
        $_SESSION["time-message"] = time();
        return false;
      }
    }
    $nama = valid($data['nama']);
    $id_jenis_kelamin = valid($data['id_jenis_kelamin']);
    $nilai_ipk = $data['nilai_ipk'];
    $nilai_spa = $data['nilai_spa'];
    $tour = "latih";

    // Mencari nilai rata-rata ipk
    $nilai_rata_rata_ipk = hitungRataRata($nilai_ipk);

    // Mencari nilai rata-rata spa
    $nilai_rata_rata_spa = hitungRataRata($nilai_spa);

    // Menghitung nilai rata-rata ipk dan spa
    $nilai_gabungan = array_merge($nilai_ipk, $nilai_spa);
    $nilai_rata_rata = hitungRataRata($nilai_gabungan);

    // Menentukan jenis kelamin
    add_atribut_sub_jenis_kelamin($tour, $id_latih, $id_atr = 1, $id_jenis_kelamin, $conn);

    // Menentukan predikat ipk
    if (round($nilai_rata_rata, 0) < 2.5) {
      $atribut_ipk = "Cukup";
      add_atribut_sub_other($tour, $id_latih, $id_atr = 2, $atribut_ipk, $conn);
    } else if (round($nilai_rata_rata, 0) < 2.8) {
      $atribut_ipk = "Memuaskan";
      add_atribut_sub_other($tour, $id_latih, $id_atr = 2, $atribut_ipk, $conn);
    } else if (round($nilai_rata_rata, 0) < 3) {
      $atribut_ipk = "Sangat Memuaskan";
      add_atribut_sub_other($tour, $id_latih, $id_atr = 2, $atribut_ipk, $conn);
    } else if (round($nilai_rata_rata, 0) >= 3) {
      $atribut_ipk = "Dengan Pujian";
      add_atribut_sub_other($tour, $id_latih, $id_atr = 2, $atribut_ipk, $conn);
    }

    // Menentukan predikat spa
    if (round($nilai_rata_rata, 0) < 2.5) {
      $atribut_spa = "D";
      add_atribut_sub_other($tour, $id_latih, $id_atr = 3, $atribut_spa, $conn);
    } else if (round($nilai_rata_rata, 0) < 2.8) {
      $atribut_spa = "C";
      add_atribut_sub_other($tour, $id_latih, $id_atr = 3, $atribut_spa, $conn);
    } else if (round($nilai_rata_rata, 0) < 3) {
      $atribut_spa = "B";
      add_atribut_sub_other($tour, $id_latih, $id_atr = 3, $atribut_spa, $conn);
    } else if (round($nilai_rata_rata, 0) >= 3) {
      $atribut_spa = "A";
      add_atribut_sub_other($tour, $id_latih, $id_atr = 3, $atribut_spa, $conn);
    }

    // Menentukan prediksi
    if (round($nilai_rata_rata, 0) < 2.5) {
      $atribut_prediksi = "Tidak Tepat";
      add_atribut_sub_other($tour, $id_latih, $id_atr = 4, $atribut_prediksi, $conn);
    } else if (round($nilai_rata_rata, 0) >= 2.5) {
      $atribut_prediksi = "Lulus Tepat";
      add_atribut_sub_other($tour, $id_latih, $id_atr = 4, $atribut_prediksi, $conn);
    }

    // menginput IPK dari data latih
    for ($ipk = 1; $ipk <= count($nilai_ipk); $ipk++) {
      $ipk_fix = $ipk - 1;
      $update_ipk = "UPDATE ipk_latih SET nilai_ipk='$nilai_ipk[$ipk_fix]' WHERE id_latih='$id_latih' AND id_status_ipk='$ipk'";
      mysqli_query($conn, $update_ipk);
    }

    // menginput SPA dari data latih
    for ($spa = 1; $spa <= count($nilai_spa); $spa++) {
      $spa_fix = $spa - 1;
      $update_spa = "UPDATE spa_latih SET nilai_spa='$nilai_spa[$spa_fix]' WHERE id_latih='$id_latih' AND id_status_spa='$spa'";
      mysqli_query($conn, $update_spa);
    }
    $data_latih = "UPDATE data_latih SET nim='$nim', nama='$nama', nilai_rata_rata_ipk='$nilai_rata_rata_ipk', nilai_rata_rata_spa='$nilai_rata_rata_spa', nilai_rata_rata='$nilai_rata_rata' WHERE id_latih='$id_latih'";
    mysqli_query($conn, $data_latih);
    return mysqli_affected_rows($conn);
  }
  function delete_latih($data)
  {
    global $conn;
    $id_latih = valid($data['id_latih']);
    $data_latih = "DELETE FROM data_latih WHERE id_latih='$id_latih'";
    mysqli_query($conn, $data_latih);
    return mysqli_affected_rows($conn);
  }
  function edit_testing($data)
  {
    global $conn;
    $id_testing = valid($data['id_testing']);
    $nim = valid($data['nim']);
    $nimOld = valid($data['nimOld']);
    if ($nim != $nimOld) {
      $checkNIM = mysqli_query($conn, "SELECT * FROM data_testing WHERE nim='$nim'");
      if (mysqli_num_rows($checkNIM) > 0) {
        $_SESSION["message-danger"] = "Maaf, NIM yang anda masukan sudah terdaftar.";
        $_SESSION["time-message"] = time();
        return false;
      }
    }
    $nama = valid($data['nama']);
    $id_jenis_kelamin = valid($data['id_jenis_kelamin']);
    $nilai_ipk = $data['nilai_ipk'];
    $nilai_spa = $data['nilai_spa'];
    $tour = "testing";

    // Mencari nilai rata-rata ipk
    $nilai_rata_rata_ipk = hitungRataRata($nilai_ipk);

    // Mencari nilai rata-rata spa
    $nilai_rata_rata_spa = hitungRataRata($nilai_spa);

    // Menghitung nilai rata-rata ipk dan spa
    $nilai_gabungan = array_merge($nilai_ipk, $nilai_spa);
    $nilai_rata_rata = hitungRataRata($nilai_gabungan);

    // Menentukan jenis kelamin
    add_atribut_sub_jenis_kelamin($tour, $id_testing, $id_atr = 1, $id_jenis_kelamin, $conn);

    // Menentukan predikat ipk
    if (round($nilai_rata_rata, 0) < 2.5) {
      $atribut_ipk = "Cukup";
      add_atribut_sub_other($tour, $id_testing, $id_atr = 2, $atribut_ipk, $conn);
    } else if (round($nilai_rata_rata, 0) < 2.8) {
      $atribut_ipk = "Memuaskan";
      add_atribut_sub_other($tour, $id_testing, $id_atr = 2, $atribut_ipk, $conn);
    } else if (round($nilai_rata_rata, 0) < 3) {
      $atribut_ipk = "Sangat Memuaskan";
      add_atribut_sub_other($tour, $id_testing, $id_atr = 2, $atribut_ipk, $conn);
    } else if (round($nilai_rata_rata, 0) >= 3) {
      $atribut_ipk = "Dengan Pujian";
      add_atribut_sub_other($tour, $id_testing, $id_atr = 2, $atribut_ipk, $conn);
    }

    // Menentukan predikat spa
    if (round($nilai_rata_rata, 0) < 2.5) {
      $atribut_spa = "D";
      add_atribut_sub_other($tour, $id_testing, $id_atr = 3, $atribut_spa, $conn);
    } else if (round($nilai_rata_rata, 0) < 2.8) {
      $atribut_spa = "C";
      add_atribut_sub_other($tour, $id_testing, $id_atr = 3, $atribut_spa, $conn);
    } else if (round($nilai_rata_rata, 0) < 3) {
      $atribut_spa = "B";
      add_atribut_sub_other($tour, $id_testing, $id_atr = 3, $atribut_spa, $conn);
    } else if (round($nilai_rata_rata, 0) >= 3) {
      $atribut_spa = "A";
      add_atribut_sub_other($tour, $id_testing, $id_atr = 3, $atribut_spa, $conn);
    }

    // menginput IPK dari data testing
    for ($ipk = 1; $ipk <= count($nilai_ipk); $ipk++) {
      $ipk_fix = $ipk - 1;
      $update_ipk = "UPDATE ipk_testing SET nilai_ipk='$nilai_ipk[$ipk_fix]' WHERE id_testing='$id_testing' AND id_status_ipk='$ipk'";
      mysqli_query($conn, $update_ipk);
    }

    // menginput SPA dari data testing
    for ($spa = 1; $spa <= count($nilai_spa); $spa++) {
      $spa_fix = $spa - 1;
      $update_spa = "UPDATE spa_testing SET nilai_spa='$nilai_spa[$spa_fix]' WHERE id_testing='$id_testing' AND id_status_spa='$spa'";
      mysqli_query($conn, $update_spa);
    }
    $data_testing = "UPDATE data_testing SET nim='$nim', nama='$nama', nilai_rata_rata_ipk='$nilai_rata_rata_ipk', nilai_rata_rata_spa='$nilai_rata_rata_spa', nilai_rata_rata='$nilai_rata_rata' WHERE id_testing='$id_testing'";
    mysqli_query($conn, $data_testing);
    return mysqli_affected_rows($conn);
  }
  function delete_testing($data)
  {
    global $conn;
    $id_testing = valid($data['id_testing']);
    $data_testing = "DELETE FROM data_testing WHERE id_testing='$id_testing'";
    mysqli_query($conn, $data_testing);
    return mysqli_affected_rows($conn);
  }
  function predictDecisionTree($data, $decisionTree)
  {
    if (is_array($decisionTree) && count($decisionTree) > 0) {
      $rootAttribute = key($decisionTree);
      $rootValue = $data[$rootAttribute];

      if (isset($decisionTree[$rootAttribute][$rootValue])) {
        $subtree = $decisionTree[$rootAttribute][$rootValue];

        // Jika sub-pohon adalah string, maka itu adalah prediksi
        if (is_string($subtree)) {
          return $subtree;
        } else {
          // Jika sub-pohon adalah array, rekursif memanggil diri sendiri
          return predictDecisionTree($data, $subtree);
        }
      }
    }
    // Default jika tidak ada prediksi
    return 'Tidak Lulus';
  }
  function prediksiKelulusan($ipk, $spa)
  {
    // Atur ambang batas untuk prediksi
    $batas_ipk = 2.5;
    $batas_spa = 2.5;

    // Lakukan prediksi
    if ($ipk >= $batas_ipk && $spa >= $batas_spa) {
      return "Lulus Tepat";
    } else {
      return "Tidak Tepat";
    }
  }
  function prediksi_checking($data)
  {
    global $conn;
    $data_testing = "SELECT * FROM data_testing ORDER BY id_testing DESC LIMIT 1";
    $checkID = mysqli_query($conn, $data_testing);
    if (mysqli_num_rows($checkID) > 0) {
      $row = mysqli_fetch_assoc($checkID);
      $id_testing = $row['id_testing'] + 1;
    } else {
      $id_testing = 1;
    }
    $nim = valid($data['nim']);
    $checkNIM = mysqli_query($conn, "SELECT * FROM data_testing WHERE nim='$nim'");
    if (mysqli_num_rows($checkNIM) > 0) {
      $_SESSION["message-danger"] = "Maaf, NIM yang anda masukan sudah terdaftar.";
      $_SESSION["time-message"] = time();
      return false;
    }
    $nama = valid($data['nama']);
    $id_jenis_kelamin = valid($data['id_jenis_kelamin']);
    $nilai_ipk = $data['nilai_ipk'];
    $nilai_spa = $data['nilai_spa'];
    $tour = "testing";

    // Mencari nilai rata-rata ipk
    $nilai_rata_rata_ipk = hitungRataRata($nilai_ipk);

    // Mencari nilai rata-rata spa
    $nilai_rata_rata_spa = hitungRataRata($nilai_spa);

    // Menghitung nilai rata-rata ipk dan spa
    $nilai_gabungan = array_merge($nilai_ipk, $nilai_spa);
    $nilai_rata_rata = hitungRataRata($nilai_gabungan);

    // Menginput data testing
    mysqli_query($conn, "INSERT INTO data_testing(id_testing,nim,nama,nilai_rata_rata_ipk,nilai_rata_rata_spa,nilai_rata_rata) VALUES('$id_testing','$nim','$nama','$nilai_rata_rata_ipk','$nilai_rata_rata_spa','$nilai_rata_rata')");

    // Menentukan jenis kelamin
    add_atribut_sub_jenis_kelamin($tour, $id_testing, $id_atr = 1, $id_jenis_kelamin, $conn);

    // Menentukan predikat ipk
    if (round($nilai_rata_rata, 0) < 2.5) {
      $atribut_ipk = "Cukup";
      add_atribut_sub_other($tour, $id_testing, $id_atr = 2, $atribut_ipk, $conn);
    } else if (round($nilai_rata_rata, 0) < 2.8) {
      $atribut_ipk = "Memuaskan";
      add_atribut_sub_other($tour, $id_testing, $id_atr = 2, $atribut_ipk, $conn);
    } else if (round($nilai_rata_rata, 0) < 3) {
      $atribut_ipk = "Sangat Memuaskan";
      add_atribut_sub_other($tour, $id_testing, $id_atr = 2, $atribut_ipk, $conn);
    } else if (round($nilai_rata_rata, 0) >= 3) {
      $atribut_ipk = "Dengan Pujian";
      add_atribut_sub_other($tour, $id_testing, $id_atr = 2, $atribut_ipk, $conn);
    }

    // Menentukan predikat spa
    if (round($nilai_rata_rata, 0) < 2.5) {
      $atribut_spa = "D";
      add_atribut_sub_other($tour, $id_testing, $id_atr = 3, $atribut_spa, $conn);
    } else if (round($nilai_rata_rata, 0) < 2.8) {
      $atribut_spa = "C";
      add_atribut_sub_other($tour, $id_testing, $id_atr = 3, $atribut_spa, $conn);
    } else if (round($nilai_rata_rata, 0) < 3) {
      $atribut_spa = "B";
      add_atribut_sub_other($tour, $id_testing, $id_atr = 3, $atribut_spa, $conn);
    } else if (round($nilai_rata_rata, 0) >= 3) {
      $atribut_spa = "A";
      add_atribut_sub_other($tour, $id_testing, $id_atr = 3, $atribut_spa, $conn);
    }

    // Menentukan prediksi
    if (round($nilai_rata_rata, 0) < 2.5) {
      $atribut_prediksi = "Tidak Tepat";
      add_atribut_sub_other($tour, $id_testing, $id_atr = 4, $atribut_prediksi, $conn);
    } else if (round($nilai_rata_rata, 0) >= 2.5) {
      $atribut_prediksi = "Lulus Tepat";
      add_atribut_sub_other($tour, $id_testing, $id_atr = 4, $atribut_prediksi, $conn);
    }

    // menginput IPK dari data testing
    for ($ipk = 1; $ipk <= count($nilai_ipk); $ipk++) {
      $ipk_fix = $ipk - 1;
      $insert_ipk = "INSERT INTO ipk_testing(id_testing,id_status_ipk,nilai_ipk) VALUES('$id_testing','$ipk','$nilai_ipk[$ipk_fix]')";
      mysqli_query($conn, $insert_ipk);
    }

    // menginput SPA dari data testing
    for ($spa = 1; $spa <= count($nilai_spa); $spa++) {
      $spa_fix = $spa - 1;
      $insert_spa = "INSERT INTO spa_testing(id_testing,id_status_spa,nilai_spa) VALUES('$id_testing','$spa','$nilai_spa[$spa_fix]')";
      mysqli_query($conn, $insert_spa);
    }

    // Menentukan predikat ipk
    if (round($id_jenis_kelamin, 0) == 1) {
      $status_jk = "Laki-Laki";
    } else if (round($id_jenis_kelamin, 0) == 2) {
      $status_jk = "Perempuan";
    }

    // Panggil fungsi prediksiKelulusan
    $hasil_prediksi = prediksiKelulusan($ipk, $spa);
    $_SESSION['prediksi'] = [
      'nama' => $nama,
      'jk' => $status_jk,
      'ipk' => $atribut_ipk,
      'spa' => $atribut_spa,
      'hasil_prediksi' => $atribut_prediksi,
    ];
    return mysqli_affected_rows($conn);
  }
  function getLastIdLatih($conn)
  {
    $data_latih = "SELECT * FROM data_latih ORDER BY id_latih DESC LIMIT 1";
    $checkID = mysqli_query($conn, $data_latih);
    if (mysqli_num_rows($checkID) > 0) {
      $rowCheck = mysqli_fetch_assoc($checkID);
      $id_latih = $rowCheck['id_latih'] + 1;
    } else {
      $id_latih = 1;
    }
    return $id_latih;
  }
  function getNilai($worksheet, $row, $startCol, $endCol)
  {
    $nilai = [];

    for ($col = $startCol; $col <= $endCol; $col++) {
      $nilai[] = valid($worksheet->getCellByColumnAndRow($col, $row)->getValue());
    }

    return $nilai;
  }
  function getPredikatIPK($nilai_rata_rata)
  {
    if ($nilai_rata_rata < 2.5) {
      return "Cukup";
    } elseif ($nilai_rata_rata < 2.8) {
      return "Memuaskan";
    } elseif ($nilai_rata_rata < 3) {
      return "Sangat Memuaskan";
    } elseif ($nilai_rata_rata >= 3) {
      return "Dengan Pujian";
    }

    return "Tidak Diketahui"; // Predikat tidak ditemukan
  }
  function getPredikatSPA($nilai_rata_rata)
  {
    if ($nilai_rata_rata < 2.5) {
      return "D";
    } elseif ($nilai_rata_rata < 2.8) {
      return "C";
    } elseif ($nilai_rata_rata < 3) {
      return "B";
    } elseif ($nilai_rata_rata >= 3) {
      return "A";
    }

    return "Tidak Diketahui"; // Predikat tidak ditemukan
  }
  function getPrediksi($nilai_rata_rata)
  {
    if ($nilai_rata_rata < 2.5) {
      return "Tidak Tepat";
    } elseif ($nilai_rata_rata >= 2.5) {
      return "Lulus Tepat";
    }

    return "Tidak Diketahui"; // Prediksi tidak ditemukan
  }
  function import_atribut_sub_jenis_kelamin($tour, $id_latih, $id_atr,  $id_jenis_kelamin, $conn)
  {
    $sql = "INSERT INTO atribut_$tour(id_$tour, id_atribut, id_atribut_sub) VALUES('$id_latih', '$id_atr', '$id_jenis_kelamin')";
    $result = mysqli_query($conn, $sql);
    return $result;
  }
  function import_atribut_sub_other($tour, $id_latih, $id_atr, $atribut_sub, $conn)
  {
    $id_atribut_sub = getIdAtributSub($conn, $atribut_sub);

    if ($id_atribut_sub !== null) {
      $sql = "INSERT INTO atribut_$tour(id_$tour, id_atribut, id_atribut_sub) VALUES('$id_latih', '$id_atr', '$id_atribut_sub')";
      $result = mysqli_query($conn, $sql);
      return $result;
    }

    return false;
  }
  function getIdAtributSub($conn, $atribut_sub)
  {
    $checkAtributSub = "SELECT id_atribut_sub FROM atribut_sub WHERE atribut_sub='$atribut_sub'";
    $queryAtributSub = mysqli_query($conn, $checkAtributSub);

    if (mysqli_num_rows($queryAtributSub) > 0) {
      $row = mysqli_fetch_assoc($queryAtributSub);
      return $row['id_atribut_sub'];
    }

    return null;
  }
  function import_latih($filename)
  {
    global $conn;
    $tour = "latih";

    require '../assets/vendor/autoload.php';

    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filename);
    $worksheet = $spreadsheet->getActiveSheet();
    $highestRow = $worksheet->getHighestRow();

    // Loop through each row in the Excel file
    for ($row = 1; $row <= $highestRow; $row++) {
      // Mengambil ID terakhir dan menambahkannya
      $id_latih = getLastIdLatih($conn) + 1;

      $nim = valid($worksheet->getCell('A' . $row)->getValue());
      $nama = valid($worksheet->getCell('B' . $row)->getValue());
      $id_jenis_kelamin = valid($worksheet->getCell('C' . $row)->getValue());


      // Mengambil nilai IPK dan SPA dari sel-sel yang sesuai
      $nilai_ipk = getNilai($worksheet, $row, 4, 10);
      $nilai_spa = getNilai($worksheet, $row, 11, 16);

      // Menghitung nilai rata-rata IPK dan SPA
      $nilai_rata_rata_ipk = hitungRataRata($nilai_ipk);
      $nilai_rata_rata_spa = hitungRataRata($nilai_spa);

      // Menghitung nilai rata-rata gabungan IPK dan SPA
      $nilai_gabungan = array_merge($nilai_ipk, $nilai_spa);
      $nilai_rata_rata = hitungRataRata($nilai_gabungan);

      // Memasukkan data latih ke database
      mysqli_query($conn, "INSERT INTO data_latih(id_latih, nim, nama, nilai_rata_rata_ipk, nilai_rata_rata_spa, nilai_rata_rata) VALUES ('$id_latih', '$nim', '$nama', '$nilai_rata_rata_ipk', '$nilai_rata_rata_spa', '$nilai_rata_rata')");

      // menginput IPK dari data latih
      for ($ipk = 1; $ipk <= count($nilai_ipk); $ipk++) {
        $ipk_fix = $ipk - 1;
        $insert_ipk = "INSERT INTO ipk_latih(id_latih,id_status_ipk,nilai_ipk) VALUES('$id_latih','$ipk','$nilai_ipk[$ipk_fix]')";
        mysqli_query($conn, $insert_ipk);
      }

      // menginput SPA dari data latih
      for ($spa = 1; $spa <= count($nilai_spa); $spa++) {
        $spa_fix = $spa - 1;
        $insert_spa = "INSERT INTO spa_latih(id_latih,id_status_spa,nilai_spa) VALUES('$id_latih','$spa','$nilai_spa[$spa_fix]')";
        mysqli_query($conn, $insert_spa);
      }

      // Menentukan jenis kelamin
      import_atribut_sub_jenis_kelamin($tour, $id_latih, $id_atr = 1, $id_jenis_kelamin, $conn);

      // Menentukan predikat IPK
      $predikat_ipk = getPredikatIPK($nilai_rata_rata);
      import_atribut_sub_other($tour, $id_latih, $id_atr = 2,  $predikat_ipk, $conn);

      // Menentukan predikat SPA
      $predikat_spa = getPredikatSPA($nilai_rata_rata);
      import_atribut_sub_other($tour, $id_latih, $id_atr = 3,  $predikat_spa, $conn);

      // Menentukan prediksi
      $prediksi = getPrediksi($nilai_rata_rata);
      import_atribut_sub_other($tour, $id_latih, $id_atr = 4,  $prediksi, $conn);
    }

    return mysqli_affected_rows($conn);
  }
  function delete_all_latih($data)
  {
    global $conn;
    $sql = "DELETE FROM data_latih";
    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
  }
  function tambah_beranda($data)
  {
    global $conn;
    if (isset($_FILES['images'])) {
      $files = $_FILES['images'];
      $upload_directory = "../assets/images/beranda/";

      for ($i = 0; $i < count($files['name']); $i++) {
        $file_name = $files['name'][$i];
        $file_tmp = $files['tmp_name'][$i];
        $file_size = $files['size'][$i];

        if ($file_size > 2097152) {
          $_SESSION['message-danger'] = "File size must be exactly 2 MB";
          $_SESSION['time-message'] = time();
          return false;
        }

        $fileName = str_replace(" ", "-", $file_name);
        $fileName_encrypt = crc32($fileName);
        $ekstensiGambar = explode('.', $fileName);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        $imageUploadPath = $upload_directory . $fileName_encrypt . "." . $ekstensiGambar;
        $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
        $allowTypes = array('jpg', 'png', 'jpeg');
        if (in_array($fileType, $allowTypes)) {
          compressImage($file_tmp, $imageUploadPath, 75);
          $image = $fileName_encrypt . "." . $ekstensiGambar;
          mysqli_query($conn, "INSERT INTO beranda(image) VALUES('$image')");
        } else {
          $_SESSION['message-danger'] = "Sorry, only JPG, JPEG and PNG image files are allowed.";
          $_SESSION['time-message'] = time();
          return false;
        }
      }
    }
    return mysqli_affected_rows($conn);
  }
  function hapus_beranda($data)
  {
    global $conn;
    $id = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['id']))));
    $image = htmlspecialchars(addslashes(trim(mysqli_real_escape_string($conn, $data['image']))));
    $path = "../assets/images/beranda/";
    unlink($path . $image);
    mysqli_query($conn, "DELETE FROM beranda WHERE id='$id'");
    return mysqli_affected_rows($conn);
  }
}
