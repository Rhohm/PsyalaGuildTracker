String.prototype.capitalize = function () {
    return this.charAt(0).toUpperCase() + this.slice(1);
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

function getRaidCell(cell, data, raidName) {
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
    $(cell).html('<a href="#" class="raid-progress-cell" style="display:block;" title="' + title + '">' + totKills + '</a>');
    $(cell).addClass(css);
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