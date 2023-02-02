const month = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

const tanggal = new Date();
const day = tanggal.getDay();
const dd = tanggal.getDate();
const mm = tanggal.getMonth();
const yy = tanggal.getFullYear();

function liveDay() {
    $('#tgl').html(changeHari(day) + ", " + dd + " " + month[mm] + " " + yy);
}

function capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function liveTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    h = checkTime(h);
    m = checkTime(m);
    s = checkTime(s);
    $('#jam').html(h + ":" + m + ":" + "<div>" + s + "</div>");
    var t = setTimeout(liveTime, 500);
}

function rupiah(angka) {
    var hasil = "Rp " + angka.toLocaleString('id');
    return hasil;
}

function formatDate(date) {
    if (date !== undefined && date !== "") {
        var myDate = new Date(date);
        var months = [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
        ][myDate.getMonth()];
        var str = myDate.getDate() + "-" + months + "-" + myDate.getFullYear();
        return str;
    }
    return "";
}

function formatDateFull(date) {
    if (date !== undefined && date !== "") {
        var myDate = new Date(date);
        var months = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember",
        ][myDate.getMonth()];
        var str = myDate.getDate() + "-" + months + "-" + myDate.getFullYear();
        return str;
    }
    return "";
}

function changeHari(h) {
    switch (h) {
        case 1:
            h = "Senin";
            break;
        case 2:
            h = "Selasa";
            break;
        case 3:
            h = "Rabu";
            break;
        case 4:
            h = "Kamis";
            break;
        case 5:
            h = "Jumat";
            break;
        case 6:
            h = "Sabtu";
            break;
        case 0:
            h = "Minggu";
            break;
    }
    return h;
}

function checkTime(i) {
    if (i < 10) { i = "0" + i };
    return i;
}

