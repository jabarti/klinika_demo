/****************************************************
 * Project:     Klinika_Local
 * Filename:    AddSzpitalController.js
 * Encoding:    UTF-8
 * Created:     2016-08-17
 *
 * Author       Bartosz M. Lewiński <jabarti@wp.pl>
 ***************************************************/
$(document).ready(function () {

    var url = "AJAX/AddSzpitalAJAX.php"; // the script where you handle the form input.

    $('#AddSzpitalForm').submit(function (e) {
//        console.log("EDIT:" + url + $('#EditSzpitalForm').serialize() + '&action=edit&id_record=' + Url_id_record);

        $.ajax({
            type: "POST",
            url: url,
            data: $('#AddSzpitalForm').serialize() + '&action=add', // serializes the form's elements.
            success: function (response) {
                var data = jQuery.parseJSON(response);

                if (data[3]['NewID'] != "") {
                    location.href = "index.php?page=editSzpital&id_record=" + data[3]['NewID'];

                } else
                if (data[4][''] != "") {
//                    alert(data[2]['error'])
                    $('#message').html(data[2]['error'])
                    if (confirm("Taki szpital jest w BD.\nCzy chcesz przejśc do jego edycji?")) {
//                        alert(data[4]['OldID'])
                        location.href = "index.php?page=editSzpital&id_record=" + data[4]['OldID'];
                    }
                }
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





