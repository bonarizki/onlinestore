<div class= "main-content">
	<section class= "section">
		<div class= "section-header">
			<h1>Data Barang</h1>
		</div>

		<a href="<?php echo base_url ('admin/data_barang/tambah_barang') ?>" class="btn btn-primary mb-4"> Tambah Data </a>

		<?php echo $this->session->flashdata ('pesan') ?>

		<table class ="table table-hover table-striped table-borderd" id="table">
			<thead>
				<tr>
				<th> No </th>
				<th> Gambar </th>
				<th> Type </th>
				<th> Brand </th>
				<th> Stok </th>
				<th> Harga </th>
				<th> Diskon </th>
				<th> Aksi </th>
			</tr>
			</thead>
			<tbody>
				<?php 
				$no=1;
				foreach ($barang as $brg) : ?>
					<tr>
					<td><?php echo $no++?></td>
					<td><image width="250px" src="<?php echo base_url (). 'assets/upload/'. $brg->gambar?>">
					</td>
					<td><?php echo $brg->kode_type?></td>
					<td><?php echo $brg->merk?></td>
					<td><?php echo $brg->stok?></td>
					<td><?php echo number_format($brg->harga,2,',','.')?></td>
					<td><?php echo number_format($brg->diskon,2,',','.')?></td>
					<td> 
						<a href="<?php echo base_url ('admin/data_barang/detail_barang/').$brg->id_barang ?>" class="btn btn-sm btn-success"> <i class="fas fa-eye"></i></a>
						<a href="<?php echo base_url ('admin/data_barang/delete_barang/').$brg->id_barang ?>" class="btn btn-sm btn-danger"> <i class="fas fa-trash"></i></a>
						<a href="<?php echo base_url ('admin/data_barang/update_barang/').$brg->id_barang ?>" class="btn btn-sm btn-primary"> <i class="fas fa-edit"></i></a>
					</td>
				</tr>
				<?php endforeach; ?>
				</tbody>
		</table>
	</section>
</div>

<script>
	$(document).ready( function () {
    $('#table').DataTable({
		dom: 'Bfrtip',
		buttons: [
			'pageLength',
			{ extend: 'pdf', text: '<span class="btn btn-sm btn-info mr-2"><i class="fas fa-file-pdf fa-1x" aria-hidden="true"></i> PDF </span>'},
			{ extend: 'csv', text: '<span class="btn btn-sm btn-info mr-2"><spa class="fas fa-file-csv fa-1x"></i> CSV </span>'},
			{ extend: 'excel', text: '<span class="btn btn-sm btn-info mr-2"><i class="fas fa-file-excel" aria-hidden="true"></i> EXCEL </span>' },
		]
	});
	} );
</script>