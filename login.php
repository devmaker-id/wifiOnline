<?php
session_start();
include "include/db/conn.php";
if (isset($_POST["btnMasuk"])) {
	$email = htmlspecialchars($_POST["email"]);
	$pass = htmlspecialchars($_POST["password"]);
	$result = mysqli_query($conn, "SELECT * FROM user_wifi WHERE email='$email' ");
	if (mysqli_num_rows($result)===1) {
		$row = mysqli_fetch_assoc($result);
		if (password_verify($pass, $row["password"])) {
			$_SESSION["member"]=$row;
			header("Location:index.php");
			exit;
		}
	}
	$error = true;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>portal | ©  bc24.id</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#086fc9">
</head>
<body style="background-color:lightblue;width:400px;height:200px;padding:40px;position: fixed;top: 50%;left: 50%;margin-top: -150px;margin-left: -180px;padding:40px;">
	<div style="background-color:silver;display: table-cell;text-align: center;vertical-align: middle;border:2px solid green;border-radius:30px;">
		<h2>welcome <a href="login.php">© bc24.id</a></h2>
		<form method="post">
				<div style="background-color:silver;margin-top: 10px;margin-bottom: 10px;margin-left: 10px;margin-right: 10px;">
					<label>email mu</label>
					<input style="border:2px solid green;border-radius:5px;" type="email" placeholder="example@email.com" name="email" autocomplete="off">
				</div>
				<div style="background-color:silver;margin-top: 10px;margin-bottom: 10px;margin-left: 10px;margin-right: 10px;">
					<label>password</label>
					<input style="border:2px solid green;border-radius:5px;" type="password" placeholder="password" name="password">
				</div>
				<div style="background-color:silver;margin-top: 10px;margin-bottom: 10px;margin-left: 10px;margin-right: 10px;">
					<button style="background-color:green;width: 240px;height: 25px;position: left;border:2px solid lightblue;color: black;font-style: normal;border-radius:8px;" name="btnMasuk">Masuk</button>
				</div>
				<?php if (isset($error)): ?>
					<div style="background-color:silver;margin-top: 10px;margin-bottom: 10px;margin-left: 10px;margin-right: 10px;">
						<p style="color: red; font-size: 12px;"><i>* email dan password salah..!</i></p>
					</div>
				<?php endif ?>
		</form>
	</div>
	</div>
	<div style="font-family:sans-serif;position:fixed;left:0;bottom:0;width:100%;height:20px;margin:0;background-color:#333;color:yellow;text-align:center;">
		<marquee scrollamount="12">*) selalu berhati-hati, ketika melakukan transaksi.</marquee>
	</div>
	<div class="footer">
		<p>© Devmaker-id | +62 87-8866-2828-9</p>
	</div>
</body>
<script type="text/javascript" src="js/javaScript.js" ></script>
</html>