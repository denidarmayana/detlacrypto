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
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4 col-9">
                <div class="card card-login">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Sign Up</h5>
                        <form method="post" action="" id="login">
                          <div class="mb-3">
                                <div class="input-group mb-3">
                                  <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i>  </span>
                                  <input type="text" class="form-control" placeholder="Username" id="username" required >
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group mb-3">
                                  <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-envelope-open-text"></i>  </span>
                                  <input type="email" class="form-control" placeholder="Email" id="email" required >
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group mb-3">
                                  <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user-lock"></i>  </span>
                                  <input type="password" class="form-control" id="password" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group mb-3">
                                  <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-user"></i>  </span>
                                  <input type="text" class="form-control" placeholder="Referral" id="reff" required >
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100" id="btn_login">Sign Up &nbsp;&nbsp;&nbsp;<i class="fa-solid fa-right-to-bracket"></i></button>
                            <button class="btn btn-warning w-100 hidden" id="loading" disabled>
                              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                            </button>
                        </form>
                        <p class="mb-0 mt-4">You have account ? <span class="float-end"><a href="<?=base_url('auth') ?>">Sign In</a></span> </p>
                    </div>
                </div>
                <p class="text-center mt-4 mb-0">Copyright &copy; <?=date("Y") ?> All Right Reserved</p>
                <p class="text-center mt-0 mb-0">Delta Crypto</p>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">  
      $("#login").submit(function() {
        var username = $("#username").val()
        var email = $("#email").val()
        var password = $("#password").val()
        var reff = $("#reff").val()
        $("#btn_login").hide()
        $("#loading").show()
        const socket = new WebSocket('wss://deltacrypto.biz.id:6969');
        socket.onopen = function (event) {
          console.log('Koneksi terbuka');
          socket.send(JSON.stringify({ method:"register", username:username,email:email, password:password }))
        };

        // Event saat menerima pesan
        socket.onmessage = function (event) {
          $("#username").val("")
          $("#email").val("")
          $("#reff").val("")
          $("#password").val("")
          $("#btn_login").show()
          $("#loading").hide()
          var json = JSON.parse(event.data)
          if (json.success == true) {
            toastr.success(json.message)
            $.ajax({
              type: "POST",
              url: "./auth/registration",
              data: "username=" + username+"&email="+email+"&password="+password+"&upline="+reff,
              success: function(html) {
                window.location.href="./"
              }
            });
          }else{
            toastr.error(json.message)
          }
        };
        return false
      })
    </script>
  </body>
</html>