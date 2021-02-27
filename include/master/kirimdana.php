<?php if (mysqli_num_rows($_varNotif)===1): ?>
	<div class="content">
		<div class="column">
			<div class="card">
				<?php
				$_keyNotif = mysqli_fetch_assoc($_varNotif); 
				$_txtix = $_keyNotif["tx_tiket"];
				$_fileJson = file_get_contents("trf_dana/".session("username").'-'.$_txtix.'.json',true);
				$keyJs = json_decode($_fileJson);
				$TotalJ = $keyJs->pengirim->mengirim+$keyJs->pengirim->fee_admin;
				?>
				<span style="color: green; font-size: 15px;">TOKEN : <b style="color:red;font-family:sans-serif;font-size:18px;"><?=$keyJs->Token_pin;?></b></span>
				<hr>
				<form method="post">
					<div style="text-align:left;">
						<input style="color:blue;text-align:center;font-size:16px;" type="text" value="<?=$keyJs->penerima->nama;?>" autocomplete="off" readonly="" >
						<style type="text/css">
							li{
								font-size:15px;
								color:black;
								font-family: sans-serif;
							}
						</style>
						<ul>
							<li><?=$keyJs->penerima->telepon;?></li>
							<li>Rp. <?=number_format($keyJs->pengirim->mengirim);?>,-</li>
							<li>Rp. <?=number_format($keyJs->pengirim->fee_admin);?>,-</li>
							<li>Rp. <?=number_format($TotalJ);?>,-</li>
						</ul>
						<span>untuk melanjutkan masukan TOKEN</span>
					</div>
					<div style="text-align:left;">
						<input style="font-size:15px;text-align:center;font-family:sans-serif;color:red;" type="text" autocomplete="off" placeholder="konfirmasi token" name="token">
					</div>
					<button style="text-align:center;width:95%;color:white;font-size:14px;background-color:red;border-radius:5px;" name="konfirmasi">kirim</button>
					<button style="text-align:center;width:95%;color:orange;font-size:14px;background-color:green;border-radius:5px;" name="batalConf">batal</button>
				</form>
				<?php
				if (isset($_POST["konfirmasi"])) {
					if (tokenConfirmSaldoSend($_POST)>0) {
						$_encod = encodeBase64('penjualan');
						echo "<script>location='index.php?$main=$_encod';</script>";
					}
				}
				if (isset($_POST["batalConf"])) {
					if (tokenCenceldSaldoSend($_POST)>0) {
						$_encod = encodeBase64('depositeuang');
						echo "<script>location='index.php?$main=$_encod';</script>";
					}
				}
				?>
			</div>
		</div>
	</div>		
<?php else: ?>
<?php $kurang = 51000; ?>
<?php if (saldo("nominal")>$kurang): ?>
	<div class="content">
				<div style="background:orange;" class="column">
					<div class="card">
						<span class="duit">siap kirim : Rp. <?=number_format(saldo("nominal")-$kurang);?>,-</span>
						<hr>
						<form method="post">
							<div style="text-align:left;">
								<input type="number" placeholder="input nominal" autocomplete="off" name="nominal" >
							</div>
							<div style="text-align:left;">
								<input type="number" placeholder="ponsel tujuan...." autocomplete="off" name="tujuan" >
							</div>
							<button style="text-align:center;width:95%;color:white;font-size:14px;background-color:green;border-radius:5px;" onclick="return confirm('!!! informasi.\n\nUntuk pengiriman saldo,\ncek kembali nomor tujuan,\ncek saldo siap kirim kamu.\n\nTERIMA KASIH');" name="kirimSaldo">kirim !</button>
							<?php
							if (isset($_POST["kirimSaldo"])) {
								if (masterKirimSaldo($_POST)>0) {
									$_encod = encodeBase64('depositeuang');
									echo "<script>location='index.php?$main=$_encod';</script>";
								}
							}
							?>
						</form>
					</div>
				</div>
	</div>
<?php endif ?>
<?php endif; ?>