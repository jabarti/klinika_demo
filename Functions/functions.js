/****************************************************
 * Project:     Klinika
 * Filename:    functions.js
 * Encoding:    UTF-8
 * Created:     2016-06-18
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 ***************************************************/
var tabClics = [];
var ileImg = 3; // maksymalnie dwa zaznaczone obszary cycków
var longOfString = ileImg * 5 + 1;
var indexIntabClics = 0;
var isNyLoaded = true;

function showCoordsCyca(event, text) {

    var toLoad = "";
    var czyDopisać = false;
    var tempToLoad = "";
    var isFormObszar = true;

    if ($("#obszar").val() != null && isNyLoaded) {
        isNyLoaded = false;
        tempToLoad = $("#obszar").val();
        var arr = tempToLoad.split("_");
        for (var i = 0; i < arr.length; i++) {
//            alert("len=" + tabClics.length + "\ntabClics[" + i + "]=" + tabClics[i] + "\narr[" + (i + 1) + "]=" + arr[i + 1])
            if (arr[i + 1] != undefined) {
                var text_temp = arr[i + 1];
                tabClics.push(text_temp);
                tabClics.sort();
            }
        }
    } else {
//        alert("null")
    }

//    alert("TABLICA1:(" + tabClics.toString() + ")")

    if (tabClics.length < ileImg && isFormObszar && !isNyLoaded) {
//        alert("Dopisuję element!")
        czyDopisać = true;
    } else {
        indexIntabClics = tabClics.indexOf(text)
//        alert("indexIntabClics=" + indexIntabClics)
        if (indexIntabClics >= 0) {
//            tabClics.splice(indexIntabClics, 1); // usówa 1 element w indexie
        } else {
            alert("Maksymalnie " + ileImg + " zaznaczonych elementów, usuń jeden!")
        }
    }

    var isIntabClics = false;

    for (var i = 0; i < tabClics.length; i++) {
        if (tabClics[i] == text) {
//            alert(tabClics[i] + " != " + text + ", przed:" + isIntabClics)
            isIntabClics = true;
//            alert(tabClics[i])
        }
    }

//    alert("text:'" + text + "', isIntabClics: " + isIntabClics)

    if (!isIntabClics && czyDopisać) {
        tabClics.push(text);
        tabClics.sort();
    } else {
        indexIntabClics = tabClics.indexOf(text)
//        alert("indexIntabClics=" + indexIntabClics)
        if (indexIntabClics >= 0) {
            tabClics.splice(indexIntabClics, 1); // usówa 1 element w indexie
        }
    }

//    alert("TABLICA2:(" + tabClics.toString() + ")")

    for (var i = 0; i < tabClics.length; i++) {
//        alert("length="+tabClics.length+", tabClics["+i+"]="+tabClics[i])
        toLoad += "_" + tabClics[i];
    }

//    alert("toLoad:" + toLoad + ", LEngth: " + toLoad.length);

    var coords = toLoad// + ", clics on '" + text + "':" + tabClics[text];// + ": coords: " + x + ", Y coords: " + y;
    var el = document.getElementById("obszar");
    el.innerHTML = coords;
    el.value = coords;


    function load_this(text) {
        if (text != null && text.length < longOfString) {
//            alert("load zaznacz")
            $('#map_img_image').attr('src', 'img/cycki_03/anatomy_03' + text + '.jpg');
            $('#gmipam_0_image').attr('src', 'img/cycki_03/anatomy_03' + text + '.jpg');
        } else {
//            alert("load czyste")
            $('#map_img_image').attr('src', 'img/cycki_03/anatomy_03.jpg');
            $('#gmipam_0_image').attr('src', 'img/cycki_03/anatomy_03.jpg');
        }
    }

    load_this(toLoad);
}

function showOUTCoordsCyca(event) {
    var x = event.clientX;
    var y = event.clientY;
    var coords = " coordsOUT: " + x + ", Y coords: " + y;
    var el = document.getElementById("obszar");
    el.innerHTML = coords;
    alert("OUT")
    el.style.backgroundColor = "black";
}


// Popover w formularzu na przykład (ID_Wpis)
$(document).ready(function () {
    $('[data-toggle="popover"]').popover();
});


function CalculateAge2(data1, data2) {

    var data_x = new Date(data1);   // wcześniejsza
    var data_y = new Date(data2);   // późniejsza

    var year_x = data_x.getFullYear();
    var year_y = data_y.getFullYear();

    var month_x = data_x.getMonth() + 1;
    var month_y = data_y.getMonth() + 1;

    var day_x = data_x.getDate();
    var day_y = data_y.getDate();

    var lat = year_y - year_x;
    var mies = month_y - month_x;
    var dni = day_y - day_x;

    console.log("Rok 2=" + year_y + ", Rok 1=" + year_x + ", czyli 2-1 = " + lat);
    console.log("Miesiąc 2=" + month_y + ", Miesiąc 1=" + month_x + ", czyli 2-1 = " + mies);
    console.log("Dzień 2=" + day_y + ", Dzień 1=" + day_x + ", czyli 2-1 = " + dni);

    if (dni < 0) {
        mies -= 1;
        var temp_dni_x = ileDniMaMiesiąc(month_x, year_x);
//        var temp_dni_y = ileDniMaMiesiąc(month_y, year_y);
        dni = temp_dni_x + dni
        console.log("temp_dni_x=" + temp_dni_x)
    }

    if (mies < 0) {
        lat -= 1
        mies = 12 + mies
    }

    console.log(lat + " lat i " + mies + " mieś. i " + dni + "dni");

    return lat + " lat i " + mies + " mieś. i " + dni + "dni";
}
;

// funkcje do oblicznia wieku dziś lub w danej dacie
function CalculateAge(data) {
    var data_x = new Date(data);
    var data_y = new Date();

    var year_x = data_x.getFullYear();
    var year_y = data_y.getFullYear();

    var month_x = data_x.getMonth() + 1;
    var month_y = data_y.getMonth() + 1;

    var day_x = data_x.getDate();
    var day_y = data_y.getDate();

    var lat = year_y - year_x;
    var mies = month_y - month_x;
    var dni = day_y - day_x;

    console.log("Rok 2=" + year_y + ", Rok 1=" + year_x + ", czyli 2-1 = " + lat);
    console.log("Miesiąc 2=" + month_y + ", Miesiąc 1=" + month_x + ", czyli 2-1 = " + mies);
    console.log("Dzień 2=" + day_y + ", Dzień 1=" + day_x + ", czyli 2-1 = " + dni);

    if (dni < 0) {
        mies -= 1;
        var temp_dni_x = ileDniMaMiesiąc(month_x, year_x);
//        var temp_dni_y = ileDniMaMiesiąc(month_y, year_y);
        dni = temp_dni_x + dni
        console.log("temp_dni_x=" + temp_dni_x)
    }

    if (mies < 0) {
        lat -= 1
        mies = 12 + mies
    }

    console.log(lat + " lat i " + mies + " mieś. i " + dni + "dni");

    return lat + " lat i " + mies + " mieś. i " + dni + "dni";
}
;

function FormatDateToString(date){
    var temp = new Date(date);
    
    var now_year = temp.getFullYear();
    var now_mont = temp.getMonth()+1;
    var now_day = temp.getDate();
    
    if(now_mont<10){
        now_mont = "0"+now_mont;
    }
    
    if(now_day < 10){
        now_day = "0"+now_day;
    }
    
    return now_year + "-" + now_mont + "-" + now_day;
}

function getUrlProperty(text) {
    var start = text.length + 1;

    var url = location.search.substring(1);
    var slajs = url.split("&");

    for (i = 0; i < slajs.length; i++) {
        var czy = slajs[i].indexOf(text)
        if (czy == 0) {
            var outp = slajs[i].substring(start)
        }
    }
    return outp;
}

function trans(text) {

    var Fintext = ''
    switch (text) {
        case 'mama_firstname':
            Fintext = 'Imię matki'
            break;
        case 'mama_lastname':
            Fintext = 'Nazwisko matki'
            break;
        case 'urodz_ulica':
            Fintext = 'ulica'
            break;
        case 'urodz_ulica_nr':
            Fintext = 'nr'
            break;
        case 'urodz_ulica_nr_mieszkanie':
            Fintext = 'mieszkania'
            break;
        case 'urodz_kod_poczt':
            Fintext = 'kod pocztowy'
            break;
        case 'urodz_miasto':
            Fintext = 'miasto'
            break;
        case 'urodz_kraj':
            Fintext = 'kraj'
            break;
        default:
            var pattern = "_";
            re = new RegExp(pattern, "g");
            Fintext = text.replace(re, " ");
//            Fintext = text
            break;
    }

    return Fintext;
}

function isEmail(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}

// ile dni ma faktycznie miesiąc dni!!!!!
    function ileDniMaMiesiąc(monad, year) {
        var dni = 0;
        switch (monad) {
            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
                dni = 31;
                break;
            case 4:
            case 6:
            case 9:
            case 11:
                dni = 30;
                break;
            default:
                if (year % 4 == 0) {
                    dni = 29;
                } else {
                    dni = 28;
                }
                break;
        }
        return dni;
    }

