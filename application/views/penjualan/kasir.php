<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Master POS Kasir</title>
    <link rel="icon" type="image/png" href="<?=base_url('logo.png') ?>">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <style>
    body {
        font-family: 'Poppins';
    }
    h1{
      font-weight: bold;
    }
    </style>
  </head>
  <body>
    <div class="container mt-3">
      <div class="row">
        <div class="col-md-6">
          <table width="100%">
            <tr>
              <td width="17%">
                <img src="<?=base_url('logo_kasir.png') ?>" width="80">
              </td>
              <td>
                <h2 class="text-success m-0"><b>Kantin JF</b></h2>
                <p class="m-0">Kp. Bojong RT. 005/04, Desa, Bojongsari, Kec. Kedungwaringin, Kabupaten Bekasi, Jawa Barat 17540</p>
              </td>
            </tr>
          </table>
        </div>
        <div class="col-md-6">
          <div class="card bg-success">
            <div class="card-body">
              <h1 class="text-white float-end" id="h1_total"></h1>
            </div>
          </div>
        </div>
      </div>
      <hr class="bg-success">
      <div class="row">
        <div class="col-md-4">
          <div class="row mb-2">
            <label class="form-label col-md-3">ID Trx</label>
            <div class="col-md-9">
              <input type="text" class="form-control" id="invoice" disabled value="<?=$code_penjualan ?>">
            </div>
          </div>
          <div class="row mb-2">
            <label class="form-label col-md-3">Tanggal</label>
            <div class="col-md-9">
              <input type="text" class="form-control" disabled value="<?=date("Y-m-d H:i:s") ?>">
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-md-12">
              <form method="post" id="pelanggan">
                <input type="text" class="form-control" id="no_pelanggan" placeholder="No. Kartu atau ID Pelanggan">  
              </form>
              
            </div>
          </div>
          <table width="100%">
            <tr><td width="45%">Nama Pelanggan </td><td width="3%">:</td><td id="nama_pelanggan"></td></tr>
            <tr><td valign="top">Alamat</td><td valign="top">:</td><td id="alamat_pelanggan"></td></tr>
            <tr><td>No. HP</td><td>:</td><td id="phone_pelanggan"></td></tr>
            <tr><td>Limit</td><td>:</td><td id="limit"></td></tr>
          </table>
          <div class="row mt-2">
            <div class="col-4">
              <button class="btn btn-primary w-100" id="simpan">Simpan</button>
            </div>
            <div class="col-4">
              <button class="btn btn-warning w-100" id="tunggu">Tunggu</button>
            </div>
            <div class="col-4">
              <button class="btn btn-danger w-100" id="batal">Batal</button>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <form method="post" id="barang">
            <input type="text" id="barcode" class="form-control-lg w-100 mb-2" autofocus placeholder="Barcode atau nama barang">
          </form>
          <table class="table table-bordered table-striped">
            <thead>
              <tr><th>Nama Barang</th><th width="10%">QTY</th><th width="20%">Harga</th><th>Subtotal</th></tr>
            </thead>
            <tbody id="keranjang"></tbody>
            <tfoot>
              <tr><th colspan="3" class="text-end">Total</th><th class="text-end" id="total"></th></tr>
              <tr><th colspan="3" class="text-end">Infaq</th><th width="20%"><input type="text" id="infaq" class="form-control text-end" value="0"></th></tr>
              <tr><th colspan="3" class="text-end">Bayar</th><th class="text-end"><input type="text" id="bayar" class="form-control text-end" value="0"></th></tr>
              <tr><th colspan="3" class="text-end">Kembalian</th><th class="text-end" id="kembalian">0</th></tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
    <script src="<?php echo base_url('public');?>/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
      $(document).ready(function()  {
        var get_kerankang = "<?=base_url('penjualan/get_keranjang') ?>"+"/"+$('#invoice').val()
        var get_total = "<?=base_url('penjualan/get_total') ?>"+"/"+$('#invoice').val()
        $("#keranjang").load(get_kerankang)
        $("#total").load(get_total)
        $("#h1_total").load(get_total)
        $("#batal").click(function() {
          var code = $('#invoice').val()
          $.ajax({
            type: "POST",
            url: "./del_transaksi",
            data: "code=" + code,
            success: function(html) {
              window.location.href="./create"
            }
          });
          return false;
        })

        function getCst() {
          $.ajax({
            type: "POST",
            url: "./get_pelanggan",
            data: "code=" + $('#invoice').val(),
            success: function(html) {
              var json = JSON.parse(html)
              $("#nama_pelanggan").html(json.customer_name)
              $("#alamat_pelanggan").html(json.customer_address)
              $("#phone_pelanggan").html(json.customer_phone)
              $("#limit").html(json.limit)
            }
          });
        }
        getCst();
        $("#pelanggan").submit(function(e) {
          e.preventDefault();
          var no_pelanggan = $('#no_pelanggan').val()
          $.ajax({
            type: "POST",
            url: "./update_pelanggan",
            data: "pelanggan=" + no_pelanggan+"&code="+$('#invoice').val(),
            success: function(html) {
              $('#no_pelanggan').val("")
              getCst();
            }
          });
          return false;
        })
        $("#barang").submit(function(e) {
          e.preventDefault();
          var barang = $('#barcode').val()
          $.ajax({
            type: "POST",
            url: "./get_transaksi",
            data: "barang=" + barang+"&code="+$('#invoice').val(),
            success: function(html) {
              $('#barcode').val("")
              $("#keranjang").load(get_kerankang)
              $("#total").load(get_total)
              $("#h1_total").load(get_total)
              var json = JSON.parse(html);
              if (json.code == 203) {
                toastr.error(json.message);

              }
            }
          });
          return false;
        })
        $.ajax({
          type: "GET",
          url: "./get_total/"+$('#invoice').val(),
          success: function(html) {
            var totals = html.replace("Rp. ","");
            var jumlah = totals.replace(".","");
            $("#bayar").keyup(function() {
              var bayar = parseInt($("#bayar").val());
              var infaq = parseInt($("#infaq").val());
              var total_belanja = parseInt(jumlah);
              var kembalian = bayar- (total_belanja + infaq);
              $("#kembalian").html(kembalian)
            });
            $("#infaq").keyup(function() {
              var bayar = parseInt($("#bayar").val());
              var infaq = parseInt($("#infaq").val());
              var total_belanja = parseInt(jumlah);
              var kembalian = bayar- (total_belanja + infaq);
              $("#kembalian").html(kembalian)
            });
            $("#simpan").click(function() {
              var code = $('#invoice').val()
              var bayar = $("#bayar").val();
              var infaq = $("#infaq").val();
              if (bayar == 0) {
                toastr.error("Jumlah bayar tidak boleh 0")
              }else{
                var total_belanja = parseInt(jumlah);
                var kembalian = parseInt(bayar) - (parseInt(total_belanja) + parseInt(infaq));
                $.ajax({
                  type: "POST",
                  url: "./simpan",
                  data: "code=" + code+"&total="+total_belanja+"&infaq="+parseInt(infaq)+"&bayar="+parseInt(bayar)+"&kembalian="+parseInt(kembalian),
                  success: function(html) {
                    var json = JSON.parse(html)
                    toastr.success(json.message)
                    setTimeout(function() {
                      window.location.href="./create"
                    },1500)
                    
                  }
                });
              }
              
              return false;
            })
          }
        });
        
      })
    </script>
  </body>
</html>