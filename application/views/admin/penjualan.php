<div class= "main-content">
    <section class= "section">
        <div class= "section-header">
            <h1>Data Penjualan</h1>
        </div>

        <?php echo $this->session->flashdata ('pesan') ?>
            
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm" id="table" width="100%">
                <thead>
                    <tr>
                        <th> Id Order </th>
                        <th> Nama Cust </th>
                        <th> Merk </th>
                        <th> Total Item </th>
                        <th> Status </th>
                        <th> Type</th>
                        <th> Pengiriman</th>
                        <th> Opsi </th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th> Id Order </th>
                        <th> Nama Cust </th>
                        <th> Merk</th>
                        <th> Total Item</th>
                        <th> Status </th>
                        <th> Type</th>
                        <th> Pengiriman</th>
                        <th> Opsi </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
</div>

<div class="modal fade" id="konfirmasi-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pembayaran</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <img class="card-img-top" id="imgModal" src="" style ="width : 450px; height : 300px" alt="">
            <h4 id="idModal" hidden></h4>
            <h4 id="merekModal"></h4>
            <h5>Harga:</h5>
            <h5 id="hargaModal"><?php echo number_format(1000,2,',','.') ?> </h5>
            <div class="mt-2">
              <label for="">Jumlah Barang</label>
              <input type="number" class="form-control" id="total_item" placeholder="Total Item" readonly>
            </div>
            <div class="mt-2">
              <label for="">Type Pengiriman</label>
              <input type="text" class="form-control" id="type_pengiriman" readonly>
            </div>
            <div class="mt-2" id="total">
              <label for="">Total Bayar</label>
              <input type="text" class="form-control" id="total_bayar" placeholder="Total Bayar" readonly>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="button">Konfirmasi</button>
          </div>
        </div>
      </div>
  </div>

<script>
    $(document).ready( function () {
        $('#table').DataTable({
            responsive:true,
            ajax:"<?= base_url('admin/dashboard/getAllOrder') ?>",
            columns:[
                {"data":"id_trans"},
                {"data":"nama"},
                {   "data":"nama_type",
                    "render":function(data,type,row){
                        return data+'-'+row.merk+'-'+row.warna;
                    }
                },
                {"data":"total_item"},
                {
                    "data":"satatus_transaksi",
                    "render":(data,type,row)=>{
                        if (data==0) {
                            return "menunggu pembayaran";
                        }else if(data==1){
                            return "menunggu konfirmasi";
                        }else{
                            return "terfkonfirmasi"
                        }
                    }
                },
                {"data":"type_transaksi"},
                {"data":"type_pengiriman"},
                {
                    "data":"id_trans",
                    "render":(data,type,row)=>{
                        return `
                                <button class="btn btn-sm btn-success" onclick="showModal('${data}')">
                                    Konfirmasi
                                </button>
                                `
                    }
                }
                
            ],
            dom: 'Bfrtip',
            buttons: [
                'pageLength',
                { extend: 'pdf', text: '<span class="btn btn-sm btn-info mr-2"><i class="fas fa-file-pdf fa-1x" aria-hidden="true"></i> PDF </span>'},
                { extend: 'csv', text: '<span class="btn btn-sm btn-info mr-2"><spa class="fas fa-file-csv fa-1x"></i> CSV </span>'},
                { extend: 'excel', text: '<span class="btn btn-sm btn-info mr-2"><i class="fas fa-file-excel" aria-hidden="true"></i> EXCEL </span>' },
            ]
        });
    });

    


    function sweetSuccess(message)
    {
        Swal.fire(
            'Good job!',
            message,
            'success'
        )
    }

    function sweetFailed(message)
    {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: message,
        })
    }

    function tableReset()
    {
        var table = $('#table').DataTable();
        table.ajax.reload();
    }

    

    function cacncelOrder(id_sewa,id_mobil)
    {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it!',
            preConfirm:function(isConfirm){
                $.ajax({
                    url:"<?= base_url('admin/dashboard/cancelOrder/')?>"+id_sewa+"/"+id_mobil,
                    success:function(response){
                        sweetSuccess(response.message);
                        tableReset();
                    },
                    error:function(response){
                        sweetFailed(response.statusText);
                    }
                })
            }
        })
    }

    showModal = (id) => {
        $.ajax({
            type:"get",
            url:"<?= base_url('admin/dashboard/getOrderById') ?>/"+id,
            success:(res)=>{
                let data = JSON.parse(res);
                data = data.data[0]
                if (data.image_trasfer=='') {
                    sweetFailed('belum melakukan transfer')
                }else{
                    console.log(data.type_pengiriman)
                    let onkir = 0;
                    if(data.type_pengiriman=='TIKI'){
                        ongkir = 18000
                    }else if(data.type_pengiriman=='JNE'){
                        ongkir = 20000
                    }else{
                        onkir = 22000
                    }
                    $('#imgModal').attr('src','<?= base_url('assets/upload/')?>'+data.image_trasfer);
                    $('#merekModal').text(data.merk);
                    $('#idModal').text(data.id_barang);
                    $('#hargaModal').text(data.harga);
                    $('#total_item').val(data.total_item);
                    $('#type_pengiriman').val(data.type_pengiriman);
                    $('#total_bayar').val(data.harga*data.total_item+ongkir)
                    $('#konfirmasi-modal').modal('show');
                }
            }
        })
    }

    
</script>