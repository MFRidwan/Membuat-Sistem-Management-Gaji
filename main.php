<?php

// File model gaji.php untuk menyimpan data karyawan
define('GAJI_FILE', __DIR__ . '/model/gaji.php');

// Pastikan folder model ada
if (!file_exists(__DIR__ . '/model')) {
    mkdir(__DIR__ . '/model', 0777, true);
}

// Fungsi untuk membaca data karyawan dari file
function bacaKaryawan() {
    if (!file_exists(GAJI_FILE)) {
        return [];
    }
    $data = include GAJI_FILE;
    return is_array($data) ? $data : [];
}

// Fungsi untuk menyimpan data karyawan ke file
function simpanKaryawan($data) {
    file_put_contents(GAJI_FILE, '<?php return ' . var_export($data, true) . ';');
}

// Fungsi untuk mencetak teks berwarna
function warna($text, $colorCode) {
    return "\e[{$colorCode}m{$text}\e[0m";
}

// Fungsi menampilkan daftar karyawan
function lihatKaryawan() {
    $karyawan = bacaKaryawan();
    if (empty($karyawan)) {
        echo warna("\nBelum ada data karyawan.\n", "31");
        return;
    }
    echo warna("\n============= Daftar Karyawan ===============\n", "36");
    foreach ($karyawan as $index => $k) {
        echo warna("[$index] Nama: {$k['nama']}, Jabatan: {$k['jabatan']}\n", "32");
    }
    echo warna("=============================================\n", "36");
}

// Fungsi menambahkan karyawan
function tambahKaryawan() {
    $jabatanTersedia = ['Manager', 'Supervisor', 'Staff'];
    $karyawan = bacaKaryawan();
    echo warna("Masukkan nama karyawan: ", "33");
    $nama = trim(fgets(STDIN));
    echo warna("Masukkan jabatan karyawan (Manager/Supervisor/Staff): ", "33");
    $jabatan = trim(fgets(STDIN));
    if (!in_array($jabatan, $jabatanTersedia)) {
        echo warna("Jabatan tidak valid!\n", "31");
        return;
    }
    $karyawan[] = ['nama' => $nama, 'jabatan' => $jabatan];
    simpanKaryawan($karyawan);
    echo warna("Karyawan berhasil ditambahkan!\n", "32");
}

// Fungsi memperbarui data karyawan
function updateKaryawan() {
    $karyawan = bacaKaryawan();
    lihatKaryawan();
    echo warna("Masukkan nomor karyawan yang akan diperbarui: ", "33");
    $index = (int) trim(fgets(STDIN));
    if (!isset($karyawan[$index])) {
        echo warna("Karyawan tidak ditemukan!\n", "31");
        return;
    }
    echo warna("Masukkan nama baru: ", "33");
    $nama = trim(fgets(STDIN));
    echo warna("Masukkan jabatan baru: ", "33");
    $jabatan = trim(fgets(STDIN));
    $karyawan[$index] = ['nama' => $nama, 'jabatan' => $jabatan];
    simpanKaryawan($karyawan);
    echo warna("Data karyawan berhasil diperbarui!\n", "32");
}

// Fungsi menghapus karyawan
// Fungsi menghapus karyawan dengan konfirmasi lebih jelas
function hapusKaryawan() {
    $karyawan = bacaKaryawan();
    lihatKaryawan();
    
    echo warna("Masukkan nomor karyawan yang akan dihapus: ", "33");
    $index = (int) trim(fgets(STDIN));

    if (!isset($karyawan[$index])) {
        echo warna("Karyawan tidak ditemukan!\n", "31");
        return;
    }

    // Tampilkan detail karyawan yang akan dihapus
    echo warna("\nAnda akan menghapus karyawan berikut:\n", "35");
    echo warna("Nama: ", "31") . warna("[{$karyawan[$index]['nama']}]\n", "32");
    echo warna("Jabatan: ", "31") . warna("[{$karyawan[$index]['jabatan']}]\n", "32");

    echo warna("\nApakah Anda yakin ingin menghapus? (y/n): ", "36");
    $konfirmasi = trim(fgets(STDIN));

    if (strtolower($konfirmasi) !== 'y') {
        echo warna("Penghapusan dibatalkan.\n", "31");
        return;
    }

    unset($karyawan[$index]);
    simpanKaryawan(array_values($karyawan));
    echo warna("Karyawan berhasil dihapus!\n", "32");
}


// Fungsi menghitung gaji karyawan
function hitungGaji() {
    $karyawan = bacaKaryawan();
    lihatKaryawan();
    echo warna("Masukkan nomor karyawan untuk dihitung gajinya: ", "33");
    $index = (int) trim(fgets(STDIN));
    if (!isset($karyawan[$index])) {
        echo warna("Karyawan tidak ditemukan!\n", "31");
        return;
    }
    echo warna("Masukkan jumlah jam lembur: ", "33");
    $jam_lembur = (int) trim(fgets(STDIN));
    echo warna("Masukkan rating kinerja (1-5): ", "33");
    $rating_kinerja = (int) trim(fgets(STDIN));
    if ($rating_kinerja < 1 || $rating_kinerja > 5) {
        echo warna("Rating kinerja harus antara 1-5!\n", "31");
        return;
    }
    $gaji_pokok = 5000000;
    $tunjangan_jabatan = ['Manager' => 2000000, 'Supervisor' => 1500000, 'Staff' => 1000000];
    $lembur = $jam_lembur * 25000;
    $bonus_kinerja = $rating_kinerja * 500000;
    $total_gaji = $gaji_pokok + ($tunjangan_jabatan[$karyawan[$index]['jabatan']] ?? 0) + $lembur + $bonus_kinerja;
    echo warna("\n============= Gaji Karyawan =============\n", "36");
    echo warna("Nama: {$karyawan[$index]['nama']}\n", "32");
    echo warna("Jabatan: {$karyawan[$index]['jabatan']}\n", "32");
    echo warna("Gaji Pokok: Rp " . number_format($gaji_pokok, 0, ',', '.') . "\n", "32");
    echo warna("Tunjangan Jabatan: Rp " . number_format($tunjangan_jabatan[$karyawan[$index]['jabatan']] ?? 0, 0, ',', '.') . "\n", "32");
    echo warna("Lembur: Rp " . number_format($lembur, 0, ',', '.') . "\n", "32");
    echo warna("Bonus Kinerja: Rp " . number_format($bonus_kinerja, 0, ',', '.') . "\n", "32");
    echo warna("Total Gaji: Rp " . number_format($total_gaji, 0, ',', '.') . "\n", "32");
}

// Fungsi utama
while (true) {
    echo warna("\n==== Sistem Manajemen Gaji Karyawan ====\n", "34");
    echo warna("1. Lihat karyawan\n2. Tambah karyawan\n3. Update karyawan\n4. Hapus karyawan\n5. Hitung gaji\n6. Keluar\n", "36");
    echo warna("Pilih aksi (1-6): ", "33");
    $pilihan = trim(fgets(STDIN));
    switch ($pilihan) {
        case '1':
            lihatKaryawan();
            break;
        case '2':
            tambahKaryawan();
            break;
        case '3':
            updateKaryawan();
            break;
        case '4':
            hapusKaryawan();
            break;
        case '5':
            hitungGaji();
            break;
        case '6':
            exit(warna("Keluar dari aplikasi. Terima kasih!\n", "35"));
        default:
            echo warna("Pilihan tidak valid!\n", "31");
    }
}
?>