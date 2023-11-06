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
                        <h6 class="card-title mb-4">Welcome <span class="text-warning float-end fw-600"><small><?=$this->session->userdata('email') ?></small></span> </h6>
                        <div class="area-trading">
                            <div class="row mb-2">
                                <div class="col-6">
                                    <p class="form-label text-center m-0">Base Trade</p>
                                    <input type="text" class="form-control" value="0.000001" id="base_trade">
                                </div>
                                <div class="col-6">
                                    <p class="form-label text-center m-0">Profite Global</p>
                                    <input type="text" class="form-control" value="0.00000000" id="if_profit_global">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <p class="form-label text-center m-0">Shoot</p>
                                    <input type="text" class="form-control" value="1.00000000" id="val_shoot">
                                </div>
                                <div class="col-6">
                                    <p class="form-label text-center m-0">Boom</p>
                                    <input type="text" class="form-control" value="10.00000000" id="val_boom">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <p class="form-label text-center m-0">Chance</p>
                                    <table width="100%">
                                        <tr>
                                            <td><input type="text" class="form-control" value="35" id="chance_min"></td>
                                            <td>&nbsp;-&nbsp;</td>
                                            <td><input type="text" class="form-control" value="45" id="chance_max"></td>
                                        </tr>
                                    </table>
                                    
                                    
                                </div>
                                <div class="col-6">
                                    <p class="form-label text-center m-0">Profite Session</p>
                                    <input type="text" class="form-control" value="1.00000000" id="profite_session">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <p class="form-label text-center m-0">Marti Win (%)</p>
                                    <input type="text" class="form-control" value="100" id="marti_win">
                                </div>
                                <div class="col-6">
                                    <p class="form-label text-center m-0">Marti Los (%)</p>
                                    <input type="text" class="form-control" value="100" id="marti_los">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <p class="form-label text-center m-0">If Win Reset</p>
                                    <input type="text" class="form-control" value="1" id="if_win_reset">
                                </div>
                                <div class="col-6">
                                    <p class="form-label text-center m-0">If Los Reset</p>
                                    <input type="text" class="form-control" value="0" id="if_los_reset">
                                </div>
                            </div>
                            <!-- row -->
                            <table width="100%" class="data-balance">
                                <tr>
                                    <th class="text-center">Balance</th>
                                    <th class="text-center">Win</th>
                                    <th class="text-center">Los</th>
                                    <th class="text-center">Roll</th>
                                    <th class="text-center">Profite Global</th>
                                </tr>
                                <tr>
                                    <td class="text-center bg-primary">0.00000000</td>
                                    <td class="text-center bg-success">0</td>
                                    <td class="text-center bg-danger">0</td>
                                    <td class="text-center bg-info">0</td>
                                    <td class="text-center bg-secondary">0.00000000</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
  </body>
</html>