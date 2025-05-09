# Wordpress x Pakasir

Sebelum memulai, pastikan Anda telah memiliki proyek di Pakasir. Jika belum, Anda dapat [membuatnya sekarang](https://pakasir.zone.id).

Setelah membuat proyek, Anda perlu mencacat/menyimpan Slug dan API Key. Kita akan membutuhkannya nanti.

## How to install

Pastikan Anda telah memiliki wordpress yang sudah berjalan (di lokal maupun di hosting).

Anda juga wajib memiliki plugin Woocomerce sebelum menginstall plugin ini.

1. Download the [pakasir.zip](https://github.com/gx1org/wordpress_x_pakasir/raw/refs/heads/main/pakasir.zip) file.

2. Login ke halaman wp-admin, Lalu upload plugin `pakasir.zip`. (Plugins > Add new Plugin > Upload Plugin).

3. Aktifkan pluginnya, Lalu klik "Manage" pada halaman Installed Plugins.

4. Silakan paste Slug dan Api Key yang Anda dapat dari halaman Pakasir. Lalu klik Save Changes.

5. Langkah terakhir yaitu mengatur webhook.

## Add webhook to Pakasir

1. Buka halaman detail proyek Anda di web Pakasir.

2. Klik tombol `Edit Proyek`, lalu masukkan URL webhooknya:
```
https://example.com/wp-json/pakasir/v1/webhook
```
_Ganti `example.com` dengan alamat wordpress Anda._

Selesai. Sekarang Anda dapat checkout dengan metode pembayaran Pakasir.

## Demo

For a demo, please go to [http://knbr.wuaze.com/shop](http://knbr.wuaze.com/shop). (Thanks to [Infinityfree](https://infinityfree.com) for the free hosting).

## Resources

- [Pakasir docs](https://pakasir.gx1.org/p/docs)
- [PT. Geksa Contact form](https://pakasir.gx1.org/l/contact)

## Contributing

Please create an issue or pull request.
