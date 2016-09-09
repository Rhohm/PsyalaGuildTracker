<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Psyala Guild Tracker - Feedback</title>  
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
        <link rel="icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="/js/bootstrap/dist/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="/css/wow_api.css"/>
        <script type="text/javascript" src="/js/jquery.min.js"></script>
        <script type="text/javascript" src="/js/bootstrap/dist/js/bootstrap.min.js"></script>
    </head>
    <body>
        <!-- Start Header -->
        <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/html/layout/header.php"; ?>
        <!-- End Header -->
        <!-- Start Page Content -->
        <div id="page-content" class="container-fluid">
            <div class="container">
                <div class="row">

                </div>
                <div id="first-row" class="row">
                    <div class="col-xs-12 text-center h1">Feedback</div>
                </div>
                <div class="row">
                    <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSeUN33unXzPHjblsnNf5gl2_SXkMexb1_LkZK4-TEVXxzSRCQ/viewform?embedded=true" width="760" height="500" frameborder="0" marginheight="0" marginwidth="0">Loading...</iframe>
                </div>
            </div>
        </div>
        <!--End Page Content -->
    </body>
</html>
