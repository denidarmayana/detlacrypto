<!doctype html>
<html lang="en" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crypto Trading Bot</title>
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
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="nav-item">
                                <a href="#home" class="nav-link active" data-bs-toggle="tab">Home</a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile" class="nav-link" data-bs-toggle="tab">Users</a>
                            </li>
                            <li class="nav-item">
                                <a href="#messages" class="nav-link" data-bs-toggle="tab">Withdrawl</a>
                            </li>
                            <li class="nav-item">
                                <a href="#sharing" class="nav-link" data-bs-toggle="tab">Share</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="home">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card p-0 mt-1 mb-2">
                                            <div class="card-body m-0 p-2">
                                                <h6 class="card-title fw-600 text-center m-0 mb-1">Deposit Hari Ini</h6>
                                                <table width="100%" cellpadding="5">

                                                    <tr>
                                                        <td width="10%"><img src="https://indodax.com/v2/logo//png/color/trx.png" width="25"> </td>
                                                        <td valign="middle" width="60%"><h6 class="m-0">TRON</h6></td>
                                                        <td valign="middle" width="20%"><?=$this->app->getDepositToday("TRX") ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="10%"><img src="https://indodax.com/v2/logo//png/color/doge.png" width="25"> </td>
                                                        <td valign="middle" width="60%"><h6 class="m-0">DOGE</h6></td>
                                                        <td valign="middle" width="20%"><?=$this->app->getDepositToday("DOGE") ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card p-0 mt-1 mb-2">
                                            <div class="card-body m-0 p-2">
                                                <h6 class="card-title fw-600 text-center m-0 mb-1">All Deposit</h6>

                                                <table width="100%" cellpadding="5">
                                                    <tr>
                                                        <td width="10%"><img src="https://indodax.com/v2/logo//png/color/trx.png" width="25"> </td>
                                                        <td valign="middle" width="60%"><h6 class="m-0">TRON</h6></td>
                                                        <td valign="middle" width="20%"><?=$this->app->getDepositAll("TRX") ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="10%"><img src="https://indodax.com/v2/logo//png/color/doge.png" width="25"> </td>
                                                        <td valign="middle" width="60%"><h6 class="m-0">DOGE</h6></td>
                                                        <td valign="middle" width="20%"><?=$this->app->getDepositAll("TRX") ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card p-0 mt-1 mb-2">
                                            <div class="card-body m-0 p-2">
                                                <h6 class="card-title fw-600 m-0 mb-1">Members Hari Ini <span class="text-warning float-end"><?=$day_members ?></span> </h6>
                                                <table width="100%" class="data-panel">
                                                    <tr>
                                                        <td>Username</td>
                                                        <td>Email</td>
                                                    </tr>
                                                    <tbody>
                                                        <?php foreach ($day_members_result as $dm) { ?>
                                                        <tr>
                                                            <td><?=$dm->username ?></td>
                                                            <td><?=$dm->email ?></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card p-0 mt-1 mb-2">
                                            <div class="card-body m-0 p-2 table-responsive">
                                                <h6 class="card-title fw-600 m-0 mb-1">Members <span class="float-end text-success"><?=$count_members ?></span> </h6>
                                                <table width="100%" class="data-panel">
                                                    <tr>
                                                        <td>Username</td>
                                                        <td>XBOT</td>
                                                        <td>TRX</td>
                                                        <td>DOGE</td>
                                                    </tr>
                                                    <tbody>
                                                        <?php foreach ($all_members as $am) { 
                                                            $saldo_xbot = $this->app->setSado($am->username,"XBOT");
                                                            $saldo_trx = $this->app->setSado($am->username,"TRX");
                                                            $saldo_doge = $this->app->setSado($am->username,"DOGE");
                                                        ?>
                                                        <tr>
                                                            <td><?=$am->username ?></td>
                                                            <td><?=number_format($saldo_xbot,8) ?></td>
                                                            <td><?=number_format($saldo_trx,8) ?></td>
                                                            <td><?=number_format($saldo_doge,8) ?></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="messages">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card p-0 mt-1 mb-2">
                                            <div class="card-body m-0 p-2 table-responsive">
                                                <h6 class="card-title fw-600 m-0 mb-1">Withdrawl </h6>
                                                <table width="100%" class="data-panel">
                                                    <tr>
                                                        <td>Username</td>
                                                        <td>Coin</td>
                                                        <td>Address</td>
                                                        <td>Amount</td>
                                                        <td>Status</td>
                                                    </tr>
                                                    <tbody>
                                                        <?php foreach ($withdrawl as $wd) {  
                                                            if ($wd->status == 0) {
                                                                $status = "<button class='btn btn-info btn-sm'>Approve</button>";
                                                            }else{
                                                                $status = "Done";
                                                            }
                                                        ?>
                                                        <tr>
                                                            <td><?=$wd->members ?></td>
                                                            <td><?=$wd->coin ?></td>
                                                            <td><?=$wd->address ?></td>
                                                            <td><?=$wd->amount ?></td>
                                                            <td><?=$status ?></td>
                                                        </tr>
                                                    </tbody>
                                                    <?php } ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- TABcONTENT -->
                            <div class="tab-pane fade" id="sharing">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card p-0 mt-1 mb-2">
                                            <div class="card-body m-0 p-2 table-responsive">
                                                <h7 class="card-title fw-600 m-0 mb-1">SharingAfiliator </h7>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- TABcONTENT -->
                        </div>
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