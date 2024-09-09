<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Beasiswa</title>
    <link rel="stylesheet" href="./assets/css/style.css"/>
    <link href="./assets/css/bootstrap@5.0.2_css.min.css" rel="stylesheet">
    <script src="./assets/js/bootstrap@5.0.2_js.bundle.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<?php
    include_once './functions/connection.php';
?>
<!-- <body class="bg-secondary"> -->
<body style="background-image: url(assets/img/bg.jpg);">
    <div>
        <nav class="navbar navbar-dark navbar-expand-lg bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Pendaftaran Beasiswa</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Daftar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="hasil.php">Hasil</a>
                    </li>
                </ul>
            </div>
        </div>
        </nav>
        <main class="min-vh-300d-flex flex-column justify-content-center align-items-center">
            <form class="form bg-light p-5" action="" method="POST" class="form needs-validation" enctype="multipart/form-data" novalidate>
                <div class="mb-1">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" aria-describedby="nama" required>
                </div>
                <div class="mb-1">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" required>
                    <script>
                        const emailInput = document.getElementById('email');
                        emailInput.addEventListener('change', function() {
                            const email = this.value;
                            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                            if(email.match(emailPattern)) {
                                // tidak terjadi apa apa
                            } else {
                                alert('Email tidak valid');
                                emailInput.value = '';
                            }
                        });
                    </script>
                </div>
                <div class="mb-1">
                    <label for="nomor_hp" class="form-label">Nomor Hp</label>
                    <input type="text" class="form-control" name="nomor_hp" id="nomor_hp" aria-describedby="no_hp" required pattern="\d+">
                    <script>
                        const noHpInput = document.getElementById('nomor_hp');
                        noHpInput.addEventListener('change', function() {
                            const noHp = this.value;
                            const noHpPattern = /^\d+$/;
                            if(noHp.match(noHpPattern)) {
                                // tidak terjadi apa apa
                            } else {
                                alert('Nomor Hp tidak valid');
                                noHpInput.value = '';
                            }
                        });
                    </script>
                </div>
                <div class="mb-1">
                    <label for="semester" class="form-label">Semester Saat Ini</label>
                    <select class='form-select' name='semester' id='semester' aria-label='Default select example'>
                        <option selected>Pilih Semester</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                    </select>
                </div>
                <div class="mb-1">
                    <label for="ipk" class="form-label">IPK</label>
                    <input type="tel" class="form-control" name="ipk" id="ipk" disabled aria-describedby="ipk" required readonly>
                </div>
                <div class="mb-1">
                <label for="beasiswa" class="form-label">Pilih Beasiswa</label>
                    <select class="form-select" disabled id="beasiswa" name="beasiswa" aria-label="Default select example">
                        <option value="0" selected>Pilih</option>
                        <option value="K1">Akademik</option>
                        <option value="K2">Non Akademik</option>
                        <option value="K3">Lainnya</option>
                    </select>
                    <script>
                        const beasiswaInput = document.getElementById('beasiswa');
                        beasiswaInput.addEventListener('change', function() {
                            const beasiswa = this.value;
                            if(beasiswa == '0') {
                                alert('Pilih Beasiswa');
                                beasiswaInput.value = '';
                            }
                        });
                    </script>
                </div>
                <div class="mb-3">
                    <label for="berkas" class="form-label">Upload Berkas Syarat</label>
                    <small class="form-text text-muted">Berkas yang diperbolehkan: pdf, jpg, jpeg, zip</small>
                    <input class="form-control" accept="application/pdf, .zip, .jpg, .jpeg" type="file" disabled name="berkas" id="berkas">
                    <script>
                        const berkasInput = document.getElementById('berkas');
                        berkasInput.addEventListener('change', function() {
                            const file = this.files[0];
                            const fileType = file.type;
                            const validExtensions = ['application/pdf', 'image/jpeg', 'image/jpg', 'application/zip', 'application/x-zip-compressed', 'application/x-zip'];
                            if(validExtensions.includes(fileType)) {
                               // tidak terjadi apa apa
                            } else {
                                alert('Berkas tidak valid');
                                berkasInput.value = '';
                            }
                        });
                    </script>
                </div>
                <div class="row text-center ">
                    <div class="col">
                        <button type="submit" name="submit" id="submit" disabled class="btn btn-primary">Daftar</button>
                    </div>
                    <div class="col">
                        <button type="reset" name="reset" id="reset" class="btn btn-danger">Batal</button>
                    </div>
                </div>
            </form>
        </main>
    </div>
<?php
// Fungsi untuk menginput data saat menekan tombol submit
if(isset($_POST['submit'])) {
    // Cek inputan
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $nomorhp = $_POST['nomor_hp'];
    $semester = $_POST['semester'];
    $ipk = $_POST['ipk'];
    $beasiswa = $_POST['beasiswa'];
    // Berkas upload
    $berkas = $_FILES['berkas']['name'];
    $berkas_tmp = $_FILES['berkas']['tmp_name'];
    $berkas_size = $_FILES['berkas']['size'];
    $berkas_type = $_FILES['berkas']['type'];
    $berkas_error = $_FILES['berkas']['error'];
    // cek berkas ekstensi
    $berkas_ext = pathinfo($berkas, PATHINFO_EXTENSION);
    $berkas_ext = strtolower($berkas_ext); // nama file huruf kecil semua utk simpan ke db
    $berkas_ext = explode('.', $berkas);
    $berkas_ext = $berkas_ext[1];
    // Status Ajuan
    $status = '0';
    // Pengecekan inputan kosong
    if($nama == '' || $email == '' || $nomorhp == '' || $semester == '' || $ipk == '' || $berkas == '') {
        echo "<script>alert('Semua kolom harus diisi')</script>";
    } else {
        // Pengecekan beasiswa
        if($beasiswa == '0' || $beasiswa == '') {
            echo "Tidak Memenuhi Syarat beasiswa";
        }
        // Input semua data ke database
        $sql = "INSERT INTO daftar (nama, email, no_hp, semester, last_ipk, beasiswa, syarat_berkas, status_ajuan) VALUES ('$nama', '$email', '$nomorhp', '$semester', '$ipk', '$beasiswa', '$berkas', '$status')";
        // Cek koneksi
        if(mysqli_query($conn, $sql)) {
            // jika berhasil atau tidak error
            if($berkas_error == 0) {
                // Upload Berkas sesuai ekstensi yang dianjurkan
                if($berkas_ext == 'pdf' || $berkas_ext == 'jpg' || $berkas_ext == 'jpeg' || $berkas_ext == 'zip') {
                    // upload berkas kedalam folder uploads
                    move_uploaded_file($berkas_tmp, 'uploads/'.$berkas);
                    echo "<script>alert('Data berhasil ditambahkan'); window.location.href='hasil.php';</script>";
                } 
                else {
                    // Jika tidak sesuai ekstensi berkas tidak diperbolehkan
                    echo "<script>alert('Berkas tidak diperbolehkan karena mengandung nama file lebih dari 255 kata')</script>";
                }
            }
        } else {
            // gagal diupload ke database
            echo "<script>alert('Data gagal ditambahkan')</script>";
        }
    }
}
?>

    <link rel="stylesheet" href="./assets/css/jquery-ui.css">
    <script src="./assets/js/jquery-3.7.0.min.js"></script>
    <script src="./assets/js/jquery-ui.js"></script>
    <script src="./assets/js/script.js"></script>
    <script type="text/javascript">
    $(function () {
        // fitur autocomplete ambil data dari database
        $("#nama").autocomplete({
            source: "./Utils/inputNama.php",
            minLength: 1,
        });
        $("#email").autocomplete({
            source: "./Utils/inputMail.php",
            minLength: 1,
        });
    });
    </script>
</body>
</html>