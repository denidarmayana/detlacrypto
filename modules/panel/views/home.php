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
                                <a href="#home" class="nav-link active" data-bs-toggle="tab">Sumary</a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile" class="nav-link" data-bs-toggle="tab">Members</a>
                            </li>
                            <li class="nav-item">
                                <a href="#messages" class="nav-link" data-bs-toggle="tab">withdrawl</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="home">
                                <table width="100%" class="mt-1">
                                    <tr>
                                        <td width="50%" valign="top">
                                            <div class="card p-0">
                                                <div class="card-body p-2 m-0">
                                                    <p class="m-0 mb-2 text-center">Jumlah Members</p>
                                                    <table width="100%" class="data-panel">
                                                        <tr>
                                                            <td>Total</td><td class="text-end"><?=$all_members ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Hari ini</td><td class="text-end"><?=$day_members ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                        <td width="50%">
                                            <div class="card p-0">
                                                <div class="card-body p-2">
                                                    <p class="m-0 mb-3 text-center">Deposit Members</p>
                                                    <table width="100%" class="data-panel">
                                                        <tr>
                                                            <td colspan="2" class="text-center">Hari Ini</td>
                                                        </tr>
                                                        <tr>
                                                            <td>XBOT</td><td class="text-end"><?=$all_members ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>DOGE</td><td class="text-end"><?=$day_members ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>TRX</td><td class="text-end"><?=$day_members ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>BTT</td><td class="text-end"><?=$day_members ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" class="text-center">Sampai Hari Ini</td>
                                                        </tr>
                                                        <tr>
                                                            <td>XBOT</td><td class="text-end"><?=$all_members ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>DOGE</td><td class="text-end"><?=$day_members ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>TRX</td><td class="text-end"><?=$day_members ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>BTT</td><td class="text-end"><?=$day_members ?></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="profile">
                                <h4 class="mt-2">Profile tab content</h4>
                                <p>Vestibulum nec erat eu nulla rhoncus fringilla ut non neque. Vivamus nibh urna, ornare id gravida ut, mollis a magna. Aliquam porttitor condimentum nisi, eu viverra ipsum porta ut. Nam hendrerit bibendum turpis, sed molestie mi fermentum id. Aenean volutpat velit sem. Sed consequat ante in rutrum convallis. Nunc facilisis leo at faucibus adipiscing.</p>
                            </div>
                            <div class="tab-pane fade" id="messages">
                                <h4 class="mt-2">Messages tab content</h4>
                                <p>Donec vel placerat quam, ut euismod risus. Sed a mi suscipit, elementum sem a, hendrerit velit. Donec at erat magna. Sed dignissim orci nec eleifend egestas. Donec eget mi consequat massa vestibulum laoreet. Mauris et ultrices nulla, malesuada volutpat ante. Fusce ut orci lorem. Donec molestie libero in tempus imperdiet. Cum sociis natoque penatibus et magnis.</p>
                            </div>
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