<?php require_once("../controller/script.php");
if (isset($_SESSION["data-user"])) {
  header("Location: ../views/");
  exit();
}
$_SESSION["page-name"] = "Masuk";
$_SESSION["page-url"] = "./";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once("../resources/auth-header.php") ?>
  <style>
    .fixed-container {
      position: fixed;
      top: 50%;
      left: 80%;
      transform: translate(-50%, -50%);
      /* Ubah nilai di atas sesuai dengan posisi yang diinginkan */
      /* Misalnya, dengan translate(-50%, 0) jika ingin elemen di tengah horizontal */
      /* Dan dengan translate(0, -50%) jika ingin elemen di tengah vertikal */
    }

    /* Add other styles for your page as needed */
  </style>
</head>

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
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 justify-content-center">
          <div class="col-lg-6">
            <div class="col-md-12" style="padding-top: 50px;height: 170px;">
              <h1 id="typing-text" style="font-size: 40px;line-height: 45px;"></h1>
              <script>
                const text = "Selamat datang di Fakultas Teknik<br>Program Studi Arsitektur UNWIRA.";
                let index = 0;
                const typingSpeed = 50; // Kecepatan pengetikan dalam milidetik (semakin kecil, semakin cepat)

                function typeText() {
                  if (index < text.length) {
                    const char = text.charAt(index);
                    if (char === '<') {
                      // Cari karakter penutup '>' untuk menambahkan elemen <br>
                      const closingTagIndex = text.indexOf('>', index);
                      document.getElementById('typing-text').innerHTML += text.substring(index, closingTagIndex + 1);
                      index = closingTagIndex + 1;
                    } else {
                      document.getElementById('typing-text').innerHTML += char;
                      index++;
                    }
                    setTimeout(typeText, typingSpeed);
                  }
                }

                // Panggil fungsi untuk memulai animasi ketika halaman dimuat
                window.onload = typeText;
              </script>
            </div>
            <div class="col-md-12">
              <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner shadow">
                  <div class="carousel-item active">
                    <img src="../assets/images/1.jpg" class="d-block w-100" style="height: 300px;object-fit: cover;" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="../assets/images/2.jpg" class="d-block w-100" style="height: 300px;object-fit: cover;" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="../assets/images/3.jpg" class="d-block w-100" style="height: 300px;object-fit: cover;" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="../assets/images/4.jpg" class="d-block w-100" style="height: 300px;object-fit: cover;" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="../assets/images/5.jpg" class="d-block w-100" style="height: 300px;object-fit: cover;" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="../assets/images/6.jpg" class="d-block w-100" style="height: 300px;object-fit: cover;" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="../assets/images/7.jpg" class="d-block w-100" style="height: 300px;object-fit: cover;" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="../assets/images/8.jpg" class="d-block w-100" style="height: 300px;object-fit: cover;" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="../assets/images/9.jpg" class="d-block w-100" style="height: 300px;object-fit: cover;" alt="...">
                  </div>
                  <div class="carousel-item">
                    <img src="../assets/images/10.jpg" class="d-block w-100" style="height: 300px;object-fit: cover;" alt="...">
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
            </div>
            <div class="col-md-12 mt-3">
              <h2>VISI DAN MISI</h2>
              <hr>
              <h4>Visi</h4>
              <p class="text-justify">Menjadi komunitas arsitektur yang unggul dalam transformasi arsitektur vernakular ntt kewujud baru sesuai dengan perkembangan teknologi, seni dalam konteks perkembangan global untuk menjawab tantangan lokal di wilayah kepulauan nusa tenggara dan kawasan timur indonesia berdasarkan nilai – nilai kristiani hingga tahun 2022.</p>
              <h4>Misi</h4>
              <p class="text-justify">Menjalankan pembelajaran dengan menggunakan kurikulum pendidikan arsitektur yang terus diperbaharui sesuai dengan perkembangan ilmu, teknologi dan seni dalam konteks global serta tuntutan profesionalisme.</p>
              <p class="text-justify">Menyebarluaskan dan mengupayakan penggunaan ilmu arsitektur untuk menghasilkan lulusan yang dapat bekerja secara mandiri, produktif, profesional dan memiliki kepercayaan diri yang tinggi dalam perencanaan, perancangan, pelaksanaan dan pengelolaan lingkungan binaan, dengan spirit transformasi arsitektur vernacular NTT.</p>
              <p class="text-justify">Mengaplikasikan ilmu dan teknologi arsitektur dalam rangka memenuhi kebutuhan masyarakat berupa kegiatan pendampingan, perencanaan dan perancangan arsitektur serta lingkungan binaan serta dengan mengedepankan nilai-nilai Kristiani.</p>
            </div>
          </div>
          <div class="col-lg-4"></div>
          <div class="col-lg-4 fixed-container">
            <div class="auth-form-light text-center py-5 px-4 px-sm-5 shadow">
              <img src="../assets/images/logo.png" style="width: 120px;margin-bottom: 10px;" alt="Logo Data Mining c45">
              <h2>Data Mining c45</h2>
              <h6 class="fw-light">Masuk untuk melanjutkan.</h6>
              <form class="pt-3" action="" method="POST">
                <div class="form-group mt-3">
                  <label for="email">Email</label>
                  <input type="email" name="email" id="email" class="form-control text-center" placeholder="Email" required>
                </div>
                <div class="form-group">
                  <label for="pasword">Password</label>
                  <input type="password" name="password" id="password" class="form-control text-center" placeholder="Kata Sandi" required>
                </div>
                <div class="mt-3">
                  <button type="submit" name="masuk" class="btn rounded-0 text-white" style="background-color: rgb(3, 164, 237);">Masuk</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php require_once("../resources/auth-footer.php") ?>
</body>

</html>