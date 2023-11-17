<!doctype html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delta Crypto Trading Bot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <link href="<?=base_url('template/style.css?='.time()) ?>" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-11 col-12">
                <div class="card card-login">
                    <div class="card-body">
                        <h6 class="card-title mb-4">Welcome <span class="text-warning float-end fw-600"><button class="btn btn-sm btn-danger" id="logout">Logout</button></span> </h6>
                        <table width="100%" class="data-balance mb-3">
                            <tr>
                                <th class="text-center">Jumlah Member</th>
                                <th class="text-center">Member Hari Ini</th>
                            </tr>
                            <tr>
                                <td class="text-center"><?=$this->app->jumlah_members() ?> </td>
                                <td class="text-center"><?=$this->app->jumlah_members_today() ?></td>
                            </tr>
                        </table>
                        <p class="mb-1 mt-3">Balance Member <span class="float-end"><?=$this->app->tgl() ?></span></p>
                        <?php 
                        $minus_doge = ($this->app->getMinus("DOGE") > $this->app->getDeposit("DOGE") ? $this->app->getDeposit("DOGE") : $this->app->getMinus("DOGE"));
                        $minus_trx = ($this->app->getMinus("TRX") > $this->app->getDeposit("TRX") ? $this->app->getDeposit("TRX") : $this->app->getMinus("TRX"));
                        $minus_btt = ($this->app->getMinus("BTT") > $this->app->getDeposit("BTT") ? $this->app->getDeposit("BTT") : $this->app->getMinus("BTT"));
                        ?>
                        <table width="100%" class="data-balance mb-2">
                            <tr>
                                <th class="text-center bg-primary">Coin</th>
                                <th class="text-center bg-success">Deposit</th>
                                <th class="text-center bg-danger">Member Los</th>
                            </tr>
                            <tr>
                                <td class=" text-primary">XBOT</td>
                                <td class="text-center"><?=number_format($this->app->getDeposit("XBOT"),8) ?></td>
                                <td class="text-center"><?=number_format($this->app->getMinus("XBOT"),8) ?></td>
                            </tr>
                            <tr>
                                <td class=" text-primary">DOGE</td>
                                <td class="text-center"><?=number_format($this->app->getDeposit("DOGE"),8) ?></td>
                                <td class="text-center"><?=number_format($minus_doge,8) ?></td>
                            </tr>
                            <tr>
                                <td class=" text-primary">TRX</td>
                                <td class="text-center"><?=number_format($this->app->getDeposit("TRX"),8) ?></td>
                                <td class="text-center"><?=number_format($minus_trx,8) ?></td>
                            </tr>
                            <tr>
                                <td class=" text-primary">BTT</td>
                                <td class="text-center"><?=number_format($this->app->getDeposit("BTT"),8) ?></td>
                                <td class="text-center"><?=number_format($minus_btt,8) ?></td>
                            </tr>
                        </table>
                       <p class="mb-1 mt-3">Bagi Hasil Afiliator</p>
                       <table width="100%" class="data-balance mb-2">
                            <tr>
                                <th class="text-center bg-primary">Coin</th>
                                <th class="text-center bg-danger">Member Los</th>
                            </tr>
                            <tr>
                                <td class=" text-primary">XBOT</td>
                                <td class="text-center"><?=(floatval($this->app->getMinus("XBOT"))*40)/100  ?></td>
                            </tr>
                            <?php 
                            $bagi_doge = floatval((floatval($minus_doge)*40)/100);
                            $bagi_trx = floatval((floatval($minus_trx)*40)/100);
                            $bagi_btt = floatval((floatval($minus_btt)*40)/100);
                            ?>
                            <tr>
                                <td class=" text-primary">DOGE</td>
                                <td class="text-center"><?=number_format($bagi_doge,8)  ?></td>
                            </tr>
                            <tr>
                                <td class=" text-primary">TRX</td>
                                <td class="text-center"><?=number_format($bagi_trx,8)  ?></td>
                            </tr>
                            <tr>
                                <td class=" text-primary">BTT</td>
                                <td class="text-center"><?=number_format($bagi_btt,8)  ?></td>
                            </tr>
                        </table>
                       <p class="mb-1 mt-3">Riwayat Pencairan</p>
                       <table width="100%" class="data-balance mb-2">
                            <tr>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Coin</th>
                                <th class="text-center">Jumlah</th>
                            </tr>     
                        </table>
                        <p class="mb-1 mt-3 text-center">Wallet Afiliator</p>
                        <form class="mb-3" id="update_wallet" method="post" action="">
                            <div class="row mb-2">
                               <div class="col-12">
                                   <label class="form-label">Wallet XBOT</label>
                                   <input type="text" class="form-control" placeholder="Wallet XBOT" id="xbot" value="<?=$wallet->xbot ?>">
                               </div>
                           </div>
                           <div class="row mb-2">
                               <div class="col-12">
                                   <label class="form-label">Wallet DOGE</label>
                                   <input type="text" class="form-control" placeholder="Wallet DOGE" id="doge" value="<?=$wallet->doge ?>">
                               </div>
                           </div>
                           <div class="row mb-2">
                               <div class="col-12">
                                   <label class="form-label">Wallet TRX</label>
                                   <input type="text" class="form-control" placeholder="Wallet TRX" id="trx" value="<?=$wallet->trx ?>">
                               </div>
                           </div>
                           <div class="row mb-2">
                               <div class="col-12">
                                   <label class="form-label">Wallet BTT</label>
                                   <input type="text" class="form-control" placeholder="Wallet BTT" id="btt" value="<?=$wallet->btt ?>">
                               </div>
                           </div>
                           <div class="row mb-2">
                               <div class="col-12">
                                   <button class="btn btn-success w-100">Update Wallet</button>
                               </div>
                           </div>
                        </form>
                       <p class="mb-1 mt-3">Riwayat Pencairan</p>
                       <table width="100%" class="data-balance mb-2">
                            <tr>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Coin</th>
                                <th class="text-center">Jumlah</th>
                            </tr>
                            
                        </table>
                        <p class="mb-1 mt-3">Total pembagian Sampai hari ini</p>
                        <table width="100%" class="data-balance mb-2">
                            <tr>
                                <th class="text-center">Coin</th>
                                <th class="text-center">Jumlah</th>
                            </tr>
                            <?php 
                            $minus_doge_all = ($this->app->getAllMinus("DOGE") > $this->app->getAllDeposit("DOGE") ? $this->app->getAllDeposit("DOGE") : $this->app->getAllMinus("DOGE"));
                            $minus_trx_all = ($this->app->getAllMinus("TRX") > $this->app->getAllDeposit("TRX") ? $this->app->getAllDeposit("TRX") : $this->app->getAllMinus("TRX"));
                            ?>
                            <tr>
                                <td>XBOT</td><td>0.00000000</td>
                            </tr>
                            <tr>
                                <td>DOGE</td><td><?=$minus_doge_all ?></td>
                            </tr>
                            <tr>
                                <td>TRX</td><td><?=$minus_trx_all ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bignumber.js@9"></script>
    <script type="text/javascript">
        $("#update_wallet").submit(function() {
            var xbot = $("#xbot").val()
            var doge = $("#xbot").val()
            var trx = $("#trx").val()
            var btt = $("#btt").val()
            $.ajax({
                type:'post',
                url:'./afiliator/update_wallet',
                data:'xbot='+xbot+'doge='+doge+'trx='+trx+'btt='+btt,
                success:()=>{
                    if (html.success == true) {
                      toastr.success(html.message)
                      window.location.href="./afiliator"
                    }else{
                      toastr.error(html.message)
                    }
                }
            })
        })
    </script>
  </body>
</html>