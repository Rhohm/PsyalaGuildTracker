<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Psyala Guild Tracker - Member Detail</title>  
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
        <link rel="icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" type="text/css" href="/js/bootstrap/dist/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="/css/wow_api.css"/>
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
                <div class="row">
                    <form class="form-inline navigation-form">
                        <div class="form-group">
                            <label for="region">Region:</label>
                            <input id="region" name="region" type="text" class="form-control" value="<?php echo $region ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="realm-name">Realm Name:</label>
                            <input id="realm-name" name="realmName" type="text" class="form-control" value="<?php echo $realmName ?>"/>
                        </div>
                        <div class="form-group">
                            <label for="guild-name">Guild Name:</label>
                            <input id="guild-name" name="guildName" type="text" class="form-control" value="<?php echo $guildName ?>"/>
                        </div>
                        <input id="submit" type="submit" class="btn btn-primary" value="Submit"/>
                    </form>
                </div>
				<div id="first-row" class="row">
					<div class="col-xs-12 text-center h1">Member Details</div>
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
                                <th class="character-item-level" title="Average Equipped Item Level">Item Level</th>
                                <th class="character-artifact-level">Artifact Level</th>
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
            function getItemLevel(name) {
                var ilvlRequest = "https://<?php echo $region ?>.api.battle.net/wow/character/<?php echo $realmName ?>/" + encodeURI(name) + "?fields=items&locale=en_GB&apikey=bjahzm89djw4wd4r6n8hnutmb6ygw4gn";
                try {
                    $.getJSON(ilvlRequest, function (data) {
                        var ilvl = data.items.averageItemLevelEquipped;
                        sessionStorage.setItem("itemLevel-" + name, ilvl);
                        var aLevel = 0;
                        if (data.items.mainHand.artifactTraits != undefined) {
                            for (var i = 0; i < data.items.mainHand.artifactTraits.length; i++) {
                                aLevel = aLevel + data.items.mainHand.artifactTraits[i].rank;
                            }
                        }
                        sessionStorage.setItem("artifactLevel-" + name, aLevel);
                    });
                } catch (ex) {

                }
            }

            $(document).ready(function () {
                var region = <?php echo "\"" . $region . "\"" ?>;
                var realm = <?php echo "\"" . $realmName . "\"" ?>;
                var guild = <?php echo "\"" . $guildName . "\"" ?>;
                var requestURL = "https://" + region + ".api.battle.net/wow/guild/" + realm + "/" + guild + "?fields=members&locale=en_GB&apikey=bjahzm89djw4wd4r6n8hnutmb6ygw4gn";
                $.getJSON(requestURL, function (data) {
                    var dataSet = [];

                    for (var i = 0; i < data.members.length; i++) {
                        var name = data.members[i].character.name;
                        var cclass = data.members[i].character.class;
                        var specName = "";
                        var role = "";
                        var level = data.members[i].character.level;
                        if (level >= 100) {
                            try {
                                specName = data.members[i].character.spec.name;
                                role = data.members[i].character.spec.role;
                            } catch (ex) {

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

                            getItemLevel(name);
                            var charData = new Array();
                            charData[0] = name;
                            charData[1] = cclass;
                            charData[2] = specName;
                            charData[3] = role;
                            charData[4] = level;
                            charData[5] = sessionStorage.getItem("itemLevel-" + name);
                            charData[6] = sessionStorage.getItem("artifactLevel-" + name);

                            dataSet.push(charData);
                        }
                    }
                    

                    var columnsDef = [{
                            "render": function (data, type, row, meta) {
                                return '<a target="_blank" href="http://<?php echo $region ?>.battle.net/wow/en/character/<?php echo $realmName ?>/' + data + '/simple"" class="link">' + data + '</a>';
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

                    $(".character-table").DataTable({
                        "lengthMenu": [[20, 30, 40, 50, 100, -1], [20, 30, 40, 50, 100, "All"]],
                        data: dataSet,
                        "columns": columnsDef
                    });
                });
            });
        </script>
    </body>
</html>