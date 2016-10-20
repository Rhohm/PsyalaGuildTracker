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