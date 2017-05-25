/****************************************************
 * Project:     Klinika_Local
 * Filename:    ListaMothersController.js
 * Encoding:    UTF-8
 * Created:     2016-08-27
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 ***************************************************/
$(document).ready(function () {

    var url = "AJAX/ListaMothersAJAX.php"; // the script where you handle the form input.

// POBRANIE PODSTAWOWYCH  DANYCH
    $.ajax({
        type: "POST",
        url: url,
        data: 'action=init', // serializes the form's elements.
        success: function (response) {
//                alert(response)
            var data = jQuery.parseJSON(response);
//                alert(data)

            Make_Records(data);
        },
        error: function (response) {
            alert("ERROR" + response);
        }
    });

// POBRANIE DANYCH WYSZUKIWANYCH
    $("#ListMothers_Search").submit(function (e) {
//        alert("Searching")
        $.ajax({
            type: "POST",
            url: url,
            data: $("#ListMothers_Search").serialize() + '&action=search', // serializes the form's elements.
            success: function (response) {
//                alert(response)
                var data = jQuery.parseJSON(response);
//                alert(data)

                Make_Records(data);
            },
            error: function (response) {
//                alert("ERROR" + response);
            }
        });

        e.preventDefault(); // avoid to execute the actual submit of the form.
    });

// OBSŁUGA ZDARZEŃ BUTTONÓW FORMULARZA (order UP, DOWN) - TO DO!!!!!!!!!!!!!
    $.fn.MessageBox = function (where, upOchNer) {
        return this.each(function () {
//            alert("po czym:" + where +", up czy down:"+ upOchNer);
            $.ajax({
                type: "POST",
                url: url,
                data: 'action=order&poczym=' + where + '&updown=' + upOchNer, // serializes the form's elements.
                success: function (response) {
                    var data = jQuery.parseJSON(response);

                    Make_Records(data);
                },
                error: function (response) {
//                    alert("ERROR" + response);
                }
            });
        });
    };

// OBSŁUGA ZDARZEŃ BUTTONÓW FORMULARZA (DEL, EDIT) - TO DO!!!!!!!!!!!!!
    $('tbody').delegate("button", "click", function () {
        var butt_id = this.id;
        var where = butt_id.slice(0, 6);

//        alert("Where:" + where + "\nWhat: " + what);

        switch (where) {
            case 'toEdit':
                var what = butt_id.slice(13);
                alert("Zdarzenie: " + where + ", na rekordzie:" + what);
//                window.location.href = 'index.php?page=editMatka&idMatka=' + what;
                break;

            case 'toDelR':
                var what = butt_id.slice(7);
                alert("Zdarzenie: " + where + ", na rekordzie:" + what);
                var del = confirm("Czy faktycznie skasować tę Matkę?");
                if (del === true) {
//                    alert("to kasuje");
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: 'action=deleMatka&idMatka=' + what, // serializes the form's elements.
                        success: function (response) {
                            var data = jQuery.parseJSON(response);

                            Make_Records(data);
                        },
                        error: function (response) {
//                            alert("ERROR" + response);
                        }
                    });

                } else {
                    alert("to NIE kasuje");
                }
                break;

            default:
//                alert("Zdarzenie: default?? " + where + ", na rekordzie:" + what);
                break;
        }
    });


// FUNKCJA PAKUJĄCA DANE DO FORMULARZA
    function Make_Records(data) {
        var trHTML = '';
        var IDs = [];

        for (var f = 0; f < data.length; f++) {

            if (data[f]['idMatka'] == null) {
                for (var j = 0; j < data[f].length; j++) {
//                    alert("nie twórz rekordu tylko zablokuj: " + data[f][j]['id_SzpitalOrInne'])
                    IDs.push(data[f][j]['Matka_idMatka'])
                }
//                alert("nie twórz rekordu tylko zablokuj: "+data[f]['id_SzpitalOrInne'])
            }
        }

//        for (var k = 0; k < data.length; k++) {
//            for (var l = 0; l < data[k].length; l++) {
//                for (key in data[k][l]) {
//                    if (key == "Matka_idMatka" || key == "ID_Wpisu") {
//                        if (k == 6) {
//                            alert("[" + key + "][" + k + "][" + l + "] = " + data[k][l][key])
//                        }
//                    }
//                }
//
//            }
//        }

        for (var f = 0; f < data.length; f++) {

            var text = (data[f]['idMatka']);
            var disabledDelete = false;

            for (var j = 0; j < IDs.length; j++) {
                if (IDs[j] == data[f]['idMatka']) {
                    disabledDelete = true;
                }
            }

            if (data[f]['idMatka'] != null) {

                if (disabledDelete) {       // To są rekordy szpitali, które są w Formularzu, usunięcie grozi błedami

                    trHTML += '<tr>\n\
                            <td><span >' + data[f]['idMatka'] + '</span></td>\n\
                            <td><span >' + data[f]['mama_firstname'] + '</span></td>\n\
                            <td><span >' + data[f]['mama_lastname'] + '</span></td>\n\
                            <td><span >' + data[f]['data_urodzenia_matka'] + '</span></td>\n\
                            <td><span >' + data[f]['ulica'] + '</span></td>\n\
                            <td><span >' + data[f]['miasto'] + '</span></td>\n\\n\
                            <td><span >' + data[f]['telefon'] + '</span></td>\n\\n\
                            <td><span >' + data[f]['email'] + '</span></td>\n\\n\
                            <td><button id="toDelR_' + text + '" class="btn btn-warning btn-sm" disabled ><span class="glyphicon glyphicon-remove" ></span> Usuń</button></td></td>\n\
                       </tr>';
                } else {
                    trHTML += '<tr>\n\
                            <td><span >' + data[f]['idMatka'] + '</span></td>\n\
                            <td><span >' + data[f]['mama_firstname'] + '</span></td>\n\
                            <td><span >' + data[f]['mama_lastname'] + '</span></td>\n\
                            <td><span >' + data[f]['data_urodzenia_matka'] + '</span></td>\n\
                            <td><span >' + data[f]['ulica'] + '</span></td>\n\
                            <td><span >' + data[f]['miasto'] + '</span></td>\n\\n\
                            <td><span >' + data[f]['telefon'] + '</span></td>\n\\n\
                            <td><span >' + data[f]['email'] + '</span></td>\n\\n\
                            <td><button id="toDelR_' + text + '" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> Usuń</button></td>\n\
                       </tr>';
                }
            }
        }
        $('#ListMothers_Table_body').html(trHTML);
    }

});



