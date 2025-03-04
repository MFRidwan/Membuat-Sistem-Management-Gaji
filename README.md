# Sistem Manajemen Gaji Karyawan

## Deskripsi
Sistem ini adalah aplikasi berbasis CLI (Command Line Interface) yang digunakan untuk mengelola data karyawan dan menghitung gaji mereka berdasarkan jabatan, jumlah jam lembur, serta rating kinerja.

## Fitur
1. **Melihat daftar karyawan**
2. **Menambahkan karyawan baru**
3. **Memperbarui data karyawan**
4. **Menghapus karyawan**
5. **Menghitung gaji karyawan**
6. **Keluar dari aplikasi**

## Struktur File
```
project-directory/
│-- model/
│   ├── gaji.php (Menyimpan data karyawan)
│-- main.php (File utama aplikasi)
```

## Cara Menggunakan
1. **Pastikan Anda memiliki PHP terinstal**
   - Cek dengan perintah: `php -v`
2. **Jalankan aplikasi**
   ```sh
   php main.php
   ```
3. **Pilih menu yang tersedia**
   - Masukkan angka yang sesuai dengan pilihan menu untuk melakukan operasi yang diinginkan.

## Detail Perhitungan Gaji
- **Gaji Pokok:** Rp 5.000.000
- **Tunjangan Jabatan:**
  - Manager: Rp 2.000.000
  - Supervisor: Rp 1.500.000
  - Staff: Rp 1.000.000
- **Lembur:** Rp 25.000 per jam
- **Bonus Kinerja:**
  - Rating kinerja (1-5) dikalikan Rp 500.000
- **Total Gaji:**
  ```
  Total Gaji = Gaji Pokok + Tunjangan Jabatan + (Jam Lembur x Rp 25.000) + (Rating Kinerja x Rp 500.000)
  ```

## Catatan Tambahan
- Data karyawan disimpan dalam file `model/gaji.php`.
- Jika folder `model` tidak ada, sistem akan membuatnya secara otomatis.
- Gunakan warna terminal untuk membedakan jenis pesan (misalnya merah untuk error, hijau untuk sukses).

## Lisensi
Proyek ini bebas digunakan dan dimodifikasi sesuai kebutuhan.

---
Terima kasih telah menggunakan Sistem Manajemen Gaji Karyawan!
