<?php
$idL = session("id");
$varL = query("SELECT * FROM transaksi_wifi WHERE id_user='$idL' ORDER BY id DESC LIMIT 10");
$varsl = query("SELECT * FROM transaksi_wifi WHERE id_user='$idL' ");
$invouce = 0;
foreach ($varsl as $keysl) {
	$item = $keysl["harga"];
$invouce+=$item;
}
$bill = 0;
foreach ($varsl as $keysl) {
	$item = $keysl["harga_jual"];
$bill+=$item;
}
$advantage = 0;
foreach ($varsl as $keysl) {
	$item = $keysl["harga"] - $keysl["harga_jual"];
$advantage+=$item;
}
$_userSes =session("username");
$_vry = query("SELECT * FROM trx_saldo_user WHERE username_send='$_userSes' ORDER BY id DESC ");

if (isset($_POST["tenyoDetail"])) {
	if (sessionTenyoVouxher($_POST)>0) {
	}
}
?>
<h4>Laporan penjualan kamu</h4>
<font>
	tabel penjualan ini akan menampilan 10 transaksi terakhir kamu.
</font> <hr>
<table class="penjualan">
	<thead>
		<tr>
			<th>hari/tanggal</th>
			<th>voucher</th>
			<th>kode</th>
			<th>info</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($varL as $keyL): ?>
			<?php
			if ($keyL["harga"] == 2000) {
				$bgc = "violet";
				$bgt = "white";
			}
			if ($keyL["harga"] == 3000) {
				$bgc = "orange";
				$bgt = "white";
			}
			if ($keyL["harga"] == 5000) {
				$bgc = "green";
				$bgt = "white";
			}
			$hysu = $keyL['kode'];
			$hashVcr = encodeBase64($hysu);
			?>
			<tr>
				<td style="background-color:<?=$bgc;?>;color:<?=$bgt;?>"><?=date($keyL['tanggal']);?></td>
				<td style="background-color:<?=$bgc;?>;color:<?=$bgt;?>"><?=$keyL['nama_wifi'];?></td>
				<td style="background-color:<?=$bgc;?>;color:<?=$bgt;?>"><?=substr($hysu,0,2)."*****";?></td>
				<td>
					<form method="post">
						<input type="hidden" value="<?=$hashVcr;?>" name="cryVcr">
						<button style="background-color:<?=$bgc;?>;color:<?=$bgt;?>;width:50px;height:25px;text-align:center;border-radius:50px;" name="tenyoDetail" >cek.!</button>
					</form>
				</td>
			</tr>
		<?php endforeach; ?>
		<tr>
			<td colspan="3">Total penjualan</td>
			<td><?=number_format($invouce);?></td>
		</tr>
		<tr>
			<td colspan="3">Total penyetoran</td>
			<td><?=number_format($bill);?></td>
		</tr>
		<tr>
			<td colspan="3">Total keuntungan</td>
			<td><?=number_format($advantage);?></td>
		</tr>
		<?php if (date("d") >= 25 && date("d") < 30): ?>
			<tr>
			<form method="post">
				<td style="text-align: center;" colspan="4"><button style="text-align: center; font-size: 12px; height: 25px; width:100%;" name="record_shell">record</button></td>
			</form>
			<?php
			if (isset($_POST["record_shell"])) {
				if (recordShellerUser($_POST)>0) {
				}
			}
			?>
		</tr>
		<?php else: ?>
			<tr>
				<td  style="text-align: center;" colspan="5"> !! tombol record segera tampil</td>
			</tr>
		<?php endif ?>
	</tbody>
</table>
<?php if (mysqli_num_rows($_vry)>0): ?>
<?php include "notif_user/trx_saldo.php"; ?>
<?php endif ?>