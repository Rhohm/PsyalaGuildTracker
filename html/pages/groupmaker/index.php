<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Psyala Guild Tracker - Group Maker</title>  
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
        <script type="text/javascript" src="/js/typeahead.min.js"></script>
    </head>
    <body>
        <!-- Start Header -->
        <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/html/layout/header.php"; ?>
        <!-- End Header -->
        <!-- Start Page Content -->
        <div id="page-content" class="container-fluid">
            <div class="container">
                <div class="row">
                    <form class="form-inline navigation-form display-form">
                        <?php
                        if (empty($_GET["region"])) {
                            $region = $config["region"];
                        } else {
                            $region = $_GET["region"];
                        }
                        if (empty($_GET["guildName"])) {
                            $guildName = $config["guild"];
                        } else {
                            $guildName = $_GET["guildName"];
                        }
                        if (empty($_GET["realmName"])) {
                            $realmName = $config["realm"];
                        } else {
                            $realmName = $_GET["realmName"];
                        }
                        if (empty($_GET["c1"])) {
                            if (empty($_SESSION["c1"])) {
                                $c1 = "Psyala";
                            } else {
                                $c1 = $_SESSION["c1"];
                            }
                        } else {
                            $c1 = $_GET["c1"];
                        }
                        if (empty($_GET["c2"])) {
                            if (empty($_SESSION["c2"])) {
                                $c2 = "Twéekz";
                            } else {
                                $c2 = $_SESSION["c2"];
                            }
                        } else {
                            $c2 = $_GET["c2"];
                        }
                        if (empty($_GET["c3"])) {
                            if (empty($_SESSION["c3"])) {
                                $c3 = "Hydrazis";
                            } else {
                                $c3 = $_SESSION["c3"];
                            }
                        } else {
                            $c3 = $_GET["c3"];
                        }
                        if (empty($_GET["c4"])) {
                            if (empty($_SESSION["c4"])) {
                                $c4 = "Hydraxo";
                            } else {
                                $c4 = $_SESSION["c4"];
                            }
                        } else {
                            $c4 = $_GET["c4"];
                        }
                        if (empty($_GET["c5"])) {
                            if (empty($_SESSION["c5"])) {
                                $c5 = "Psyra";
                            } else {
                                $c5 = $_SESSION["c5"];
                            }
                        } else {
                            $c5 = $_GET["c5"];
                        }
                        $_SESSION["c1"] = $c1;
                        $_SESSION["c2"] = $c2;
                        $_SESSION["c3"] = $c3;
                        $_SESSION["c4"] = $c4;
                        $_SESSION["c5"] = $c5;
                        ?>
                        <div class="input-group">
                            <div class="input-group-addon">1</div>
                            <input name="c1" id="c1" type="text" class="form-control" value="<?php echo $c1 ?>" autocomplete="off"/>
                        </div>
                        <div class="input-group">
                            <div class="input-group-addon">2</div>
                            <input name="c2" id="c2" type="text" class="form-control" value="<?php echo $c2 ?>" autocomplete="off"/>
                        </div>
                        <div class="input-group">
                            <div class="input-group-addon">3</div>
                            <input name="c3" id="c3" type="text" class="form-control" value="<?php echo $c3 ?>" autocomplete="off"/>
                        </div>
                        <div class="input-group">
                            <div class="input-group-addon">4</div>
                            <input name="c4" id="c4" type="text" class="form-control" value="<?php echo $c4 ?>" autocomplete="off"/>
                        </div>
                        <div class="input-group">
                            <div class="input-group-addon">5</div>
                            <input name="c5" id="c5" type="text" class="form-control" value="<?php echo $c5 ?>" autocomplete="off"/>
                        </div>
                        <input id="submit" type="submit" class="btn btn-primary" value="Submit"/>
                    </form>
                </div>
                <div id="first-row" class="row">
                    <div class="col-xs-12 text-center h1">Group Maker</div>
                </div>
                <div class="row">
                    <div class="col-xs-6 text-right h4 data-message">
                        If character data doesn't load: 
                    </div>
                    <div class="col-xs-6 text-left">
                        <button class="btn btn-default data-button" onclick="main()">Reload Data</button>
                    </div>
                </div>
                <div class="row">
                    <table class="table table-condensed table-bordered character-table">
                        <thead>
                            <tr>
                                <th class="character-name">Character</th>
                                <th class="character-role">Class</th>
                                <th class="character-role">Spec</th>
                                <th class="character-role">Role</th>
                                <th class="character-level">Level</th>
                                <th class="character-item-level" title="Average Item Level">Item Level</th>
                                <th class="character-artifact-level">Artifact Level</th>
                                <th>Last Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--End Page Content -->
        <script>
            var loader = $(".loader");
            $(document).ready(function () {
                var dataSet = [];
                var region = <?php echo "\"" . $region . "\"" ?>;
                var realm = <?php echo "\"" . $realmName . "\"" ?>;
                var guild = <?php echo "\"" . $guildName . "\"" ?>;
                var requestURL = "https://" + region + ".api.battle.net/wow/guild/" + realm + "/" + guild + "?fields=members&locale=en_GB&apikey=bjahzm89djw4wd4r6n8hnutmb6ygw4gn";
                $.get(requestURL, function (data) {
                    for (var i = 0; i < data.members.length; i++) {
                        var level = data.members[i].character.level;
                        var name = data.members[i].character.name;
                        if (level >= 110) {
                            dataSet.push(name);
                        }
                    }
                    $("#c1").typeahead({source: dataSet, items: 10});
                    $("#c2").typeahead({source: dataSet, items: 10});
                    $("#c3").typeahead({source: dataSet, items: 10});
                    $("#c4").typeahead({source: dataSet, items: 10});
                    $("#c5").typeahead({source: dataSet, items: 10});
                });
                main();
            });

            function convertTime(timestamp) {
                var a = new Date(timestamp);
                var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                var year = a.getFullYear();
                var month = months[a.getMonth()];
                var date = a.getDate();
                var hour = convertNo(a.getHours());
                var min = convertNo(a.getMinutes());
                var sec = convertNo(a.getSeconds());
                var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec;
                return time;
            }

            function convertNo(number) {
                if (number < 10) {
                    return "0" + number;
                } else {
                    return number;
                }
            }

            function getAllCharacterDetails(name) {
                var ilvlRequest = "https://<?php echo $region ?>.api.battle.net/wow/character/<?php echo $realmName ?>/" + encodeURI(name) + "?fields=items,talents&locale=en_GB&apikey=bjahzm89djw4wd4r6n8hnutmb6ygw4gn";
                try {
                    $.getJSON(ilvlRequest, function (data) {
                        var cclass = data.class;
                        var level = data.level;
                        var ilvl = data.items.averageItemLevel;
                        var aLevel = 0;
                        var specName = data.talents[0].spec.name;
                        var role = data.talents[0].spec.role;
                        if (specName == "Protection") {
                            if (data.items.offHand.artifactTraits !== undefined) {
                                for (var i = 0; i < data.items.offHand.artifactTraits.length; i++) {
                                    aLevel = aLevel + data.items.offHand.artifactTraits[i].rank;
                                }
                            }
                        } else {
                            if (data.items.mainHand.artifactTraits !== undefined) {
                                for (var i = 0; i < data.items.mainHand.artifactTraits.length; i++) {
                                    aLevel = aLevel + data.items.mainHand.artifactTraits[i].rank;
                                }
                            }
                        }
                        if (cclass == "1") {
                            cclass = "Warrior";
                        } else if (cclass == "2") {
                            cclass = "Paladin";
                        } else if (cclass == "3") {
                            cclass = "Hunter";
                        } else if (cclass == "4") {
                            cclass = "Rogue";
                        } else if (cclass == "5") {
                            cclass = "Priest";
                        } else if (cclass == "6") {
                            cclass = "Death Knight";
                        } else if (cclass == "7") {
                            cclass = "Shaman";
                        } else if (cclass == "8") {
                            cclass = "Mage";
                        } else if (cclass == "9") {
                            cclass = "Warlock";
                        } else if (cclass == "10") {
                            cclass = "Monk";
                        } else if (cclass == "11") {
                            cclass = "Druid";
                        } else if (cclass == "12") {
                            cclass = "Demon Hunter";
                        }
                        var lastModified = convertTime(data.lastModified);
                        var characterData = name + "," + cclass + "," + specName + "," + role + "," + level + "," + ilvl + "," + aLevel + "," + lastModified;
                        sessionStorage.removeItem(name + "-g");
                        sessionStorage.setItem(name + "-g", characterData);
                    });
                } catch (ex) {

                }
            }

            function main() {
                loader.show();
                var dataSet = [];
                var characters = ["<?php echo $c1 ?>", "<?php echo $c2 ?>", "<?php echo $c3 ?>", "<?php echo $c4 ?>", "<?php echo $c5 ?>"];
                for (var i = 0; i < characters.length; i++) {
                    getAllCharacterDetails(characters[i]);
                    var characterData = ["", "", "", "", "", "", "", ""];
                    characterData[0] = characters[i];
                    try {
                        var temp = sessionStorage.getItem(characters[i] + "-g").split(",");
                        characterData[1] = temp[1];
                        characterData[2] = temp[2];
                        characterData[3] = temp[3];
                        characterData[4] = temp[4];
                        characterData[5] = temp[5];
                        characterData[6] = temp[6];
                        characterData[7] = temp[7];
                    } catch (ex) {
                    }
                    dataSet.push(characterData);
                }

                var columnsDef = [{
                        "render": function (data, type, row, meta) {
                            return '<a target="_blank" href="http://<?php echo $region ?>.battle.net/wow/en/character/<?php echo $realmName ?>/' + data + '/simple"" class="link" title="Armoury Link">' + data + '</a>';
                        }
                    },
                    {
                        "render": function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        "render": function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        "render": function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        "render": function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        "render": function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        "render": function (data, type, row, meta) {
                            return data;
                        }
                    },
                    {
                        "render": function (data, type, row, meta) {
                            return data;
                        }
                    }
                ];
                
                loader.hide();

                $(".character-table").DataTable({
                    "lengthMenu": [[-1], ["All"]],
                    data: dataSet,
                    "columns": columnsDef,
                    destroy: true
                });

            }
            ;
        </script>
    </body>
</html>
