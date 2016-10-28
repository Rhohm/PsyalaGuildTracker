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
        <link rel="stylesheet" type="text/css" href="/css/guild-tracker.css"/>
        <link rel="stylesheet" type="text/css" href="/css/loader.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.12/fh-3.1.2/datatables.min.css"/>
        <script type="text/javascript" src="/js/jquery.min.js"></script>
        <script type="text/javascript" src="/js/bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.12/fh-3.1.2/datatables.min.js"></script>
        <script type="text/javascript" src="/js/utils.js"></script>
    </head>
    <body>
        <!-- Start Header -->
        <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/html/layout/header.php"; ?>
        <!-- End Header -->
        <!-- Start Page Content -->
        <div id="page-content" class="container-fluid">
            <div class="container-fluid">
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
                <div class="row">
                    <div class="col-xs-12 text-center h1 page-title"><?php echo strtoupper($guildName) ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-12 text-center h3 page-title"><?php echo strtoupper($realmName . "-" . $region) ?></div>
                </div>
                <div class="row kpi-container">
                    <!-- REALM INFO KPI START -->
                    <div class="col-md-6 col-xs-12">
                        <div class="kpi-box" id="realm-info">
                            <div class="row">
                                <div class="col-xs-12 text-center h4">
                                    REALM INFORMATION
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    Status:
                                </div>
                                <div class="col-xs-6" id="realm-info-status"></div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    Queue:
                                </div>
                                <div class="col-xs-6" id="realm-info-queue"></div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    Population:
                                </div>
                                <div class="col-xs-6" id="realm-info-population"></div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    Realm Type:
                                </div>
                                <div class="col-xs-6" id="realm-info-type"></div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    Connected Realms:
                                </div>
                                <div class="col-xs-6" id="realm-info-connected"></div>
                            </div>
                        </div>
                    </div>
                    <!-- REALM INFO KPI END -->
                    <!-- GUILD INFO KPI START -->
                    <div class="col-md-6 col-xs-12">
                        <div class="kpi-box" id="guild-info">
                            <div class="row">
                                <div class="col-xs-12 text-center h4">
                                    GUILD INFORMATION
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    Level:
                                </div>
                                <div class="col-xs-6" id="guild-info-level"></div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    Members:
                                </div>
                                <div class="col-xs-6" id="guild-info-members"></div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    Members @ 110:
                                </div>
                                <div class="col-xs-6" id="guild-info-members-oneten"></div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    Achievement Points:
                                </div>
                                <div class="col-xs-6" id="guild-info-achievement-points"></div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    Faction:
                                </div>
                                <div class="col-xs-6" id="guild-info-faction"></div>
                            </div> 
                        </div>
                    </div>
                    <!-- GUILD INFO KPI END -->
                    <!-- GUILD NEWS KPI START -->
<!--                    <div class="col-md-4 col-xs-12">
                        <div class="kpi-box" id="latest-news">
                            <div class="row">
                                <div class="col-xs-12 text-center h4">
                                    Latest News
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped" id="news-table">
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>-->
                    <!-- GUILD NEWS KPI END -->
                </div>
                <div class="row">
                    <div class="kpi-table-box">
                        <table class="table table-condensed table-bordered" id="member-table">
                            <thead>
                                <tr>
                                    <th>Character</th>
                                    <th>Class</th>
                                    <th>Spec</th>
                                    <th>Role</th>
                                    <th title="Average Item Level (inc Bags)">Item Level</th>
                                    <th>Artifact Level</th>
                                    <th title="Emerald Nightmare - Normal Progression">EM N</th>
                                    <th title="Emerald Nightmare - Heroic Progression">EM H</th>
                                    <th title="Emerald Nightmare - Mythic Progression">EM M</th>
                                    <th>Last Updated</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="get-data-container">
                                    <td colspan="10" class="text-center">
                                        <button class="btn btn-default" onclick="getProgressionMemberData()">Get Character Data</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row" id="last-content">
                    <div class="col-xs-12 text-center">
                        Last Update: <span id="last-update"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="loader"></div>
        <!--End Page Content -->
        <script>
            var region = "<?php echo $region ?>";
            var guildName = "<?php echo $guildName ?>";
            var realmName = "<?php echo $realmName ?>";
            var a;

            $.ajaxSetup({
                async: false
            });

            $(document).ready(function () {
                $(".loader").show();
                getRealmInformation();
                getGuildInformation();
                //getLatestNews();
                $(".loader").hide();
            });

            function getCharacterData(name, specName) {
                var url = "https://" + region + ".api.battle.net/wow/character/" + realmName + "/" + encodeURI(name) + "?fields=items,progression&locale=en_GB&apikey=bjahzm89djw4wd4r6n8hnutmb6ygw4gn";
                var returnData = "";
                try {
                    $.getJSON(url, function (data) {
                        if (data !== undefined) {
                            var ilvl = data.items.averageItemLevel;
                            var aLevel = 0;
                            if (data.items.mainHand.artifactTraits !== undefined || specName !== "Protection" || specName !== "Demonology") {
                                for (var i = 0; i < data.items.mainHand.artifactTraits.length; i++) {
                                    aLevel = aLevel + data.items.mainHand.artifactTraits[i].rank;
                                }
                                aLevel = aLevel - data.items.mainHand.relics.length;
                            } else if (data.items.offHand.artifactTraits !== undefined) {
                                for (var i = 0; i < data.items.offHand.artifactTraits.length; i++) {
                                    aLevel = aLevel + data.items.offHand.artifactTraits[i].rank;
                                }
                                aLevel = aLevel - data.items.offHand.relics.length;
                            }
                            var emeraldNightmare = getBossKills(data.progression.raids[35]);
                            var emeraldNightmareN = JSON.stringify(emeraldNightmare[0]);
                            var emeraldNightmareH = JSON.stringify(emeraldNightmare[1])
                            var emeraldNightmareM = JSON.stringify(emeraldNightmare[2]);
                            var lastModified = convertTime(data.lastModified);
                            returnData = ilvl + "|" + aLevel + "|" + lastModified + "|" + emeraldNightmareN + "|" + emeraldNightmareH + "|" + emeraldNightmareM;
                        } else {
                            returnData = null;
                        }
                    });
                } catch (ex) {

                }
                return returnData;
            }

            function getProgressionMemberData() {
                $(".loader").show();
                $("#get-data-container").remove();
                var url = "https://" + region + ".api.battle.net/wow/guild/" + realmName + "/" + guildName + "?fields=members&locale=en_GB&apikey=bjahzm89djw4wd4r6n8hnutmb6ygw4gn";
                $.getJSON(url, function (data) {
                    var dataSet = [];
                    for (var i = 0; i < data.members.length; i++) {
                        var name = data.members[i].character.name;
                        var charClass = data.members[i].character.class;
                        var specName = "";
                        var role = "";
                        var level = data.members[i].character.level;
                        if (level == 110) {
                            try {
                                specName = data.members[i].character.spec.name;
                                role = data.members[i].character.spec.role;
                            } catch (ex) {

                            }
                            if (charClass == "1") {
                                charClass = "Warrior";
                            } else if (charClass == "2") {
                                charClass = "Paladin";
                            } else if (charClass == "3") {
                                charClass = "Hunter";
                            } else if (charClass == "4") {
                                charClass = "Rogue";
                            } else if (charClass == "5") {
                                charClass = "Priest";
                            } else if (charClass == "6") {
                                charClass = "Death Knight";
                            } else if (charClass == "7") {
                                charClass = "Shaman";
                            } else if (charClass == "8") {
                                charClass = "Mage";
                            } else if (charClass == "9") {
                                charClass = "Warlock";
                            } else if (charClass == "10") {
                                charClass = "Monk";
                            } else if (charClass == "11") {
                                charClass = "Druid";
                            } else if (charClass == "12") {
                                charClass = "Demon Hunter";
                            }
                            var charData = new Array();
                            var moreDetail = getCharacterData(name, specName);
                            charData[0] = name;
                            charData[1] = charClass;
                            charData[2] = specName;
                            charData[3] = role;
                            if (moreDetail !== null) {
                                moreDetail = moreDetail.split("|");
                                charData[4] = moreDetail[0];
                                charData[5] = moreDetail[1];
                                charData[6] = JSON.parse(moreDetail[3]);
                                charData[7] = JSON.parse(moreDetail[4]);
                                charData[8] = JSON.parse(moreDetail[5]);
                                charData[9] = moreDetail[2];
                            }
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
                            "createdCell": function (cell, cellData, rowData, rowIndex, colIndex) {
                                var css = '';
                                if (cellData >= 850) {
                                    css = 'good';
                                } else if (cellData >= 840) {
                                    css = 'okay';
                                } else if (cellData >= 820) {
                                    css = 'meh';
                                } else {
                                    css = 'bad';
                                }
                                $(cell).html('<a href="#" style="display:block">' + cellData + '</a>');
                                $(cell).addClass(css);
                            },
                            "render": function (data, type, row, meta) {
                                return data;
                            }
                        },
                        {
                            "createdCell": function (cell, cellData, rowData, rowIndex, colIndex) {
                                var css = '';
                                if (cellData >= 20) {
                                    css = 'good';
                                } else if (cellData >= 17) {
                                    css = 'okay';
                                } else if (cellData >= 15) {
                                    css = 'meh';
                                } else {
                                    css = 'bad';
                                }
                                $(cell).html('<a href="#" style="display:block">' + cellData + '</a>');
                                $(cell).addClass(css);
                            },
                            "render": function (data, type, row, meta) {
                                return data;
                            }
                        },
                        {
                            "createdCell": function (cell, cellData, rowData, rowIndex, colIndex) {
                                getRaidCell(cell, cellData, "Emerald Nightmare");
                            },
                            "render": function (data, type, row, meta) {
                                return data[0];
                            }
                        },
                        {
                            "createdCell": function (cell, cellData, rowData, rowIndex, colIndex) {
                                getRaidCell(cell, cellData, "Emerald Nightmare");
                            },
                            "render": function (data, type, row, meta) {
                                return data[0];
                            }
                        },
                        {
                            "createdCell": function (cell, cellData, rowData, rowIndex, colIndex) {
                                getRaidCell(cell, cellData, "Emerald Nightmare");
                            },
                            "render": function (data, type, row, meta) {
                                return data[0];
                            }
                        },
                        {
                            "render": function (data, type, row, meta) {
                                return data;
                            }
                        }
                    ];
                    $("#member-table").DataTable({
                        "lengthMenu": [[15, 30, 40, 50, 100, -1], [15, 30, 40, 50, 100, "All"]],
                        data: dataSet,
                        "columns": columnsDef,
                        destroy: true
                    });
                });
                
                $(".loader").hide();
            }

            function getItemInformation(itemID) {
                var url = "https://eu.api.battle.net/wow/item/" + itemID + "?locale=en_GB&apikey=bjahzm89djw4wd4r6n8hnutmb6ygw4gn";
                var item = "";
                try {
                    $.getJSON(url, function (data) {
                        var quality;
                        switch (data.quality) {
                            case 0:
                                quality = "item-poor";
                                break;
                            case 1:
                                quality = "item-common";
                                break;
                            case 2:
                                quality = "item-uncommon";
                                break;
                            case 3:
                                quality = "item-rare";
                                break;
                            case 4:
                                quality = "item-epic";
                                break;
                            case 5:
                                quality = "item-legendary";
                                break;
                            case 6:
                                quality = "item-artifact";
                                break;
                            case 7:
                                quality = "item-heirloom";
                                break;
                            case 8:
                                quality = "item-wowtoken";
                                break;
                        }
                        item = "<a target='_blank' href='http://www.wowhead.com/item=" + itemID + "' class='" + quality + "'> " + data.name + " : " + data.itemLevel + "</a>";
                    });
                } catch (ex) {
                    console.error(ex);
                }
                return item;
            }

            function getLatestNews() {
                var url = "https://" + region + ".api.battle.net/wow/guild/" + realmName + "/" + guildName + "?fields=news&locale=en_GB&apikey=bjahzm89djw4wd4r6n8hnutmb6ygw4gn";
                try {
                    $.getJSON(url, function (data) {
                        var newsCount = 1;
                        for (var i = 0; i < data.news.length; i++) {
                            var news = data.news[i];
                            if (news.itemId != undefined && newsCount < 26) {
                                var newsData = "<tr><td><span style='font-weight:bold'>" + news.character + "</span> received " + getItemInformation(news.itemId) + "</td></tr>";
                                $("#news-table tbody").append(newsData);
                                newsCount++;
                            }
                        }
                    });
                } catch (ex) {
                    console.error(ex);
                }
            }

            function getGuildInformation() {
                var url = "https://" + region + ".api.battle.net/wow/guild/" + realmName + "/" + guildName + "?fields=members&locale=en_GB&apikey=bjahzm89djw4wd4r6n8hnutmb6ygw4gn";
                try {
                    $.getJSON(url, function (data) {
                        $("#guild-info-level").text(data.level);
                        $("#guild-info-members").text(data.members.length);
                        var membersoneten = 0;
                        for (var i = 0; i < data.members.length; i++) {
                            if (data.members[i].character.level == 110) {
                                membersoneten++;
                            }
                        }
                        $("#guild-info-members-oneten").text(membersoneten);
                        $("#guild-info-achievement-points").text(data.achievementPoints);
                        $("#guild-info-faction").html(data.side == 1 ? "<span class='horde'>Horde</span>" : "<span class='alliance'>Alliance</span>;");
                        $("#last-update").text(convertTime(data.lastModified));
                    });
                } catch (ex) {
                    console.error(ex);
                }
            }

            function getRealmInformation() {
                var url = "https://" + region + ".api.battle.net/wow/realm/status?locale=en_GB&apikey=bjahzm89djw4wd4r6n8hnutmb6ygw4gn";
                try {
                    $.getJSON(url, function (data) {
                        for (var i = 0; i < data.realms.length; i++) {
                            var realm = data.realms[i];
                            if (realm.name === realmName) {
                                $("#realm-info-status").html(realm.status == true ? "<span class='positive'>Online</span>" : "<span class='negative'>Offline</span>");
                                $("#realm-info-queue").html(realm.queue == false ? "<span class='positive'>No</span>" : "<span class='negative'>Yes</span>");
                                $("#realm-info-type").text(realm.type.toUpperCase());
                                var population = realm.population;
                                switch (population) {
                                    case "high":
                                        population = "<span class='negative'>High</span>";
                                        break;
                                    case "medium":
                                        population = "<span class='ok'>Medium</span>";
                                        break;
                                    case "low":
                                        population = "<span class='positive'>Low</span>";
                                        break;
                                }
                                $("#realm-info-population").html(population);
                                var connectedRealms = "None";
                                for (var j = 0; j < realm.connected_realms.length; j++) {
                                    if (realm.connected_realms[j].capitalize() !== realmName) {
                                        if (j !== realm.connected_realms.length - 1) {
                                            connectedRealms = connectedRealms + realm.connected_realms[j].capitalize() + ",";
                                        } else {
                                            connectedRealms = connectedRealms + realm.connected_realms[j].capitalize();
                                        }
                                    }
                                }
                                $("#realm-info-connected").text(connectedRealms);
                            }
                        }
                    });
                } catch (ex) {
                    console.error(ex);
                }
            }
        </script>
    </body>
</html>
