<!DOCTYPE html>
<html class="no-js">
<head>
    <?php
        $privacy = $terms = $about_us = $disclaimer =  "";
        $data = $this->uri->segment('2');
        
        switch($data){
            case 'privacy':
                $privacy = "active";
            break;

            case 'terms' :
                $terms = "active";
            break;

            case 'about_us':
                $about_us = "active";
            break;

            case 'disclaimer':
                $disclaimer = "active";
            break;
        }  
    ?>
    <link rel="icon" href="<?php echo base_url().ADMIN_THEME.'images/logo/icon_20.png';?>"  type="image/png" sizes="16x16">
    <title>Live Wire | <?php echo !empty($title) ? $title : '' ; ?></title>
    <meta name="google-site-verification" content="AIzaSyAPa2BHnKkDi7bDv1uzrSY7li677k3qidI"/>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <!--link files-->
    <?php  $frontend_asset= base_url(); ?>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800" rel="stylesheet">

    <link href="<?php echo $frontend_asset.LV_ASSETS_CSS;?>bootstrap.min.css" rel="stylesheet" type="text/css">

    <link href="<?php echo $frontend_asset.LV_ASSETS_CSS;?>bootstrap-theme.min.css" 
      rel="stylesheet" type="text/css">

    <link href="<?php echo $frontend_asset.LV_ASSETS_CSS;?>bootstrap-datetimepicker.min.css" 
      rel="stylesheet" type="text/css">

    <link href="<?php echo $frontend_asset.LV_ASSETS_CSS;?>font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="<?php echo $frontend_asset.LV_ASSETS_CSS;?>owl.carousel.min.css" rel="stylesheet" type="text/css">

    <link href="<?php echo $frontend_asset.LV_ASSETS_CSS;?>owl.theme.default.min.css" rel="stylesheet" type="text/css">

    <link href="<?php echo $frontend_asset.LV_ASSETS_CSS;?>animate.css" rel="stylesheet" type="text/css">
    <?php if(!empty($front_styles)) { load_css($front_styles); } //load required page styles ?>  
    <!-- <link href="<?php echo $frontend_asset.LV_ASSETS_CSS;?>semantic.min.css" rel="stylesheet" type="text/css"> -->

    <link href="<?php echo $frontend_asset.LV_ASSETS_CSS;?>style.css" rel="stylesheet" type="text/css">

    <link href="<?php echo $frontend_asset.LV_ASSETS_CSS;?>mystyle.css" rel="stylesheet" type="text/css">

    <link href="<?php echo $frontend_asset.LV_ASSETS_CSS;?>responsive.css" rel="stylesheet" type="text/css">

    <link href="<?php echo $frontend_asset.LV_TOASTR;?>toastr.min.css" rel="stylesheet" type="text/css">

    <link href="<?php echo $frontend_asset.LV_CUSTOM_CSS;?>front_common.css" rel="stylesheet" type="text/css"> 
    <script src="<?php echo $frontend_asset.LV_ASSETS_JS;?>jquery-3.3.1.min.js"></script>
    <!-- for gmail login -->
    <script src="https://apis.google.com/js/api:client.js"></script>
</head>
<body>
<div class="wrapper">
<header class="headerSec">
    <nav class="navbar navbar-default mainHeader navbar-fixed-top">
        <div class="innerHeader">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo base_url(); ?>"><img src="<?php echo $frontend_asset.LV_ASSETS_IMG;?>logo1.png" rel="stylesheet" type="text/css""></a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right mainMenu">

                        <li ><a href="<?php echo base_url(''); ?>">Home</a></li>

                        <li><a href="<?php echo base_url(); ?>home/about_us" target="_blank">About Us</a></li>

                        <li><a href="<?php echo base_url(); ?>home#download-app">Download App</a></li>

                        <li ><a href="<?php echo base_url(); ?>home/faq">FAQ</a></li>

                        <li><a href="javascript:void(0)">Contact Us</a></li>

                        <li ><a href="<?php echo base_url(); ?>auth/selectUserType">Sign Up</a></li>    

                    </ul>
                </div>
            </div>
        </div>  
    </nav>
</header>

<style type="text/css">
    .csWrapper {
    min-height: calc(100vh - 159px);
}
</style>

<style type="text/css">
.nav.navbar-nav.navbar-right.mainMenu li h4.nav-TxT{
    font-size: 16px;
    padding: 20px 0px;
    margin: 0;
    color: #fff;
}
</style>