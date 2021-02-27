<?php $extfile = $token.'.json';
?>
<?php if (file_exists("include/trx_setor/".$extfile)): ?>
	<?php include "include/tx_recode.php"; ?>
<?php else: ?>
<?php if (mysqli_num_rows($_tx_recods)>0): ?>
	<?php
	if (isset($_POST["payment_get"])) {
		if (paymentTxRecord($_POST)>0) {
		}
	}
	?>
	<h2>penyetoran tidak bisa dibatalkan</h2>
	<div class="content">
		<div class="column">
			<div class="card">
				<form method="post">
					<label>nominal</label>
					<input value="Rp. <?=number_format($bayar_setor);?>,-" readonly="on" name="nominal">
					<label>metod payment</label>
					<select name="id">
						<?php foreach ($_list_payment as $key_payment): ?>
							<option><?=$key_payment["pay_name"];?></option>
						<?php endforeach ?>
					</select>
					<button name="payment_get">bayar</button>
				</form>
			</div>
		</div>
	</div>
	<?php else: ?>
		<?php
		if (isset($_POST["buy_wifi"])) {
			if (buyWifi($_POST)>0) {
			}
		}
		?>
		<?php if (session("level")=="master"): ?>
			<?php include "master/menu.php"; ?>
		<?php endif ?>
		<div class="row">
			<h3>Produk wifi</h3>
			<?php $var = query("SELECT * FROM p_wifi"); ?>
			<?php foreach ($var as $key): ?>
				<?php $name_wifi = $key["wifi_name"]; ?>
				<div class="column">
					<div class="card">
						<font style="color: black; font-size: 20px; font-family:bold;"><?=$name_wifi;?></font>
						<hr><h4 style="margin: 0;"><s><?=number_format($key["harga_jual"]);?></s> <span class="price-new"><?=number_format($key["harga_beli"]);?></span></h4>
						<font>
							Durasi : <?=$key["durasi"];?> <br>
							Aktif : <?=$key["aktif"];?>
						</font> <hr>
						<form method="post">
							<button onclick="return confirm('Apakah kamu akan membeli <?=$name_wifi;?>');" value="<?=encodeBase64($key["id"]);?>" name="buy_wifi">beli !</button>
						</form>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="content">
			<h3>Produk lainnya</h3>
			<div class="column">
				<div class="card">
					<h4>GAS LPG 3KG</h4>
					<font>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit,
					</font> <hr>
					<button name="beli">beli !</button>
				</div>
			</div>
			<div class="column">
				<div class="card">
					<h4>AQUA GALON 25L</h4>
					<font>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit,
					</font> <hr>
					<button name="beli">beli !</button>
				</div>
			</div>
			<div class="column">
				<div class="card">
					<h4>BERAS MURNI</h4>
					<font>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit,
					</font> <hr>
					<button name="beli">beli !</button>
				</div>
			</div>
			<div class="column">
				<div class="card">
					<h4>MINYAK GORENG 1L</h4>
					<font>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit,
					</font> <hr>
					<button name="beli">beli !</button>
				</div>
			</div>
		</div>
		<?php endif; ?>
<?php endif; ?>