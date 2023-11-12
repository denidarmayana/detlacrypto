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
                                <td class="text-center">5</td>
                                <td class="text-center">5</td>
                            </tr>
                        </table>
                        <p class="mb-1 mt-3">Balance Member <span class="float-end"><?=$this->app->tgl() ?></span></p>
                        <table width="100%" class="data-balance mb-2">
                            <tr>
                                <th class="text-center bg-primary">Coin</th>
                                <th class="text-center bg-success">Deposit</th>
                                <th class="text-center bg-danger">Member Los</th>
                            </tr>
                            <tr>
                                <td class=" text-primary">XBOT</td>
                                <td class="text-center"><?=$this->app->getDeposit("XBOT") ?></td>
                                <td class="text-center"><?=$this->app->getMinus("XBOT") ?></td>
                            </tr>
                            <tr>
                                <td class=" text-primary">DOGE</td>
                                <td class="text-center"><?=$this->app->getDeposit("DOGE") ?></td>
                                <td class="text-center"><?=$this->app->getMinus("DOGE") ?></td>
                            </tr>
                            <tr>
                                <td class=" text-primary">TRX</td>
                                <td class="text-center"><?=$this->app->getDeposit("TRX") ?></td>
                                <td class="text-center"><?=$this->app->getMinus("TRX") ?></td>
                            </tr>
                            <tr>
                                <td class=" text-primary">BTT</td>
                                <td class="text-center"><?=$this->app->getDeposit("BTT") ?></td>
                                <td class="text-center"><?=$this->app->getMinus("BTT") ?></td>
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
                            <tr>
                                <td class=" text-primary">DOGE</td>
                                <td class="text-center"><?=(floatval($this->app->getMinus("DOGE"))*40)/100  ?></td>
                            </tr>
                            <tr>
                                <td class=" text-primary">TRX</td>
                                <td class="text-center"><?=(floatval($this->app->getMinus("TRX"))*40)/100  ?></td>
                            </tr>
                            <tr>
                                <td class=" text-primary">BTT</td>
                                <td class="text-center"><?=(floatval($this->app->getMinus("BTT"))*40)/100  ?></td>
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
    <script type="text/javascript" src="<?=base_url('template/main.js?='.time()) ?>"></script>
  </body>
</html>