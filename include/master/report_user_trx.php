<?php
$idbases = decodeBase64($_GET["_%_"]);
$varSeamLink = query("SELECT * FROM transaksi_wifi WHERE id_user='$idbases' ");
$_rows_num = mysqli_num_rows($varSeamLink);
$_varUserLap = query("SELECT * FROM user_wifi WHERE id='$idbases' ");
$_keyUserLap = mysqli_fetch_assoc($_varUserLap);
?>
<div class="row">
	<div class="content">
		<h2>penjualan <span style="color:white;"><?=$_keyUserLap["username"];?></span>(<span style="color:red;"><?=$_rows_num;?></span>)</h2>
		<table class="table">
			<thead>
				<tr>
					<th style="background-color:violet;color:black;">no</th>
					<th style="background-color:violet;color:black;">vcr</th>
					<th style="background-color:violet;color:black;">harga</th>
				</tr>
			</thead>
			<tbody>
				<?php $n = 1;?>
				<?php foreach ($varSeamLink as $keySeamLink): ?>
					<?php
					$vcr = $keySeamLink["harga"];
					if ($vcr <= 2000) {
						$bgc = "orange";
						$bgt = "white";
					}
					if ($vcr > 2000 && $vcr <= 3000) {
						$bgc = "blue";
						$bgt = "white";
					}
					if ($vcr > 3000 && $vcr <= 5000) {
						$bgc = "green";
						$bgt = "white";
					}
					?>
					<tr>
						<td style="background-color:<?=$bgc;?>;color:<?=$bgt;?>"><?=$n;?></td>
						<td style="background-color:<?=$bgc;?>;color:<?=$bgt;?>">voucher_<?=$vcr;?></td>
						<td style="background-color:<?=$bgc;?>;color:<?=$bgt;?>"><?=$keySeamLink["harga_jual"];?></td>
					</tr>
					<?php $n++;?>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>