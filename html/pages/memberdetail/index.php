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
                <div class="row">
                    <form class="form-inline navigation-form">
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
                        ?>
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
                    <div class="loader"></div>
                    <div class="col-xs-12 text-center h1">Member Details</div>
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
                                <th class="character-class">Class</th>
                                <th class="character-role">Spec</th>
                                <th class="character-role">Role</th>
                                <th class="character-item-level" title="Average Item Level">Item Level</th>
                                <th class="character-artifact-level">Artifact Level</th>
                                <th class="raid-progress" title="Emerald Nightmare Normal">EM N</th>
                                <th class="raid-progress" title="Emerald Nightmare Heroic">EM H</th>
                                <th class="raid-progress" title="Emerald Nightmare Mythic">EM M</th>
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
                main();
            });

            function sleep(ms) {
                var unixtime_ms = new Date().getTime();
                while (new Date().getTime() < unixtime_ms + ms) {
                }
            }

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

            function getCharacterDetails(name, specName) {
                var ilvlRequest = "https://<?php echo $region ?>.api.battle.net/wow/character/<?php echo $realmName ?>/" + encodeURI(name) + "?fields=items,progression&locale=en_GB&apikey=bjahzm89djw4wd4r6n8hnutmb6ygw4gn";
                try {
                    $.getJSON(ilvlRequest, function (data) {
                        var ilvl = data.items.averageItemLevel;
                        var aLevel = 0;
                        if (specName == "Protection" || specName == "Demonology") {
                            if (data.items.offHand.artifactTraits !== undefined) {
                                for (var i = 0; i < data.items.offHand.artifactTraits.length; i++) {
                                    aLevel = aLevel + data.items.offHand.artifactTraits[i].rank;
                                }
                                aLevel = aLevel - data.items.offHand.relics.length;
                            }
                        } else {
                            if (data.items.mainHand.artifactTraits !== undefined) {
                                for (var i = 0; i < data.items.mainHand.artifactTraits.length; i++) {
                                    aLevel = aLevel + data.items.mainHand.artifactTraits[i].rank;
                                }
                                aLevel = aLevel - data.items.mainHand.relics.length;
                            }
                        }
                        var emeraldNightmare = getBossKills(data.progression.raids[35]);
                        var emeraldNightmareN = JSON.stringify(emeraldNightmare[0]);
                        var emeraldNightmareH = JSON.stringify(emeraldNightmare[1])
                        var emeraldNightmareM = JSON.stringify(emeraldNightmare[2]);
                        var lastModified = convertTime(data.lastModified);
                        var characterData = ilvl + "|" + aLevel + "|" + lastModified + "|" + emeraldNightmareN + "|" + emeraldNightmareH + "|" + emeraldNightmareM;

                        sessionStorage.removeItem(name);
                        sessionStorage.setItem(name, characterData);
                    });
                } catch (ex) {

                }
            }

            function getBossKills(raid) {
                var returnArray = [[], [], []];
                var n = 0;
                var h = 0;
                var m = 0;
                for (var i = 0; i < raid.bosses.length; i++) {
                    if (raid.bosses[i].normalKills > 0) {
                        n++;
                    }
                    if (raid.bosses[i].heroicKills > 0) {
                        h++;
                    }
                    if (raid.bosses[i].mythicKills > 0) {
                        m++;
                    }
                }
                returnArray[0].push(n);
                returnArray[1].push(h);
                returnArray[2].push(m);
                for (var i = 0; i < raid.bosses.length; i++) {
                    returnArray[0].push(raid.bosses[i].normalKills);
                    returnArray[0].push(raid.bosses[i].name);
                    returnArray[1].push(raid.bosses[i].heroicKills);
                    returnArray[1].push(raid.bosses[i].name);
                    returnArray[2].push(raid.bosses[i].mythicKills);
                    returnArray[2].push(raid.bosses[i].name);
                }
                return returnArray;
            }

            function getRaidCell(data, raidName) {
                var totKills = data[0];
                var css = '';

                if (raidName === "Emerald Nightmare") {
                    if (totKills == 7) {
                        css = 'good';
                    } else if (totKills == 6) {
                        css = 'okay';
                    } else if (totKills > 0) {
                        css = 'meh';
                    } else {
                        css = 'bad';
                    }
                }

                var title = "";
                for (var i = 1; i < data.length; i++) {
                    if (i % 2 === 0) {
                        title = title + data[i];
                    }
                    if (i % 2 === 1) {
                        if (i !== 1) {
                            title = title + "\r\n";
                        }
                        title = title + data[i] + " x ";
                    }
                }

                return '<a href="#" class="' + css + '" title="' + title + '">' + totKills + '</a>';
            }

            function main() {
                loader.show();
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
                        if (level >= 110) {
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
                            getCharacterDetails(name, specName);
                            var charData = new Array();
                            charData[0] = name;
                            charData[1] = cclass;
                            charData[2] = specName;
                            charData[3] = role;
                            var characterData;
                            try {
                                characterData = sessionStorage.getItem(name).split("|");
                            } catch (ex) {

                            }
                            charData[4] = characterData[0];
                            charData[5] = characterData[1];
                            charData[6] = JSON.parse(characterData[3]);
                            charData[7] = JSON.parse(characterData[4]);
                            charData[8] = JSON.parse(characterData[5]);
                            charData[9] = characterData[2];
                            dataSet.push(charData);
                        }
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
                                var css = '';
                                if (data >= 850) {
                                    css = 'good';
                                } else if (data >= 840) {
                                    css = 'okay';
                                } else if (data >= 820) {
                                    css = 'meh';
                                } else {
                                    css = 'bad';
                                }
                                return '<a href="#" class="' + css + '">' + data + '</a>';
                            }
                        },
                        {
                            "render": function (data, type, row, meta) {
                                var css = '';
                                if (data >= 20) {
                                    css = 'good';
                                } else if (data >= 17) {
                                    css = 'okay';
                                } else if (data >= 15) {
                                    css = 'meh';
                                } else {
                                    css = 'bad';
                                }
                                return '<a href="#" class="' + css + '">' + data + '</a>';
                            }
                        },
                        {
                            "render": function (data, type, row, meta) {
                                return getRaidCell(data, "Emerald Nightmare");
                            }
                        },
                        {
                            "render": function (data, type, row, meta) {
                                return getRaidCell(data, "Emerald Nightmare");
                            }
                        },
                        {
                            "render": function (data, type, row, meta) {
                                return getRaidCell(data, "Emerald Nightmare");
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
                        "lengthMenu": [[15, 30, 40, 50, 100, -1], [15, 30, 40, 50, 100, "All"]],
                        data: dataSet,
                        "columns": columnsDef,
                        destroy: true
                    });

                });
            }
            ;
        </script>
    </body>
</html>
