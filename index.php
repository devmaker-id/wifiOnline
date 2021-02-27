<?php
session_start();
if (empty($_SESSION["member"])) {
	header("Location:login.php");
	exit;
}
include "include/functions.php";
$idUsr = session("id");
$_usrFrom = session("username");
$main = encodeBase64($idUsr);
$_varNotif = query("SELECT * FROM send_saldo WHERE tx_from='$_usrFrom' ");
$varInfo = query("SELECT * FROM notif_topup WHERE id_user='$idUsr' ");
$_tx_recods = query("SELECT * FROM tx_record WHERE id_user='$idUsr' ");
$_keyTrx = mysqli_fetch_assoc($_tx_recods);
$token = $_keyTrx['token'];
$bayar_setor = $_keyTrx['payment'];
$_list_payment = query("SELECT * FROM payment");
$notifTopup = mysqli_fetch_assoc($varInfo);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>welcome ©-<?=session("username"); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#086fc9">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
</thead>
<body style="background-color: silver;">
	<div class="navbar">
		<div class="main">
			<?php if (mysqli_num_rows($_tx_recods)>0): ?>
			<a href="index.php" style="color:yellow;">selesaikan penyetoran !!!</a>
			<?php else: ?>
			<a href="index.php">home</a>
			<?php if (!empty(session("level")=="master")): ?>
			<a style="color:violet;" href="index.php?<?=$main;?>=<?=encodeBase64('addUserMaster');?>">User++</a>
			<?php endif ?>
			<a href="index.php?<?=$main;?>=<?=encodeBase64('userSessioin');?>">profile</a>
			<a href="index.php?<?=$main;?>=<?=encodeBase64('penjualan');?>">penjualan</a>
			<?php if (!empty($notifTopup)): ?>
			<a href="index.php?<?=$main;?>=<?=encodeBase64('depositeuang');?>"><span class="money">prosess!!!!</span></a>
			<?php else: ?>
			<?php if (saldo("nominal")<7500): ?>
			<a href="index.php?<?=$main;?>=<?=encodeBase64('depositeuang');?>"><span class="money">segera isi ulang saldo !</span></a>
			<?php else: ?>
			<a href="index.php?<?=$main;?>=<?=encodeBase64('depositeuang');?>"><span class="money">Rp. <?=number_format(saldo("nominal"));?>,-</span></a>
			<?php endif ?>
			<?php endif ?>
			<a href="index.php?<?=$main;?>=<?=encodeBase64('logout');?>">keluar</a>
			<?php endif ?>
		</div>
	</div>
	<div class="row">
		<div class="containerTab">
		<?php
		if (isset($_GET[$main])) {
			if ($_GET[$main]==encodeBase64('userSessioin')) {
				require "include/profile.php";
			}
			if ($_GET[$main]==encodeBase64("addUserMaster")) {
				require "include/master/add_user.php";
			}
			if ($_GET[$main]==encodeBase64("reportUserTransaksi")) {
				require "include/master/report_user_trx.php";
			}
			if ($_GET[$main]==encodeBase64("penjualan")) {
				require "include/penjualan.php";
			}
			if ($_GET[$main]==encodeBase64("depositeuang")) {
				require "include/setorTarik.php";
			}
			if ($_GET[$main]==encodeBase64("logout")) {
				require "include/logout.php";
			}
			if ($_GET[$main]==encodeBase64("printVcr")) {
				require "include/print-vcr.php";
			}
		}else{
			require "include/home.php";
		}
		?>
		</div>
	</div>
	<div style="font-family:sans-serif;font-size:12px;position:fixed;left:0;bottom:12px;width:100%;height:20px;margin:0;background-color:#333;color:yellow;text-align:center;">
		<marquee direction="height" scrollamount="9">Dengan Rp, 150.000/bulan saja satu rumah sudah bisa online, dan ada paket-paket member untuk satu perangkat Rp, 50.000/bulan, silahkan hubungi +62 87 8866 2828 9 (sms/telpon/whatsapp). multi payment, (BANK BRI, BANK BJB, OVO, DANA, GOPAY, LINK AJA, ALFAMART, INDOMART.)</marquee>
	</div>
	<div class="footer">
		<p>© Devmaker-id | hellp : +62 87-8866-2828-9</p>
	</div>
</body>
</html>