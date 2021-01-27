<!-- Page Content -->
<div class="container">
    <?php
        for ($i=0; $i < count($pesanan) ; $i++) { 
    ?>
    <div class="row mt-3">
        <div class="col-12">
            <div class="card" with="100%">
                <div class="card-body">
                    <h5 class="card-title">Order No. <?= $pesanan[$i]['id_trans']?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?= $pesanan[$i]['merk'] ?></h6>
                    <p class="card-text">Harga : Rp.<?php echo number_format($pesanan[$i]['harga'],2,',','.') ?></p>
                    <p class="card-text">Status Pembayaran : 
                        <?php if ($pesanan[$i]['satatus_transaksi'] == '0') {
                            echo "Menunggu Pembayaran";
                        }else if($pesanan[$i]['satatus_transaksi'] == '1'){
                            echo "Menunggu Konfirmasi";
                        } ?>
                    </p>
                    <a class="card-link upload" onclick="modal('<?= $pesanan[$i]['id_trans'] ?>')">Upload Pembayaran</a>
                </div>
            </div>
        </div>
    </div>
    <?php     
        }
     ?>

</div>

<!-- Modal -->
<div class="modal fade" id="modal-upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form enctype="multipart/form-data" id="form">
                    <input type="text" name="id_transaksi" id="id_transaksi" hidden>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Example file input</label>
                        <input type="file" class="form-control-file" id="file">
                    </div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="save()">Save changes</button>
			</div>
		</div>
	</div>
</div>

<script>
    modal = (id) => {
        $('#modal-upload').modal('show');
        $('#id_transaksi').val(id);
    }

    save = () => {
        let data = new FormData();
        data.append( 'file', $( '#file' )[0].files[0] );
        data.append( 'id_transaksi', $( '#id_transaksi' ).val() );
        $.ajax({
            processData: false,
            contentType: false,
            type: "post",
            url: "<?= base_url('customer/dashboard/uploadPembayaran') ?>",
            data : data,
            success : (res) => {
                $('#modal-upload').modal('hide');
                $('#id_transaksi').val('');
                newdata = JSON.parse(res)
                Swal.fire(
                    'Good job!',
                    newdata.message,
                    'success'
                ).then((resul)=>{
                    location.reload(true);
                })
            }
        })
    }
</script>

