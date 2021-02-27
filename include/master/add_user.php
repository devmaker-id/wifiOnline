<?php
if (isset($_POST["kirim"])) {
	if (add_user_new($_POST)>0) {
	}
}
if (isset($_POST["penjualan"])) {
	if (listLaporanPenjualan($_POST)>0) {
	}
}
$_num_var = query("SELECT * FROM user_wifi");
$_key_num = mysqli_num_rows($_num_var);
?>
<?php if (!empty(isset($_POST["list"]))): ?>
	<div class="content">
		<h2>list user</h2>
		<?php foreach ($_num_var as $keyMe): ?>
			<?php
			$idsalus = $keyMe["id"];
			$user_lap = encodeBase64($idsalus);
			$saldovar = query("SELECT * FROM user_saldo WHERE id_user='$idsalus' ");
			$keysalus = mysqli_fetch_assoc($saldovar);
			$qwerty = $keysalus['nominal'];
			if ($qwerty <= 25000) {
				$bgc = "red";
				$txc = "black";
			}
			if ($qwerty > 25000 && $qwerty <= 50000) {
				$bgc = "orange";
				$txc = "white";
			}
			if ($qwerty > 50000 && $qwerty <= 100000) {
				$bgc = "violet";
				$txc = "white";
			}
			if ($qwerty > 100000 && $qwerty <= 200000) {
				$bgc = "blue";
				$txc = "white";
			}
			if ($qwerty > 200000 && $qwerty <= 2000000) {
				$bgc = "green";
				$txc = "white";
			}
			?>
			<div class="column">
				<div class="card">
					<form method="post">
						<input style="background-color:<?=$bgc;?>;color:<?=$txc;?>;" value="<?=$keyMe['username'];?>" readonly="on">
						<input value="<?=$keyMe['telepon'];?>" readonly="on">
						<input value="<?=$keyMe['email'];?>" readonly="on">
						<input style="background-color:<?=$bgc;?>;color:<?=$txc;?>;" value="Rp. <?=number_format($qwerty);?>,-" readonly="on">
						<a href="index.php">kembali</a>
						<input type="hidden" value="<?=$user_lap;?>" name="user_lap">
						<button style="text-align:center;font-family:sans-serif;width:70px;height:25px;font-size:12px;" name="penjualan">Cek pjl</button>
					</form>
				</div>
			</div>
		<?php endforeach ?>
	</div>
	<?php else: ?>
		<div class="content">
			<h2>add user new</h2>
			<div class="column">
				<div class="card">
					<form class="form-control" method="post">
						<input type="text" placeholder="name" autocomplete="off" name="username">
						<input type="number" placeholder="telepon" autocomplete="off" name="telepon">
						<input type="email" placeholder="email" autocomplete="off" name="email">
						<button name="list"><?=$_key_num;?> | terdaftar</button>
						<button name="kirim">tambah++</button>
					</form>
					<font style="color:red;">*) password default <b>bc24</b></font>
				</div>
			</div>
		</div>
		<?php endif ?>