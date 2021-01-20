<div class= "main-content">
	<section class= "section">
		<div class= "section-header">
			<h1> Form Update Data Motor</h1>
		</div>
		<div class="card">
			<div class="card-body">
				<?php foreach ($barang as $mb) : ?>
			<form method="POST" action="<?php echo base_url ('admin/data_barang/barang_update') ?>" enctype= "multipart/form-data">
			<div class="row">
				<div class="col-md-6"> 
					<div class="form-group">
						<label> Type Barang </label>
						<input type="hidden" name="id_barang" value="<?php echo $mb->id_barang ?>">
						<select name="kode_type" class="form-control">
							<option value="<?php echo $mb->kode_type ?>"><?php echo $mb->nama_type ?></option>
							<?php foreach ($type as $tp) : ?>
								<option value="<?php echo $tp->kode_type ?>">
									<?php echo $tp->nama_type ?></option>
							<?php endforeach; ?>
						</select>
						<?php echo form_error('kode_type', '<div class="text-small text-danger">',' </div>') ?>
					</div>
					<div class="form-group">
						<label> Brand </label>
						<input type="text" name="merk" class="form-control" value="<?php echo $mb->merk ?>" >
						<?php echo form_error('merk', '<div class="text-small text-danger">',' </div>') ?>
					</div>
					<div class="form-group">
						<label> Warna </label>
						<input type="text" name="warna" class="form-control" value="<?php echo $mb->warna?>">
						<?php echo form_error('warna', '<div class="text-small text-danger">',' </div>') ?>
					</div>
					<div class="form-group">
						<label> Diskon </label>
						<input type="text" name="diskon" class="form-control" value="<?php echo $mb->diskon?>">
						<?php echo form_error('diskon', '<div class="text-small text-danger">',' </div>') ?>
					</div>
					

				</div>
				<div class="col-md-6"> 
					<div class="form-group">
						<label> Stok </label>
						<input type="text" name="stok" class="form-control" value="<?php echo $mb->stok?>">
						<?php echo form_error('stok', '<div class="text-small text-danger">',' </div>') ?>
					</div>

					<div class="form-group">
						<label> Status </label>
						<select name="status" class="form-control">
						<option <?php if($mb->status == "1") {echo "selected='selected'";}
						echo $mb->status;?> value="1"> Tersedia </option>
						<option <?php if($mb->status == "0") {echo "selected='selected'";}
						echo $mb->status;?> value="0"> Terjual </option>
						</select>
						<?php echo form_error('status', '<div class="text-small text-danger">',' </div>') ?>
					</div>
					<div class="form-group">
						<label> Gambar </label>
						<input type="file" name="gambar" class="form-control">
					</div>
					<div class="form-group">
						<label> Harga </label>
						<input type="text" name="harga" class="form-control" value="<?php echo $mb->harga?>">
						<?php echo form_error('harga', '<div class="text-small text-danger">',' </div>') ?>
					</div>
				</div>
				<div>
					<button type="submit" class="btn btn-primary mt-4"> Simpan </button>
					<button type="reset" class="btn btn-danger mt-4"> Reset </button>
				</div>
			</div>
			</form>

		<?php endforeach; ?>
		</div>
		</div>
	</section>
</div>