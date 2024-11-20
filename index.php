<?php
require './php/function.php';

// Cek nomor terakhir dari tabel `ambilnomor`
$nomorTerakhirAmbilNomor = query("SELECT no_ndkeluar FROM ambilnomor ORDER BY id DESC LIMIT 1");
$nomorTerakhir = !empty($nomorTerakhirAmbilNomor) ? $nomorTerakhirAmbilNomor[0]['no_ndkeluar'] : '';

// Jika tabel `ambilnomor` kosong, cek tabel `mahasiswa`
if (empty($nomorTerakhir)) {
  $nomorTerakhirMahasiswa = query("SELECT no_ndkeluar FROM mahasiswa ORDER BY id DESC LIMIT 1");
  $nomorTerakhir = !empty($nomorTerakhirMahasiswa) ? $nomorTerakhirMahasiswa[0]['no_ndkeluar'] : 'B/ND-0/XI/LOG.5.6./2024/Baglog';
}

// Ekstraksi angka terakhir menggunakan regex
preg_match('/B\/ND-(\d+)\/XI\/LOG\.5\.6\.\/2024\/Baglog/', $nomorTerakhir, $matches);
$angkaTerakhir = isset($matches[1]) ? (int)$matches[1] : 0;

// Tambahkan 1 ke nomor terakhir untuk nomor baru
$angkaBaru = $angkaTerakhir + 1;

// Format nomor baru
$nomorBaru = sprintf("B/ND-%03d/XI/LOG.5.6./2024/Baglog", $angkaBaru);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_POST['nama'];
  $satfung = $_POST['satfung'];
  $hal = $_POST['hal'];

  // Simpan data ke tabel `ambilnomor`
  $insertQuery = "INSERT INTO ambilnomor (nama, satfung, hal, no_ndkeluar) VALUES ('$nama', '$satfung', '$hal', '$nomorBaru')";
  if (mysqli_query($koneksi, $insertQuery)) {
    // Redirect dengan parameter success
    header("Location: " . $_SERVER['PHP_SELF'] . "?success=true");
    exit();
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Logistik Polres Karimun</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- css -->
  <link rel="stylesheet" href="css/style.css">

  <!-- SweetAlert2 CSS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- logo title -->
  <link rel="icon" href="./assets/img/logistik.png">

</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container d-flex justify-content-start">
      <img src='./assets/img/logistik.png' alt="logo" class="nav-logo" />
      <a class="navbar-brand mx-2 text-white" href="index.php">Nota Dinas</a>
    </div>
  </nav>

  <div class="container">
    <div class="d-flex flex-column row justify-content-center align-items-center vh-100">
      <!-- Title & Note -->
      <div class="text">
        <h2 class="judul-h2 text-center">AJUKAN NOMOR NOTA DINAS</h2>
        <p class="note text-center mt-3">
          Note: isi nama, satfung terlebih dahulu agar admin bisa menginput ke
          database...Terima kasih
        </p>
      </div>

      <!-- Button untuk memunculkan form -->
      <div class="d-flex justify-content-center align-items-center">
        <button class="btn btn-primary" id="showFormButton">Ambil nomor nota dinas</button>

      </div>

      <!-- Form Pengambilan Nomor Nota Dinas -->
      <div class="d-flex justify-content-center align-items-center mt-4" id="formContainer">
        <div class="col-md-6">
          <form method="post">
            <label>Nama</label>
            <input type="text" class="form-control" placeholder="Adi Supiyansah" name="nama" required />

            <label class="mt-4">Satfung</label>
            <input type="text" class="form-control" placeholder="Baglog" name="satfung" required />

            <label class="mt-4">Hal</label>
            <input type="text" class="form-control" placeholder="Perihal..." name="hal" required />

            <label class="mt-4">No Nota Dinas Anda <span class="text-danger fst-italic">(Note: untuk bulan & KKA silahkan edit sendiri</span> <span class="text-danger">😁)</span></label>
            <input type="text" class="form-control" value="<?= $nomorBaru ?>"/>

            <div class="trigger-submit d-flex justify-content-end align-items-end">
              <button class="btn mt-4 btn-primary" type="submit">
                Submit
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Script untuk memunculkan/menghilangkan form dan tombol -->
  <script src="./js/script.js"></script>

  <script>
    // Deteksi jika URL mengandung parameter ?success=true
    if (window.location.search.includes('success=true')) {
      Swal.fire({
        title: 'Berhasil!',
        text: 'Data telah disimpan.',
        icon: 'success',
        confirmButtonText: 'OK'
      }).then(() => {
        // Refresh halaman setelah alert ditutup
        window.location.href = window.location.pathname;
      });
    }
  </script>


  <!-- script bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>