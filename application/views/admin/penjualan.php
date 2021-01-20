<div class= "main-content">
    <section class= "section">
        <div class= "section-header">
            <h1>Data Penjualan</h1>
        </div>

        <?php echo $this->session->flashdata ('pesan') ?>
            
        <table class="table table-striped table-bordered table-sm" id="table">
            <thead>
                <tr>
                    <th> Id Order </th>
                    <th> Nama Cust </th>
                    <th> Jenis Mobil </th>
                    <th> Plat </th>
                    <th> Status </th>
                    <th> Type</th>
                    <th> Opsi </th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th> Id Order </th>
                    <th> Nama Cust </th>
                    <th> Jenis Mobil </th>
                    <th> Plat </th>
                    <th> Status </th>
                    <th> Type</th>
                    <th> Opsi </th>
                </tr>
            </tfoot>
        </table>
    </section>
</div>  

<script>
    $(document).ready( function () {
        $('#table').DataTable({
            ajax:"<?= base_url('admin/dashboard/getAllOrder') ?>",
            columns:[
                {"data":"id_trans"},
                {"data":"nama"},
                {   "data":"nama_type",
                    "render":function(data,type,row){
                        return data+'-'+row.merk+'-'+row.warna;
                    }
                },
                {"data":"no_plat"},
                {
                    "data":"status",
                    "render":(data,type,row)=>{
                        if (data==0) {
                            return "tersedia";
                        }else if(data==3){
                            return "booked";
                        }else{
                            return "terjual"
                        }
                    }
                },
                {"data":"type_transaksi"},
                {"data":"id_trans"}
                
            ],
            "createdRow": function( row, data, dataIndex ) {
                            var today = getDateToday();
							if (data.flag_sewa=='1') {
                                if(data.flag_sewa=='1'&&today>data.tanggal_kembali){
                                    return $(row).addClass('table-danger');
                                }else{
                                    return $(row).addClass('table-info');
                                }
							}else if(data.flag_sewa=='2'){
								$(row).addClass('table-success');
                            }else if(data.flag==null){
                                if(data.flag_sewa==null&&today==data.tanggal_sewa){
                                    return $(row).addClass('table-warning');
                                }
                            }
		    },
            dom: 'Bfrtip',
            buttons: [
                'pageLength',
                { extend: 'pdf', text: '<span class="btn btn-sm btn-info mr-2"><i class="fas fa-file-pdf fa-1x" aria-hidden="true"></i> PDF </span>'},
                { extend: 'csv', text: '<span class="btn btn-sm btn-info mr-2"><spa class="fas fa-file-csv fa-1x"></i> CSV </span>'},
                { extend: 'excel', text: '<span class="btn btn-sm btn-info mr-2"><i class="fas fa-file-excel" aria-hidden="true"></i> EXCEL </span>' },
            ]
        });
    });

    var today = getDateToday();

    function ButtonDecision(flag_sewa,tanggal_sewa,id_sewa,tanggal_kembali,id_mobil)
    {   
        var today = getDateToday();
        if(flag_sewa==null){
            return buttonNull(flag_sewa,tanggal_sewa,id_sewa,id_mobil);
        }else if(flag_sewa=='1'){
            return buttonOne(flag_sewa,tanggal_kembali,id_sewa,id_mobil)
        }else if(flag_sewa=='2'){
            return 'No Action'
        }
    }

    function getDateToday()
    {
        var date = new Date();
        var month = date.getMonth()+1;
        var month2 = month < 10 ? '0' + month : '' + month;
        var day = date.getDate();
        var year = date.getFullYear();
        return year+'-'+month2+'-'+day
    }

    function buttonNull(flag_sewa,tanggal_sewa,id_sewa,id_mobil)
    {
        if(flag_sewa==null&&tanggal_sewa==today){
            return '<center><badge class="btn btn-sm btn-success fa fa-check-circle mr-2" onclick="custTakeCar('+"'"+id_sewa+"'"+')" title="Customer Have Take a Car"></badge><badge class="btn btn-sm btn-danger fa fa-times-circle" onclick=cancelOrder('+"'"+id_sewa+"','"+id_mobil+"'"+') title="Cancel Sewa"></badge></center>'
        }else{
            return '<center><badge class="btn btn-sm btn-danger fa fa-times-circle" onclick=cacncelOrder('+"'"+id_sewa+"','"+id_mobil+"'"+') title="Cancel Order"></badge><center>'
        }
    }

    function buttonOne(flag_sewa,tanggal_kembali,id_sewa,id_mobil)
    {
        if(flag_sewa=='1'&&today>tanggal_kembali){
            return '<center><badge class="btn btn-sm btn-danger fa fa-check-double mr-2" title="the car is back" onclick="carBackWithCharge('+"'"+id_sewa+"','"+id_mobil+"'"+')"></badge></center>'
        }else{
            return '<center><badge class="btn btn-sm btn-success fa fa-check-double mr-2" onclick="carBack('+"'"+id_sewa+"','"+id_mobil+"'"+')" title="the car is back"></badge></center>'
        }
    }

    function custTakeCar(id)
    {
        Swal.fire({
            title: 'Apakah Kamu Yakin?',
            text: "Customer Sudah Membayar dan Mengambil Mobil?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Saya Yakin',
            preConfirm:function(isConfirm){
                $.ajax({
                    url:"<?= base_url('admin/dashboard/CarInRent/')?>"+id,
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

    function carBack(id,id_mobil)
    {
        // console.log(id_mobil)
        Swal.fire({
            title: 'Apakah Kamu Yakin?',
            text: "Customer Sudah Mengembalikan Mobil?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Saya Yakin',
            preConfirm:function(isConfirm){
                $.ajax({
                    url:"<?= base_url('admin/dashboard/carIsBack/')?>"+id+"/"+id_mobil,
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

    function carBackWithCharge(id,id_mobil)
    {
        Swal.fire({
            title: 'Apakah Kamu Yakin?',
            text: "Customer Sudah Mengembalikan Mobil?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Saya Yakin',
            preConfirm:function(isConfirm){
                $.ajax({
                    url:"<?= base_url('admin/dashboard/carBackWithCharge/')?>"+id,
                    success:function(response){
                        var data = JSON.parse(response).data[0]
                        var today = getDateToday()
                        var tanggal_kembali = data.tanggal_kembali;
                        var tgl1 = new Date(today);
                        var tgl2 = new Date(tanggal_kembali);
                        var timeDiff = (tgl2 - tgl1) / 1000;
                        var hari = Math.floor(timeDiff/(86400));
                        var finalhari = Math.abs(hari)
                        var denda = finalhari*data.harga;
                        alertCharge(denda,id,id_mobil)
                        // sweetSuccess(response.message);
                        // tableReset();
                    },
                    error:function(response){
                        sweetFailed(response.statusText);
                    }
                })
            }
        })
    }

    function alertCharge(denda,id_sewa,id_mobil)
    {
        Swal.fire({
            title: 'Denda',
            text: "Silahkan Tagih Denda Sebesar "+denda,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            preConfirm:function(isConfirm){
                $.ajax({
                    url:"<?= base_url('admin/dashboard/carIsBack/')?>"+id_sewa+"/"+id_mobil,
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
</script>