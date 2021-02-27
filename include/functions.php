<?php
include "db/conn.php";
function tanggal_indo($tanggal, $cetak_hari = false)
{
	$hari = array ( 1 =>    'Senin',
		'Selasa',
		'Rabu',
		'Kamis',
		'Jumat',
		'Sabtu',
		'Minggu'
	);

	$bulan = array (1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$split 	  = explode('-', $tanggal);
	$tgl_indo = $split[2] . " " . $bulan[ (int)$split[1] ] . " " . $split[0];
	
	if ($cetak_hari) {
		$num = date('N', strtotime($tanggal));
		return $hari[$num] . ', ' . $tgl_indo;
	}
	return $tgl_indo;
//echo tanggal_indo ('2021-02-14'); // Hasil: 14 Februari 2021;
//echo tanggal_indo ('2021-02-14', true); // Hasil: Minggu, 14 Februari 2021
}
function encodeBase64($data){
	return rtrim(strtr(base64_encode($data),'+/','-_'),'=');
}
function decodeBase64($data){
	return base64_decode(strtr($data,'-_','+/').str_repeat('=',3-(3+strlen($data))%4));
}
function session($data){
	return $_SESSION["member"][$data];
}
function query($data){
	global $conn;
	return mysqli_query($conn, $data);
}
function saldo($data){
	global $conn;
	$id = session("id");
	// key 'id_user' 'nominal'
	$raw = mysqli_query($conn, "SELECT * FROM user_saldo WHERE id_user='$id' ");
	$qy = mysqli_fetch_assoc($raw);
	return $qy[$data];
}
function updateSaldo($saldo){
	global $conn;
	$id = session("id");
	$awal = saldo("nominal");
	query("UPDATE user_saldo SET nominal='$saldo' WHERE id_user='$id' ");
	return mysqli_affected_rows($conn);
}
function randomString($length){
	$str        = "";
	$characters = 'ABCDEFGHKSTUVWXYZuvwxyz23456789';
	$max        = strlen($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max);
		$str .= $characters[$rand];
	}
	return $str;
}
function prosessTop($data){
	global $conn;
	$id = session("id");
	$date = date("Y-m-d");
	$metod = $data["metod"];
	$nominal =$data["nominal"];
	$token = randomString(7);
	query("INSERT INTO notif_topup (id,token,id_user,tanggal,metod,nominal) VALUES (NULL,'$token','$id','$date','$metod','$nominal')");
	$main = encodeBase64(session("id"));
	$coz = encodeBase64('depositeuang');
	echo "<script>location='index.php?$main=$coz';</script>";
	return mysqli_affected_rows($conn);
}
function batalTopup($data){
	global $conn;
	$id = session("id");
	$var = query("DELETE FROM notif_topup WHERE id_user='$id' ");
	return mysqli_affected_rows($conn);
}
function buyWifi($wifi){
	global $conn;
	$buy = decodeBase64($wifi["buy_wifi"]);
	$raw = query("SELECT * FROM p_wifi WHERE id='$buy' ");
	$result = mysqli_fetch_assoc($raw);
	$nameW = $result["wifi_name"];
	$durasiW = $result["durasi"];
	$aktifW = $result["aktif"];
	$jualW = $result["harga_jual"];
	$beliW = $result["harga_beli"];
	$ketW = $result["keterangan"];
	$date = date("Y-m-d");
	$id_user = session("id"); 
	$commentVcr = session("username");
	$profileVcr = $result["profileApi"];
	$aktivVcr = $result["internetApi"];
	$saldo = saldo("nominal");
	$voucher = randomString(6);
	if ($saldo < $beliW) { //cek jika saldo lebih kecil dari produk maka batalkan
		echo "<script>alert('saldo kamu tindak mencukupi');</script>";
		return false;
	}
	//udate saldo kurangi saldo user
	$saldoBaru = $saldo - $beliW;
	updateSaldo($saldoBaru);
	//simpan ke laporan pembelian
	$main = encodeBase64(session("id"));
	$encod = encodeBase64('printVcr');
	$id_hash = session("id");
	$sha = hash("sha512",$id_hash);
	$hash = encodeBase64($voucher);
	query("INSERT INTO transaksi_wifi (id,id_user,tanggal,nama_wifi,kode,harga,harga_jual) VALUES (NULL,'$id_user','$date','$nameW','$voucher','$jualW','$beliW')");
	echo "<script>location='index.php?$main=$encod&$sha=$hash';</script>";
	//start connet api dont forget ip mikrotik
	require('db/api.php');
	$API = new RouterosAPI();
	if ($API->connect('ip mikrotik', 'user mikrotik', 'password mikrotik')) {
		$user = array(1 => array(
			"name" => "$voucher",
			"password" => "$voucher"));
		foreach($user as $tmp)
		{
			$username="=name=";
			$username.=$tmp['name'];
			$pass="=password=";
			$pass.=$tmp['password'];
			$timelimit="=limit-uptime=";
			$timelimit.="$aktivVcr";
			$comment="=comment=";
			$comment.="Online-$commentVcr";
			$server="=server=";
			$server.='all';
			$profile="=profile=";
			$profile.="$profileVcr";
			$API->write('/ip/hotspot/user/add',false);
			$API->write($username, false);
			$API->write($pass, false);
 			$API->write($timelimit, false);
			$API->write($comment, false);
			$API->write($server, false);
			$API->write($profile);
			$ARRAY = $API->read();
		}

		$API->disconnect();

	}
	//end connet api mikrotik
	return mysqli_affected_rows($conn);
	
}
function sessionTenyoVouxher($data){
	global $conn;
	$hashCryip = $data["cryVcr"];
	$vcr = decodeBase64($hashCryip);
	$var = query("SELECT * FROM transaksi_wifi WHERE kode='$vcr' ");
	if (mysqli_num_rows($var)>0) {
		$main = encodeBase64(session("id"));
		$encod = encodeBase64('printVcr');
		$id_hash = session("id");
		$sha = hash("sha512",$id_hash);
		$hash = encodeBase64($vcr);
		echo "<script>location='index.php?$main=$encod&$sha=$hash';</script>";
	}else{
		echo "<script>alert('mohon maaf ada yang bermasalah.!');</script>";
	}
}


// profile user
function changePassword($data){
	global $conn;
	$id = session("id");
	$old = htmlspecialchars($data["oldpass"]);
	$new1 = htmlspecialchars($data["newpass1"]);
	$new2 = htmlspecialchars($data["newpass2"]);
	$varCek = query("SELECT * FROM user_wifi WHERE id='$id' ");
	$keyCek = mysqli_fetch_assoc($varCek);
	if (empty($old)){
		echo "<script>alert('mohon isi terlebih dahulu password lama kamu');</script>";
		return false;
	}
	if (empty($new1)){
		echo "<script>alert('password barunya di isi dulu..!');</script>";
		return false;
	}
	if (empty($new2)){
		echo "<script>alert('password konfirmasi masih kosong.!');</script>";
		return false;
	}
	if (!password_verify($old, $keyCek["password"])){
		echo "<script>alert('mohon maaf password lama anda kurang tepat.');</script>";
		return false;
	}
	if ($new1 != $new2){
		echo "<script>alert('password baru, dengan konfirmasi password berbeda.');</script>";
		return false;
	}
	$password = password_hash($new2, PASSWORD_DEFAULT);
	query("UPDATE user_wifi SET password='$password' WHERE id='$id' ");
	return mysqli_affected_rows($conn);
}
// menu master
function masterKirimSaldo($data){
	global $conn;
	$_nominal = htmlspecialchars($data["nominal"]);
	$_tujuan = htmlspecialchars($data["tujuan"]);
	if (empty($_nominal)) {
		echo "<script>alert('kolum nominal belum di isi');</script>";
		return false;
	}
	if (empty($_nominal)) {
		echo "<script>alert('masukan nomor ponsel tujuan kamu');</script>";
		return false;
	}
	//cek penerima apakah ada dalam database. kalo ada lanjutkan
	if ($_tujuan == session("telepon")) {
		echo "<script>alert('kamu tidak bisa mengirim dana ke dirimu sendiri...');</script>";
		return false;
	}
	//jika tujuan terdaftar dalam database;
	$_var = query("SELECT * FROM user_wifi WHERE telepon='$_tujuan' ");
	if (mysqli_num_rows($_var)===1) {
		$s_trf = mysqli_fetch_assoc($_var);
		$si_trf = $s_trf["id"];
		$_vsru = query("SELECT * FROM user_saldo WHERE id_user='$si_trf' ");
		$_ksut = mysqli_fetch_assoc($_vsru)["nominal"];
		$feeAdmin = 1500;
		$_tmp_send = $_nominal+$feeAdmin;
		$tmp_saldo = saldo("nominal")-$_tmp_send;
		$_tmp_minimal = 50000;
		// saldo pengirim apakah cukup dari
		// nominal + admin sisa saldo pengirim harus $_tmp_minimal
		if (saldo("nominal") > $_tmp_send) {
			//cek sisa saldo pengirim, sisa harus lebih dari $_tmp_minimal
			if ($tmp_saldo > $_tmp_minimal) {
				# jika saldo mencukupi lanjutkan
				//tampilakn dahulu identitas penerima + konfirmasi
				//simpan dalam bentuk json . lempar kembali ke user tanyakan yes|no
				$_etc_name = $s_trf["username"];
				$_etc_phone = $s_trf["telepon"];
				$nameFile = session("username");
				$_txtiket = randomString(4);
				$_txTgl = date("Y-m-d");
				$_etc_received = array(
					"tanggal"=>tanggal_indo($_txTgl),
					"Token_pin"=>$_txtiket,
					"pengirim"=>["nama"=>session("username"),
								"telepon"=>session("telepon"),
								"saldo_awal"=>saldo("nominal"),
								"mengirim"=>$_nominal,
								"fee_admin"=>$feeAdmin],
					"penerima"=>["nama"=>$_etc_name,
								"telepon"=>$_etc_phone,
								"saldo_awal"=>$_ksut,
								"menerima"=>$_nominal],
					"status_trx"=>"pending"
							);
				$_json = json_encode($_etc_received);
				$libJson = "include/master/trf_dana/".$nameFile.'-'.$_txtiket.'.json';
				$heandler = fopen($libJson, "a+");
				fwrite ($heandler, $_json);
				//simpan sementara ke db untuk tiket konfirmasi
				query("INSERT INTO send_saldo (tx_tiket,tanggal,tx_from,tx_to)VALUES('$_txtiket','$_txTgl','$nameFile','$_etc_phone')");
				echo "<script>alert('SATU KONFIRMASI LAGI...!');</script>";
				return mysqli_affected_rows($conn);
			}
			else{
				echo "<script>alert('saldo kamu masih kurang coba perhatikan, berapa nominal yang bisa kamu kirim kan SIAP KIRIM');</script>";
			}
		}
	}
	else{
	echo "<script>alert('nominal pas dengan siap kirim');</script>";
	}
}
function tokenCenceldSaldoSend($data){
	global $conn;
	$token = htmlspecialchars($data["token"]);
	$var = query("SELECT * FROM send_saldo WHERE tx_tiket='$token' ");
	if (!empty($token)) {
		if (mysqli_num_rows($var)===1) {
			$key = mysqli_fetch_assoc($var);
			$_txn = $key["tx_tiket"];
			query("DELETE FROM send_saldo WHERE tx_tiket='$token' ");
			return mysqli_affected_rows($conn);
		}else{
			echo "<script>alert('Token salah..!');</script>";
			return false;
		}
	}
	else{
		echo "<script>alert('mohon masukan token dahulu');</script>";
		return false;
	}
}
function tokenConfirmSaldoSend($data){
	global $conn;
	$token = htmlspecialchars($data["token"]);
	$var = query("SELECT * FROM send_saldo WHERE tx_tiket='$token' ");
	if (!empty($token)) {
		if (mysqli_num_rows($var)===1) {
			$key = mysqli_fetch_assoc($var);
			$_txn = $key["tx_tiket"];
			$_sysPhone = $key["tx_to"];
			$_fileJson = file_get_contents("master/trf_dana/".session("username").'-'.$_txn.'.json',true);
			$keyJs = json_decode($_fileJson);
			$_jsnominal = $keyJs->pengirim->mengirim;
			$_jsadmin = $keyJs->pengirim->fee_admin;
			$_username_received = $keyJs->penerima->nama;
			$_jstotal = $_jsnominal + $_jsadmin;
			//cari penerima di db
			$s_trf = query("SELECT * FROM user_wifi WHERE telepon='$_sysPhone' "); //penerima
			$_sysKey = mysqli_fetch_assoc($s_trf);
			 $_ids = $_sysKey["id"]; //penerima
			//rincikan penerima
			$_varSal = query("SELECT * FROM user_saldo WHERE id_user='$_ids' "); //get saldo awal penerima
			$_keySal = mysqli_fetch_assoc($_varSal); //penerima
			$_awalSal = $_keySal["nominal"]; //saldo awal penerima
			$_newSaldo = $_awalSal + $_jsnominal; //saldo baru
			query("UPDATE user_saldo SET nominal='$_newSaldo' WHERE user_saldo.id_user='$_ids' "); //tambahklan saldo ke penerima
			// simpan ke db
			$date = date("Y-m-d");
			$_var_var = query("SELECT * FROM user_wifi WHERE telepon='$$_sysPhone' ");
			$_key_key = mysqli_fetch_assoc($_var_var);
			$username_receiv = $_key_key["username"];
			$username_send = session("username");
			$status = "BERHASIL";
			query("INSERT INTO trx_saldo_user (id,tanggal,username_send,username_received,rec_telepon,nominal,fee,total,status)VALUES(NULL,'$date','$username_send','$_username_received','$_sysPhone','$_jsnominal','$_jsadmin','$_jstotal','$status')");
			//kurangi saldo pengirim//
			$_newSalPengirim = saldo("nominal") - $_jstotal; //pengurangan saldo pengirim
			updateSaldo($_newSalPengirim); // update saldo pengirim
			query("DELETE FROM send_saldo WHERE tx_tiket='$token' "); //hapus tiket di db
			echo "<script>alert('PROSESS SELESAI, TERIMA KASIH')</script>";
			return mysqli_affected_rows($conn); //kembalikan nilai ke function
		}else{
			echo "<script>alert('Token salah..!')</script>";
			return false;
		}
	}
	else{
		echo "<script>alert('mohon masukan token dahulu')</script>";
		return false;
	}
}
function topup_trxsal($data){
	global $conn;
	$token = htmlspecialchars($data["babymon"]);
	$_varNotif = query("SELECT * FROM notif_topup WHERE token='$token' ");
	if (mysqli_num_rows($_varNotif)>0) {
		$key = mysqli_fetch_assoc($_varNotif);
		$id = $key["id_user"];
		$varsaldo= query("SELECT * FROM user_saldo WHERE id_user='$id' ");
		$keysaldo = mysqli_fetch_assoc($varsaldo);
		$newsaldo = $key["nominal"]+$keysaldo["nominal"];
		query("UPDATE user_saldo SET nominal='$newsaldo' WHERE user_saldo.id_user='$id' ");
		query("DELETE FROM notif_topup WHERE token='$token' ");
		echo "<script>alert('berhasil di proses');</script>";
		echo "<script>location='index.php';</script>";
		return mysqli_affected_rows($conn);
	}else{
		echo "<script>alert('saya paling tidak suka anda merubah element nya.!');</script>";
	}
}
function recordShellerUser(){
	global $conn;
	$id = session("id");
	$kode = randomString(5);
	$link = "include/tx_wifi/".session("username").'-'.date("Y-m-d").'-'.$kode.".json";
	$var = query("SELECT * FROM transaksi_wifi WHERE id_user='$id' ");
	if (mysqli_num_rows($var)>0) {
		$arr = array();
		$payment = 0;
		foreach ($var as $key) {
			$arr[] = array( 'id' => $key['id'],
				'id_user' => $key['id_user'],
				'tanggal' => $key['tanggal'],
				'nama_wifi' => $key['nama_wifi'],
				'kode' => $key['kode'],
				'harga' => $key['harga'],
				'harga_jual' => $key['harga_jual']);
			$item = $key["harga_jual"];
			$payment+=$item;
		}
		$content = json_encode($arr);
		$handler = fopen($link, "a+");
		fwrite($handler, $content);
		fclose($handler);
	query("INSERT INTO tx_record (id,id_user,token,payment) VALUES (NULL,'$id','$kode','$payment')");
	query("DELETE FROM transaksi_wifi WHERE id_user='$id' ");
	echo "<script>alert('Status pending!!!');</script>";
	echo "<script>location='index.php';</script>";
	return mysqli_affected_rows($conn);
	}else{
		echo "<script>alert('kamu tidak memiliki transaksi penjualan');</script>";
	}
}
function add_user_new($data){
	global $conn;
	$name = htmlspecialchars($data["username"]);
	$lv = "member";
	$hp = htmlspecialchars($data["telepon"]);
	$mail = htmlspecialchars($data["email"]);
	$pass = password_hash("bc24", PASSWORD_DEFAULT);
	if (!empty($name)) {
		if (!empty($hp)) {
			if (!empty($mail)) {
				query("INSERT INTO user_wifi (id,level,username,password,email,telepon)VALUES(NULL,'$lv','$name','$pass','$mail','$hp')");
				$var = query("SELECT * FROM user_wifi WHERE telepon='$hp' ");
				$key = mysqli_fetch_assoc($var);
				$key_id = $key["id"];
				query("INSERT INTO user_saldo (id_user,nominal)VALUES('$key_id',0)");
				echo "<script>alert('$name, $lv, $hp, $mail,                                                          Berhasil ditambahkan.');</script>";
				return mysqli_affected_rows($conn);
			}else{
				echo "<script>alert('email jangan kosong');</script>";
			}
		}else{
			echo "<script>alert('nomor ponselnya jangan lupa!');</script>";
		}
	}else{
		echo "<script>alert('mohon masukan nama dahulu');</script>";
	}
}
function paymentTxRecord($data){
	global $conn;
	$_txTgl = date("Y-m-d");
	$date = tanggal_indo($_txTgl);
	$id = session("id");
	$username = session("username");
	$telepon = session("telepon");
	$metod = htmlspecialchars($data["id"]);
	$varPay = query("SELECT * FROM payment WHERE pay_name = '$metod' ");
	if (mysqli_num_rows($varPay)==1) {
		$keyPay = mysqli_fetch_assoc($varPay);
		$namePay = $keyPay["pay_name"];
		$noPay = $keyPay["pay_no"];
		$ketPay = $keyPay["pay_ket"];
		$varTxRecord = query("SELECT * FROM tx_record WHERE id_user='$id' ");
		if (mysqli_num_rows($varTxRecord)>0) {
			$keyRec = mysqli_fetch_assoc($varTxRecord);
			$token = $keyRec["token"];
			$nominal = $keyRec["payment"];
			$arr = array(
				"tanggal"=>"$date",
				"token"=>"$token",
				"username"=>"$username",
				"username"=>"$telepon",
				"nominal"=>"$nominal",
				"bayar_via"=>"$namePay",
				"nomor_rek"=>"$noPay",
				"keterangan"=>"$ketPay");
			$link = "include/trx_setor/".$token.'.json';
			$jsonContent = json_encode($arr);
			$handler = fopen($link, "a+");
			fwrite($handler, $jsonContent);
			fclose($handler);
			echo "<script>location='index.php';</script>";
			return mysqli_affected_rows($conn);
		}else{
			echo "<script>alert('MOHON MAAF AKUN KAMU DI KUNCI, silahkan hubungi administrator.');</script>";
		}
	}else{
		echo "<script>alert('MOHON MAAF AKUN KAMU DI KUNCI, silahkan hubungi administrator.');</script>";
	}
}

function prosess_laporan($data){
	global $conn;
	$token = htmlspecialchars($data["token"]);
	$var = query("SELECT * FROM tx_record WHERE token='$token'");
	if (mysqli_num_rows($var)>0) {
		query("DELETE FROM tx_record WHERE token='$token' ");
		echo "<script>alert('$token prosess berhasil');</script>";
		echo "<script>location='index.php';</script>";
		return mysqli_affected_rows($conn);
	}else{
		echo "<script>alert('jangan mengubah value ataupun element, karna itu bisa membuat saya kesal.!');</script>";
	}
}
	function listLaporanPenjualan($data){
	global $conn;
	$id = decodeBase64(htmlspecialchars($data["user_lap"]));
	$var = query("SELECT * FROM transaksi_wifi WHERE id_user='$id' ");
	if (mysqli_num_rows($var)>0) {
		$main = encodeBase64(session("id"));
		$base64 = encodeBase64("reportUserTransaksi");
		$idbase = encodeBase64($id);
		$end = encodeBase64("aku ganteng banget");
		echo "<script>location='index.php?$main=$base64&_%_=$idbase&_$end';</script>";
	}else{
		echo "<script>alert('user ini belum memiliki penjualan');</script>";
	}
}
?>