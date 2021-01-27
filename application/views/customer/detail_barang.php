<div class="container mt-5 mb-5">

	<div class="card">
		<div class="card-body">
			<?php foreach ($detail as $dt) : ?>
				<div class="row">
					<div class="col-md-5"> 
						<img style= "width:90%" src= "<?php echo base_url ('assets/upload/'.$dt->gambar)?>">
					</div>
					<div class="col-md-5"> 
						<table class="table">
							<tr>
								<th> Brand </th>
								<td> <?php echo $dt->merk ?> </td>
							</tr>
							<tr>
								<th> Status </th>
								<td> <?php if ($dt->status == '0') {
									echo "terjual";
								}else if ($dt->status == '3'){
									echo "Booked";
							 	}else {
									echo "Tersedia";
								} 
								?> 
							</td>
							</tr>
							<tr>
							<td></td>
							<td>
								<?php 
				               if ($dt->status == "0") {
				                echo "<span class='btn btn-danger' disable> TERJUAL </span>";
							   }else if ($dt->status == '3'){
								echo "<span class='btn btn-danger' disable> Menunggu Pembayaran </span>";
							 	}else{
				                // echo '<button class="btn btn-success"  onclick="sewamobil('.$dt->id_barang.')"> Beli </button>';
				                echo '<button class="btn btn-success" onclick="sewamobil('.$dt->id_barang.')"> Beli </button>';
				               }
				               ?>
							</td>
							</tr>
						</table>
					</div>
				<?php endforeach; ?>
		</div>
	</div>
</div>