<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login</title>
   <link rel="icon" type="image/png" href="<?=base_url().'assets/'?>img/icon.png">

  <!-- Custom fonts for this template-->
  <link href="<?=base_url().'assets/'?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?=base_url().'assets/'?>css/sb-admin-2.min.css" rel="stylesheet">
  <link href="<?=base_url().'assets/'?>css/sb-admin-2.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary" style="background: #15406a">

  <div class="container" style="width:50%">

    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-xl-5 col-lg-5 col-md-5">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <img src="<?=base_url().'assets/'?>img/logo.png" class="rounded mx-auto d-block mb-4" style="width: 50%">
                    <h1 class="h3 text-gray-900 mb-4">Login SIM</h1>
                    <h6><font color="red"><?=isset($_SESSION['pesan'])? $_SESSION['pesan'] : '';?></font></h6>
                    <!-- <?=password_hash('123qweasdzxc', PASSWORD_DEFAULT)?> -->
                    <hr class=" mb-4" style="width: 100%">
                  </div>
                  <form method="post" class="user" action="<?=base_url().'login'?>" autocomplete="off">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" style="display: none">
                    <div class="form-group">
                      <input class="rounded form-control form-control-user" name="username" id="username" aria-describedby="username" placeholder="Masukan Username">
                    </div>
                    <div class="form-group">
                      <input type="password" class="rounded form-control form-control-user" name="password" id="password" placeholder="Masukan Password">
                    </div>
                    <div class="form-group">
                      <button type="submit" class="rounded btn btn-primary btn-user btn-block" id="submit" name="submit" value="1">Masuk</button>
                    </div>
                    <a href="<?=base_url('lupa_password')?>">Lupa Password?</a>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?=base_url().'assets/'?>vendor/jquery/jquery.min.js"></script>
  <script src="<?=base_url().'assets/'?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?=base_url().'assets/'?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?=base_url().'assets/'?>js/sb-admin-2.min.js"></script>

</body>

</html>
