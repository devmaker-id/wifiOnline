<div class="row">
	<h2>Saldo : <span class="duit">Rp. <?=number_format(saldo("nominal"));?>,-</span></h2>
</div>
<?php if (session("level")=="master"): ?>
<?php include "master/kirimdana.php"; ?>
<?php else: ?>
<?php endif ?>

<?php if (session("level")=="gold"): ?>
<?php include "master/kirimdana.php"; ?>
<?php if (!empty($notifTopup)): ?>
	<div class="content">
		<?php
		$namePay = $notifTopup["metod"];
		$varNamePay = query("SELECT * FROM payment WHERE pay_name='$namePay' ");
		$notifPay = mysqli_fetch_assoc($varNamePay);
		?>
		<div class="column">
			<div class="card">
				<span class="price-new">!! prosess top up</span>
				<hr>
				<span>--token--</span>
				<h4 style="color:red;margin:0px;margin-bottom:10px;"><?=$notifTopup["token"];?></h4>
				<span>--yg harus dibayarkan--</span>
				<h4 style="color:green;margin:0px;margin-bottom:10px;">Rp. <?=number_format($notifTopup["nominal"]);?>,-</h4>
				<div style="text-align:left;">
					<input readonly="on" value="<?=session("username");?>" >
				</div>
				<div style="text-align: left;">
					<input readonly="on" value="<?=$notifTopup["metod"];?>  =>  <?=$notifPay["pay_no"];?>" >
				</div>
				<div style="text-align: left;">
					<input readonly="on" value="Ppn 0%" >
				</div>
				<span style="color:red;font-size:13px;">
					* <?=$notifPay["pay_ket"];?>
				</span>
			</div>
			<form method="post">
				<button style="text-align:center;width:95%;color:white;font-size:14px;background-color:red;border-radius:5px;" onclick="return confirm('jika kamu sudah melakukan pengiriman dana,\nmohon jangan di batalkan.\n\nTERIMA KASIH');" name="cancleTopup">batal !</button>
			</form>
			<?php
			if (isset($_POST["cancleTopup"])) {
				if (batalTopup($_POST)>0) {
					$encod = encodeBase64('depositeuang');
					echo "<script>location='index.php?$main=$encod';</script>";
				}
			}
			?>
		</div>
</div>
<?php else: ?>
<div class="column">
	<div class="card">
		<span style="font-size: 12px;">*) welcome console deposite</span>
		<hr>
		<form method="post">
			<div class="form-control">
				<label>nominal</label>
				<select name="nominal">
					<option>25000</option>
					<option>30000</option>
					<option>50000</option>
					<option>100000</option>
				</select>
			</div>
			<div class="form-control">
				<label>menu isi ulang saldo</label>
				<select name="metod">
					<?php $payVar = query("SELECT * FROM payment");?>
					<?php foreach ($payVar as $payKey): ?>
						<option><?=$payKey["pay_name"];?></option>
					<?php endforeach ?>
				</select>
			</div>
			<div class="form-control">
				<button name="kirim">proses</button>
			</div>
		</form>
	</div>
</div>
<?php if (isset($_POST["kirim"])) {
	if (prosessTop($_POST)>0) {
	}
} ?>
<?php endif ?>
<?php endif ?>