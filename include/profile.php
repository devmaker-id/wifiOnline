<?php
if (isset($_POST["update"])) {
	if (changePassword($_POST)>0) {
		$xcfs = encodeBase64('logout');
		echo "<script>alert('password berhasil di rubah, kamu harus login ulang');</script>";
		echo "<script>location='index.php?$main=$xcfs';</script>";
	}
}

?>
<div class="row">
	<h2><?=session("username");?></h2>
	<div class="card">
		<form class="profile-user" method="post">
			<input class="read-only" readonly="on" value="Telepon : <?=session("telepon");?>">
			<input class="read-only" readonly="on" value="E-mail : <?=session("email");?>">
			<input type="password" placeholder="password lama" autofocus="off" name="oldpass">
			<input type="password" placeholder="password baru" autofocus="off" name="newpass1">
			<input type="password" placeholder="konfirmasi password" autofocus="off" name="newpass2">
			<button class="btn" name="update">update password</button>
		</form>
	</div>
</div>