# wifiOnline <br>
diperlukan `web-server` (apache/nginx) <br>
memerlukan pula `server-databases` <br>

biling voucher wifi sederhana. <br>
semoga teman-teman bisa memanfaatkannya dengan sempurna. <br>
diharapkan mempermudah penjualan voucher teman-teman. <br>
source code ini bisa teman teman modipikasi sesuai yang di inginkan. <br>

#tahapan installasi <br>

buat data_base dengan nama apapun misal `wifionline` <br>
buka file `include/db/wifionline.sql` <br>
masukan ke database teman teman, <br>

setting nama atau lebih tepatnya koneksi data basesnya <br>
buka file `include/db/conn.php` <br>
`$host = "localhost"; // sesuai server teman teman `<br>`
$user = "root"; // user databases `<br>`
$pass = ""; // password databases `<br>`
$db = "wifionline"; // nama databases` <br>


setting ip mikrotik untuk terhubung dengan api <br>
buka file `include/functions.php` line 131  <br>
`if ($API->connect('ip mikrotik', 'user mikrotik', 'password mikrotik'))`


user defaullt ada 3 level <br>
`master` admin@bc24.id <br>
`gold` dika@bc24.id <br>
`member` diki@bc24.id <br>


password default `bc24`
