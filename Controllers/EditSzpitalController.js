/****************************************************
 * Project:     Klinika_Local
 * Filename:    EditSzpitalController.js
 * Encoding:    UTF-8
 * Created:     2016-08-16
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 ***************************************************/
$(document).ready(function () {

    var url = "AJAX/EditSzpitalAJAX.php"; // the script where you handle the form input.
    var Url_id_record = getUrlProperty("id_record");
//    alert(Url_id_record)

// POBRANIE PODSTAWOWYCH  DANYCH
    $.ajax({
        type: "POST",
        url: url,
        data: 'action=init&id_record=' + Url_id_record, // serializes the form's elements.
        success: function (response) {
            var data = jQuery.parseJSON(response);

            Make_Records(data);
        },
        error: function (response) {
//            alert("ERROR" + response);
        }
    });

    $('#EditSzpitalForm').submit(function (e) {
//        console.log("EDIT:" + url + $('#EditSzpitalForm').serialize() + '&action=edit&id_record=' + Url_id_record);

        $.ajax({
            type: "POST",
            url: url,
            data: $('#EditSzpitalForm').serialize() +'&action=edit&id_record=' + Url_id_record, // serializes the form's elements.
            success: function (response) {
                var data = jQuery.parseJSON(response);

                Make_Records(data);
            },
            error: function (response) {
//            alert("ERROR" + response);
            }
        });
        e.preventDefault(); // avoid to execute the actual submit of the form.
    });


    function Make_Records(data) {
        $('#idSzpital').val(data[0]['idSzpital']);
        $('#nazwa').val(data[0]['nazwa']);
        $('#skrot_nazwy').val(data[0]['skrot_nazwy']);
        $('#urodz_ulica').val(data[0]['urodz_ulica']);
        $('#urodz_ulica_nr').val(data[0]['urodz_ulica_nr']);
        $('#urodz_kod_poczt').val(data[0]['urodz_kod_poczt']);
        $('#urodz_miasto').val(data[0]['urodz_miasto']);
        $('#urodz_kraj').val(data[0]['urodz_kraj']);
    }
});


