<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Psyala Guild Tracker - Raw Character Details</title>  
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
        <link rel="icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="/js/bootstrap/dist/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="/css/wow_api.css"/>
        <link rel="stylesheet" type="text/css" href="/css/loader.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.12/fh-3.1.2/datatables.min.css"/>
        <script type="text/javascript" src="/js/jquery.min.js"></script>
        <script type="text/javascript" src="/js/bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.12/fh-3.1.2/datatables.min.js"></script>
    </head>
    <body>
        <!-- Start Header -->
        <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/html/layout/header.php"; ?>
        <!-- End Header -->
        <!-- Start Page Content -->
        <div id="page-content" class="container-fluid">
            <div class="container">
                <div class="row" id="top-row">
                    <?php
                    if (empty($_GET["region"])) {
                        $region = $config["region"];
                    } else {
                        $region = $_GET["region"];
                    }
                    if (empty($_GET["character"])) {
                        $character = $config["defaultCharacter"];
                    } else {
                        $character = $_GET["character"];
                    }
                    if (empty($_GET["realmName"])) {
                        $realmName = $config["realm"];
                    } else {
                        $realmName = $_GET["realmName"];
                    }
                    ?>
                    <form class="form-inline navigation-form display-form">
                        <div class="form-group">
                            <label for="region">Region:</label>
                            <input id="region" name="region" type="text" class="form-control" value="<?php echo $region ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="realm-name">Realm Name:</label>
                            <input id="realm-name" name="realmName" type="text" class="form-control" value="<?php echo $realmName ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="guild-name">Character:</label>
                            <input id="guild-name" name="character" type="text" class="form-control" value="<?php echo $character ?>"/>
                        </div>
                        <input id="submit" type="submit" class="btn btn-primary" value="Submit"/>
                    </form>
                </div>
                <div id="first-row" class="row">
                    <div class="col-xs-12 text-center h1">Raw Character Details</div>
                </div>
                <div class="row" id="json-area">

                </div>
            </div>
        </div>
        <!--End Page Content -->
        <script>
            var a;
            $(document).ready(function () {
                var url = "https://<?php echo $region ?>.api.battle.net/wow/character/<?php echo $realmName ?>/<?php echo $character ?>?fields=items&locale=en_GB&apikey=bjahzm89djw4wd4r6n8hnutmb6ygw4gn";
                try {
                    $.getJSON(url, function (data) {
                        a = data;
                        $("#json-area").append("<pre>" + JSON.stringify(data, null, 4) + "</pre>");
                    });
                } catch (ex) {
                }
            });
        </script>
    </body>
</html>
