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
        line-height: 1.2em
    }
    h1{
      font-weight: bold;
    }
    small{
      font-size: 12px;
    }
    br{
      height: 10px;
    }
    </style>
  </head>
  <body>
    <div class="container mt-3">
      <div class="row">
        <div class="col-md-4">
          <table width="100%" cellpadding="5" class="mb-3">
            <tr>
              <td width="20%">
                <img src="<?=base_url('logo_kasir.png') ?>" width="70">
              </td>
              <td>
                <h3 class="text-success m-0"><b>Kantin JF</b></h3>
                <p class="m-0" style="font-size: 13px;">Kp. Bojong RT. 005/04, Desa, Bojongsari,<br>Kec. Kedungwaringin -Bekasi 17540</p>
              </td>
            </tr>
          </table>
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">TRANSAKSI ANDA</h3>
            </div>
            <div class="card-body">
              <div id="load_trx" ></div>
            </div>
          </div>
          <div class="row mt-2">
              <p class="text-center">Bagaimana menurut anda, tentang Pelayanan kami ? </p>
              <div class="col-4">
                <button class="btn btn-success btn-sm w-100">BAIK</button>
              </div>
              <div class="col-4">
                <button class="btn btn-info btn-sm w-100">SEDANG</button>
              </div>
              <div class="col-4">
                <button class="btn btn-danger btn-sm w-100">BURUK</button>
              </div>
          </div>
        </div>
        <div class="col-md-8">
          <div class="card">
            <div class="card-body">
              <iframe width="100%" height="445" src="http://www.youtube.com/embed/_wkCP3jGvjM?autoplay=1&loop=1&autopause=0" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen allow="autoplay"></iframe>
            </div>
          </div>
        </div>
      </div>
      
    </div>
    <script src="<?php echo base_url('public');?>/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
      setInterval(function() {
        $("#load_trx").load("<?=base_url('customers/trx') ?>")
      },1000);
    </script>
  </body>
</html>