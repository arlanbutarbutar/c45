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
  function add_atribut_sub_jenis_kelamin($tour, $id_latih, $id_atribut_sub, $conn)
  {
    $sql = "INSERT INTO atribut_$tour(id_$tour,id_atribut_sub) VALUES('$id_latih','$id_atribut_sub')";
    $result = mysqli_query($conn, $sql);
    return $result;
  }
  function edit_atribut_sub_jenis_kelamin($tour, $id_latih, $id_atribut_sub, $conn)
  {
    $sql_delete = "DELETE FROM atribut_$tour WHERE id_$tour='$id_latih'";
    $result_delete = mysqli_query($conn, $sql_delete);

    // Periksa jika penghapusan gagal
    if (!$result_delete) {
      return false;
    }

    $sql_insert = "INSERT INTO atribut_$tour(id_$tour,id_atribut_sub) VALUES('$id_latih','$id_atribut_sub')";
    $result_insert = mysqli_query($conn, $sql_insert);

    // Periksa jika penambahan gagal
    if (!$result_insert) {
      return false;
    }

    return true;
  }
  function add_atribut_sub_other($tour, $id_latih, $atribut_sub, $conn)
  {
    $checkCukup = "SELECT * FROM atribut_sub WHERE atribut_sub='$atribut_sub'";
    $queryCukup = mysqli_query($conn, $checkCukup);
    if (mysqli_num_rows($queryCukup) > 0) {
      $row = mysqli_fetch_assoc($queryCukup);
      $id_atribut_sub = $row['id_atribut_sub'];
      $sql = "INSERT INTO atribut_$tour(id_$tour,id_atribut_sub) VALUES('$id_latih','$id_atribut_sub')";
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
    add_atribut_sub_jenis_kelamin($tour, $id_latih, $id_jenis_kelamin, $conn);

    // Menentukan predikat ipk
    if (round($nilai_rata_rata_ipk, 0) <= 1) {
      $atribut_sub = "Cukup";
      add_atribut_sub_other($tour, $id_latih, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_ipk, 0) == 2) {
      $atribut_sub = "Memuaskan";
      add_atribut_sub_other($tour, $id_latih, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_ipk, 0) == 3) {
      $atribut_sub = "Sangat Memuaskan";
      add_atribut_sub_other($tour, $id_latih, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_ipk, 0) >= 4) {
      $atribut_sub = "Dengan Pujian";
      add_atribut_sub_other($tour, $id_latih, $atribut_sub, $conn);
    }

    // Menentukan predikat ipk
    if (round($nilai_rata_rata_spa, 0) <= 1) {
      $atribut_sub = "D";
      add_atribut_sub_other($tour, $id_latih, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_spa, 0) == 2) {
      $atribut_sub = "C";
      add_atribut_sub_other($tour, $id_latih, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_spa, 0) == 3) {
      $atribut_sub = "B";
      add_atribut_sub_other($tour, $id_latih, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_spa, 0) >= 4) {
      $atribut_sub = "A";
      add_atribut_sub_other($tour, $id_latih, $atribut_sub, $conn);
    }

    // Menentukan prediksi
    if (round($nilai_rata_rata, 0) < 2) {
      $atribut_sub = "Tidak Tepat";
      add_atribut_sub_other($tour, $id_latih, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata, 0) >= 2) {
      $atribut_sub = "Lulus Tepat";
      add_atribut_sub_other($tour, $id_latih, $atribut_sub, $conn);
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
    edit_atribut_sub_jenis_kelamin($tour, $id_latih, $id_jenis_kelamin, $conn);

    // Menentukan predikat ipk
    if (round($nilai_rata_rata_ipk, 0) <= 1) {
      $atribut_sub = "Cukup";
      add_atribut_sub_other($tour, $id_latih, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_ipk, 0) == 2) {
      $atribut_sub = "Memuaskan";
      add_atribut_sub_other($tour, $id_latih, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_ipk, 0) == 3) {
      $atribut_sub = "Sangat Memuaskan";
      add_atribut_sub_other($tour, $id_latih, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_ipk, 0) >= 4) {
      $atribut_sub = "Dengan Pujian";
      add_atribut_sub_other($tour, $id_latih, $atribut_sub, $conn);
    }

    // Menentukan predikat ipk
    if (round($nilai_rata_rata_spa, 0) <= 1) {
      $atribut_sub = "D";
      add_atribut_sub_other($tour, $id_latih, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_spa, 0) == 2) {
      $atribut_sub = "C";
      add_atribut_sub_other($tour, $id_latih, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_spa, 0) == 3) {
      $atribut_sub = "B";
      add_atribut_sub_other($tour, $id_latih, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_spa, 0) >= 4) {
      $atribut_sub = "A";
      add_atribut_sub_other($tour, $id_latih, $atribut_sub, $conn);
    }

    // Menentukan prediksi
    if (round($nilai_rata_rata, 0) < 2) {
      $atribut_sub = "Tidak Tepat";
      add_atribut_sub_other($tour, $id_latih, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata, 0) >= 2) {
      $atribut_sub = "Lulus Tepat";
      add_atribut_sub_other($tour, $id_latih, $atribut_sub, $conn);
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
  function add_testing($data)
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
    add_atribut_sub_jenis_kelamin($tour, $id_testing, $id_jenis_kelamin, $conn);

    // Menentukan predikat ipk
    if (round($nilai_rata_rata_ipk, 0) <= 1) {
      $atribut_sub = "Cukup";
      add_atribut_sub_other($tour, $id_testing, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_ipk, 0) == 2) {
      $atribut_sub = "Memuaskan";
      add_atribut_sub_other($tour, $id_testing, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_ipk, 0) == 3) {
      $atribut_sub = "Sangat Memuaskan";
      add_atribut_sub_other($tour, $id_testing, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_ipk, 0) >= 4) {
      $atribut_sub = "Dengan Pujian";
      add_atribut_sub_other($tour, $id_testing, $atribut_sub, $conn);
    }

    // Menentukan predikat ipk
    if (round($nilai_rata_rata_spa, 0) <= 1) {
      $atribut_sub = "D";
      add_atribut_sub_other($tour, $id_testing, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_spa, 0) == 2) {
      $atribut_sub = "C";
      add_atribut_sub_other($tour, $id_testing, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_spa, 0) == 3) {
      $atribut_sub = "B";
      add_atribut_sub_other($tour, $id_testing, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_spa, 0) >= 4) {
      $atribut_sub = "A";
      add_atribut_sub_other($tour, $id_testing, $atribut_sub, $conn);
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
    edit_atribut_sub_jenis_kelamin($tour, $id_testing, $id_jenis_kelamin, $conn);

    // Menentukan predikat ipk
    if (round($nilai_rata_rata_ipk, 0) <= 1) {
      $atribut_sub = "Cukup";
      add_atribut_sub_other($tour, $id_testing, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_ipk, 0) == 2) {
      $atribut_sub = "Memuaskan";
      add_atribut_sub_other($tour, $id_testing, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_ipk, 0) == 3) {
      $atribut_sub = "Sangat Memuaskan";
      add_atribut_sub_other($tour, $id_testing, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_ipk, 0) >= 4) {
      $atribut_sub = "Dengan Pujian";
      add_atribut_sub_other($tour, $id_testing, $atribut_sub, $conn);
    }

    // Menentukan predikat ipk
    if (round($nilai_rata_rata_spa, 0) <= 1) {
      $atribut_sub = "D";
      add_atribut_sub_other($tour, $id_testing, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_spa, 0) == 2) {
      $atribut_sub = "C";
      add_atribut_sub_other($tour, $id_testing, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_spa, 0) == 3) {
      $atribut_sub = "B";
      add_atribut_sub_other($tour, $id_testing, $atribut_sub, $conn);
    } else if (round($nilai_rata_rata_spa, 0) >= 4) {
      $atribut_sub = "A";
      add_atribut_sub_other($tour, $id_testing, $atribut_sub, $conn);
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
}
