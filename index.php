<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Psyala Guild Tracker - Class Overview</title>  
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
                    <div class="col-xs-12 text-center h1">Class Overview</div>
                </div>
                <div class="row">
                    <table class="table table-condensed table-bordered class-table">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Spec</th>
                                <th>Count</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <!--End Page Content -->
        <script>

            $(document).ready(function () {
                var region = <?php echo "\"" . $region . "\"" ?>;
                var realm = <?php echo "\"" . $realmName . "\"" ?>;
                var guild = <?php echo "\"" . $guildName . "\"" ?>;
                var requestURL = "https://" + region + ".api.battle.net/wow/guild/" + realm + "/" + guild + "?fields=members&locale=en_GB&apikey=bjahzm89djw4wd4r6n8hnutmb6ygw4gn";
                $.getJSON(requestURL, function (data) {
                    var warriorCount = [["Fury", "Protection", "Arms"], [0, 0, 0]];
                    var paladinCount = [["Retribution", "Holy", "Protection"], [0, 0, 0]];
                    var hunterCount = [["Marksmanship", "Survival", "Beast Mastery"], [0, 0, 0]];
                    var rogueCount = [["Outlaw", "Subtlety", "Assassination"], [0, 0, 0]];
                    var priestCount = [["Shadow", "Holy", "Discipline"], [0, 0, 0]];
                    var dkCount = [["Blood", "Unholy", "Frost"], [0, 0, 0]];
                    var shamanCount = [["Elemental", "Restoration", "Enhancement"], [0, 0, 0]];
                    var mageCount = [["Fire", "Frost", "Arcane"], [0, 0, 0]];
                    var warlockCount = [["Destruction", "Affliction", "Demonology"], [0, 0, 0]];
                    var monkCount = [["Windwalker", "Mistweaver", "Brewmaster"], [0, 0, 0]];
                    var druidCount = [["Balance", "Guardian", "Feral", "Restoration"], [0, 0, 0, 0]];
                    var dhCount = [["Vengeance", "Havoc"], [0, 0]];

                    for (var i = 0; i < data.members.length; i++) {
                        var cclass = data.members[i].character.class;
                        var level = data.members[i].character.level;
                        var specName = "";
                        try {
                            specName = data.members[i].character.spec.name;
                            role = data.members[i].character.spec.role;
                        } catch (ex) {

                        }
                        if (level >= 100) {
                            if (cclass == "1") {
                                cclass = "Warrior";
                                if (specName == warriorCount[0][0]) {
                                    warriorCount[1][0]++;
                                } else if (specName == warriorCount[0][1]) {
                                    warriorCount[1][1]++;
                                } else if (specName == warriorCount[0][2]) {
                                    warriorCount[1][2]++;
                                }
                            } else if (cclass == "2") {
                                cclass = "Paladin";
                                if (specName == paladinCount[0][0]) {
                                    paladinCount[1][0]++;
                                } else if (specName == paladinCount[0][1]) {
                                    paladinCount[1][1]++;
                                } else if (specName == paladinCount[0][2]) {
                                    paladinCount[1][2]++;
                                }
                            } else if (cclass == "3") {
                                cclass = "Hunter";
                                if (specName == hunterCount[0][0]) {
                                    hunterCount[1][0]++;
                                } else if (specName == hunterCount[0][1]) {
                                    hunterCount[1][1]++;
                                } else if (specName == hunterCount[0][2]) {
                                    hunterCount[1][2]++;
                                }
                            } else if (cclass == "4") {
                                cclass = "Rogue";
                                if (specName == rogueCount[0][0]) {
                                    rogueCount[1][0]++;
                                } else if (specName == rogueCount[0][1]) {
                                    rogueCount[1][1]++;
                                } else if (specName == rogueCount[0][2]) {
                                    rogueCount[1][2]++;
                                }
                            } else if (cclass == "5") {
                                cclass = "Priest";
                                if (specName == priestCount[0][0]) {
                                    priestCount[1][0]++;
                                } else if (specName == priestCount[0][1]) {
                                    priestCount[1][1]++;
                                } else if (specName == priestCount[0][2]) {
                                    priestCount[1][2]++;
                                }
                            } else if (cclass == "6") {
                                cclass = "Death Knight";
                                if (specName == dkCount[0][0]) {
                                    dkCount[1][0]++;
                                } else if (specName == dkCount[0][1]) {
                                    dkCount[1][1]++;
                                } else if (specName == dkCount[0][2]) {
                                    dkCount[1][2]++;
                                }
                            } else if (cclass == "7") {
                                cclass = "Shaman";
                                if (specName == shamanCount[0][0]) {
                                    shamanCount[1][0]++;
                                } else if (specName == shamanCount[0][1]) {
                                    shamanCount[1][1]++;
                                } else if (specName == shamanCount[0][2]) {
                                    shamanCount[1][2]++;
                                }
                            } else if (cclass == "8") {
                                cclass = "Mage";
                                if (specName == mageCount[0][0]) {
                                    mageCount[1][0]++;
                                } else if (specName == mageCount[0][1]) {
                                    mageCount[1][1]++;
                                } else if (specName == mageCount[0][2]) {
                                    mageCount[1][2]++;
                                }
                            } else if (cclass == "9") {
                                cclass = "Warlock";
                                if (specName == warlockCount[0][0]) {
                                    warlockCount[1][0]++;
                                } else if (specName == warlockCount[0][1]) {
                                    warlockCount[1][1]++;
                                } else if (specName == warlockCount[0][2]) {
                                    warlockCount[1][2]++;
                                }
                            } else if (cclass == "10") {
                                cclass = "Monk";
                                if (specName == monkCount[0][0]) {
                                    monkCount[1][0]++;
                                } else if (specName == monkCount[0][1]) {
                                    monkCount[1][1]++;
                                } else if (specName == monkCount[0][2]) {
                                    monkCount[1][2]++;
                                }
                            } else if (cclass == "11") {
                                cclass = "Druid";
                                if (specName == druidCount[0][0]) {
                                    druidCount[1][0]++;
                                } else if (specName == druidCount[0][1]) {
                                    druidCount[1][1]++;
                                } else if (specName == druidCount[0][2]) {
                                    druidCount[1][2]++;
                                } else if (specName == druidCount[0][3]) {
                                    druidCount[1][3]++;
                                }
                            } else if (cclass == "12") {
                                cclass = "Demon Hunter";
                                if (specName == dhCount[0][0]) {
                                    dhCount[1][0]++;
                                } else if (specName == dhCount[0][1]) {
                                    dhCount[1][1]++;
                                }
                            }
                        }
                    }
                    var classData = [];
                    classData[0] = ["Warrior", warriorCount[0][0], warriorCount[1][0]];
                    classData[1] = ["Warrior", warriorCount[0][1], warriorCount[1][1]];
                    classData[2] = ["Warrior", warriorCount[0][2], warriorCount[1][2]];
                    classData[3] = ["Paladin", paladinCount[0][0], paladinCount[1][0]];
                    classData[4] = ["Paladin", paladinCount[0][1], paladinCount[1][1]];
                    classData[5] = ["Paladin", paladinCount[0][2], paladinCount[1][2]];
                    classData[6] = ["Hunter", hunterCount[0][0], hunterCount[1][0]];
                    classData[7] = ["Hunter", hunterCount[0][1], hunterCount[1][1]];
                    classData[8] = ["Hunter", hunterCount[0][2], hunterCount[1][2]];
                    classData[9] = ["Rogue", rogueCount[0][0], rogueCount[1][0]];
                    classData[10] = ["Rogue", rogueCount[0][1], rogueCount[1][1]];
                    classData[11] = ["Rogue", rogueCount[0][2], rogueCount[1][2]];
                    classData[12] = ["Priest", priestCount[0][0], priestCount[1][0]];
                    classData[13] = ["Priest", priestCount[0][1], priestCount[1][1]];
                    classData[14] = ["Priest", priestCount[0][2], priestCount[1][2]];
                    classData[15] = ["Death Knight", dkCount[0][0], dkCount[1][0]];
                    classData[16] = ["Death Knight", dkCount[0][1], dkCount[1][1]];
                    classData[17] = ["Death Knight", dkCount[0][2], dkCount[1][2]];
                    classData[18] = ["Shaman", shamanCount[0][0], shamanCount[1][0]];
                    classData[19] = ["Shaman", shamanCount[0][1], shamanCount[1][1]];
                    classData[20] = ["Shaman", shamanCount[0][2], shamanCount[1][2]];
                    classData[21] = ["Mage", mageCount[0][0], mageCount[1][0]];
                    classData[22] = ["Mage", mageCount[0][1], mageCount[1][1]];
                    classData[23] = ["Mage", mageCount[0][2], mageCount[1][2]];
                    classData[24] = ["Warlock", warlockCount[0][0], warlockCount[1][0]];
                    classData[25] = ["Warlock", warlockCount[0][1], warlockCount[1][1]];
                    classData[26] = ["Warlock", warlockCount[0][2], warlockCount[1][2]];
                    classData[27] = ["Monk", monkCount[0][0], monkCount[1][0]];
                    classData[28] = ["Monk", monkCount[0][1], monkCount[1][1]];
                    classData[29] = ["Monk", monkCount[0][2], monkCount[1][2]];
                    classData[30] = ["Demon Hunter", dhCount[0][0], dhCount[1][0]];
                    classData[31] = ["Demon Hunter", dhCount[0][1], dhCount[1][1]];
                    classData[32] = ["Druid", druidCount[0][0], druidCount[1][0]];
                    classData[33] = ["Druid", druidCount[0][1], druidCount[1][1]];
                    classData[34] = ["Druid", druidCount[0][2], druidCount[1][2]];
                    classData[35] = ["Druid", druidCount[0][3], druidCount[1][3]];

                    $(".class-table").DataTable({
                        "lengthMenu": [[50], [50]],
                        data: classData
                    });
                });
            });
        </script>
    </body>
</html>
