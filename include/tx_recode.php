<?php
$contentJson = file_get_contents("include/trx_setor/$extfile",true);
$json = json_decode($contentJson);
?>
<div class="content">
	<div class="column">
		<div class="card">
			<h3>selesaikan pembayaran</h3>
			<ol style="color:green;">Tiket/Token <br> <span style="font-size:30px;"><?=$json->token;?></span></ol>
			<ol>tanggal : <?=$json->tanggal;?></ol>
			<ol>jumlah : <span style="color:green;font-size:20px;">Rp. <?=number_format($json->nominal);?>,-</span></ol>
			<ol>bayar via : <?=$json->bayar_via;?></ol>
			<span><?=$json->keterangan;?></span>
		</div>
	</div>
</div>