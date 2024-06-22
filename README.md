# Invoice-App
Aplikasi ini dirancang untuk membantu CV Sampurno Abadi dalam proses pembuatan invoice untuk penjualan produk bakau dari gudangnya.

## Persyaratan Instalasi
- Composer
- PHP (mbstring, xml, gd, mysql)
- Git
- MySQL
- Apache/NGINX

1. Pastikan PHP & MySQL terinstall. Untuk pengguna Windows dapat 
menginstall XAMPP dan pengguna Linux dapat menginstall LAMP(Linux, Apache, 
MySQL, PHP).
2. Lakukan git clone terhadap repository atau dapat mengekstrak zip 
aplikasi.
3. Buka Terminal pada directory tempat mengekstrak tadi.
4. Esekusi perintah `composer install` untuk mendownload dependencies yang 
diperlukan, tunggu hingga selesai. 
5. Apabila sudah selesai, esekusi perintah `composer dump-autoload` untuk 
mengload fungsi kustom yang dibuat.
6. Edit file env.example menjadi .env, kemudian edit file tersebut dengan 
mengatur koneksi database dan smtp
```
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME} - MAIL" 
```
6. Lakukan restore database dengan mengesekusi perintah `php artisan 
migrate:fresh --seed`
7. Lakukan linking directory storage dan directory public dengan 
mengesekusi perintah `php artisan storage:link`
8. Lakukan konfigurasi final dan nyalakan server development dengan 
mengetikkan `php artisan serve`, Aplikasi dapat diakses pada alamat 
`http://localhost:8000`
9. Apabila menggunakan web server, letakkan pada root directory agar dapat 
langsung diakses tanpa menggunakan tahapan yang ada dilangkah 9
