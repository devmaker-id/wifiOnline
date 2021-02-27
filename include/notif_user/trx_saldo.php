<hr>
<font>
	tabel pengiriman saldo kamu.
</font>
<table class="penjualan">
	<thead>
		<tr>
			<th>hari/tanggal</th>
			<th>tujuan</th>
			<th>telepon</th>
			<th>nominal</th>
			<th>admin</th>
			<th>jumlah</th>
			<th>status</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($_vry as $key_vry): ?>
			<tr>
				<td><?=tanggal_indo($key_vry['tanggal'],true);?></td>
				<td><?=$key_vry['username_received'];?></td>
				<td><?=$key_vry['rec_telepon'];?></td>
				<td><?=number_format($key_vry['nominal']);?></td>
				<td><?=number_format($key_vry['fee']);?></td>
				<td><?=number_format($key_vry['total']);?></td>
				<td style="color:green;"><?=$key_vry['status'];?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>