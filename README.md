# wifiOnline
diperlukan `web-server` (apache/nginx)
memerlukan pula `server-databases`

biling voucher wifi sederhana.
semoga teman-teman bisa memanfaatkannya dengan sempurna.
diharapkan mempermudah penjualan voucher teman-teman.
source code ini bisa teman teman modipikasi sesuai yang di inginkan.

#tahapan installasi

buat data_base dengan nama apapun misal `wifionline`
buka file `include/db/wifionline.sql`
masukan ke database teman teman,

setting nama atau lebih tepatnya koneksi data basesnya
buka file `include/db/conn.php`
`$host = "localhost"; // sesuai server teman teman
$user = "root"; // user databases
$pass = ""; // password databases
$db = "wifionline"; // nama databases`

setting ip mikrotik untuk terhubung dengan api
buka file `include/db/functions.php` line 131
`if ($API->connect('ip mikrotik', 'user mikrotik', 'password mikrotik'))`

user defaullt ada 3 level
`master` admin@bc24.id
`gold` dika@bc24.id
`member` diki@bc24.id

password default `bc24`
