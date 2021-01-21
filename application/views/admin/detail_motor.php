<div class= "main-content">
	<section class= "section">
		<div class= "section-header">
			<h1>Detail Barang</h1>
		</div>
	</section>

	<?php foreach ($detail as $dt) : ?>
		<div class = "card">
			<div clas ="card-body">

			<div class="row">
				<div class="col-md-5">
					<img src="<?php echo base_url().'assets/upload/'.$dt->gambar ?>" width="450px" height="350px">
				</div>
				<div class="col-md-7">
					<table class="table">
						<tr>
							<td> Type Barang </td>
							<td>
							<?php
							if ($dt->kode_type != null) {
								echo $dt->nama_type;
							} else {
								echo "<span class= 'text-danger'> Type Motor Belum Terdaftar </span>";
							}
							?>
						</td>
						</tr>

						<tr>
							<td> Merk </td>
							<td> <?php echo $dt->merk ?></td>
						</tr>

						

						<tr>
							<td> Warna </td>
							<td> <?php echo $dt->warna ?></td>
						</tr>

						<tr>
							<td> Stok </td>
							<td> <?php echo $dt->stok ?></td>
						</tr>
						<tr>
							<td> Diskon </td>
							<td> <?php echo $dt->diskon ?></td>
						</tr>
						<tr>
							<td> Harga </td>
							<td> <?php echo $dt->harga ?></td>
						</tr>

						<tr>
							<td> Status </td>
							<td>
								<?php
								if ($dt->status == "0"){
									echo "<span class= 'badge badge-danger'> Tidak Tersedia </span>";
								} else if($dt->status == "3") {
									echo "<span class= 'badge badge-info'> Booked </span>";
								}else {
									echo "<span class= 'badge badge-primary'> Tersedia </span>";
								}
								?>
							</td>
						</tr>
					</table>

					<a class = "btn btn-sm btn-danger ml-10" href="<?php echo base_url ('admin/data_barang')?>"> Kembali </a>

					<!-- <a class = "btn btn-sm btn-primary" href="<?php echo base_url ('admin/data_motor/update_motor/'.$dt->id_motor)?>"> Update </a> -->
				</div>
			</div>
		</div>
		</div>

	<?php endforeach; ?>
</div>