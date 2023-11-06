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
    <link href="<?=base_url('assets/css/style.css?='.time()) ?>" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-10 col-12">
                <div class="card card-login">
                    <div class="card-body">
                       <h5>Welcome <span class="text-warning"><?=$this->session->userdata('username') ?></span> <button class="btn btn-primary btn-sm float-end" id="refresh">REFRESH</button> </h5>
                       <input type="text" disabled class="link_reff" value="<?=base_url('reff/'.$this->session->userdata('username')) ?>">
                       <table class="mt-3" width="100%" cellpadding="3">
                           <tr>
                               <td width="50%">
                                   <p class="m-0 text-center">Base Trade</p>
                                   <input type="text" id="base_trade" value="0.000001" class="form-control">
                               </td>
                               <td>
                                   <p class="m-0 text-center">if Profit Global</p>
                                   <input type="text" id="if_profit_global" value="0" class="form-control">
                               </td>
                           </tr>
                           <tr>
                               <td>
                                   <p class="m-0 text-center">Chance</p>
                                   <table width="100%">
                                       <tr>
                                           <td>
                                               <input type="text" id="chance_min" value="35" class="form-control">
                                           </td>
                                           <td class="text-center">
                                               &nbsp;&nbsp;-&nbsp;&nbsp;
                                           </td>
                                           <td>
                                               <input type="text" id="chance_max" value="45" class="form-control">
                                           </td>
                                       </tr>
                                   </table>
                               </td>
                               <td>
                                   <p class="m-0 text-center">Profit Session</p>
                                   <input type="text" id="profit_session" value="0.1" class="form-control">
                               </td>
                           </tr>
                           <tr>
                               <td>
                                   <table width="100%">
                                       <tr>
                                           <td>
                                                <p class="m-0 fs-10 text-center">Mrt WIN (%)</p>
                                                <input type="text" id="marti_min" value="100" class="form-control">
                                           </td>
                                           <td>
                                                <p class="m-0 fs-10 text-center">Mrt LOS (%)</p>
                                               <input type="text" id="marti_los" value="100" class="form-control">
                                           </td>
                                       </tr>
                                   </table>
                               </td>
                               <td>
                                   <table width="100%">
                                       <tr>
                                           <td>
                                                <p class="m-0 fs-10 text-center">If WIN Reset</p>
                                                <input type="text" id="if_win_reset" value="1" class="form-control">
                                           </td>
                                           <td>
                                                <p class="m-0 fs-10 text-center">if LOS Reset</p>
                                               <input type="text" id="if_los_reset" value="0" class="form-control">
                                           </td>
                                       </tr>
                                   </table>
                               </td>
                           </tr>
                           <tr>
                               <td width="50%">
                                   <p class="m-0 fs-10 text-center">Boom</p>
                                   <input type="text" id="boom_val" value="1.00000000" class="form-control">
                               </td>
                               <td>
                                   <p class="m-0 fs-10 text-center">Shoot</p>
                                   <input type="text" id="shoot_val" value="10.00000000" class="form-control">
                               </td>
                           </tr>
                       </table>
                       <div class="row mt-2 mb-2">
                           <div class="col-4">
                               <button class="btn btn-success btn-sm w-100" id="start">START</button>
                               <button class="btn btn-danger btn-sm w-100 hidden" id="stop">STOP</button>
                           </div>
                           <div class="col-4">
                               <button class="btn btn-warning btn-sm w-100" id="shoot">SHOOT</button>
                           </div>
                           <div class="col-4">
                               <button class="btn btn-secondary btn-sm w-100" id="boom">BOOM</button>
                           </div>
                       </div>
                       <table width="100%" class="mt-3 data-balance">
                           <tr>
                               <td width="40%" class="text-center bg-info text-black">BALANCE</td>
                               <td width="10%" class="text-center bg-success">WIN</td>
                               <td width="10%" class="text-center bg-danger">LOS</td>
                               <td width="40%" class="text-center bg-warning text-black">PROFIT GLOBAL</td>
                           </tr>
                           <tr>
                               <td id="balance" class="text-center text-white fw-600">0.000000</td>
                               <td id="rol_win" class="text-center text-success fw-600">0</td>
                               <td id="rol_los" class="text-center text-danger fw-600">0</td>
                               <td id="profite_global" class="text-center text-warning fw-600">0.00000000</td>
                           </tr>
                       </table>
                       <div class="row mt-3">
                           <div class="col-6">
                               <button class="btn btn-info btn-sm w-100" id="show_deposi">DEPOSIT</button>
                               <div class="card hidden" id="card-deposit">
                                   <div class="card-header p-2">
                                        <table width="100%">
                                           <tr>
                                               <td width="90%" valign="middle"><p class="m-0 text-center">DEPOSIT</p></td>
                                               <td><p><button class="btn btn-danger btn-sm float-end" id="close-depo"><i class="fa-solid fa-circle-xmark"></i></button></p></td>
                                           </tr>
                                       </table>
                                   </div>
                                   <div class="card-body">
                                       <div class="row mb-3">
                                            <div class="col-12">
                                                <input type="text" class="form-control" id="addres_depo" disabled>
                                            </div>
                                       </div>
                                        <div class="row justify-content-center">
                                            <div class="col-12">
                                                <center>
                                                    <img class="img-responsive" id="img_depo">    
                                                </center>
                                                
                                            </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                           <div class="col-6">
                               <button class="btn btn-secondary btn-sm w-100" id="show_withdrawl">WITHDRAWL</button>
                               <div class="card hidden" id="card-wd">
                                   <div class="card-header p-2">
                                       <table width="100%">
                                           <tr>
                                               <td width="90%" valign="middle"><p class="m-0 text-center">WITHDRAWL</p></td>
                                               <td><p><button class="btn btn-danger btn-sm float-end" id="close-wd"><i class="fa-solid fa-circle-xmark"></i></button></p></td>
                                           </tr>
                                       </table>
                                   </div>
                                   <div class="card-body">
                                       <div class="row mb-3">
                                            <div class="col-12">
                                                <input type="text" class="form-control" placeholder="Address Wallet TRX">
                                            </div>
                                       </div>
                                       <div class="row mb-3">
                                            <div class="col-12">
                                                <input type="phone" class="form-control" placeholder="Ammount">
                                            </div>
                                       </div>
                                       <div class="row">
                                            <div class="col-12">
                                                <button class="btn btn-primary w-100">Submit</button>
                                            </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <table width="100%" class="mt-3 data-balance">
                           <tr>
                               <th class="bg-secondary">TYPE</th>
                               <th class="bg-secondary">BASE</th>
                               <th class="bg-secondary">PROFITE</th>
                           </tr>
                           <tr class="bg-success">
                               <td >HEIGHT</td>
                               <td >0.00000100</td>
                               <td >0.00000111</td>
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
    <script type="text/javascript">
        const socket = new WebSocket('ws://deltacrypto.biz.id:6969');
        socket.onopen = function (event) {
            console.log('Koneksi terbuka');
        };
        socket.onmessage = function (event) {
            var json = JSON.parse(event.data);
            console.log(event.data)
        }
        
    </script>
  </body>
</html>