<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Brebes Education Fair 2018</title>

  <link rel="shortcut icon" type="image/icon" href="<?= base_url();?>/assets/images/favicon.ico"/>
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?= base_url();?>/assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url();?>/assets/css/slick.css" rel="stylesheet">
  <link id="switcher" href="<?= base_url();?>/assets/css/theme-color/lite-blue-theme.css" rel="stylesheet">
  <link href="<?= base_url();?>/assets/css/style.css" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700,800" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body style="background-color: rgba(55,198,245,1)">
<!-- Start main content -->
<main role="main">
  <!-- Start Register  -->
  <section id="mu-register">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="mu-register-area">
            <div class="mu-title-area">
              <h2 class="mu-title">Panitia <a href="<?= site_url(); ?>">BEF 2018</a></h2>
            </div>

            <div class="mu-register-content">
              <form class="mu-register-form" action="" method="post">
                
                <?= $message; ?>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">                
                      <input type="text" class="form-control" placeholder="Username" name="username" required autofocus>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">                
                      <input type="password" class="form-control" placeholder="Password" name="password" required>
                    </div>     
                  </div>
                </div>

                <input type="submit" class="mu-reg-submit-btn" name="masuk" value="MASUK">
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Register -->
</main>
<!-- End main content --> 

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<!-- Bootstrap -->
<script src="<?= base_url();?>/assets/js/bootstrap.min.js"></script>
<!-- Slick slider -->
<script type="text/javascript" src="<?= base_url();?>/assets/js/slick.min.js"></script>
<!-- Event Counter -->
<script type="text/javascript" src="<?= base_url();?>/assets/js/jquery.countdown.min.js"></script>
<!-- Ajax contact form  -->
<!-- <script type="text/javascript" src="<?= base_url();?>/assets/js/app.js"></script> -->
<!-- Custom js -->
<script type="text/javascript" src="<?= base_url();?>/assets/js/custom.js"></script>
</body>
</html>