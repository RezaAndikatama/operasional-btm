Sistem Informasi Operasional Bengkel Manufaktur

Sistem Informasi Operasional berbasis web yang dikembangkan secara khusus untuk **PT. Briliant Teknik Mandiri**. Sistem ini dirancang untuk mendigitalisasi dan mengotomatisasi proses bisnis bengkel, mulai dari pencatatan transaksi pesanan pelanggan (*Work Order*), manajemen ketersediaan bahan baku (*Inventory*), hingga pelacakan status pengerjaan secara *real-time*.

Proyek ini dikembangkan sebagai pemenuhan **Tugas Akhir Skripsi** dengan mengimplementasikan metode pengembangan perangkat lunak Agile (Scrum) dan arsitektur yang modern.

## 🚀 Fitur Utama

- **Work Order Management:** Pencatatan detail pekerjaan, estimasi selesai, status pengerjaan, hingga kalkulasi biaya dan DP pelanggan.
- **Inventory & Sparepart Control:** Manajemen stok bahan baku dengan fitur mutasi barang (masuk/keluar) yang terintegrasi langsung dengan pemakaian pada setiap *Work Order*.
- **Public Order Tracking:** Halaman pelacakan publik yang minimalis (*clean design*) untuk memungkinkan pelanggan mengecek progres pesanan mereka secara *real-time* menggunakan Nomor WO.
- **Dynamic Activity History:** Pencatatan riwayat transaksi inventaris yang dikelompokkan secara cerdas berdasarkan tanggal dan waktu operasional.
- **Invoice Generation:** Pembuatan dan pencetakan invoice transaksi secara otomatis.

## 🛠️ Teknologi yang Digunakan

Sistem ini dibangun menggunakan *stack* teknologi terkini untuk memastikan performa, keamanan, dan skalabilitas:

- **Backend:** PHP 8.4 & Laravel 12.x
- **Frontend:** Blade Templating, Tailwind CSS (dengan sistem grid standar UI/UX)
- **Database:** MySQL 8.0
- **Environment & Deployment:** Docker & Docker Compose (Nginx Webserver)
