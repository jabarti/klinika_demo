/****************************************************
 * Project:     Klinika_Local
 * Filename:    ListaController.js
 * Encoding:    UTF-8
 * Created:     2016-08-07
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 ***************************************************/
$(document).ready(function () {

    var url = "AJAX/ListaAJAX.php"; // the script where you handle the form input.

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
//            alert("ERROR" + response);
        }
    });

// POBRANIE DANYCH WYSZUKIWANYCH
    $("#ListForm_Search").submit(function (e) {
//        alert("Searching")
        $.ajax({
            type: "POST",
            url: url,
            data: $("#ListForm_Search").serialize() + '&action=search', // serializes the form's elements.
            success: function (response) {
                var data = jQuery.parseJSON(response);

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
        var what = butt_id.slice(7);
        var what = what.replace('_', '/');
//        alert("Where:" + where + "\nWhat: " + what);

        switch (where) {
            case 'toEdit':
//                alert("Zdarzenie: " + where + ", na rekordzie:" + what);
                window.location.href = 'index.php?page=edit&id_record=' + what;
                break;

            case 'toDelR':
//                alert("Zdarzenie: " + where + ", na rekordzie:" + what);
                var del = confirm("Czy faktycznie skasować ten rekord?");
                if (del === true) {
//                    alert("to kasuje");
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: 'action=deleteRec&id_rec=' + what, // serializes the form's elements.
                        success: function (response) {
                            var data = jQuery.parseJSON(response);

                            Make_Records(data);
                        },
                        error: function (response) {
//                            alert("ERROR" + response);
                        }
                    });

                } else {
//                    alert("to NIE kasuje");
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
        for (var f = 0; f < data.length; f++) {

            var text = (data[f]['ID_Wpisu']).replace('/', '_');

            trHTML += '<tr>\n\
                            <td><button id="toEdit_' + text + '" class="editButt btn btn-primary" formtarget="_blank"><span class="glyphicon glyphicon-edit" ></span> ' + data[f]['ID_Wpisu'] + '</button></td>\n\
                            <td><span >' + data[f]['data_utworzenia'] + '</span></td>\n\
                            <td><span >' + data[f]['mama_firstname'] + '</span></td>\n\
                            <td><span >' + data[f]['mama_lastname'] + '</span></td>\n\
                            <td><span >' + data[f]['imie_dziecka'] + '</span></td>\n\
                            <td><span >' + data[f]['ktore_dziecko'] + '</span></td>\n\\n\
                            <td><button id="toDelR_' + text + '" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span> Usuń</button></td>\n\
                       </tr>';
        }
        $('#ListForm_Table_body').html(trHTML);
    }

});



