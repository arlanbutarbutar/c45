<?php
require_once("../controller/db_connect.php");

function entropy_gain()
{
  global $conn;

  $data_ipk = "SELECT * FROM ipk_latih";
  $dataIPK = mysqli_query($conn, $data_ipk);
  $data_arrayIPK = array();
  foreach ($dataIPK as $row_ipk) {
    $data_arrayIPK[$row_ipk['id_latih']][$row_ipk['id_status_ipk']] = $row_ipk['nilai_ipk'];
  }

  $data_spa = "SELECT * FROM spa_latih";
  $dataSPA = mysqli_query($conn, $data_spa);
  $data_arraySPA = array();
  foreach ($dataSPA as $row_spa) {
    $data_arraySPA[$row_spa['id_latih']][$row_spa['id_status_spa']] = $row_spa['nilai_spa'];
  }

  $data_atribut = "SELECT * FROM atribut_sub JOIN atribut_latih ON atribut_sub.id_atribut_sub=atribut_latih.id_atribut_sub JOIN atribut ON atribut_latih.id_atribut=atribut.id_atribut";
  $dataAtribut = mysqli_query($conn, $data_atribut);
  $data_arrayAtribut = array();
  foreach ($dataAtribut as $row_atribut) {
    $data_arrayAtribut[$row_atribut['id_latih']][$row_atribut['id_atribut']] = $row_atribut['atribut_sub'];
  }

  $query = "SELECT data_latih.*, atribut_latih.id_atribut, atribut_latih.id_atribut_sub 
              FROM data_latih 
              JOIN atribut_latih ON data_latih.id_latih = atribut_latih.id_latih
              JOIN atribut_sub ON atribut_latih.id_atribut_sub = atribut_sub.id_atribut_sub";
  $result = mysqli_query($conn, $query);
  $data_uji = array();
  while ($row_latih = mysqli_fetch_assoc($result)) {
    $data_uji[] = array(
      'NIM' => $row_latih['nim'],
      'Nama' => $row_latih['nama'],
      'Jenis_Kelamin' => $data_arrayAtribut[$row_latih['id_latih']][1],
      'IPK' => [
        1 => $data_arrayIPK[$row_latih['id_latih']][1],
        2 => $data_arrayIPK[$row_latih['id_latih']][2],
        3 => $data_arrayIPK[$row_latih['id_latih']][3],
        4 => $data_arrayIPK[$row_latih['id_latih']][4]
      ],
      'nilai_SPA' => [
        1 => $data_arraySPA[$row_latih['id_latih']][1],
        2 => $data_arraySPA[$row_latih['id_latih']][2],
        3 => $data_arraySPA[$row_latih['id_latih']][3],
        4 => $data_arraySPA[$row_latih['id_latih']][4],
        5 => $data_arraySPA[$row_latih['id_latih']][5],
        6 => $data_arraySPA[$row_latih['id_latih']][6]
      ],
      'nilai_rata_rata_IPK' => $row_latih['nilai_rata_rata_ipk'],
      'nilai_rata_rata_SPA' => $row_latih['nilai_rata_rata_spa'],
      'Predikat_IPK' => $data_arrayAtribut[$row_latih['id_latih']][2],
      'Predikat_SPA' => $data_arrayAtribut[$row_latih['id_latih']][3],
      'nilai_rata_rata_IPK_&_perancangan' => $row_latih['nilai_rata_rata'],
      'Prediksi' => $data_arrayAtribut[$row_latih['id_latih']][4]
    );
  }

  $atribut = ['Jenis_Kelamin', 'Predikat_IPK', 'Predikat_SPA', 'Prediksi'];
  $atribut_penentu = 'Prediksi';
  $key_penentu = 'Lulus Tepat';

  //pengelompokan atribut & sub atribut
  $atribut_sub_atribut = [];

  foreach ($atribut as $key_atribut => $value_atribut) {

    $atribut_sub_atribut[$key_atribut]['atribut'] = $value_atribut;

    $array_count_values = array_count_values(array_column($data_uji, $value_atribut));
    $array_count_values_penentu = array_count_values(array_column($data_uji, $atribut_penentu));

    foreach ($array_count_values as $key_array_count_values => $value_array_count_values) {

      $i = 0;
      $j = 0;
      $x = 0;

      foreach ($array_count_values_penentu as $key_array_count_values_penentu => $value_array_count_values_penentu) {

        foreach ($data_uji as $value_trainingData) {

          if ($value_trainingData[$value_atribut] == $key_array_count_values) {

            if ($value_trainingData[$atribut_penentu] == $key_array_count_values_penentu) {

              $atribut_sub_atribut[$key_atribut][$key_array_count_values]['jumlah'] = ++$i;

              if ($value_trainingData[$atribut_penentu] == $key_penentu) {

                $atribut_sub_atribut[$key_atribut][$key_array_count_values]['lulus'] = ++$j;
              } else {

                $atribut_sub_atribut[$key_atribut][$key_array_count_values]['tidak lulus'] = ++$x;
              }
            }
          }
        }
      }
    }
  }

  //perhitungan entropy
  $i = 0;
  $entropy_gain = [];
  $entropy_gain_penentu = [];

  $total = count($data_uji);

  // memanggil fungsi entropy
  foreach ($atribut_sub_atribut as $key_atribut_sub_atribut => $value_atribut_sub_atribut) {

    $entropy_gain[0][$key_atribut_sub_atribut]['atribut'] = $value_atribut_sub_atribut['atribut'];
    $entropy_gain[0][$key_atribut_sub_atribut]['entropy'] = entropy($atribut_sub_atribut, $key_atribut_sub_atribut, $total, $atribut_penentu);

    if ($entropy_gain[0][$key_atribut_sub_atribut]['atribut'] == $atribut_penentu) {

      $entropy_gain_penentu = $entropy_gain[0][$key_atribut_sub_atribut];
    }
  }

  // memanggil fungsi gain
  foreach ($entropy_gain[0] as $key_entropy_gain => $value_entropy_gain) {

    if ($value_entropy_gain['atribut'] !== $atribut_penentu) {

      $entropy_gain[0][$key_entropy_gain]['gain'] = gain($entropy_gain_penentu, $value_entropy_gain, $total);
    } else {

      unset($entropy_gain[0][$key_entropy_gain]);
    }
  }

  //mengurutkan $entropy_gain secara descending
  $gains = array_column($entropy_gain[0], 'gain');
  array_multisort($gains, SORT_DESC, $entropy_gain[0]);

  $atribut_sub_atribut_baru = [];
  foreach ($atribut_sub_atribut as $key_atribut_sub_atribut => $value_atribut_sub_atribut) {

    if ($value_atribut_sub_atribut['atribut'] !== $atribut_penentu) {

      $atribut_sub_atribut_baru[$key_atribut_sub_atribut] = $value_atribut_sub_atribut;
    }
  }

  //mengambil nilai gain atribut tertinggi dari $entropy_gain
  $gain_atribut_tertinggi = $entropy_gain[0][0];

  //mengatur ulang index array
  $atribut_sub_atribut_baru = array_values($atribut_sub_atribut_baru);

  //mengeliminasi nilai entropy = 0 dari atribut tertinggi
  foreach ($gain_atribut_tertinggi['entropy'] as $key_gain_atribut_tertinggi => $value_gain_atribut_tertinggi) {

    if ($value_gain_atribut_tertinggi['entropy'] == null) {

      unset($gain_atribut_tertinggi['entropy'][$key_gain_atribut_tertinggi]);
    }
  }

  if ($gain_atribut_tertinggi['entropy'] == null) {

    return $entropy_gain;
  }

  //perhitungan entropy & gain atribut tertinggi
  $i = 0;
  foreach ($gain_atribut_tertinggi['entropy'] as $key_gain_atribut_tertinggi => $value_gain_atribut_tertinggi) {

    $total = $value_gain_atribut_tertinggi['jumlah'];

    $sub_atribut_tertinggi = $key_gain_atribut_tertinggi;

    $atribut_penentu_baru = $gain_atribut_tertinggi['atribut'];

    //entropy
    foreach ($atribut_sub_atribut_baru as $key_atribut_sub_atribut_baru => $value_atribut_sub_atribut_baru) {

      if ($key_atribut_sub_atribut_baru !== ['atribut']) {

        $entropy_gain[1][$i][$key_atribut_sub_atribut_baru]['atribut'] = $value_atribut_sub_atribut_baru['atribut'];
        $entropy_gain[1][$i][$key_atribut_sub_atribut_baru]['entropy'] = entropy($atribut_sub_atribut_baru, $key_atribut_sub_atribut_baru, $total, $atribut_penentu_baru, $sub_atribut_tertinggi, $data_uji, $atribut_penentu, $key_penentu);

        if ($entropy_gain[1][$i][$key_atribut_sub_atribut_baru]['atribut'] == $atribut_penentu_baru) {

          $entropy_gain_penentu = $entropy_gain[1][$i][$key_atribut_sub_atribut_baru];
        }
      }
    }

    //gain
    foreach ($entropy_gain[1][$i] as $key_entropy_gain => $value_entropy_gain) {

      if ($value_entropy_gain['atribut'] !== $atribut_penentu_baru) {

        $entropy_gain[1][$i][$key_entropy_gain]['gain'] = gain($entropy_gain_penentu, $value_entropy_gain, $total, $sub_atribut_tertinggi);
        $entropy_gain[1][$i][$key_entropy_gain]['attr_key'] = $gain_atribut_tertinggi['atribut'];
        $entropy_gain[1][$i][$key_entropy_gain]['sub_attr_key'] = $key_gain_atribut_tertinggi;
      } else {

        unset($entropy_gain[1][$i][$key_entropy_gain]);
      }
    }

    $i++;
  }

  //filter atribut untuk ke perhitungan sampai selesai
  $atribut_sampai_selesai = [];
  foreach ($entropy_gain[1] as $key_entropy_gain => $value_entropy_gain) {

    foreach ($value_entropy_gain as $key_value_entropy_gain => $value_value_entropy_gain) {

      $temp = $value_entropy_gain;
      $gains = array_column($temp, 'gain');
      array_multisort($gains, SORT_DESC, $temp);
      $atribut_sampai_selesai[$key_entropy_gain] = $temp;
    }

    $valid = false;
    foreach ($atribut_sampai_selesai[$key_entropy_gain][0]['entropy'] as $key_value_temp1 => $value_value_temp1) {

      if ($value_value_temp1['entropy'] != null) {

        $valid = true;
      }
    }

    if ($valid == false) {

      unset($atribut_sampai_selesai[$key_entropy_gain]);
    }
  }

  //menyusun atribut baru untuk ke perhitungan sampai selesai
  $atribut_sub_atribut_baru = [];
  $i = 0;
  foreach ($atribut_sampai_selesai[0] as $key_atribut_sampai_selesai => $value_atribut_sampai_selesai) {

    foreach ($atribut_sub_atribut as $key_atribut_sub_atribut => $value_atribut_sub_atribut) {

      if ($value_atribut_sub_atribut['atribut'] !== $atribut_penentu && $value_atribut_sub_atribut['atribut'] == $value_atribut_sampai_selesai['atribut']) {

        $atribut_sub_atribut_baru[$i] = $value_atribut_sub_atribut;
        $i++;
      }
    }
  }

  //menyusun ulang index array
  $atribut_sampai_selesai = array_values($atribut_sampai_selesai);
  $atribut_sub_atribut_baru = array_values($atribut_sub_atribut_baru);

  //menentukan atribut dan sub atribut kedua untuk ke perhitungan sampai selesai
  $attr_sub_attr_key2 = [];
  foreach ($atribut_sampai_selesai as $key_atribut_sampai_selesai => $value_atribut_sampai_selesai) {

    foreach ($value_atribut_sampai_selesai[0]['entropy'] as $key_value_atribut_sampai_selesai => $value_value_atribut_sampai_selesai) {

      if ($value_value_atribut_sampai_selesai['entropy'] !== null) {

        $attr_sub_attr_key2[$key_atribut_sampai_selesai]['attr'] = $value_atribut_sampai_selesai[0]['atribut'];
        $attr_sub_attr_key2[$key_atribut_sampai_selesai]['sub_attr'] = $key_value_atribut_sampai_selesai;
        $attr_sub_attr_key2[$key_atribut_sampai_selesai]['total'] = $value_value_atribut_sampai_selesai['jumlah'];
      }
    }
  }

  //perhitungan entropy & gain sampai selesai
  $i = 0;
  foreach ($atribut_sampai_selesai as $key_atribut_sampai_selesai => $value_atribut_sampai_selesai) {

    foreach ($value_atribut_sampai_selesai as $key_value_atribut_sampai_selesai => $value_value_atribut_sampai_selesai) {

      foreach ($value_value_atribut_sampai_selesai['entropy'] as $key_value_value_atribut_sampai_selesai => $value_value_value_atribut_sampai_selesai) {

        if ($value_value_value_atribut_sampai_selesai['entropy'] != null) {

          if ($key_value_atribut_sampai_selesai == 0) {

            $total = $value_atribut_sampai_selesai[0]['entropy'][$key_value_value_atribut_sampai_selesai]['jumlah'];
          }

          $sub_atribut_tertinggi = $key_value_value_atribut_sampai_selesai;

          $atribut_penentu_baru = $value_value_atribut_sampai_selesai['atribut'];

          //entropy
          foreach ($atribut_sub_atribut_baru as $key_atribut_sub_atribut_baru => $value_atribut_sub_atribut_baru) {

            if ($value_atribut_sampai_selesai[$key_value_atribut_sampai_selesai]['atribut'] == $value_atribut_sub_atribut_baru['atribut']) {

              if ($key_atribut_sub_atribut_baru !== ['atribut']) {

                $entropy_gain[2][$i][$key_atribut_sub_atribut_baru]['atribut'] = $value_atribut_sub_atribut_baru['atribut'];
                $entropy_gain[2][$i][$key_atribut_sub_atribut_baru]['entropy'] = entropy($atribut_sub_atribut_baru, $key_atribut_sub_atribut_baru, $total, $atribut_penentu_baru, $sub_atribut_tertinggi, $data_uji, $atribut_penentu, $key_penentu, $value_value_atribut_sampai_selesai['attr_key'], $value_value_atribut_sampai_selesai['sub_attr_key'], $attr_sub_attr_key2[$key_atribut_sampai_selesai]);

                if ($entropy_gain[2][$i][$key_atribut_sub_atribut_baru]['atribut'] == $atribut_penentu_baru) {

                  $entropy_gain_penentu = $entropy_gain[2][$i][$key_atribut_sub_atribut_baru];
                }
              }
            }
          }
        }

        //gain
        foreach ($entropy_gain[2][$i] as $key_entropy_gain => $value_entropy_gain) {

          if ($value_entropy_gain['atribut'] !== $atribut_penentu_baru) {

            $entropy_gain[2][$i][$key_entropy_gain + 1]['gain'] = gain($entropy_gain_penentu, $value_entropy_gain, $total, $sub_atribut_tertinggi);
          }
        }
      }
    }

    $i++;
  }

  print_r($entropy_gain);
  return $entropy_gain;
}

function value_atribut_terpilih_baru($atribut_terpilih, $key_atribut_terpilih, $atribut_penentu, $sub_atribut_tertinggi, $atribut_penentu_awal, $key_penentu, $data_uji, $attr_key = null, $sub_attr_key = null, $attr_sub_attr_key2 = null)
{

  $value = $key_atribut_terpilih;
  $value_sub = $sub_attr_key;

  if ($attr_sub_attr_key2 != null) {

    $value_sub2 = $attr_sub_attr_key2['sub_attr'];
    $index2 = $attr_sub_attr_key2['attr'];
  }

  $index = $atribut_terpilih['atribut'];

  $hasil = [];

  //mencari kolom dan value
  foreach ($data_uji as $key_data_uji => $value_data_uji) {

    foreach ($value_data_uji as $key_value_data_uji => $value_value_data_uji) {

      if ($value_data_uji[$index] == $value) {

        if ($attr_key != null && $sub_attr_key != null && $attr_sub_attr_key2 != null) {

          if ($value_data_uji[$attr_key] == $value_sub) {

            if ($value_data_uji[$index2] == $value_sub2) {

              if ($value_data_uji[$atribut_penentu] == $sub_atribut_tertinggi) {

                if ($value_data_uji[$atribut_penentu_awal] == $key_penentu) {

                  $hasil['lulus'][$key_data_uji] = $value_data_uji;
                } else {

                  $hasil['tidak lulus'][$key_data_uji] = $value_data_uji;
                }
              }
            }
          }
        } else {

          if ($value_data_uji[$atribut_penentu] == $sub_atribut_tertinggi) {

            if ($value_data_uji[$atribut_penentu_awal] == $key_penentu) {

              $hasil['lulus'][$key_data_uji] = $value_data_uji;
            } else {

              $hasil['tidak lulus'][$key_data_uji] = $value_data_uji;
            }
          }
        }
      }
    }
  }

  if (!isset($hasil['lulus']) && isset($hasil['tidak lulus'])) {

    $return['jumlah'] = count($hasil['tidak lulus']);
    $return['tidak lulus'] = count($hasil['tidak lulus']);
  } elseif (!isset($hasil['tidak lulus']) && isset($hasil['lulus'])) {

    $return['jumlah'] = count($hasil['lulus']);
    $return['lulus'] = count($hasil['lulus']);
  } elseif (isset($hasil['lulus']) && isset($hasil['tidak lulus'])) {

    $return['jumlah'] = count($hasil['lulus']) + count($hasil['tidak lulus']);
    $return['lulus'] = count($hasil['lulus']);
    $return['tidak lulus'] = count($hasil['tidak lulus']);
  } else {

    $return['jumlah'] = 0;
  }

  return $return;
}

function entropy($atribut_sub_atribut, $key_atribut_sub_atribut, $total, $atribut_penentu, $sub_atribut_tertinggi = null, $data_uji = null, $atribut_penentu_awal = null, $key_penentu = null, $attr_key = null, $sub_attr_key = null, $attr_sub_attr_key2 = null)
{
  $entropy = [];

  $atribut_terpilih = $atribut_sub_atribut[$key_atribut_sub_atribut];
  $temp = [];

  foreach ($atribut_terpilih as $key_atribut_terpilih => $value_atribut_terpilih) {

    if ($atribut_terpilih['atribut'] == $atribut_penentu) {

      if ($key_atribut_terpilih !== 'atribut') {

        if ($sub_atribut_tertinggi != null) {

          $value_atribut_terpilih = $atribut_terpilih[$sub_atribut_tertinggi];
        }

        if ($attr_key !== null && $sub_attr_key !== null && $attr_sub_attr_key2 != null) {

          $value_atribut_terpilih = value_atribut_terpilih_baru($atribut_terpilih, $key_atribut_terpilih, $atribut_penentu, $sub_atribut_tertinggi, $atribut_penentu_awal, $key_penentu, $data_uji, $attr_key, $sub_attr_key, $attr_sub_attr_key2);

          if (isset($value_atribut_terpilih['lulus'])) {

            $temp['lulus'] = $value_atribut_terpilih['lulus'];
          }

          if (isset($value_atribut_terpilih['tidak lulus'])) {

            $temp['tidak lulus'] = $value_atribut_terpilih['tidak lulus'];
          }
        } else {

          if (isset($value_atribut_terpilih['lulus'])) {

            $temp['lulus'] = $value_atribut_terpilih['lulus'];
          }

          if (isset($value_atribut_terpilih['tidak lulus'])) {

            $temp['tidak lulus'] = $value_atribut_terpilih['tidak lulus'];
          }
        }

        if ($sub_atribut_tertinggi !== null) {

          break;
        }
      }
    } else {

      if ($key_atribut_terpilih !== 'atribut') {

        if (isset($value_atribut_terpilih['lulus']) && isset($value_atribut_terpilih['tidak lulus'])) {

          $entropy_valid = true;

          if ($sub_atribut_tertinggi !== null && $data_uji !== null) {

            if ($attr_key != null && $sub_attr_key != null) {

              $value_atribut_terpilih = value_atribut_terpilih_baru($atribut_terpilih, $key_atribut_terpilih, $atribut_penentu, $sub_atribut_tertinggi, $atribut_penentu_awal, $key_penentu, $data_uji, $attr_key, $sub_attr_key);
            } else {

              $value_atribut_terpilih = value_atribut_terpilih_baru($atribut_terpilih, $key_atribut_terpilih, $atribut_penentu, $sub_atribut_tertinggi, $atribut_penentu_awal, $key_penentu, $data_uji);
            }

            if (!isset($value_atribut_terpilih['lulus']) || !isset($value_atribut_terpilih['tidak lulus'])) {

              $entropy_valid = false;

              if (!isset($value_atribut_terpilih['lulus'])) {

                $value_atribut_terpilih['lulus'] = 0;
              }
              if (!isset($value_atribut_terpilih['tidak lulus'])) {

                $value_atribut_terpilih['tidak lulus'] = 0;
              }
              if (!isset($value_atribut_terpilih['lulus']) && !isset($value_atribut_terpilih['tidak lulus'])) {

                $value_atribut_terpilih['lulus'] = 0;
                $value_atribut_terpilih['tidak lulus'] = 0;
              }

              $entropy[$key_atribut_terpilih] = ['jumlah' => $value_atribut_terpilih['jumlah'], 'y' => $value_atribut_terpilih['lulus'], 'n' => $value_atribut_terpilih['tidak lulus'], 'entropy' => null];
            }
          }

          if ($entropy_valid == true) {

            $temp1 = -$value_atribut_terpilih['lulus'] / $total;
            $temp2 = -$value_atribut_terpilih['tidak lulus'] / $total;

            $entropy[$key_atribut_terpilih] = ['jumlah' => $value_atribut_terpilih['jumlah'], 'y' => $value_atribut_terpilih['lulus'], 'n' => $value_atribut_terpilih['tidak lulus'], 'entropy' => $temp1 * log(($value_atribut_terpilih['lulus'] / $total), 2) + ($temp2 * log(($value_atribut_terpilih['tidak lulus'] / $total), 2))];
          }
        } else {

          if (!isset($value_atribut_terpilih['lulus'])) {

            $value_atribut_terpilih['lulus'] = 0;
          }
          if (!isset($value_atribut_terpilih['tidak lulus'])) {

            $value_atribut_terpilih['tidak lulus'] = 0;
          }
          if (!isset($value_atribut_terpilih['lulus']) && !isset($value_atribut_terpilih['tidak lulus'])) {

            $value_atribut_terpilih['lulus'] = 0;
            $value_atribut_terpilih['tidak lulus'] = 0;
          }

          $entropy[$key_atribut_terpilih] = ['jumlah' => $value_atribut_terpilih['jumlah'], 'y' => $value_atribut_terpilih['lulus'], 'n' => $value_atribut_terpilih['tidak lulus'], 'entropy' => null];
        }
      }
    }
  }

  if ($atribut_terpilih['atribut'] == $atribut_penentu) {

    if (!isset($temp['lulus'])) {

      $temp['lulus'] = 0;
      $temp1 = 0;
    }
    if (!isset($temp['tidak lulus'])) {

      $temp['tidak lulus'] = 0;
      $temp2 = 0;
    }
    if (isset($temp['lulus']) && isset($temp['tidak lulus'])) {

      $temp1 = -$temp['lulus'] / $total;
      $temp2 = -$temp['tidak lulus'] / $total;
    }

    // $temp1 = -$temp['lulus'] / $total;
    // $temp2 = -$temp['tidak lulus'] / $total;

    if ($sub_atribut_tertinggi !== null) {

      $entropy[$sub_atribut_tertinggi] = ['jumlah' => $total, 'y' => $temp['lulus'], 'n' => $temp['tidak lulus'], 'entropy' => $temp1 * log(($temp['lulus'] / $total), 2) + ($temp2) * log(($temp['tidak lulus'] / $total), 2)];
    } else {

      $entropy = ['jumlah' => $total, 'y' => $temp['lulus'], 'n' => $temp['tidak lulus'], 'entropy' => $temp1 * log(($temp['lulus'] / $total), 2) + ($temp2) * log(($temp['tidak lulus'] / $total), 2)];
    }
  }

  return $entropy;
}

function gain($entropy_gain_penentu, $entropy_gain_sekarang, $total, $sub_atribut_tertinggi = null)
{

  $gain = 0;
  $i = 0;

  foreach ($entropy_gain_sekarang['entropy'] as $key_entropy_gain_sekarang_entropy => $value_entropy_gain_sekarang_entropy) {

    if ($i == 0) {

      if ($sub_atribut_tertinggi !== null) {

        $gain = $entropy_gain_penentu['entropy'][$sub_atribut_tertinggi]['entropy'] - (($value_entropy_gain_sekarang_entropy['jumlah'] / $total) * $value_entropy_gain_sekarang_entropy['entropy']);
      } else {

        $gain = $entropy_gain_penentu['entropy']['entropy'] - (($value_entropy_gain_sekarang_entropy['jumlah'] / $total) * $value_entropy_gain_sekarang_entropy['entropy']);
      }
    } else {

      if ($sub_atribut_tertinggi !== null) {

        $gain = $gain - (($value_entropy_gain_sekarang_entropy['jumlah'] / $total) * $value_entropy_gain_sekarang_entropy['entropy']);
      } else {

        $gain = $gain - (($value_entropy_gain_sekarang_entropy['jumlah'] / $total) * $value_entropy_gain_sekarang_entropy['entropy']);
      }
    }

    $i++;
  }

  return $gain;
}

function store($entropy_gain, $waktu, $conn)
{

  $temp = end($entropy_gain);
  $temp2 = reset($temp);
  $temp3 = reset($temp2);
  $atribut_penentu = reset($temp3);

  $sub_atribut_penentu = key(end($temp3));

  foreach (reset($temp) as $key => $value) {

    if ($key != 0) {

      $atribut = $value['atribut'];
      $sub_atribut = key($value['entropy']);
      $s = reset($value['entropy'])['jumlah'];
      $y = reset($value['entropy'])['y'];
      $n = reset($value['entropy'])['n'];
      $entropy = reset($value['entropy'])['entropy'];
      $gain = end($value);

      $sql = "INSERT INTO history_perhitungan (atribut_penentu, sub_atribut_penentu, atribut, sub_atribut, s, y, n, entropy, gain, waktu) VALUES ('$atribut_penentu', '$sub_atribut_penentu','$atribut','$sub_atribut','$s','$y','$n','$entropy','$gain','$waktu')";

      if (!mysqli_query($conn, $sql)) {

        echo "Error : " . $sql . "<br>" . mysqli_error($conn);
      }
    }
  }

  mysqli_close($conn);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php

  $entropy_gain = entropy_gain();

  ?>
</body>

</html>