<h1 align="center">Selamat datang di Sistem Informasi Permintaan Alat Tulis Kantor! 👋</h1>

## Fitur tersedia

**Website** 
- Dashboard Admin & User
- Login Page 
- Master Data User
- Master Data Supplier
- Master Data Semester
- Master Data Barang
- Verifikasi Pengadaan Barang
- Transaksi Barang Masuk
- Transaksi Barang Keluar
- Report Data filter tanggal

**Software**

-   Visual Studio Code
-   Framework Laravel Versi 10

---

## Release Date

**Release date : 15 Mei 2023**

> Sistem Informasi Permintaan Alat Tulis Kantor merupakan project open source yang dibuat karena adanya permintaan. dan dapat dikembangkan sewaktu-waktu. Terima kasih!

---

## Default Account for testing

**Admin Default Account**

-   email: admin@gmail.com
-   Password: 123456

---

## Install

1. **Clone Repository**

```bash
https://github.com/vikarmaulanaarrisyad/sistem-informasi-permintaan-alat-tulis-kantor.git sitatik
cd sitatik
composer install
cp .env.example .env
```

2. **Buka `.env` lalu ubah baris berikut sesuai dengan databasemu yang ingin dipakai**

```bash
DB_PORT=3306
DB_DATABASE=sitatik 
DB_USERNAME=root
DB_PASSWORD=
```

3. **Instalasi website**

```bash
php artisan key:generate
php artisan migrate --seed
```

4. **Jalankan website**

```bash
php artisan serve
```

## Author

-   Facebook : <a href="https://web.facebook.com/viikar.arrisyad.7/"> Vikar Maulana</a>
-   Instagram : <a href="https://www.instagram.com/vikar_maulana_/"> Vikar Maulana</a>

## Contributing

Contributions, issues and feature requests di persilahkan.
Jangan ragu untuk memeriksa halaman masalah jika Anda ingin berkontribusi. **Berhubung Project ini masih saya kembangkan sendiri, namun banyak fitur yang kalian dapat tambahkan silahkan berkontribusi yaa!**

## License

-   Copyright © 2023 Vikar Maulana.
-   **Sistem Informasi Permintaan Alat Tulis Kantor is open-sourced software licensed under the MIT license.**
