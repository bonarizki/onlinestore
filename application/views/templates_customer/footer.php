 <!-- Modal -->
  <div class="modal fade" id="SewaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Motor</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <img class="card-img-top" id="imgModal" src="" style ="width : 450px; height : 300px" alt="">
            <h4 id="idModal" hidden></h4>
            <h4 id="merekModal"></h4>
            <h5 id="platModal"></h5>
            <h5 id="hargaModal">Harga&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo number_format(1000,2,',','.') ?> </h5>
            <div>
              <tr>
                <td>Metode Pembelian </td>
                <td> : </td>
                <td>
                  <select id="type_transaksi" name="type_transaksi">
                    <option value="">Select</option>
                    <option value="COD">COD</option>
                    <option value="TRANSFER">TRANSFER</option>
                  </select>
                </td>
              </tr>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="button" onclick="beli('<?= $this->session->userdata('username') ?>')">Beli</button>
          </div>
        </div>
      </div>
  </div>
  <!-- modal end -->

 <!-- Footer -->
  <!-- <footer class="py-5 bg-dark fixed-bottom">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Vera Rental 2020</p>
    </div> -->
    <!-- /.container -->
  <!-- </footer> -->

  <!-- Bootstrap core JavaScript -->
  <script src="<?php echo base_url() ?>/assets/assets_shop/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>/assets/assets_shop/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script>
    $( function() {
      $( "#ts" ).datepicker({
        dateFormat: "yy-mm-dd"
      });
    } );

    function sewamobil(id){
      $.ajax({
        type :'get',
        url:"<?= base_url('customer/dashboard/detail_byModal/') ?>"+id,
        success:function(data){
          ndata = JSON.parse(data);
          $('#imgModal').attr('src','<?= base_url('assets/upload/')?>'+ndata[0].gambar);
          $('#merekModal').text(ndata[0].merk);
          $('#idModal').text(ndata[0].id_motor);
          $('#platModal').text("No. Plat : "+ndata[0].no_plat);
          $('#hargaModal').text("Harga    : "+ndata[0].harga);
        }
      })
      $('#SewaModal').modal('show')
    }

    function total_sewa(){
      
      var hari = $('#ls').val();
      var tgl_kembali = tanggal_kembali(hari);
      if(hari!='')
      {
        var harga = $('#hargaModal').text();
        var harga1 = harga.split(':');
        var total_harga = hari*harga1[1];
        $('#total_harga').val(total_harga);
        $('#area').attr('hidden',false);
        $('#button').attr('hidden',false)
        namaDriver();
      }else{
        $('#area').attr('hidden',true);
        $('#button').attr('hidden',true);
      }

    }

    function tanggal_kembali(hari)
    {
      date = $("input[name='ts']").val();
      var newdate = new Date(date);
      newdate.setDate(newdate.getDate() + (+hari));
      var dd = newdate.getDate();
      var mm = newdate.getMonth() + 1;
      var y = newdate.getFullYear();

      var someFormattedDate = y + '-' + mm + '-' + dd;
      $("input[name='tl']").val(someFormattedDate);
    }

    function beli(nama)
    {
      if(nama==''){
        $('#SewaModal').modal('hide')
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Anda Harus Login Terlebih Dahulu',
          footer: '<a href>Why do I have this issue?</a>'
        });
      }else{
        if($('#type_transaksi').val()==""){
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Anda Harus Memilih Metode Pembelian',
            footer: '<a href>Why do I have this issue?</a>'
          });
        }else{
          $.ajax({
            type:'post',
            data:{
              "id_motor" : $('#idModal').text(),
              "type_transaksi" : $('#type_transaksi').val()
            },
            url:"<?= base_url('customer/dashboard/sewaMotor') ?>",
            success:function(data){
              newdata = JSON.parse(data)
              $('#SewaModal').modal('hide')
              Swal.fire(
                'Good job!',
                newdata.info,
                'success'
              ).then((resul)=>{
                location.reload(true);
              })
            }
          })
        }
      }
    }
</script>

</body>

</html>




