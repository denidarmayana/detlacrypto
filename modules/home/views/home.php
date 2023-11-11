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
                        <table width="100%" class="mb-2" cellpadding="4">
                            <tr>
                                <td valign="middle"><small>Bonus Reff</small></td>
                                <td><input type="text" readonly class="form-control"  id="Bonus_reff"></td>
                                <td><button class="btn btn-success btn-sm w-100" id="claim">Claim</button></td>
                            </tr>
                            <tr>
                               <td colspan="3"><input type="text" value="<?=base_url('reff/'.$this->session->userdata("username")) ?>" readonly class="form-control card-reff" id="link_reff"></td> 
                            </tr>
                        </table>
                        <input type="hidden" id="username" value="<?=$this->session->userdata('username') ?>">
                        <input type="hidden" id="socket" value="<?=$this->session->userdata('socket') ?>">
                        <input type="hidden" id="token" value="<?=$this->session->userdata('token') ?>">
                        <input type="hidden" id="hide_base">
                        <div class="area-trading">
                            <div class="row mb-2">
                                <div class="col-6">
                                    <p class="form-label text-center m-0">Delay (ms)</p>
                                    <input type="text" class="form-control" value="500" id="delay">
                                </div>
                                <div class="col-6">
                                    <p class="form-label text-center m-0">Coin</p>
                                    <select class="form-control" id="coin">
                                        <option value="0">Select Coin</option>
                                        <option>BITBOT</option>
                                        <option>TRX</option>
                                        <option>DOGE</option>
                                    </select>
                                </div>
                            </div>
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
                            <table width="100%" class="data-balance mb-2">
                                <tr>
                                    <th class="text-center">Balance</th>
                                    <th class="text-center">Win</th>
                                    <th class="text-center">Los</th>
                                    <th class="text-center">Roll</th>
                                    <th class="text-center">Profite Global</th>
                                </tr>
                                <tr>
                                    <td class="text-center bg-primary" id="balance">0.00000000</td>
                                    <td class="text-center bg-success" id="win">0</td>
                                    <td class="text-center bg-danger" id="los">0</td>
                                    <td class="text-center" id="roll">0</td>
                                    <td class="text-center bg-secondary" id="profite_global">0.00000000</td>
                                </tr>
                            </table>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <button class="btn btn-success w-100" id="start">Start</button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-info w-100" id="stop_on_win">Stop on Win</button>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4">
                                    <button class="btn btn-warning w-100" id="shoot">Shoot</button>
                                </div>
                                <div class="col-4">
                                    <button class="btn btn-secondary w-100" id="reset">Reset</button>
                                </div>
                                <div class="col-4">
                                    <button class="btn btn-danger w-100" id="boom">Boom</button>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#exampleModal">Deposit</button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#exampleModal2">Withdrawl</button>
                                </div>
                            </div>
                            <div class="area-tabel-trading">
                                <table width="100%" class="data-balance">
                                    <tr>
                                        <th>TYPE</th>
                                        <th>BASE</th>
                                        <th>PROFITE</th>
                                    </tr>
                                    <tbody id="table_trading">
                                        
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Deposit <span id="coin_name"></span></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="text" class="form-control mb-3" id="address">
            <center>
                <img src="" id="qrcode" class="img-thumbnail">    
            </center>
            
          </div>
        </div>
      </div>
    </div>
     <!-- Modal -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Withdrawl TRX</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="text" placeholder="Address Wallet TRX" class="form-control mb-3">
            <input type="text" placeholder="amount" class="form-control mb-4">
            <button class="btn btn-success w-100">Submit</button>
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