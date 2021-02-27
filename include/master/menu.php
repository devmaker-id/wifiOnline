	<?php $_notifVar = query("SELECT * FROM notif_topup "); ?>
	<?php if (!empty($_notifVar)): ?>
		<div class="row">
			<h2 style="color: gold;">welcome member gold</h2>
			<?php foreach ($_notifVar as $_notifKey): ?>
				<?php
				$namePay = $_notifKey["metod"];
				$varNamePay = query("SELECT * FROM payment WHERE pay_name='$namePay' ");
				$notifPay = mysqli_fetch_assoc($varNamePay);
				$id_user = $_notifKey["id_user"];
				$_var = query("SELECT * FROM user_wifi WHERE id='$id_user' ");
				$_key = mysqli_fetch_assoc($_var);?>
				<div class="column">
					<div style="background-color:orange;" class="card">
						<span class="price-new">!! prosess top up</span>
						<hr>
						<span>--token--</span>
						<h4 style="color:maroon;margin:0px;margin-bottom:10px;"><?=$_notifKey["token"];?></h4>
						<span>--yg harus dibayarkan--</span>
						<h4 style="color:green;margin:0px;margin-bottom:10px;">Rp. <?=number_format($_notifKey["nominal"]);?>,-</h4>
						<div style="text-align:left;">
							<input readonly="on" value="nama : <?=$_key["username"];?>" >
						</div>
						<div style="text-align:left;">
							<input readonly="on" value="telepon : <?=$_key["telepon"];?>" >
						</div>
						<div style="text-align: left;">
							<input readonly="on" value="<?=$_notifKey["metod"];?>  =>  <?=$notifPay["pay_no"];?>" >
						</div>
						<div style="text-align: left;">
							<input readonly="on" value="Ppn 0%" >
						</div>
						<form method="post">
							<input type="hidden" value="<?=$_notifKey['token'];?>" name="babymon">
							<button name="topup_rxtx">Prosess</button>
						</form>
					</div>
				</div>
			<?php endforeach ?>
			<?php
			if (isset($_POST["topup_rxtx"])) {
				if (topup_trxsal($_POST)>0) {
				}
			}
			?>
		</div>
	<?php endif; ?>

	<div class="row">
		<?php $_trxz = query("SELECT * FROM tx_record ")?>
		<?php if (mysqli_num_rows($_trxz)): ?>
			<?php foreach ($_trxz as $key_txz): ?>
				<?php
				$idtrxz = $key_txz["id_user"];
				$varvar = query("SELECT * FROM user_wifi WHERE id='$idtrxz' ");
				$plk = mysqli_fetch_assoc($varvar);
				?>
				<div class="column">
					<div style="background-color:violet;" class="card">
						<form method="post">
							<h4>token <br> <span style="color:green;font-size:25px;"><[ <u><?=$key_txz["token"];?></u> ]></span></h4>
							<input type="hidden" value="<?=$key_txz["token"];?>" name="token">
							<input value="nama : <?=$plk['username'];?>">
							<input value="total : Rp. <?=number_format($key_txz['payment']);?>,-"><hr>
							<button name="progres">Proses !</button>
						</form>
					</div>
				</div>
			<?php endforeach ?>
			<?php
			if (isset($_POST["progres"])) {
				if (prosess_laporan($_POST)>0) {
				}
			}
			?>
		<?php endif ?>
	</div>