<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Penilaian Mahasiswa</title> <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>

    <style>
        /* Blok CSS Kustom untuk menyesuaikan tampilan halaman */
        body {
            background-color: #f8f9fa; /* Mengatur warna latar belakang seluruh halaman menjadi abu-abu terang (light gray) */
        }

        .card-header {
            background-color: #007bff; /* Mengatur warna latar belakang header card formulir menjadi biru Bootstrap */
            color: white; /* Mengatur warna teks di dalam header card menjadi putih */
        }

        .form-label {
            font-weight: bold; /* Membuat teks label pada setiap input formulir menjadi tebal */
        }
    </style>
</head>

<body>
    <div class="container mt-4 mb-5 px-5">
        <div class="card shadow-sm"> <div class="card-header text-center"> <h1 class="h4 mb-0">Form Penilaian Mahasiswa</h1> </div>
            <div class="card-body"> <form method="post"> <div class="mb-3"> <label for="nama" class="form-label">Masukkan Nama</label> <input type="text" class="form-control" id="nama" name="nama" placeholder="" required>
                    </div>
                    <div class="mb-3"> <label for="nim" class="form-label">Masukkan NIM</label> <input type="text" class="form-control" id="nim" name="nim" placeholder="" required>
                    </div>
                    <div class="mb-3"> <label for="kehadiran" class="form-label">Nilai Kehadiran (10%)</label> <input type="number" class="form-control" id="kehadiran" name="kehadiran" placeholder="" min="0" max="100" required>
                    </div>
                    <div class="mb-3"> <label for="tugas" class="form-label">Nilai Tugas (20%)</label> <input type="number" class="form-control" id="tugas" name="tugas" placeholder="" min="0" max="100" required>
                    </div>
                    <div class="mb-3"> <label for="uts" class="form-label">Nilai UTS (30%)</label> <input type="number" class="form-control" id="uts" name="uts" placeholder="" min="0" max="100" required>
                    </div>
                    <div class="mb-3"> <label for="uas" class="form-label">Nilai UAS (40%)</label> <input type="number" class="form-control" id="uas" name="uas" placeholder="" min="0" max="100" required>
                    </div>
                    <div class="d-grid gap-2"> <button type="submit" name="proses" class="btn btn-primary">Proses</button> </div>
                </form>

                <?php
                // Bagian kode PHP dimulai di sini.
                // Kode di dalam blok ini hanya akan dieksekusi jika formulir telah dikirim oleh pengguna
                // (yaitu, ketika tombol dengan atribut name="proses" ditekan).

                if (isset($_POST['proses'])) { // Memeriksa apakah variabel POST 'proses' ada (berarti tombol 'Proses' ditekan)
                    // Mengambil nilai-nilai yang dikirimkan dari input form HTML melalui array superglobal $_POST.
                    $nama = $_POST['nama'];             // Mengambil nilai dari input 'nama'
                    $nim = $_POST['nim'];               // Mengambil nilai dari input 'nim'
                    $kehadiran = $_POST['kehadiran'];   // Mengambil nilai dari input 'kehadiran'
                    $tugas = $_POST['tugas'];           // Mengambil nilai dari input 'tugas'
                    $uts = $_POST['uts'];               // Mengambil nilai dari input 'uts'
                    $uas = $_POST['uas'];               // Mengambil nilai dari input 'uas'

                    // Menghitung nilai akhir mahasiswa berdasarkan bobot persentase masing-masing komponen nilai.
                    // Rumus: (Kehadiran * 10%) + (Tugas * 20%) + (UTS * 30%) + (UAS * 40%)
                    $nilai_akhir = ($kehadiran * 0.10) + ($tugas * 0.20) + ($uts * 0.30) + ($uas * 0.40);

                    // Menentukan grade (huruf) berdasarkan rentang nilai akhir yang telah dihitung.
                    $grade = ''; // Inisialisasi variabel untuk menyimpan grade
                    if ($nilai_akhir >= 85) { // Jika nilai akhir 85 atau lebih
                        $grade = 'A';
                    } elseif ($nilai_akhir >= 70) { // Jika nilai akhir 70-84
                        $grade = 'B';
                    } elseif ($nilai_akhir >= 55) { // Jika nilai akhir 55-69
                        $grade = 'C';
                    } elseif ($nilai_akhir >= 40) { // Jika nilai akhir 40-54
                        $grade = 'D';
                    } else { // Jika nilai akhir di bawah 40
                        $grade = 'E';
                    }

                    // Menentukan status kelulusan (LULUS/TIDAK LULUS) dan
                    // kelas warna Bootstrap yang akan digunakan untuk tampilan card hasil dan tombol "Selesai".
                    $status = ''; // Inisialisasi variabel untuk menyimpan status kelulusan
                    $card_color_class = '';    // Inisialisasi variabel untuk kelas warna latar belakang card hasil
                    $button_color_class = '';  // Inisialisasi variabel untuk kelas warna tombol "Selesai"

                    // Aturan 1: Jika nilai kehadiran di bawah 70%, mahasiswa otomatis TIDAK LULUS.
                    if ($kehadiran < 70) {
                        $status = 'TIDAK LULUS';
                        $card_color_class = 'bg-danger';   // Latar belakang card menjadi merah (Bootstrap 'danger')
                        $button_color_class = 'btn-danger'; // Tombol juga menjadi merah
                    }
                    // Aturan 2: Kondisi untuk LULUS.
                    // Mahasiswa LULUS jika: Nilai Akhir >= 60, Kehadiran > 70,
                    // DAN semua nilai komponen (Tugas, UTS, UAS) >= 40.
                    elseif ($nilai_akhir >= 60 && $kehadiran > 70 && $tugas >= 40 && $uts >= 40 && $uas >= 40) {
                        $status = 'LULUS';
                        $card_color_class = 'bg-success';   // Latar belakang card menjadi hijau (Bootstrap 'success')
                        $button_color_class = 'btn-success'; // Tombol juga menjadi hijau
                    }
                    // Aturan 3: Selain dari kedua kondisi di atas (otomatis tidak lulus atau lulus), dianggap TIDAK LULUS.
                    else {
                        $status = 'TIDAK LULUS';
                        $card_color_class = 'bg-danger';   // Latar belakang card menjadi merah
                        $button_color_class = 'btn-danger'; // Tombol juga menjadi merah
                    }
                ?>

                <div class="mt-4"> <div class="card shadow-sm <?php echo $card_color_class; ?> text-white">
                        <div class="card-body"> <h4 class="card-title text-center mb-4">Hasil Penilaian</h4>
                            <div class="row"> <div class="col-md-6"> <p class="mb-1"><strong>Nama:</strong> <?php echo $nama; ?></p> 
                            <p class="mb-1"><strong>NIM:</strong> <?php echo $nim; ?></p>     <p class="mb-1"><strong>Nilai Kehadiran:</strong> <?php echo $kehadiran; ?>%</p> <p class="mb-1"><strong>Nilai Tugas:</strong> <?php echo $tugas; ?></p>     </div>
                                <div class="col-md-6"> <p class="mb-1"><strong>Nilai UTS:</strong> <?php echo $uts; ?></p>         
                                <p class="mb-1"><strong>Nilai UAS:</strong> <?php echo $uas; ?></p>         
                                <p class="mb-1"><strong>Nilai Akhir:</strong> <?php printf("%.2f", $nilai_akhir); ?></p>
                                    <p class="mb-1"><strong>Grade:</strong> <?php echo $grade; ?></p>         
                                    <p class="mb-1"><strong>Status:</strong> <?php echo $status; ?></p>       
                                </div>
                            </div>
                            <div class="d-grid gap-2 mt-4"> <button type="button" class="btn <?php echo $button_color_class; ?> mx-auto" style="width: 50%;">Selesai</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                } // Akhir dari blok PHP 'if (isset($_POST['proses']))'
                ?>
            </div>
        </div>
    </div>
</body>
</html>