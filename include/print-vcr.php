<?php
if (isset($_POST["back"])) {
	echo "<script>alert('terimakasih telah belanja di bungacenter.');</script>";
	echo "<script>location='index.php';</script>";
}
$id_hash = session("id");
$sha = hash("sha512",$id_hash);
$hashVc = $_GET[$sha];
$hashing = decodeBase64("$hashVc");
$varhash = query("SELECT * FROM transaksi_wifi WHERE kode='$hashing' ");
$kyhash = mysqli_fetch_assoc($varhash);
$name_wifi = $kyhash["nama_wifi"];
$var_p = query("SELECT * FROM p_wifi WHERE wifi_name='$name_wifi' ");
$key_p = mysqli_fetch_assoc($var_p);
?>
<div class="row">
	<div class="print-voucher">
		<div class="card">
			<h4 style="color: green;"><u>pembelian berhasil</u></h4><hr>
			<div>
				<h4 style="color:blue;font-size:24px;"><?=$kyhash["kode"];?></h4>
				<span class="price-new">Rp, <?=number_format($kyhash["harga"]);?>,-</span><br>
				<font><?=tanggal_indo($kyhash["tanggal"]);?></font><br>
				<font>Durasi : <?=$key_p["durasi"];?><br>Aktif : <?=$key_p["aktif"];?></font>
				<hr>
				<form method="post">
					<button name="back">kembali</button>
				</form>
			</div>
			<span class="price-new">* untuk transaksi ini tidak bisa diretur, atau uang kembali. <br> * wajib uang cash (uang terima dahulu) baru berikan kodeNya.</span>
		</div>
	</div>
</div>